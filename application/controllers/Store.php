<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
			$this->load->model('site/M_products','product');
      $this->load->model('site/M_home','home');
	}

	public function index()
	{   
	    $category  = $this->Common->get_details('category',array('Cstatus'=>'Active'))->result();
	    foreach($category as $cat)
	    {
	    	$cat->count = $this->Common->get_details('products',array('category_id'=>$cat->category_id))->num_rows();
	    }
	    $data['category'] = $category;       
		$this->load->view('site/products',$data);
	}

	public function product($id)
	{
    $product         = $this->Common->get_details('products',array('product_id'=>$id))->row();
    $product->images = $this->Common->get_details('product_images',array('ProductID'=>$id))->result();
    $data['product']    = $product;
    $stock              = $this->product->get_stock($id);
    $data['stock']      = $stock;
    $data['stock_qty']  = $this->Common->get_details('stock_table',array('product_id'=>$id))->row()->stock;
    $featured           = $this->home->get_featured_products();
    $data['featured']   = $featured;
	  $this->load->view('site/single_product',$data);	
	}

	public function get_products()
	{
		$list      = array();
        $inputJSON = file_get_contents('php://input');
        $input     = json_decode($inputJSON, TRUE); 

        $products  = $this->Common->get_details('products',array('status'=>'Active'))->result();
        $Scene='<div>';
        foreach($products as $product)
        {
        	$Scene .='  <div class="col-md-3 col-sm-6 pm">
             <span class="thumbnail">
            <img src="' . base_url() . $product->image . '" alt="...">
			<div class="col-md-12 green1">
            <h4 class="">'.$product->product_name.'</h4>
           </div>
              <div class="col-md-6 col-sm-6 p-green2">
                <p class="price">'.$product->price.'</p>
              </div>
              <div class="col-md-6 col-sm-6 p-green3">
                <a class="mybtn3" href="store/product/'.$product->product_id.'"> BUY NOW</a>
              </div>              
              </span>
             </div>';
        }

        $Scene .='</div>';
        $tempData = $Scene;

       $cleanData =  json_encode($tempData);
       print_r($cleanData);
	}

	public function get_category_search()
	{
        $list      =array();
        $inputJSON = file_get_contents('php://input');
        $input     = json_decode($inputJSON, TRUE); 

        $Key       = $input['Key'];
        $result    = $this->product->get_product($Key);
      
        $Scene='<div>';
		foreach($result as $re)
		{ 
		 $count_no = $this->Common->get_details('products',array('category_id'=>$re->category_id,'status'=>'Active'))->num_rows();
		 	
         $Scene .=' <li style="list-style: none;" id="CategoryIDE'.$re->category_id.'" data-value="'.$re->category_id.'"><a onclick="CategoryFilter('.$re->category_id.')">'.$re->category_name.'<span> ('.$count_no.')</span></a></li>';

	   };
	    $Scene .='</div>';
	  
		$tempData = $Scene;
		$cleanData =  json_encode($tempData);
		print_r($cleanData);
  	}

  	public function GetProductSearch()
  	{
        $list=array();
        $inputJSON = file_get_contents('php://input');
        $input = json_decode($inputJSON, TRUE); 
        $Key=$input['Key'];

        $products = $this->product->get_search_product($Key);

        $Scene='<div>';

        foreach($products as $product)
        {
        	$Scene .='  <div class="col-md-3 col-sm-6">
             <span class="thumbnail">
            <img src="' . base_url() . $product->image . '" alt="...">
            <h4 class="green1">'.$product->product_name.'</h4>
           
           
             <div class="row merger">
              <div class="col-md-6 col-sm-6 p-green2">
                <p class="price">'.$product->price.'</p>
              </div>
              <div class="col-md-6 col-sm-6 p-green3">
                <a class="mybtn3" href="store/product/'.$product->product_id.'"> BUY NOW</a>
              </div>
              
		        </div>
		        </span>
		      </div>';
        }

        $Scene .='</div>';
        $tempData = $Scene;
        $cleanData =  json_encode($tempData);
        print_r($cleanData);
  	}

  	public function Getproductprice()
  	{
  		$list      = array();
        $inputJSON = file_get_contents('php://input');
        $input     = json_decode($inputJSON, TRUE); 

        $PFilter=$input['PFilter'];

        if($PFilter=="lowtohigh")
        {
          $result = $this->product->get_low_price_products();
        }
        elseif($PFilter=="hightolow")
        {
          $result = $this->product->get_high_price_products();
        }
        
        $Scene='<div>';

        foreach($result as $res)
        {
        	$Scene .='  <div class="col-md-3 col-sm-6">
              <span class="thumbnail">
              <img src="' . base_url() . $res->image . '" alt="...">
              <h4 class="green1">'.$res->product_name.'</h4>

             <div class="row merger">
              <div class="col-md-6 col-sm-6 p-green2">
                <p class="price">'.$res->price.'</p>
              </div>
              <div class="col-md-6 col-sm-6 p-green3">
                <a class="mybtn3" href="store/product/'.$res->product_id.'"> BUY NOW</a>
              </div>
              
	        </div>
	        </span>
	      </div>';
        }

      $Scene .='</div>';
      $tempData = $Scene;
      $cleanData =  json_encode($tempData);
      print_r($cleanData);
    }

    public function bulk_order()
    {
      $product_id = $this->security->xss_clean($this->input->post('product_id'));
      $product    = $this->security->xss_clean($this->input->post('product'));
      $price      = $this->security->xss_clean($this->input->post('price'));
      $quantity   = $this->security->xss_clean($this->input->post('qty'));
      $total      = $this->security->xss_clean($this->input->post('total'));
      $name       = $this->security->xss_clean($this->input->post('name'));
      $email      = $this->security->xss_clean($this->input->post('email'));
      $phone      = $this->security->xss_clean($this->input->post('phone'));
      $address    = $this->security->xss_clean($this->input->post('address'));
      $city       = $this->security->xss_clean($this->input->post('city'));
      $state      = $this->security->xss_clean($this->input->post('state'));
      $pincode    = $this->security->xss_clean($this->input->post('pincode'));

      $order_no='COD'.time();
      $invoice_no='CF'.time();

      $array   = [
                  'product_id'    => $product_id,
                  'price'         => $price,
                  'qty'           => $quantity,
                  'total'         => $total,
                  'name'          => $name,
                  'email'         => $email,
                  'phone'         => $phone,
                  'address'       => $address,
                  'city'          => $city,
                  'state'         => $state,
                  'pincode'       => $pincode,
                  'status'        => 'Order Placed',
                  'order_no'      => $order_no,
                  'invoice_no'    => $invoice_no
                ];
          if ($this->Common->insert('bulk_order',$array))
          {
            $this->session->set_flashdata('Message','Order Placed Successfully');
          }
          else
          {
            $this->session->set_flashdata('error','Failed to place order');
          }
        redirect ('home');  
    }

    public function CategoryFilter()
    {
      $list=array();
      $inputJSON = file_get_contents('php://input');
      $input = json_decode($inputJSON, TRUE); 

      $CategoryIDE = $input['CategoryIDE'];
      $products    = $this->Common->get_details('products',array('category_id'=>$CategoryIDE,'status'=>'Active'))->result();
      $Scene='<div>';
     
     foreach($products as $product)
      {
       $Scene .='  <div class="col-md-3 col-sm-6">
             <span class="thumbnail">
            <img src="' . base_url() . $product->image . '" alt="...">
            <h4 class="green1">'.$product->product_name.'</h4>
           
           
           <div class="row merger">
              <div class="col-md-6 col-sm-6 p-green2">
                <p class="price">'.$product->price.'</p>
              </div>
              <div class="col-md-6 col-sm-6 p-green3">
                <a class="mybtn3" href="store/product/'.$product->product_id.'"> BUY NOW</a>
              </div>
              
        </div>
        </span>
      </div>';
     };
   $Scene .='</div>';
   $tempData = $Scene;
   $cleanData =  json_encode($tempData);
   print_r($cleanData);
  }
	
}
