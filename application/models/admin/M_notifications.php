<?php

class M_notifications extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function make_query(){
    $table = "notifications";
    $select_column = array("not_id","title","text","datetime","location","sender");
    $order_column = array(null,"title","text",null,"location","sender");

    $this->db->select($select_column);
    $this->db->from($table);
    if (isset($_POST["search"]["value"])) {
      $this->db->like("title",$_POST["search"]["value"]);
      $this->db->or_like("text",$_POST["search"]["value"]);
      $this->db->or_like("location",$_POST["search"]["value"]);
      $this->db->or_like("sender",$_POST["search"]["value"]);
    }
    if (isset($_POST["order"])) {
      $this->db->order_by($_POST['order']['0']['column'],$_POST['order']['0']['dir']);
    }
    else {
      $this->db->order_by("not_id","desc");
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
    $this->db->from("notifications");
    return $this->db->count_all_results();
  }

  function getNotifications($limit)
  {
    $this->db->select('title,text,datetime,location,sender,turf_id');
    $this->db->from('notifications');
    $this->db->order_by('not_id','desc');
    $this->db->limit(10,$limit);
    return $this->db->get()->result();
  }
}

?>
