<?php

class M_user extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function getDateId($date)
  {
    $this->db->select('*');
    $this->db->from('date');
    $this->db->where('date',$date);
    return $this->db->get();
  }
  function getEntry($array)
  {
    $this->db->select('*');
    $this->db->from('entries');
    $this->db->where($array);
    $res = $this->db->get();
    if ($res->num_rows() == 0) {
      return false;
    }
    else {
      return $res->row()->entry_id;
    }
  }
  function getAllEntries($start,$date)
  {
    $this->db->select('*');
    $this->db->from('entries');
    $this->db->where('date >=',$start);
    $this->db->where('date <',$date);
    return $this->db->get()->result();
  }
}

?>
