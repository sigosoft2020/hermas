<?php

class Android extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  public function loginCheck($array)
  {
    if(is_numeric($array['username']))
    {
        $array['mobile'] = $array['username'];
        unset($array['username']);
    }
    else
    {
        $array['email'] = $array['username'];
        unset($array['username']);
    }

    $this->db->select('user_id,username,mobile,email,auth,image');
    $this->db->from('users');
    $this->db->where($array);
    return $this->db->get();
  }
  public function getFavourites($id)
  {
    $this->db->select('turfs.*');
    $this->db->from('favourites');
    $this->db->join('turfs','favourites.turf_id=turfs.turf_id');
    $this->db->where('turfs.status','a');
    $this->db->where('favourites.user_id',$id);
    $this->db->order_by('favourites.fav_id','desc');
    return $this->db->get()->result();
  }
  function getPitchesById($id)
  {
    $this->db->select('pitches.*,turf_pitches.tp_id');
    $this->db->from('turf_pitches');
    $this->db->join('pitches','turf_pitches.pitch_id=pitches.pitch_id');
    $this->db->where('turf_pitches.turf_id',$id);
    $this->db->order_by('pitches.pitch_id','asc');
    return $this->db->get()->result();
  }
  function getTimeSlots($id)
  {
    $this->db->select('ts_id,from_time,to_time,ft,tt');
    $this->db->from('time_slots');
    $this->db->where('turf_id',$id);
    return $this->db->get()->result();
  }
  function getTurfFee($ts_id,$tp_id,$day_id)
  {
    $this->db->select('turf_time_slot_fees.price');
    $this->db->from('turf_pitch_slot');
    $this->db->join('turf_time_slot_fees','turf_pitch_slot.id=turf_time_slot_fees.tsf_id');
    $this->db->where('turf_pitch_slot.ts_id',$ts_id);
    $this->db->where('turf_pitch_slot.tp_id',$tp_id);
    $this->db->where('turf_time_slot_fees.day_id',$day_id);
    return $this->db->get();
  }
  function getDatas($ts_id,$tp_id)
  {
    $this->db->select('time_slots.from_time,time_slots.to_time,time_slots.turf_id,time_slots.ft,pitches.*,turfs.turf_name');
    $this->db->from('turf_pitch_slot');
    $this->db->join('turf_pitches','turf_pitch_slot.tp_id=turf_pitches.tp_id');
    $this->db->join('time_slots','turf_pitch_slot.ts_id=time_slots.ts_id');
    $this->db->join('pitches','turf_pitches.pitch_id=pitches.pitch_id');
    $this->db->join('turfs','turfs.turf_id=time_slots.turf_id');
    $this->db->where('turf_pitch_slot.ts_id',$ts_id);
    $this->db->where('turf_pitch_slot.tp_id',$tp_id);
    return $this->db->get();
  }
  function getDatasNew($tp_id)
  {
    $this->db->select('pitches.*,turfs.turf_name');
    $this->db->from('turf_pitches');
    $this->db->join('pitches','turf_pitches.pitch_id=pitches.pitch_id');
    $this->db->join('turfs','turfs.turf_id=turf_pitches.turf_id');
    $this->db->where('turf_pitches.tp_id',$tp_id);
    return $this->db->get();
  }
  function getVoucher($voucher)
  {
    $this->db->select('voucher_id,type,offer,count');
    $this->db->from('vouchers');
    $this->db->where('code',$voucher);
    return $this->db->get();
  }
  function getMyBookings($id,$status)
  {
    $this->db->select('bookings.book_id,bookings.slot,bookings.date,turfs.turf_name,turfs.place,turfs.cover_image');
    $this->db->from('bookings');
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('user_id',$id);
    $this->db->where('booking_status',$status);
    return $this->db->get()->result();
  }
  function getBookingDetails($book_id)
  {
    $this->db->select('bookings.book_id,bookings.turf_id,bookings.slot,bookings.date,bookings.pitch,bookings.rate,bookings.voucher_status,bookings.voucher_amount,bookings.subtotal,bookings.payment_type,bookings.cash_recieved,bookings.booked_date,bookings.booked_time,turfs.turf_name,turfs.place');
    $this->db->from('bookings');
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('bookings.book_id',$book_id);
    return $this->db->get();
  }
  function getTimeSlotDetails($booking_id)
  {
    $this->db->select('bookings.date,time_slots.ft');
    $this->db->from('bookings');
    $this->db->join('time_slots','bookings.ts_id=time_slots.ts_id');
    $this->db->where('bookings.book_id',$booking_id);
    return $this->db->get()->row();
  }
  function checkTimeSlot($ts_id,$tp_id,$date)
  {
    $this->db->select('book_id');
    $this->db->from('bookings');
    $this->db->where('bookings.ts_id',$ts_id);
    $this->db->where('bookings.tp_id',$tp_id);
    $this->db->where('bookings.date',$date);
    $this->db->where('bookings.booking_status','placed');
    $get = $this->db->get();

    if ($get->num_rows() > 0) {
      $this->db->select('pitch_count');
      $this->db->from('turf_pitches');
      $this->db->where('tp_id',$tp_id);
      $pitch = $this->db->get()->row();

      if ($pitch->pitch_count > $get->num_rows()) {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return true;
    }
  }
  function getBookingsInDateAndTimeslot($ts_id,$date)
  {
    $this->db->select('book_id,pitch_id');
    $this->db->from('bookings');
    $this->db->where('bookings.ts_id',$ts_id);
    //$this->db->where('bookings.tp_id',$tp_id);
    $this->db->where('bookings.date',$date);
    $this->db->where('bookings.booking_status','placed');
    $get = $this->db->get();
    return $get;
  }
  function getBookings($from,$turf_id,$date)
  {
    $this->db->select('book_id,pitch_id');
    $this->db->from('bookings1');
    $this->db->where('bookings1.date',$date);
    $this->db->where('bookings1.turf_id',$turf_id);
    $this->db->where('bookings1.booking_status','placed');

    //$this->db->group_start()
      $this->db->where('bookings1.from_time <=',$from);
      $this->db->where('bookings1.to_time >=',$from);
    //$this->db->group_start()

    $get = $this->db->get();
    return $get;
  }
}

?>
