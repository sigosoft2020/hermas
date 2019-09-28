<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
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
            $user    = $this->Common->get_details('users',array('user_id'=>$user_id))->row();
            $data['user']   = $user;
			$orders         = $this->Common->get_details('orders',array('user_id'=>$user_id))->result();
			foreach($orders as $order)
			{
			   $order->items  = $this->Common->get_details('order_items',array('order_id'=>$order->order_id))->result();
			}
	       $data['orders'] = $orders;
	       $this->load->view('site/order_history',$data);
		}
		else
		{
			redirect('login');
		}	
	}
	
}
