<?php

class M_salesman extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $table = "salesman";
    $select_column = array("s_id","salesman_name","phone","email","salesman_status","username");
    $order_column = array(null,"salesman_name",null,null,null,"username");

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->where('salesman_status','Active');
    if (isset($_POST["search"]["value"])) {
      $this->db->like("salesman_name",$_POST["search"]["value"]);
   
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("s_id","desc");
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
    $this->db->from("salesman");
    $this->db->where('salesman_status','Active');
    return $this->db->count_all_results();
  }
}

?>
