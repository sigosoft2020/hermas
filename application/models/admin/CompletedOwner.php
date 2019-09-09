<?php

class CompletedOwner extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($owner_id){
    $date = date('Y-m-d H:i:s');
    $table = "bookings";
    $select_column = array("bookings.book_id","bookings.turf_name","bookings.date","bookings.slot","bookings.pitch","bookings.cash_recieved","users.username","users.mobile");
    $order_column = array(null,"bookings.turf_name",null,null,null,null,"users.username",null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('owner_id',$owner_id);
    $this->db->where('bookings.start <=',$date);
    $this->db->where('bookings.booking_status !=','cancelled');
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(bookings.turf_name LIKE '%" . $search .  "%' OR username LIKE '%" . $search . "%')",NULL,false);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("book_id","desc");
    }
  }
  function make_datatables($owner_id)
  {
    $this->make_query($owner_id);
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data($owner_id)
  {
    $this->make_query($owner_id);
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data($owner_id)
  {
    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('owner_id',$owner_id);
    $this->db->where('booking_status','cancelled');
    return $this->db->count_all_results();
  }
  function check($today)
  {
    $date = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('owner_id',$owner_id);
    $this->db->where('bookings.start <=',$date);
    $this->db->where('bookings.booking_status !=','cancelled');
    return $this->db->get()->result();
  }
}

?>
