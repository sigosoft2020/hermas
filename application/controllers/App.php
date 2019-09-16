<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{
		redirect('app/login');
	}
	public function login()
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
		$pass = $this->security->xss_clean($this->input->post('password'));
		$password = md5($pass);

		$details = [
			'username' => $username,
			'password' => $password
		];

		$check = $this->Common->get_details('auth',$details);
		if ( $check->num_rows() > 0 ) 
		{
			$user = $check->row();
			$session = [
				'admin_id' => $user->id,
				'name' => $user->name
			];
			$this->session->set_userdata('admin',$session);

			$hour = time() + 3600 * 24 * 30;
		    setcookie('admin_hermas_id', $user->id, $hour);
			setcookie('admin_hermas_name', $user->name, $hour);
			redirect('admin/dashboard');
		}
		else 
		{
			$this->session->set_flashdata('message','Login failed..!');
			redirect('app');
		}

	}
	public function logout()
	{
		setcookie('admin_hermas_id');
		setcookie('admin_hermas_name');

		$this->session->unset_userdata('admin');

		redirect('app');
	}
	public function unani()
	{
		if(isset($_COOKIE['unani_hermas_id']))
		{
		    $staff_id = $_COOKIE['staff_wooslot_id'];
		    $staff = $this->Common->get_details('staffs',array('staff_id' => $staff_id))->row();
		    if($staff->status == 'a')
		    {
		        $session = [
    				'staff_id' => $_COOKIE['staff_wooslot_id'],
    				'name' => $_COOKIE['staff_wooslot_name'],
    				'turf_id' => $_COOKIE['staff_turf_id']
    			];
    			$this->session->set_userdata('staff',$session);
    			redirect('staff/dashboard');
		    }
		    else
		    {
		        $this->session->set_flashdata('message','Your account is temporarily unavailable..!');
		    }
		}
		$this->load->view('login/staff/login');
	}
	public function admin()
	{
		if(isset($_COOKIE['admin_hermas_id']))
		{
			$session = [
				'admin_id' => $_COOKIE['admin_hermas_id'],
				'name' => $_COOKIE['admin_hermas_name']
			];
			$this->session->set_userdata('admin',$session);
			redirect('admin/dashboard');
		}
		$this->load->view('login/admin/login');
	}

	public function ownerLogin()
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

		$check = $this->Common->get_details('owners',$array);
		if ( $check->num_rows() > 0 ) 
		{
			$owner = $check->row();
			if($owner->status == 'b')
			{
			    $this->session->set_flashdata('message','Your account is temporarily unavailable..!');
			    redirect('app/owner');
			}
			else
			{
			    $session = [
    				'owner_id' => $owner->owner_id,
    				'name' => $owner->username
    			];
    			$this->session->set_userdata('owner',$session);
    
    			$hour = time() + 3600 * 24 * 30;
    		    setcookie('owner_wooslot_id', $owner->owner_id, $hour);
    			setcookie('owner_wooslot_name', $owner->username, $hour);
    
    
    			redirect('owner/dashboard');
			}
		}
		else 
		{
			$this->session->set_flashdata('message','Login failed..!');
			redirect('app/owner');
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
			if($staff->status == 'a')
			{
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
			else
			{
			    $this->session->set_flashdata('message','Your account is temporarily blocked , Please contact turf owner..!');
			    redirect('app/staff');
			}
			
		}
		else {
			$this->session->set_flashdata('message','Login failed..!');
			redirect('app/staff');
		}

	}

	public function logoutOwner()
	{
		setcookie('owner_wooslot_id');
		setcookie('owner_wooslot_name');

		$this->session->unset_userdata('owner');

		redirect('app/owner');
	}

	public function logoutStaff()
	{
		setcookie('staff_wooslot_id');
		setcookie('staff_wooslot_name');

		$this->session->unset_userdata('staff');

		redirect('app/staff');
	}

}
