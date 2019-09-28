<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
			$this->load->model('site/M_home','home');
	}

	public function index()
	{    
        $featured           = $this->home->get_featured_products();
        $data['featured']   = $featured;
        $latest             = $this->home->get_latest_products();
        $data['latest']     = $latest;
        $products           = $this->home->get_products();
        $data['products']   = $products;
		$this->load->view('site/site_index',$data);
	}

	public function newsletter()
	{
		date_default_timezone_set('Asia/Kolkata');
	    $timestamp  = date('Y-m-d H:i:s');

	      $email      = $this->security->xss_clean($this->input->post('sub_email'));
	      $array      =[
	      	             'news_email'  => $email,
	                     'news_status' => 'Active',
	                     'timestamp'   => $timestamp
	                   ];
	       if($this->Common->insert('newsletter',$array))
	       {
	       	   $this->session->set_flashdata('Message','Newsletter subscribed Successfully');
	       } 
	       else
	       {
	       	  $this->session->set_flashdata('error','Faile to subscribe');
	       }
	       redirect('home');   
	}	
}
