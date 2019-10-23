<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salesman extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/salesman/M_salesman','salesman');
			$this->load->model('admin/salesman/M_blockedsalesman','blocked');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/salesman/view');
	}
	public function get()
	{
		$result = $this->salesman->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->salesman_name;
			$sub_array[] = $res->phone;
			$sub_array[] = $res->email;
			$sub_array[] = $res->username;
			$sub_array[] = $res->salesman_status;
			$sub_array[] = '<button type="button" class="btn btn-link" style="font-size:20px;color:blue" onclick="edit(' . $res->s_id . ')"><i class="fa fa-pencil"></i></button>';

			if($res->salesman_status == 'Active') 
			{
             $action  = '<a class="btn btn-link" style="font-size:16px;color:red" href="' . site_url('admin/salesman/disable/'.$res->s_id) . '"  onclick="return block()">Block</i></a>';
            } 
            else
            {
             $action = '<a class="btn btn-link" style="font-size:16px;color:orange" href="' . site_url('admin/salesman/enable/'.$res->s_id) . '"  onclick="return unblock()">Enable</a>';
            }
            
            $sub_array[]    = $action; 

			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->salesman->get_all_data(),
						"recordsFiltered" => $this->salesman->get_filtered_data(),
						"data"            => $data
					   );
		echo json_encode($output);
	}
    
    public function blocked()
	{
		$this->load->view('admin/salesman/blocked_salesman');
	}
	
	public function get_blocked()
	{
		$result = $this->blocked->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->salesman_name;
			$sub_array[] = $res->phone;
			$sub_array[] = $res->email;
			$sub_array[] = $res->username;
			$sub_array[] = $res->salesman_status;
// 			$sub_array[] = '<button type="button" class="btn btn-link" style="font-size:20px;color:blue" onclick="edit(' . $res->s_id . ')"><i class="fa fa-pencil"></i></button>';

			if($res->salesman_status == 'Active') 
			{
             $action  = '<a class="btn btn-link" style="font-size:16px;color:red" href="' . site_url('admin/salesman/disable/'.$res->s_id) . '"  onclick="return block()">Block</i></a>';
            } 
            else
            {
             $action = '<a class="btn btn-link" style="font-size:16px;color:orange" href="' . site_url('admin/salesman/enable/'.$res->s_id) . '"  onclick="return unblock()">Enable</a>';
            }
            
            $sub_array[]    = $action; 

			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->blocked->get_all_data(),
						"recordsFiltered" => $this->blocked->get_filtered_data(),
						"data"            => $data
					   );
		echo json_encode($output);
	}

    
	public function addSalesman()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d H:i:s');

		$name    = $this->security->xss_clean($this->input->post('name'));
		$phone   = $this->security->xss_clean($this->input->post('phone'));
		$email   = $this->security->xss_clean($this->input->post('email'));
		$username = $this->security->xss_clean($this->input->post('username'));
		$password = md5($this->security->xss_clean($this->input->post('password')));
		
		$mobileCheck = true;
		$usernameCheck = true;

		$checkMobile    = $this->Common->get_details('salesman',array('phone' => $phone))->num_rows();
		$checkUsername  = $this->Common->get_details('salesman',array('username' => $username))->num_rows();
		
		if ( $checkMobile > 0 ) {
			$mobileCheck = false;
		}
		if ( $checkUsername > 0 ) {
			$usernameCheck = false;
		}
		
	    if($mobileCheck && $usernameCheck)
        {
			$array = [
						'salesman_name'    => $name,
						'phone'            => $phone,
						'email'            => $email,
						'username'         => $username,
						'password'         => $password,
						'salesman_status'  => 'Active'
					];
			if ($this->Common->insert('salesman',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'New salesman added..!');

				redirect('admin/salesman');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add salesman..!');

				redirect('admin/salesman');
			}		
        }
        else
        {
           if( !$mobileCheck )
		   {
        	  $this->session->set_flashdata('alert_type', 'error');
    		  $this->session->set_flashdata('alert_title', 'Failed');
    		  $this->session->set_flashdata('alert_message', 'Mobile number already registered..!');
		   }
		   elseif( !$usernameCheck)
		   {
		      $this->session->set_flashdata('alert_type', 'error');
    		  $this->session->set_flashdata('alert_title', 'Failed');
    		  $this->session->set_flashdata('alert_message', 'Username already registered..!');  
		   }
          redirect('admin/salesman');
        }			
    }

	public function update()
	{
		$salesman_id   = $this->input->post('salesman_id');
		$salesman      = $this->security->xss_clean($this->input->post('salesman'));
		$phone         = $this->security->xss_clean($this->input->post('phone'));
		$email         = $this->security->xss_clean($this->input->post('email'));
		$username      = $this->security->xss_clean($this->input->post('username'));
		
		$mobileCheck = true;
		$usernameCheck = true;

		$checkMobile    = $this->Common->get_details('salesman',array('phone' => $phone,'s_id!=' => $salesman_id))->num_rows();
		$checkUsername  = $this->Common->get_details('salesman',array('username' => $username,'s_id!=' => $salesman_id))->num_rows();
		
		if ( $checkMobile > 0 ) {
			$mobileCheck = false;
		}
		if ( $checkUsername > 0 ) {
			$usernameCheck = false;
		}
		
	    if($mobileCheck && $usernameCheck)
        {
		    $array = [
				       'salesman_name'    => $salesman,
				       'phone'            => $phone,
					   'email'            => $email,
					   'username'         => $username
			         ];
		
			if ($this->Common->update('s_id',$salesman_id,'salesman',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

				redirect('admin/salesman');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to edit vendor..!');

				redirect('admin/salesman');
			}
		
		}
		else 
		{   
		   if( !$mobileCheck )
		   {
        	  $this->session->set_flashdata('alert_type', 'error');
    		  $this->session->set_flashdata('alert_title', 'Failed');
    		  $this->session->set_flashdata('alert_message', 'Mobile number already registered..!');
		   }
		   elseif( !$usernameCheck)
		   {
		      $this->session->set_flashdata('alert_type', 'error');
    		  $this->session->set_flashdata('alert_title', 'Failed');
    		  $this->session->set_flashdata('alert_message', 'Username already registered..!');  
		   }
		   else
		   {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to edit salesman..!');
		   }
			redirect('admin/salesman');
	    }
	}

	public function disable($id)
	{
			$array = [
				       'salesman_status' => 'Blocked'
			         ];
		
			if ($this->Common->update('s_id',$id,'salesman',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Vendor blocked successfully..!');

				redirect('admin/salesman/blocked');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to block vendor..!');

				redirect('admin/salesman');
			}
	}

	public function enable($id)
	{
			$array = [
				       'salesman_status' => 'Active'
			         ];
		
			if ($this->Common->update('s_id',$id,'salesman',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Vendor activated successfully..!');

				redirect('admin/salesman');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to activate vendor..!');

				redirect('admin/salesman/blocked');
			}
	}


	public function getsalesmanById()
	{
		$id = $_POST['id'];
		$data = $this->Common->get_details('salesman',array('s_id' => $id))->row();
		print_r(json_encode($data));
	}
}
?>
