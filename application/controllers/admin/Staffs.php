<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffs extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('Common');
			$this->load->model('M_staffs','staff');
			if (!owner()) {
				redirect('app/owner');
			}
	}
	public function index()
	{
		$this->load->view('owner/staffs/view');
	}
	public function get()
	{
		$owner = $this->session->userdata['owner'];

		$result = $this->staff->make_datatables($owner['owner_id']);
		$data = array();
		foreach ($result as $res) {
			if ($res->status) {
				$status = "Active";
			}
			else {
				$status = "Blocked";
			}
			$sub_array = array();
			$sub_array[] = '<img src="' . base_url() . $res->image . '" width="100px" height="100px" onclick="showImage(this)">';
			$sub_array[] = $res->username;
			$sub_array[] = $res->mobile;
			$sub_array[] = $res->email;
			$sub_array[] = $res->turf_name;
			$sub_array[] = $status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:24px;" href="' . site_url('owner/staffs/edit/'.$res->staff_id) . '"><i class="fa fa-pencil-square-o"></i></a>';
			$sub_array[] = '<button class="btn btn-link"><i class="fa fa-key" onclick="change_password('. $res->staff_id .')"></i></button>';

			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->staff->get_all_data($owner['owner_id']),
			"recordsFiltered" => $this->staff->get_filtered_data($owner['owner_id']),
			"data" => $data
		);
		echo json_encode($output);
	}
	public function add()
	{
		$owner = $this->session->userdata['owner'];
		$data['turfs'] = $this->Common->get_details('turfs',array('owner_id' => $owner['owner_id'] , 'status' => 'a'))->result();
		$this->load->view('owner/staffs/add',$data);
	}

	public function edit($staff_id)
	{
		$check = $this->Common->get_details('staffs',array('staff_id' => $staff_id));
		if ($check->num_rows() > 0) {
			$owner = $this->session->userdata['owner'];
			$data['turfs'] = $this->Common->get_details('turfs',array('owner_id' => $owner['owner_id'] , 'status' => 'a'))->result();
			$data['user'] = $check->row();
			$this->load->view('owner/staffs/edit',$data);
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to load staff..!');

			redirect('owner/staffs');
		}
	}

	public function addstaff()
	{
		$owner = $this->session->userdata['owner'];

		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$password = $this->security->xss_clean($this->input->post('password'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$image = $this->input->post('image');
		if ($image != '') {
			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/staffs/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/staffs/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));
		}
		else {
			$path = "uploads/staffs/user.png";
		}

		$array = [
			'username' => $username,
			'email' => $email,
			'mobile' => $mobile,
			'password' => md5($password),
			'auth' => $this->getKey(),
			'turf_id' => $turf_id,
			'owner_id' => $owner['owner_id'],
			'image' => $path
		];

		if ($this->Common->insert('staffs',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'New staff added successfully..!');

			redirect('owner/staffs');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add staff..!');

			redirect('owner/staffs/add');
		}
	}

	public function editstaff()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));
		$staff_id = $this->security->xss_clean($this->input->post('staff_id'));
		$status = $this->security->xss_clean($this->input->post('status'));
		$turf_id = $this->security->xss_clean($this->input->post('turf_id'));

		$image = $this->input->post('image');
		if ($image != '') {

			$img = substr($image, strpos($image, ",") + 1);

			$url = FCPATH.'uploads/profile/';
			$rand = $username . date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path = "uploads/profile/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			// Remove file from the server

			$user = $this->Common->get_details('staffs',array('staff_id' => $staff_id))->row();
			$cr_image = "uploads/profile/user.png";
			if ($cr_image != $user->image) {
				$remove_path = FCPATH . $user->image;
				unlink($remove_path);
			}

			$array = [
				'username' => $username,
				'email' => $email,
				'mobile' => $mobile,
				'image' => $path,
				'status' => $status,
				'turf_id' => $turf_id
			];

		}
		else {
			$array = [
				'username' => $username,
				'email' => $email,
				'mobile' => $mobile,
				'status' => $status,
				'turf_id' => $turf_id
			];
		}

		if ($this->Common->update('staff_id',$staff_id,'staffs',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

			redirect('owner/staffs');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to update staff..!');

			redirect('owner/staffs/edit/'.$staff_id);
		}
	}

	public function validation()
	{
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('staffs',array('email' => $email))->num_rows();
		$checkMobile = $this->Common->get_details('staffs',array('mobile' => $mobile))->num_rows();
		$array = [
			'mobile' => false,
			'email' => false
		];
		if ($checkMobile > 0) {
			$array['mobile'] = true;
		}
		if ($checkEmail > 0) {
			$array['email'] = true;
		}
		print_r(json_encode($array));
	}
	public function validationEdit()
	{
		$staff_id = $this->security->xss_clean($this->input->post('staff_id'));
		$email = $this->security->xss_clean($this->input->post('email'));
		$mobile = $this->security->xss_clean($this->input->post('mobile'));

		$checkEmail = $this->Common->get_details('staffs',array('email' => $email , 'staff_id!=' => $staff_id))->num_rows();
		$checkMobile = $this->Common->get_details('staffs',array('mobile' => $mobile , 'staff_id!=' => $staff_id))->num_rows();
		$array = [
			'mobile' => false,
			'email' => false
		];
		if ($checkMobile > 0) {
			$array['mobile'] = true;
		}
		if ($checkEmail > 0) {
			$array['email'] = true;
		}
		print_r(json_encode($array));
	}

	function getKey() {
		while (true) {
			$key = $this->key();
			$cond = [
				'auth' => $key
			];

			$check = $this->Common->get_details('staffs',$cond);

			if ($check->num_rows() == 0) {
				break;
			}
		}
		return $key;
  }

	function key()
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 20; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
		return $randomString;
	}

	public function changePassword()
	{
		$staff_id = $this->security->xss_clean($this->input->post('staff_id'));
		$password = $this->security->xss_clean($this->input->post('password'));

		$array = [
			'password' => md5($password)
		];

		if ($this->Common->update('staff_id',$staff_id,'staffs',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Password changed successfully..!');
		}
		redirect('owner/staffs');
	}
}
?>
