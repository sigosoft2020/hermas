<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/Live_orders','live');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/orders/live_orders');
	}
	public function get()
	{
		$result = $this->live->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->order_no;
			$sub_array[] = $res->invoice_no;
			$sub_array[] = $res->name;
			$sub_array[] = $res->email;
			$sub_array[] = $res->phone;
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:16px;color:blue" href="' . site_url('admin/orders/view/'.$res->order_id) . '" ><i class="fa fa-eye"></i></a>';
			$sub_array[] = '<button type="button" class="btn btn-link" style="font-size:20px;color:blue" onclick="edit(' . $res->order_id . ')"><i class="fa fa-pencil"></i></button>';
            
	
			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->live->get_all_data(),
						"recordsFiltered" => $this->live->get_filtered_data(),
						"data"            => $data
					   );
		echo json_encode($output);
	}

	public function view($id)
	{
      $check = $this->Common->get_details('orders',array('order_id'=>$id));
      if($check->num_rows()>0)
      {
      	$order          = $check->row();
      	$order->items   = $this->Common->get_details('order_items',array('order_id'=>$id))->result();
      	foreach($order->items as $item)
      	{
      	  $product      = $this->Common->get_details('products',array('product_id'=>$item->product_id))->row();	
      	  $item->price  = $product->b2b_price;	
      	}
      	$data['order']   = $order;
      	$this->load->view('admin/orders/view_order.php',$data);
      }  
      else
      {
      	redirect('orders');
      }
	}

	public function addSalesman()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d H:i:s');

		$name = $this->security->xss_clean($this->input->post('name'));

		$vendor_check = $this->Common->get_details('salesman',array('salesman_name'=>$name));
		if($vendor_check->num_rows()==0)
        {
			$array = [
						'salesman_name'    => $name,
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
    	  $this->session->set_flashdata('alert_type', 'error');
		  $this->session->set_flashdata('alert_title', 'Failed');
		  $this->session->set_flashdata('alert_message', 'Salesman already exists..!');
          redirect('admin/salesman');
        }			
	}

	public function update()
	{
		$salesman_id   = $this->input->post('salesman_id');
		$salesman      = $this->security->xss_clean($this->input->post('salesman'));
		$check         = $this->Common->get_details('salesman',array('salesman_name' => $salesman , 's_id!=' => $salesman_id))->num_rows();
		if ($check > 0) 
		{
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add salesman..!');

			redirect('admin/salesman');
		}
		else 
		{
			$array = [
				       'salesman_name' => $salesman
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

				redirect('admin/salesman');
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

				redirect('admin/salesman');
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
