<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {
	public function __construct()
	{
			parent::__construct();
			$this->load->model('Common');
			$this->load->model('site/M_products','product');
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
		 $count_no = $this->Common->get_details('products',array('category_id'=>$re->category_id))->num_rows();
		 	
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
                <a class="mybtn3" href="product-single.php?id='.$product->product_id.'"> BUY NOW</a>
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
	
}
