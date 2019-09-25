<?php

class M_products extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  
  function get_product($key)
  {
    $this->db->select("*");
    $this->db->from("category");
    $this->db->like('category_name', $key);
    return $this->db->get()->result();
  }

  function get_search_product($key)
  {
    $this->db->select("*");
    $this->db->from("products");
    $this->db->like('product_name', $key);
    return $this->db->get()->result();
  }
}

?>
