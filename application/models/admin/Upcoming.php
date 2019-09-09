<?php

class Upcoming extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $date = date('Y-m-d H:i:s');
    $table = "bookings";
    $select_column = array("book_id","turf_name","username","mobile","date","slot","pitch","cash_recieved","start","booking_status");
    $order_column = array(null,"turf_name",null,null,null,null,"username",null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('users','bookings.user_id=users.user_id');
    $this->db->where('start >=',$date);
    $this->db->where('booking_status !=','cancelled');
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      //$this->db->like("turf_name",$_POST["search"]["value"]);
      $this->db->where("(turf_name LIKE '%" . $search .  "%' OR username LIKE '%" . $search . "%')",NULL,false);
      //$this->db->or_like("username",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("book_id","desc");
    }
  }
  function make_datatables()
  {
    $this->make_query();
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data()
  {
    $this->make_query();
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data()
  {
    $this->db->select("*");
    $this->db->from("bookings");
    return $this->db->count_all_results();
  }
  function check($today)
  {
    $this->db->select("*");
    $this->db->from("bookings");
    $this->db->where("start >=",$today);
    return $this->db->get()->result();
  }
}

?>
