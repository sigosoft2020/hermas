<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{
		$this->load->view('login/select');
	}
    public function login($param)
    {
        if($param == 'admin')
        {
            redirect('users/admin');
        }
        else
        {
            redirect('users/staff');
        }
    }
	public function staff()
	{
		if(isset($_COOKIE['staff_wooslot_id'])){
			$session = [
				'staff_id' => $_COOKIE['staff_wooslot_id'],
				'name' => $_COOKIE['staff_wooslot_name'],
				'turf_id' => $_COOKIE['staff_turf_id']
			];
			$this->session->set_userdata('staff',$session);
			redirect('staff/dashboard');
		}
		$this->load->view('login/staff/login');
	}
	public function admin()
	{
		if(isset($_COOKIE['admin_hermas_id'])){
			$session = [
				'admin_id' => $_COOKIE['admin_hermas_id'],
				'name' => $_COOKIE['admin_hermas_name']
			];
			$this->session->set_userdata('admin',$session);
			redirect('admin/dashboard');
		}
		$this->load->view('login/admin/login');
	}

	public function adminLogin()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$pass     = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);
		
		$array = [
					'username' => $username,
					'password' => $password
				  ];
	
		$check = $this->Common->get_details('auth',$array);
		if ($check->num_rows() > 0) 
		{
			$user = $check->row();
			$session = [
				'admin_id' => $user->id,
				'name'     => $user->username
			];
			$this->session->set_userdata('admin',$session);

			$hour = time() + 3600 * 24 * 30;
		    setcookie('admin_hermas_id', $user->id, $hour);
			setcookie('admin_hermas_name', $user->username, $hour);

			redirect('admin/dashboard');
		}
		else 
		{
			$this->session->set_flashdata('message','Login failed..!');
			redirect('users/admin');
		}
	}

	public function staffLogin()
	{
		$email = $this->security->xss_clean($this->input->post('email'));
		$pass = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);
		if(is_numeric($email))
        {
            $array = [
				'mobile' => $email,
				'password' => $password
			];
        }
		else {
			$array = [
				'email' => $email,
				'password' => $password
			];
		}

		$check = $this->Common->get_details('staffs',$array);
		if ( $check->num_rows() > 0 ) {
			$staff = $check->row();
			$session = [
				'staff_id' => $staff->staff_id,
				'name' => $staff->username,
				'turf_id' => $staff->turf_id
			];
			$this->session->set_userdata('staff',$session);

			$hour = time() + 3600 * 24 * 30;
		    setcookie('staff_wooslot_id', $staff->staff_id, $hour);
			setcookie('staff_wooslot_name', $staff->username, $hour);
			setcookie('staff_turf_id', $staff->turf_id, $hour);

			redirect('staff/dashboard');
		}
		else {
			$this->session->set_flashdata('message','Login failed..!');
			redirect('users/staff');
		}

	}

	public function logoutOwner()
	{
		setcookie('admin_hermas_id');
		setcookie('admin_hermas_name');

		$this->session->unset_userdata('owner');

		redirect('users/owner');
	}

	public function logoutStaff()
	{
		setcookie('staff_wooslot_id');
		setcookie('staff_wooslot_name');

		$this->session->unset_userdata('staff');

		redirect('users/staff');
	}

}
