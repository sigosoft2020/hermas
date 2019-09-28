<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Checkout extends CI_Controller {
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
		    $this->load->view('site/checkout',$data);
		}
		else
		{
			redirect('login');
		}    
	}

	public function add()
	{
	  if ($this->session->userdata('site_user')) 
	    {
		    $user = $this->session->userdata('site_user');
			$user_id = $user['user_id']; 
			$user    = $this->Common->get_details('users',array('user_id'=>$user_id))->row();
            $name    = $user->name;
            $phone   = $user->phone;
            $email   = $user->email;
			if(isset($_POST['savecheckout']))
			{
				$house      = $this->security->xss_clean($this->input->post('house'));
				$address_1  = $this->security->xss_clean($this->input->post('address_1'));
				$address_2  = $this->security->xss_clean($this->input->post('address_2'));
				$city       = $this->security->xss_clean($this->input->post('city'));
				$landmark   = $this->security->xss_clean($this->input->post('landmark'));
				$pincode    = $this->security->xss_clean($this->input->post('pincode'));
				$state      = $this->security->xss_clean($this->input->post('state'));
                
                $cart       = $cart_check = $this->Common->get_details('cart',array('user_id'=>$user_id))->result();
				$grandtotal=0;
				 foreach($cart as $c)
				  {
					 $total=$c->total; 
					 $grandtotal=$grandtotal+$total;
				  };

				$order_no   = 'COD'.time();
				$invoice_no = 'CF'.time();

				$order   = [
                             'order_no'    => $order_no,
                             'invoice_no'  => $invoice_no,
                             'grand_total' => $grandtotal,
                             'user_id'     => $user_id,
                             'user_type'   => 'User',
                             'name'        => $name,
                             'phone'       => $phone,
                             'email'       => $email,
                             'house'       => $house,
                             'address_1'   => $address_1,
                             'address_2'   => $address_2,
                             'city'        => $city,
                             'landmark'    => $landmark,
                             'pincode'     => $pincode,
                             'state'       => $state,
                             'status'      => 'Order Placed'
				          ];
                if($id = $this->Common->insert('orders',$order))
                 {
                 	$address  = [
                                  'house' => $house,
                                  'address_1' => $address_1,
                                  'address_2' => $address_2,
                                  'city'      => $city,
                                  'landmark'  => $landmark,
                                  'pincode'   => $pincode,
                                  'user_id'   => $user_id
                 	            ];
                    $this->Common->insert('address_table',$address); 

                   foreach($cart as $c)
					{    
						 $cart_id       = $c->cart_id;
						 $total         = $c->total; 
			             $product_id    = $c->product_id; 
						 $product_price = $c->price; 						 
						 $quantity      = $c->quantity; 

						 $product        = $this->Common->get_details('products',array('product_id'=>$c->product_id))->row();
                         $product_name  = $product->product_name; 
						 $product_image = $product->image; 
						 $packet_size   = $product->quantity; 
						 $product_stock = $this->Common->get_details('stock_table',array('product_id'=>$product_id))->row();
						 $stock_id      = $product_stock->stock_id;
						 $stock         = $product_stock->stock;
						 if($stock>$quantity)
						 {
						 	$new_stock  = $stock-$quantity; 
						 }
						 else
						 {
						 	$new_stock = '0';
						 }

						 $order_items   = [
                                            'order_id'     => $id,
                                            'product_id'   => $product_id,
                                            'product_image' => $product_image,
                                            'product_name'  => $product_name,
                                            'packet_size'   => $packet_size,
                                            'quantity'      => $quantity ,
                                            'product_price' => $product_price,
                                            'total'         => $total,
                                            'order_no'      => $order_no,
                                            'invoice_no'    => $invoice_no
						                  ];
						$this->Common->insert('order_items',$order_items); 
						$this->Common->delete('cart',array('cart_id' => $cart_id)); $stock_array  = [ 
							              'stock' => $new_stock
						                ];  
						$this->Common->update('stock_id',$stock_id,'stock_table',$stock_array);                
					};
				   $this->session->set_flashdata('message',"Order placed successfully");
                   redirect('checkout/orders/'.$id);
                 }					
				else
				{
				  $this->session->set_flashdata('message',"Failed to place order");
                  redirect('cart');
				}
			};

		
		  if(isset($_POST['checkout']))
			{
				$house      = $this->security->xss_clean($this->input->post('house'));
				$address_1  = $this->security->xss_clean($this->input->post('address_1'));
				$address_2  = $this->security->xss_clean($this->input->post('address_2'));
				$city       = $this->security->xss_clean($this->input->post('city'));
				$landmark   = $this->security->xss_clean($this->input->post('landmark'));
				$pincode    = $this->security->xss_clean($this->input->post('pincode'));
				$state      = $this->security->xss_clean($this->input->post('state'));
                
                $cart       = $cart_check = $this->Common->get_details('cart',array('user_id'=>$user_id))->result();
				$grandtotal=0;
				 foreach($cart as $c)
				  {
					 $total=$c->total; 
					 $grandtotal=$grandtotal+$total;
				  };

				$order_no   = 'COD'.time();
				$invoice_no = 'CF'.time();

				$order   = [
                             'order_no'    => $order_no,
                             'invoice_no'  => $invoice_no,
                             'grand_total' => $grandtotal,
                             'user_id'     => $user_id,
                             'user_type'   => 'User',
                             'name'        => $name,
                             'phone'       => $phone,
                             'email'       => $email,
                             'house'       => $house,
                             'address_1'   => $address_1,
                             'address_2'   => $address_2,
                             'city'        => $city,
                             'landmark'    => $landmark,
                             'pincode'     => $pincode,
                             'state'       => $state,
                             'status'      => 'Order Placed'
				          ];
                if($id = $this->Common->insert('orders',$order))
                 {
                   foreach($cart as $c)
					{    
						 $cart_id       = $c->cart_id;
						 $total         = $c->total; 
			             $product_id    = $c->product_id; 
						 $product_price = $c->price; 						 
						 $quantity      = $c->quantity; 

						 $product        = $this->Common->get_details('products',array('product_id'=>$c->product_id))->row();
                         $product_name  = $product->product_name; 
						 $product_image = $product->image; 
						 $packet_size   = $product->quantity; 
						 $product_stock = $this->Common->get_details('stock_table',array('product_id'=>$product_id))->row();
						 $stock_id      = $product_stock->stock_id;
						 $stock         = $product_stock->stock;
						 if($stock>$quantity)
						 {
						 	$new_stock  = $stock-$quantity; 
						 }
						 else
						 {
						 	$new_stock = '0';
						 }

						 $order_items   = [
                                            'order_id'     => $id,
                                            'product_id'   => $product_id,
                                            'product_image' => $product_image,
                                            'product_name'  => $product_name,
                                            'packet_size'   => $packet_size,
                                            'quantity'      => $quantity ,
                                            'product_price' => $product_price,
                                            'total'         => $total,
                                            'order_no'      => $order_no,
                                            'invoice_no'    => $invoice_no
						                  ];
						$this->Common->insert('order_items',$order_items); 
						$this->Common->delete('cart',array('cart_id' => $cart_id));
						$stock_array  = [ 
							              'stock' => $new_stock
						                ];  
						$this->Common->update('stock_id',$stock_id,'stock_table',$stock_array);    
					};
				   $this->session->set_flashdata('message',"Order placed successfully");
                   redirect('checkout/orders/'.$id);
                 }					
				else
				{
				 $this->session->set_flashdata('message',"Failed to place order");
                  redirect('cart');
				}
		   };	
		}
		else
		{
			redirect('login');
		}		

	}

	public function orders($id)
	{
      $order         = $this->Common->get_details('orders',array('order_id'=>$id))->row();
      $data['order'] = $order;
      $ordered_item  = $this->Common->get_details('order_items',array('order_id'=>$id))->result();
      $data['order_items'] = $ordered_item;
      $this->load->view('site/order',$data);
	}
	
	
}
