<?php

class M_dashboardAdmin extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function bookingsPending($owner_id)
  {
    $today = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id','left outer');
    $this->db->where('turfs.owner_id',$owner_id);
    $this->db->where("start >=",$today);
    return $this->db->count_all_results();
  }

  function bookingsThisMonth($owner_id)
  {
    $date = date('Y-m-d');
    $start = date('Y-m-01', strtotime($date));
    $end = date('Y-m-t', strtotime($date));

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id','left outer');
    $this->db->where('turfs.owner_id',$owner_id);
    $this->db->where("date >=",$start);
    $this->db->where("date <=",$end);
    return $this->db->count_all_results();
  }

  function registeredTurfsCounts($owner_id)
  {
    $this->db->select("*");
    $this->db->from("turfs");
    $this->db->where("register","complete");
    $this->db->where("owner_id",$owner_id);
    return $this->db->count_all_results();
  }

  function todaysExpense($owner_id)
  {
    $date = date('Y-m-d');

    $this->db->select_sum('expense');
    $this->db->from("owner_expenses");
    $this->db->where("date",$date);
    $this->db->where("owner_id",$owner_id);
    return $this->db->get()->row()->expense;
  }

  function ExpenseThisMonth($owner_id)
  {
    $date = date('Y-m-d');
    $start = date('Y-m-01', strtotime($date));
    $end = date('Y-m-t', strtotime($date));

    $this->db->select_sum('expense');
    $this->db->from("owner_expenses");
    $this->db->where("date >=",$start);
    $this->db->where("date <=",$end);
    $this->db->where("owner_id",$owner_id);
    return $this->db->get()->row()->expense;
  }

  function latestFeedbacks($owner_id)
  {
    $this->db->select("rate_id,rating,review,username,image,turf_name");
    $this->db->from('ratings');
    $this->db->join('turfs','ratings.turf_id=turfs.turf_id');
    $this->db->join('users','ratings.user_id=users.user_id');
    $this->db->where("turfs.owner_id",$owner_id);
    $this->db->limit(6);
    $this->db->order_by('rate_id','desc');
    return $this->db->get()->result();
  }

  function latestExpenses($owner_id)
  {
    $this->db->select('*');
    $this->db->from('owner_expenses');
    $this->db->where('owner_id',$owner_id);
    $this->db->limit(6);
    $this->db->order_by('exp_id','desc');
    return $this->db->get()->result();
  }
}

?>
