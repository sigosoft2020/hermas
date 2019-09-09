<?php

class M_payments extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function getPayments($turf_id)
  {
    $date = date('Y-m-d H:i:s');

    $this->db->select_sum('subtotal');
    $this->db->from('bookings');
    $this->db->where('turf_id',$turf_id);
    $this->db->where('payment_status','0');
    $this->db->where('bookings.start <=',$date);
    $query = $this->db->get();
    return $query->row()->subtotal;
  }
  function getBookings($turf_id)
  {
    $date = date('Y-m-d H:i:s');

    $this->db->select('book_id');
    $this->db->from('bookings');
    $this->db->where('turf_id',$turf_id);
    $this->db->where('payment_status','0');
    $this->db->where('bookings.start <=',$date);
    $query = $this->db->get();
    return $query->result();
  }
  function updateBookings($turf_id)
  {
    $date = date('Y-m-d H:i:s');
    $data = [
      'payment_status' => '1'
    ];

    $this->db->where('turf_id',$turf_id);
    $this->db->where('payment_status','0');
    $this->db->where('bookings.start <=',$date);
    $this->db->update('bookings', $data);

    return true;
  }
  function getPaymentsByTurf($turf_id)
  {
    $this->db->select('payments.*,turfs.turf_name');
    $this->db->from('payments');
    $this->db->join('turfs','turfs.turf_id=payments.turf_id','left outer');
    if ($turf_id != 'all') {
      $this->db->where('payments.turf_id',$turf_id);
    }
    $this->db->order_by('payment_id','desc');
     return $this->db->get()->result();
  }
  function getPaymentsByTurfOwner($turf_id,$owner_id)
  {
    $this->db->select('payments.*,turfs.turf_name');
    $this->db->from('payments');
    $this->db->join('turfs','turfs.turf_id=payments.turf_id','left outer');
    if ($turf_id != 'all') {
      $this->db->where('payments.turf_id',$turf_id);
    }
    $this->db->where('turfs.owner_id',$owner_id);
    $this->db->order_by('payment_id','desc');
     return $this->db->get()->result();
  }
}

?>
