<?php

class M_turf extends CI_Model
{
  function __construct()
  {
    $this->load->database();
  }
  function getAmenities($turf_id)
  {
    $this->db->select('amenities.amenity_id,amenities.amenity,amenities.image');
    $this->db->from('turf_amenities');
    $this->db->join('amenities','amenities.amenity_id=turf_amenities.amenity_id');
    $this->db->where('turf_amenities.turf_id',$turf_id);
    $result=$this->db->get();
    return $result->result();
  }
  function getRatings($turf_id)
  {
    $this->db->select('AVG(rating) as average');
    $this->db->from('ratings');
    $this->db->where('turf_id',$turf_id);
    return $this->db->get()->row()->average;
  }
  function getTurfs()
  {
    $this->db->select('*');
    $this->db->from('turfs');
    $this->db->where('status','a');
    $this->db->order_by('turf_id','desc');
    return $this->db->get()->result();
  }
  function getTurfImages($turf_id)
  {
    $this->db->select('image_id,image');
    $this->db->from('turf_images');
    $this->db->where('turf_id',$turf_id);
    return $this->db->get()->result();
  }
  function checkFav($turf_id,$id)
  {
    $this->db->select('fav_id');
    $this->db->from('favourites');
    $this->db->where('user_id',$id);
    $this->db->where('turf_id',$turf_id);
    $turf = $this->db->get();

    if ($turf->num_rows() > 0) {
      return true;
    }
    else {
      return false;
    }
  }
  function searchResults($key)
  {
    $query = "SELECT * FROM turfs WHERE ( turf_name LIKE '%$key%' OR place LIKE '%$key%' ) AND status='a'";
    $res = $this->db->query($query);
    return $res->result();
  }
  function getTurfOwner($owner_id)
  {
    $this->db->select('username,mobile,email,image');
    $this->db->from('owners');
    $this->db->where('owner_id',$owner_id);
    return $this->db->get()->row();
  }
  function getTurfPitch($turf_id)
  {
    $this->db->select('pitch,pitch_count,tp_id');
    $this->db->from('turf_pitches');
    $this->db->join('pitches','turf_pitches.pitch_id=pitches.pitch_id');
    $this->db->where('turf_id',$turf_id);
    return $this->db->get()->result();
  }
  function getTurfsAmenities($turf_id)
  {
    $this->db->select('amenities.*,turf_amenities.ta_id');
    $this->db->from('amenities');
    $this->db->join('turf_amenities','turf_amenities.amenity_id=amenities.amenity_id','left outer');
    $this->db->where('turf_id',$turf_id);
    return $this->db->get()->result();
  }
  function checkBooking($turf_id,$pitch_id)
  {
    $start = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('bookings');
    $this->db->where('start >',$start);
    $this->db->where('turf_id',$turf_id);
    $this->db->where('pitch_id',$pitch_id);
    return $this->db->get()->num_rows();
  }
  function updatePitchCount($turf_id,$pitch_id,$pitch_count)
  {
    $data = [
      'pitch_count' => $pitch_count
    ];
    $this->db->where('turf_id', $turf_id);
    $this->db->where('pitch_id', $pitch_id);
    $this->db->update('turf_pitches', $data);

    return true;
  }
  function checkBookingInTimeSlot($ts_id)
  {
    $start = date('Y-m-d H:i:s');

    $this->db->select('*');
    $this->db->from('bookings');
    $this->db->where('start >',$start);
    $this->db->where('ts_id',$ts_id);
    return $this->db->get()->num_rows();
  }
}

?>
