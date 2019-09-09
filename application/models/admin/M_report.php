<?php

class M_report extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function getBookingReportDaily($date,$turf_id)
  {
    $select_column = array("book_id","turf_name","username","mobile","date","slot","pitch","cash_recieved","start","booking_status");

    $this->db->select($select_column);
    $this->db->from("bookings");
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->where('date',$date);
    $this->db->where('booking_status !=','cancelled');
    if ($turf_id != 'all') {
      $this->db->where('turf_id',$turf_id);
    }
    $this->db->order_by('book_id','desc');
    return $this->db->get()->result();
  }
  function getBookingReportDateRange($start,$end,$turf_id)
  {
    $select_column = array("book_id","turf_name","username","mobile","date","slot","pitch","cash_recieved","start","booking_status");

    $this->db->select($select_column);
    $this->db->from("bookings");
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->where('date >=',$start);
    $this->db->where('date <=',$end);
    $this->db->where('booking_status !=','cancelled');
    if ($turf_id != 'all') {
      $this->db->where('turf_id',$turf_id);
    }
    $this->db->order_by('book_id','desc');
    return $this->db->get()->result();
  }
  function getExpenseReportDaily($date)
  {
    $select_column = array("exp_id","expense","notes","date","time","cat_name");

    $this->db->select($select_column);
    $this->db->from("expenses");
    $this->db->where('date',$date);
    $this->db->order_by('exp_id','desc');
    return $this->db->get()->result();
  }
  function getExpenseReportDateRange($start,$end)
  {
    $select_column = array("exp_id","expense","notes","date","time","cat_name");

    $this->db->select($select_column);
    $this->db->from("expenses");
    $this->db->where('date >=',$start);
    $this->db->where('date <=',$end);
    $this->db->order_by('exp_id','desc');
    return $this->db->get()->result();
  }
  function getPaymentReportDaily($date,$turf_id)
  {
    $this->db->select('payments.*,turfs.turf_name');
    $this->db->from('payments');
    $this->db->join('turfs','turfs.turf_id=payments.turf_id','left outer');
    if ($turf_id != 'all') {
      $this->db->where('payments.turf_id',$turf_id);
    }
    $this->db->where('date',$date);
    $this->db->order_by('payment_id','desc');
    return $this->db->get()->result();
  }
  function getPaymentReportDateRange($start,$end,$turf_id)
  {
    $this->db->select('payments.*,turfs.turf_name');
    $this->db->from('payments');
    $this->db->join('turfs','turfs.turf_id=payments.turf_id','left outer');
    if ($turf_id != 'all') {
      $this->db->where('payments.turf_id',$turf_id);
    }
    $this->db->where('date >=',$start);
    $this->db->where('date <=',$end);
    $this->db->order_by('payment_id','desc');
    return $this->db->get()->result();
  }


}

?>
