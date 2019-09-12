<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('admin/M_products','products');
			$this->load->model('Common');
			if (!admin()) {
				redirect('app');
			}
	}
	public function index()
	{
		$this->load->view('admin/products/view');
	}
	public function get()
	{
		$result = $this->products->make_datatables();
		$data = array();
		foreach ($result as $res) 
		{
			$sub_array = array();
			
			$sub_array[] = '<img src="' . base_url() . $res->image . '" height="100px">';
			$sub_array[] = $res->product_name;
			$sub_array[] = $res->quantity;
			$sub_array[] = $res->price;
			if($res->featured=='Featured')
			  {
               $star = '<a class="btn btn-link" style="font-size:10px;color:green" href="' . site_url('admin/products/featured_remove/'.$res->product_id) . '"><i class="fa fa-star fa-2x"></i></a>'; 
			  }	
			 else
			 {
              $star ='<a class="btn btn-link" style="font-size:10px;color:green" href="' . site_url('admin/products/featured/'.$res->product_id) . '"><i class="fa fa-star-o fa-2x"></i></a>';
			 } 
			$sub_array[] = $star;
			$sub_array[] = $res->status;
			$sub_array[] = '<a class="btn btn-link" style="font-size:17px;color:blue" href="' . site_url('admin/products/view/'.$res->product_id) . '"><i class="fa fa-eye"></i></a>';
			$sub_array[] = '<a class="btn btn-link" style="font-size:17px;color:blue" href="' . site_url('admin/products/edit/'.$res->product_id) . '"><i class="fa fa-pencil"></i></a>';
			$data[] = $sub_array;
		}

		$output = array(
			"draw"   => intval($_POST['draw']),
			"recordsTotal" => $this->products->get_all_data(),
			"recordsFiltered" => $this->products->get_filtered_data(),
			"data" => $data
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

	public function addCategory()
	{   
		date_default_timezone_set('Asia/Kolkata');
        $timestamp = date('Y-m-d H:i:s');

		$category = $this->security->xss_clean($this->input->post('name'));
		$image    = $this->input->post('image');
		$img      = substr($image, strpos($image, ",") + 1);

		$cat_check = $this->Common->get_details('category',array('category_name'=>$category));
		if($cat_check->num_rows()==0)
        {
        	$url      = FCPATH.'uploads/category/';
			$rand     = $category.date('Ymd').mt_rand(1001,9999);
			$userpath = $url.$rand.'.png';
			$path     = "uploads/category/".$rand.'.png';
			file_put_contents($userpath,base64_decode($img));

			$array = [
						'category_name'  => $category,
						'CategoryImage' => $path,
						'Cstatus'        => 'Active',
						'timestamp'      => $timestamp
					];
			if ($this->Common->insert('category',$array)) {
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_title', 'Success');
				$this->session->set_flashdata('alert_message', 'New category added..!');

				redirect('admin/category');
			}
			else {
				$this->session->set_flashdata('alert_type', 'error');
				$this->session->set_flashdata('alert_title', 'Failed');
				$this->session->set_flashdata('alert_message', 'Failed to add category..!');

				redirect('admin/category/add');
			}		
        }
        else
        {
    	  $this->session->set_flashdata('alert_type', 'error');
		  $this->session->set_flashdata('alert_title', 'Failed');
		  $this->session->set_flashdata('alert_message', 'Category already exists..!');
          redirect('admin/category');
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

	public function featured($id)
	{
		$array = [
			       'featured' => 'Featured'
		         ];
	
		if ($this->Common->update('product_id',$id,'products',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Product added to featured successfully..!');

			redirect('admin/products');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to add featured..!');

			redirect('admin/products');
		}
	}

	public function featured_remove($id)
	{
		$array = [
			       'featured' => 'Product'
		         ];
	
		if ($this->Common->update('product_id',$id,'products',$array)) {
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_title', 'Success');
			$this->session->set_flashdata('alert_message', 'Product removed from featured successfully..!');

			redirect('admin/products');
		}
		else {
			$this->session->set_flashdata('alert_type', 'error');
			$this->session->set_flashdata('alert_title', 'Failed');
			$this->session->set_flashdata('alert_message', 'Failed to remove from featured..!');

			redirect('admin/products');
		}
	}

	public function view($id)
	{
	  $check = $this->Common->get_details('products',array('product_id'=>$id));
	  if($check->num_rows()>0)
	  {
	  	$product = $check->row();
	  	$product->categoty = $this->Common->get_details('category',array('category_id'=>$product->category_id))->row()->category_name;
	  }	
	  else
	  {
	  	$product = '';
	  }

	  $data['product'] = $product;
	  $this->load->view('admin/products/details',$data);
 	}
}
?>
