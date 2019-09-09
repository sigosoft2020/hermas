<?php

class M_dashboard extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function bookingsPending()
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->where("start >=",$today);
    return $this->db->count_all_results();
  }

  function bookingsThisMonth()
  {
    $date = date('Y-m-d');
    $start = date('Y-m-01', strtotime($date));
    $end = date('Y-m-t', strtotime($date));

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->where("date >=",$start);
    $this->db->where("date <=",$end);
    return $this->db->count_all_results();
  }

  function registeredTurfsCounts()
  {
    $this->db->select("*");
    $this->db->from("turfs");
    $this->db->where("register","complete");
    return $this->db->count_all_results();
  }

  function registeredCustomers()
  {
    $this->db->select("*");
    $this->db->from("users");
    return $this->db->count_all_results();
  }

  function todaysExpense()
  {
    $date = date('Y-m-d');

    $this->db->select_sum('expense');
    $this->db->from("expenses");
    $this->db->where("date",$date);
    return $this->db->get()->row()->expense;
  }

  function ExpenseThisMonth()
  {
    $date = date('Y-m-d');
    $start = date('Y-m-01', strtotime($date));
    $end = date('Y-m-t', strtotime($date));

    $this->db->select_sum('expense');
    $this->db->from("expenses");
    $this->db->where("date >=",$start);
    $this->db->where("date <=",$end);
    return $this->db->get()->row()->expense;
  }

  function getUsers()
  {
    $this->db->select("username,mobile,email,image");
    $this->db->from('users');
    $this->db->limit(6);
    $this->db->order_by('user_id','desc');
    return $this->db->get()->result();
  }

  function latestFeedbacks()
  {
    $this->db->select("rate_id,rating,review,username,image,turf_name");
    $this->db->from('ratings');
    $this->db->join('turfs','ratings.turf_id=turfs.turf_id');
    $this->db->join('users','ratings.user_id=users.user_id');
    $this->db->limit(6);
    $this->db->order_by('rate_id','desc');
    return $this->db->get()->result();
  }

  function latestExpenses()
  {
    $this->db->select('*');
    $this->db->from('expenses');
    $this->db->limit(6);
    $this->db->order_by('exp_id','desc');
    return $this->db->get()->result();
  }
}

?>
