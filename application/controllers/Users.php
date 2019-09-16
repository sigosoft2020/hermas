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
            redirect('users/unani');
        }
    }

	public function unani()
	{
		if(isset($_COOKIE['hermas_unani_id'])){
			$session = [
				'staff_id' => $_COOKIE['hermas_unani_id'],
				'name' => $_COOKIE['hermas_unani_name']
			];
			$this->session->set_userdata('unani',$session);
			redirect('unani/dashboard');
		}
		$this->load->view('login/unani/login');
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

	public function unaniLogin()
	{
		$username = $this->security->xss_clean($this->input->post('username'));
		$pass = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);

		$array = [
					'username' => $username,
					'password' => $password
				  ];

		$check = $this->Common->get_details('unani_auth',$array);
		if ( $check->num_rows() > 0 ) {
			$unani = $check->row();
			$session = [
				'staff_id' => $unani->id,
				'name' => $unani->username
			];
			$this->session->set_userdata('unani',$session);

			$hour = time() + 3600 * 24 * 30;
		  setcookie('hermas_unani_id', $unani->id, $hour);
			setcookie('hermas_unani_name', $unani->username, $hour);


			redirect('unani/dashboard');
		}
		else {
			$this->session->set_flashdata('message','Login failed..!');
			redirect('users/unani');
		}
	}

	public function logoutAdmin()
	{
		setcookie('admin_hermas_id');
		setcookie('admin_hermas_name');

		$this->session->unset_userdata('admin');

		redirect('users/admin');
	}

	public function logoutUnani()
	{
		setcookie('hermas_unani_id');
		setcookie('hermas_unani_name');

		$this->session->unset_userdata('unani');

		redirect('users/unani');
	}

}
