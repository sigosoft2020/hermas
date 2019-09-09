<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bookings extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('UpcomingOwner','up');
			$this->load->model('CompletedOwner','completed');
			$this->load->model('CancelledOwner','cancelled');
			$this->load->model('Common');
			if (!owner()) {
				redirect('app');
			}
	}
	public function upcoming()
	{
		$this->load->view('owner/bookings/upcoming');
	}
	public function getUpcoming()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$result = $this->up->make_datatables($owner_id);
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->up->get_all_data($owner_id),
			"recordsFiltered" => $this->up->get_filtered_data($owner_id),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function completed()
	{
		$this->load->view('owner/bookings/completed');
	}
	public function getCompleted()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$result = $this->completed->make_datatables($owner_id);
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->completed->get_all_data($owner_id),
			"recordsFiltered" => $this->completed->get_filtered_data($owner_id),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function cancelled()
	{
		$this->load->view('owner/bookings/cancelled');
	}
	public function getCancelled()
	{
		$owner = $this->session->userdata['owner'];
		$owner_id = $owner['owner_id'];

		$result = $this->cancelled->make_datatables($owner_id);
		$data = array();
		foreach ($result as $res) {

			$sub_array = array();
			$sub_array[] = $res->turf_name;
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->date;
			$sub_array[] = $res->slot;
			$sub_array[] = $res->pitch;
			$sub_array[] = $res->cash_recieved;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/bookings/details/'.$res->book_id) . '"><i class="fa fa-info-circle"></i></a>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->cancelled->get_all_data($owner_id),
			"recordsFiltered" => $this->cancelled->get_filtered_data($owner_id),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function check()
	{
		$today = date('Y-m-d H:i:s');
		$test = $this->up->check($today);

		//print_r(json_encode($test));
		echo $today;
	}

	public function details($book_id)
	{
		$book = $this->Common->get_details('bookings',array('book_id' => $book_id))->row();
		$data['turf'] = $this->Common->get_details('turfs',array('turf_id' => $book->turf_id))->row();
		if ($book->voucher_status == '1') {
			$data['voucher'] = $this->Common->get_details('voucher_apply',array('book_id' => $book_id))->row()->code;
		}
		else {
			$data['voucher'] = false;
		}
		$data['user'] = $this->Common->get_details('users',array('user_id' => $book->user_id))->row();
		$data['book'] = $book;

		$this->load->view('owner/bookings/details',$data);
	}
}
?>
