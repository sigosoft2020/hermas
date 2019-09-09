<?php

class Turf_blocked extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($param){
    $table = "turfs";
    $select_column = array("turf_id","turf_name","place","cover_image","status","register");
    $order_column = array(null,"turf_name","place",null,null,null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->where("status","b");
    $this->db->where("register","complete");
    if ($param) {
      $this->db->where("owner_id",$param);
    }
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(turf_name LIKE '%" . $search .  "%' OR place LIKE '%" . $search . "%')",NULL,false);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("turf_id","desc");
    }
  }
  function make_datatables($param=0)
  {
    $this->make_query($param);
    if ($_POST["length"] != -1) {
      $this->db->limit($_POST["length"],$_POST["start"]);
    }
    $query = $this->db->get();
    return $query->result();
  }
  function get_filtered_data($param=0)
  {
    $this->make_query($param);
    $query = $this->db->get();
    return $query->num_rows();
  }
  function get_all_data($param=0)
  {
    $this->db->select("*");
    $this->db->from("turfs");
    $this->db->where("status","b");
    $this->db->where("register","complete");
    if ($param) {
      $this->db->where("owner_id",$param);
    }
    return $this->db->count_all_results();
  }
}

?>
