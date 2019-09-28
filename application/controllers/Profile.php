<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{   
	   if ($this->session->userdata('site_user')) 
       {
		    $user    = $this->session->userdata('site_user');
			$user_id = $user['user_id'];

			$details         = $this->Common->get_details('users',array('user_id'=>$user_id))->row();
            $data['details'] = $details;
            
            $address_check   = $this->Common->get_details('address_table',array('user_id'=>$user_id));
            if($address_check->num_rows()>0)
            {
                $address         = $address_check->row();
            }
            else
            {
               $address         = '';
            }
            $data['address_check'] = $address_check;
            $data['address']       = $address;
		    $this->load->view('site/profile',$data);
		}
		else
		{
			redirect('login');
		}    
	}

	public function update_picture()
	{
		$user_id = $this->input->post('user_id');
		$file     = $_FILES['image'];	       	
		$tar      = "uploads/admin/users/";
		$rand     = date('Ymd').mt_rand(1001,9999);
		$tar_file = $tar . $rand . basename($file['name']);
		move_uploaded_file($file['tmp_name'], $tar_file);

		$array    = [
			          'image' => $tar_file,
		            ];
		$this->Common->update('user_id',$user_id,'users',$array);
		redirect('profile');     

		// print_r($file);      
	}

	public function update()
	{
		$user_id  = $this->input->post('user_id');
		$name     = $this->input->post('name');
		$email    = $this->input->post('email');
		$phone    = $this->input->post('phone');
		$array    = [
			          'name'   => $name,
			          'phone'  => $phone,
			          'email'  => $email
		            ];
		$this->Common->update('user_id',$user_id,'users',$array);
		redirect('profile');     

		// print_r($file);      
	}

	public function change_password()
	{
		$user_id    = $this->input->post('user_id');
		$password   = md5($this->input->post('password'));
		$array    = [
			          'password'   => $password
		            ];
		$this->Common->update('user_id',$user_id,'users',$array);
		redirect('profile');     

		// print_r($file);      
	}

	public function delete_address($id)	
	{
		if ($this->Common->delete('address_table',array('address_id' => $id))) 
		{				
			$this->session->set_flashdata('message', 'Address deleted successfully');	
		}
		else 
		{
			$this->session->set_flashdata('error', 'Failed to delete address');
		}
		redirect('profile');
	}
}
