<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{           
		$this->load->view('site/login');
	}

	public function login_check()
	{
		$email      = $this->security->xss_clean($this->input->post('username'));
		$password   = md5($this->security->xss_clean($this->input->post('password')));
		// print_r($email);

		$check      = $this->Common->get_details('users',array('email' => $email, 'password' => $password));
		if($check->num_rows() > 0) 
		{
			$user = $check->row();
				$session = [
							'user_id' => $user->user_id,
							'name'    => $user->name
				           ];
				$this->session->set_userdata('site_user',$session);

				$url = $this->session->userdata('redirect_url');
				if (isset($url)) {
					redirect($url);
				}
				else {
					redirect('home');
				}
		}
		else {
			$this->session->set_flashdata('message','Invalid email address or password');
			redirect('login');
		}
	}

	public function logout()
	{
		$this->session->unset_userdata('site_user');
		redirect('home');
	}	

}
