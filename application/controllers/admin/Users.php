<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/M_user','user');
			$this->load->model('admin/M_blockeduser','blocked');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/users/view');
	}
	public function get()
	{
		$result = $this->user->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->name;
			$sub_array[] = $res->phone;
			$sub_array[] = $res->email;
			$sub_array[] = $res->Status;
			if($res->Status == 'Active') 
			{
             $action  = '<a class="btn btn-link" style="font-size:16px;color:red" href="' . site_url('admin/users/disable/'.$res->user_id) . '"  onclick="return block()">Block</i></a>';
            } 
            else
            {
             $action = '<a class="btn btn-link" style="font-size:16px;color:orange" href="' . site_url('admin/users/enable/'.$res->user_id) . '"  onclick="return block()">Enable</a>';
            }
			$sub_array[] = $action;
			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->user->get_all_data(),
			"recordsFiltered" => $this->user->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}
    
    public function blocked()
	{
		$this->load->view('admin/users/blocked_users');
	}
	public function get_blocked()
	{
		$result = $this->blocked->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->name;
			$sub_array[] = $res->phone;
			$sub_array[] = $res->email;
			$sub_array[] = $res->Status;
			if($res->Status == 'Active') 
			{
             $action  = '<a class="btn btn-link" style="font-size:16px;color:red" href="' . site_url('admin/users/disable/'.$res->user_id) . '"  onclick="return block()">Block</i></a>';
            } 
            else
            {
             $action = '<a class="btn btn-link" style="font-size:16px;color:orange" href="' . site_url('admin/users/enable/'.$res->user_id) . '"  onclick="return unblock()">Enable</a>';
            }
			$sub_array[] = $action;
			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->blocked->get_all_data(),
			"recordsFiltered" => $this->blocked->get_filtered_data(),
			"data" => $data
		);
		echo json_encode($output);
	}

	public function disable($id)
	{
			$array = [
				       'Status' => 'Blocked'
			         ];
		
			if ($this->Common->update('user_id',$id,'users',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'User blocked successfully..!');

				redirect('admin/users/blocked');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to block user..!');

				redirect('admin/users');
			}
	}

	public function enable($id)
	{
			$array = [
				       'Status' => 'Active'
			         ];
		
			if ($this->Common->update('user_id',$id,'users',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Users activated successfully..!');

				redirect('admin/users');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to activate user..!');

				redirect('admin/users/blocked');
			}
	}
}
?>
