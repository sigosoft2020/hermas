<?php

class CancelledStaff extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($turf_id){
    $table = "bookings";
    $select_column = array("book_id","bookings.turf_name","username","mobile","date","slot","pitch","cash_recieved","booking_status");
    $order_column = array(null,"turf_name","username",null,null,null,null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->where('booking_status','cancelled');
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('bookings.turf_id',$turf_id);
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
  function make_datatables($turf_id)
  {
    $this->make_query($turf_id);
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data($turf_id)
  {
    $this->make_query($turf_id);
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data($turf_id)
  {
    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('bookings.turf_id',$turf_id);
    $this->db->where('booking_status','cancelled');
    return $this->db->count_all_results();
  }
  function check($today)
  {
    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('turf_id',$turf_id);
    $this->db->where("start >=",$today);
    return $this->db->get()->result();
  }
}

?>
