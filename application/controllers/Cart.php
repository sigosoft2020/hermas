<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
	}

	public function index()
	{   
	    if ($this->session->userdata('site_user')) 
	    {
		    $user = $this->session->userdata('site_user');
			$user_id = $user['user_id'];      
			$cart_check = $this->Common->get_details('cart',array('user_id'=>$user_id));
			if($cart_check->num_rows()>0)
			{
				$cart = $cart_check->result();
				foreach($cart as $c)
				{   
					$product  = $this->Common->get_details('products',array('product_id'=>$c->product_id))->row();
					$c->name  = $product->product_name;
					$c->image = $product->image;
				}
			}
			else
			{
				$cart = '';
			}
			$data['cart_check'] = $cart_check;
			$data['cart'] = $cart;
		    $this->load->view('site/cart',$data);
		}
		else
		{
          redirect('login');
		}     
	}

	public function cart_data()
	{
		    $inputJSON = file_get_contents('php://input');
			$input = json_decode($inputJSON, TRUE); 

			$product_id=$input['product_id'];
			$quantity=$input['quantity'];

			 $product = $this->Common->get_details('products',array('product_id'=>$product_id))->row();
			// Add product name to variable, since we will use it often
			// This would be key in cart array.

			// $product_id = $row["product_id"];
			$product_name = $product->product_name;
			$price        = $product->price;
			$image        = $product->image;
			$product_qty  = $product->quantity;

			$total = $quantity*$price;

			// Array with product data
			$itemArray = array('product_id' => $product_id , 'product_name' => $product_name,  'quantity' => $quantity, 'price' => $price, 'image' => $image, 'product_qty' => $product_qty, 'total' => $total );

			// Check if cart has some products already
			if(!empty($_SESSION["cart_item"])) {

			  // Is product already in cart? If so, edit only quantity
			  if(in_array($product_id, array_keys($_SESSION["cart_item"]))) {
			    $_SESSION["cart_item"][$product_id]["quantity"] = $quantity;
			    $_SESSION["cart_item"][$product_id]["total"] = $total;
			  } else {
			    // Product is not in cart, but we have other products in cart.
			    // So just add to existing cart array.
			    $_SESSION["cart_item"][$product_id] = $itemArray;
			  }
			}
			else {
			    // No products, create cart session and add first product
			    $_SESSION["cart_item"] = array();
			    $_SESSION["cart_item"][$product_id] = $itemArray;
			}
	}

	public function add()
	{
		if ($this->session->userdata('site_user')) 
		{
		    $user       = $this->session->userdata('site_user');

			// $ $inputJSON = file_get_contents('php://input');
			// $input       = json_decode($inputJSON, TRUE); 

			$product_id = $_POST['product_id'];
		    $quantity = $_POST['quantity'];
			// $product_id=$input['product_id'];
			// $quantity=$input['quantity'];

			// print_r($product_id);
              
			 $product = $this->Common->get_details('products',array('product_id'=>$product_id))->row();
			
			$product_name = $product->product_name;
			$price        = $product->price;
			$image        = $product->image;
			$product_qty  = $product->quantity;

			$total = $quantity*$price;

			$user_id   = $user['user_id'];
			$check     = $this->Common->get_details('cart',array('product_id' => $product_id, 'user_id' => $user_id));

    	     if ($check->num_rows() > 0) 
    	     {  
    	     	$current_qty = $check->row()->quantity;
    	     	$new_qty     = $quantity+$current_qty;
    	     	$new_price   = $new_qty*$price;
				$array = [				
					'quantity' => $new_qty,
					'total'    => $new_price
				];
				if ($this->Common->update('cart_id',$check->row()->cart_id,'cart',$array)) {
					$this->session->set_flashdata('message',"Cart item updated");
					redirect('cart');
				}
				else {
					$this->session->set_flashdata('error',"Failed to update the quantity");
					redirect('cart');
				}
			}  
			else 
			{
				$cart = [
							'product_id'  => $product_id,
							'user_id'     => $user_id,
							'quantity'    => $quantity,
							'price'       => $price,
							'total'       => $total,
							'timestamp'   => date("Y-m-d H:i:s")					
						];
				if ($this->Common->insert('cart',$cart)) {
					$this->session->set_flashdata('message',"Item added to cart");
					redirect('store/product/'.$product_id);
				}
				else {
					$this->session->set_flashdata('error',"Failed to add product to cart");
					redirect('home');
				}
			}
		}
		else {
			$url = $this->input->post('url');
			$this->session->set_flashdata('message','Please sign in to start your session');
			$this->session->set_userdata('redirect_url',$url);
			redirect('login');
		}
	}

	public function delete($id)
	{
		if ($this->Common->delete('cart',array('cart_id' => $id))) 
		{				
			$this->session->set_flashdata('message', 'Item deleted from cart');			
		}
		else 
		{
			$this->session->set_flashdata('error', 'Failed to delete item from cart');
		}
		redirect('cart');
	}
	
}
