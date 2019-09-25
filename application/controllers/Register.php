<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{           
		$this->load->view('site/register');
	}

	public function add()
	{
        $name     = $this->security->xss_clean($this->input->post('name'));
        $email    = $this->security->xss_clean($this->input->post('email'));
        $phone    = $this->security->xss_clean($this->input->post('mobile'));
        $password = md5($this->security->xss_clean($this->input->post('password')));

		$user = [
					'name'     => $name,
					'email'    => $email,
					'phone'    => $phone,
					'password' => $password,
					'type'     => 'Customer',
					'bulk_stat'=> '0'
		        ];
		$UserCheck = $this->Common->get_details('users',array('email' => $email,'phone'=>$phone))->num_rows();
        $PhoneCheck = $this->Common->get_details('users',array('phone'=>$phone))->num_rows();
        $EmailCheck = $this->Common->get_details('users',array('email' => $email))->num_rows(); 
	    if($UserCheck>0)
	    {
	    	$this->session->set_flashdata('Message','User already registered');
			redirect('login');
	    }
	    elseif($PhoneCheck>0)
	    {
	    	$this->session->set_flashdata('Message','Mobile already registered');
			redirect('login');
	    }
	    elseif($EmailCheck>0)
	    {
	    	$this->session->set_flashdata('Message','Email already registered');
			redirect('login');
	    }
	    else
	    {
			if ($id = $this->Common->insert('users',$user)) 
			{
				$session = [
					'user_id' => $id,
					'name' => $user['name']
				];
				$this->session->unset_userdata('register_error');
				$this->session->set_userdata('site_user',$session);
				$this->session->set_flashdata('Message','Registered Successfully');
				redirect('home');
			}
			else 
			{
				redirect('login');
			}
		}		
	}
}
