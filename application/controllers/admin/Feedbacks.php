<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedbacks extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('M_feedbacks','feedback');
			$this->load->model('Common');
			if (!owner()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('owner/feedbacks/view');
	}
	public function get()
	{
		$owner = $this->session->userdata['owner'];

		$result = $this->feedback->make_datatables($owner['owner_id']);
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
				$button = '<a class="btn btn-sm btn-outline-danger waves-light waves-effect w-md" href="' . site_url('owner/feedbacks/block/'.$res->rate_id) . '" onclick="return unblock()"><i class="fa fa-ban m-r-5"></i><span> BLOCK</span></a>';
			}
			else {
				$status = "Blocked";
				$button = '<a class="btn btn-sm btn-outline-success waves-light waves-effect w-md" href="' . site_url('owner/feedbacks/unblock/'.$res->rate_id) . '" onclick="return block()"><i class="fa fa-check m-r-5"></i><span> UNBLOCK</span></a>';
			}
			$sub_array = array();
			$sub_array[] = $res->review;
			$sub_array[] = $res->rating;
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $status;
			$sub_array[] = $button;

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->feedback->get_all_data($owner['owner_id']),
			"recordsFiltered" => $this->feedback->get_filtered_data($owner['owner_id']),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function block($rate_id)
	{
		$status = [
			'status' => o
		];
		if ($this->Common->update('rate_id',$rate_id,'ratings',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Feedback blocked successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to block feedback..!');
		}
		redirect('owner/feedbacks');
	}
	public function unblock($rate_id)
	{
		$status = [
			'status' => 1
		];
		if ($this->Common->update('rate_id',$rate_id,'ratings',$status)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Feedback unblocked successfully..!');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to unblock feedback..!');
		}
		redirect('owner/feedbacks');
	}
}
?>
