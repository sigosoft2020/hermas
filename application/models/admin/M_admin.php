<?php

class M_admin extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
	function getUserDetails()
  {
    $this->db->select('user_id,name,phone,email,username');
    $this->db->from('users');
    $result=$this->db->get();
    return $result->result();
  }
  function getCategories()
  {
    $this->db->select('*');
    $this->db->from('category');
    $result=$this->db->get();
    return $result->result();
  }
  function getPhotos()
  {
    $this->db->select('photos.*,category.name as cat_name');
    $this->db->from('photos');
    $this->db->join('category','category.category_id=photos.category_id');
    $result=$this->db->get();
    return $result->result();
  }
  function getPhotoById($id)
  {
    $this->db->select('photos.*,category.name as cat_name');
    $this->db->from('photos');
    $this->db->join('category','category.category_id=photos.category_id');
    $this->db->where('photo_id',$id);
    $result=$this->db->get();
    return $result->row_array();
  }
  function getLatestPhotos()
  {
    $this->db->select('photos.*,category.name as cat_name');
    $this->db->from('photos');
    $this->db->join('category','category.category_id=photos.category_id');
    $this->db->order_by('photo_id','desc');
    $this->db->limit(6);
    $result=$this->db->get();
    return $result->result();
  }
  function getAdverts()
  {
    $this->db->select('*');
    $this->db->from('sideimage');
    $this->db->order_by('image_id','desc');
    $this->db->limit(2);
    $result=$this->db->get();
    return $result->result();
  }
  function getProducts()
  {
    $this->db->select('products.*,category.category_name as cat_name');
    $this->db->from('products');
    $this->db->join('category','category.category_id=products.category_id');
    $this->db->order_by('products.product_id','desc');
    $result=$this->db->get();
    return $result->result();
  }
  function getProductsByCategoryId($cat_id)
  {
    $this->db->select('products.*,category.category_name as cat_name');
    $this->db->from('products');
    $this->db->join('category','category.category_id=products.category_id');
    $this->db->order_by('products.product_id','desc');
    $this->db->where('products.category_id',$cat_id);
    $result=$this->db->get();
    return $result->result();
  }
}

?>
