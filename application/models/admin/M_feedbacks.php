<?php

class M_feedbacks extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($param){
    $table = "ratings";
    $select_column = array("rate_id","review","rating","turf_name","username","ratings.status");
    $order_column = array(null,"review",null,"turf_name","username",null);

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('turfs','ratings.turf_id=turfs.turf_id','left outer');
    $this->db->join('users','ratings.user_id=users.user_id','left outer');
    if ($param) {
      $this->db->where('turfs.owner_id',$param);
    }
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(turf_name LIKE '%" . $search .  "%' OR review LIKE '%" . $search . "%' OR username LIKE '%" . $search . "%')",NULL,false);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("rate_id","desc");
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
    $this->db->from("ratings");
    $this->db->join('turfs','ratings.turf_id=turfs.turf_id','left outer');
    if ($param) {
      $this->db->where('turfs.owner_id',$param);
    }
    return $this->db->count_all_results();
  }
}

?>
