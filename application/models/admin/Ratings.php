<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ratings extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}
	public function addRatingsAndReviews()
	{
		$key = $this->security->xss_clean($this->input->post('auth'));
		if ($id = getUserId($key)) {
			$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

			$rating = $this->security->xss_clean($this->input->post('rating'));
			$review = $this->security->xss_clean($this->input->post('review'));

			$array = [
				'user_id' => $id,
				'turf_id' => $turf_id
			];

			$check = $this->Common->get_details('ratings',$array);

			$array['rating'] = $rating;
			$array['review'] = $review;

			if ($check->num_rows() > 0) {
				$rating_id = $check->row()->rate_id;
				$this->Common->update('rate_id',$rating_id,'ratings',$array);
			}
			else {
				$this->Common->insert('ratings',$array);
			}

			$return = [
				'status' => true,
				'user' => true,
				'insertion' => true
			];
		}
		else {
			$return = [
				'status' => false,
				'user' => false,
				'insertion' => false
			];
		}

		print_r(json_encode($return));
	}
}
?>
