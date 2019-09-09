<?php

class M_expensesOwner extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query($param){
    $table = "owner_expenses";
    $select_column = array("exp_id","expense","notes","date","time","cat_name","turf_name");
    $order_column = array(null,null,"notes","date",null,"cat_name","turf_name");

    $this->db->select($select_column);
    $this->db->from($table);
    $this->db->join('turfs','turfs.turf_id=owner_expenses.turf_id','left outer');
    if ($param) {
      $this->db->where('owner_expenses.owner_id',$param);
    }
    if (isset($_POST["search"]["value"])) {
      $search = $_POST["search"]["value"];
      $this->db->where("(turf_name LIKE '%" . $search .  "%' OR notes LIKE '%" . $search . "%' OR cat_name LIKE '%" . $search . "%' OR date LIKE '%" . $search . "%')",NULL,false);

      $this->db->like("notes",$_POST["search"]["value"]);
      $this->db->or_like("date",$_POST["search"]["value"]);
      $this->db->or_like("cat_name",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("date","desc");
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
    $this->db->from("owner_expenses");
    $this->db->join('turfs','turfs.turf_id=owner_expenses.turf_id','left outer');
    if ($param) {
      $this->db->where('owner_expenses.owner_id',$param);
    }
    return $this->db->count_all_results();
  }
}

?>
