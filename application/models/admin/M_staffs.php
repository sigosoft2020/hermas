<?php

class M_staffs extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($owner_id){
    $table = "staffs";
    $select_column = array("staff_id","username","mobile","email","image","staffs.status","turf_name");
    $order_column = array(null,"username","mobile","email",null,null,"turf_name");

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('turfs','turfs.turf_id=staffs.turf_id','left outer');
    $this->db->where('staffs.owner_id',$owner_id);
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(username LIKE '%" . $search .  "%' OR mobile LIKE '%" . $search . "%' OR email LIKE '%" . $search . "%' OR turf_name LIKE '%" . $search . "%')",NULL,false);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("staff_id","desc");
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
    $this->db->from("staffs");
    $this->db->where('owner_id',$owner_id);
    return $this->db->count_all_results();
  }
}

?>
