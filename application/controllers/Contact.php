<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{           
		$this->load->view('site/contact');
	}

	public function send_enquiry()
	{
	  date_default_timezone_set('Asia/Kolkata');
	  $timestamp  = date('Y-m-d H:i:s');

	    $name       = $this->security->xss_clean($this->input->post('name'));
      $email      = $this->security->xss_clean($this->input->post('email'));
      $phone      = $this->security->xss_clean($this->input->post('phone'));
      $notes      = $this->security->xss_clean($this->input->post('notes'));

      $array      =[
      	             'en_name'  => $name,
      	             'en_email' => $email,
                     'en_phone' => $phone,
                     'en_query' => $notes,
                     'timestamp' => $timestamp
                   ];
       if($this->Common->insert('enquiry',$array))
       {
       	   $this->session->set_flashdata('Message','Enquiry Sent Successfully');
       } 
       else
       {
       	  $this->session->set_flashdata('error','Faile to Send enquiry');
       }
       redirect('contact');           
	}
	
}
