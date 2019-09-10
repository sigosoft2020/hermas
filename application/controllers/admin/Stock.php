<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/M_stock','stock');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{   
		$data['vendors'] = $this->Common->get_details('vendor_details',array('status'=>'Active'))->result();
		$this->load->view('admin/stock/view',$data);
	}
	public function get()
	{
		$result = $this->stock->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = $res->product_name;
			$stock       = $this->stock->get_stock($res->product_id);
			$sub_array[] = $stock;
			$sub_array[] = '<button type="button" class="btn btn-link" style="font-size:20px;color:green" onclick="add(' . $res->product_id . ',' . $stock . ')"><i class="fa fa-plus"></i></button>';
			$data[] = $sub_array;
		}

		$output = array(
						"draw"            => intval($_POST['draw']),
						"recordsTotal"    => $this->stock->get_all_data(),
						"recordsFiltered" => $this->stock->get_filtered_data(),
						"data"            => $data
					  );
		echo json_encode($output);
	}

	public function add()
	{
		$this->load->view('admin/category/add');
	}
	public function edit($id)
	{
		$check = $this->Common->get_details('category',array('category_id' => $id));
		if ($check->num_rows() > 0) {
			$data['category'] = $check->row();
			$this->load->view('admin/category/edit',$data);
		}
		else {
			redirect('category');
		}
	}
	public function addStock()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d H:i:s');

		$product_id       = $this->security->xss_clean($this->input->post('product_id'));
		$current_stock    = $this->security->xss_clean($this->input->post('current_stock'));
		$new_stock        = $this->security->xss_clean($this->input->post('new_stock'));
		$vendor_id        = $this->security->xss_clean($this->input->post('vendor_id'));
		$invoice          = $this->security->xss_clean($this->input->post('invoice_no'));
		$expiry_date      = $this->security->xss_clean($this->input->post('expiry_date'));
		$purchase_date    = $this->security->xss_clean($this->input->post('purchase_date'));

		$stock            = $current_stock+$new_stock;
		
		$stock_check = $this->Common->get_details('stock_table',array('product_id'=>$product_id));
		if($stock_check->num_rows()==0)
        {
			$array = [
						'product_id'  => $product_id,
						'stock'       => $stock, 
						'timestamp'   => $timestamp
					];
			if ($this->Common->insert('stock_table',$array)) 
			{   
				$history = [
                             'history_vendor_id'  => $vendor_id,
                             'history_invoice_no' => $invoice,
                             'history_old_stock'  => $current_stock,
                             'history_new_stock'  => $new_stock,
                             'history_pur_date'   => $purchase_date,
                             'history_exp_date'   => $expiry_date
				           ];
                $this->Common->insert('stock_history',$history);

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Stock added successfully..!');

				redirect('admin/stock');
			}
			else 
			{
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add stock..!');

				redirect('admin/stock');
			}		
        }
        else
        {
    	  $array = [
						'stock'       => $stock 
					];
			if ($this->Common->update('product_id',$product_id,'stock_table',$array)) 
			{   
				$history = [
                             'history_vendor_id'  => $vendor_id,
                             'history_invoice_no' => $invoice,
                             'history_old_stock'  => $current_stock,
                             'history_new_stock'  => $new_stock,
                             'history_pur_date'   => $purchase_date,
                             'history_exp_date'   => $expiry_date
				           ];
                $this->Common->insert('stock_history',$history);

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Stock added successfully..!');

				redirect('admin/stock');
			}
			else 
			{
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add stock..!');

				redirect('admin/stock');
			}		
        }			
	}

	public function update()
	{
		$category_id = $this->input->post('category_id');
		$category    = $this->security->xss_clean($this->input->post('name'));
		$check       = $this->Common->get_details('category',array('category_name' => $category , 'category_id!=' => $category_id))->num_rows();
		if ($check > 0) {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add category..!');

			redirect('admin/category/edit/'.$category_id);
		}
		else {
			// Adding base64 file to server
			$image  = $this->input->post('image');
			$status = $this->input->post('status');
			if ($image != '') {
				$img = substr($image, strpos($image, ",") + 1);

				$url      = FCPATH.'uploads/category/';
				$rand     = $category.date('Ymd').mt_rand(1001,9999);
				$userpath = $url.$rand.'.png';
				$path     = "uploads/category/".$rand.'.png';
				file_put_contents($userpath,base64_decode($img));

				// Remove old image from the server
				$old = $this->Common->get_details('category',array('category_id' => $category_id))->row()->CategoryImage;
				$remove_path = FCPATH . $old;
				unlink($remove_path);

				$array = [
					'category_name' => $category,
					'CategoryImage' => $path,
					'Cstatus'       => $status
				];
			}
			else {
				$array = [
					'category_name' => $category,
					'Cstatus'       => $status
				];
			}

			if ($this->Common->update('category_id',$category_id,'category',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'Changes made successfully..!');

				redirect('admin/category');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to update category..!');

				redirect('admin/amenities/edit/'.$category_id);
			}
		}
	}
	
	public function getCategoryById()
	{
		$id = $_POST['id'];
		$data = $this->Common->get_details('category',array('category_id' => $id))->row();
		print_r(json_encode($data));
	}
}
?>
