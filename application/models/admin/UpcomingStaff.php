<?php

class UpcomingStaff extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($turf_id){
    $date = date('Y-m-d H:i:s');
    $table = "bookings";
    $select_column = array("book_id","bookings.turf_name","username","mobile","date","slot","pitch","cash_recieved","start","booking_status");
    $order_column = array(null,"turf_name",null,null,null,null,"username",null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('start >=',$date);
    $this->db->where('booking_status !=','cancelled');
    $this->db->where('bookings.turf_id',$turf_id);
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      //$this->db->like("turf_name",$_POST["search"]["value"]);
      $this->db->where("(bookings.turf_name LIKE '%" . $search .  "%' OR username LIKE '%" . $search . "%')",NULL,false);
      //$this->db->or_like("username",$_POST["search"]["value"]);
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
    $date = date('Y-m-d H:i:s');

    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->join('turfs','turfs.turf_id=bookings.turf_id');
    $this->db->where('start >=',$date);
    $this->db->where('booking_status !=','cancelled');
    $this->db->where('bookings.turf_id',$turf_id);
    return $this->db->count_all_results();
  }
}

?>
