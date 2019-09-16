<?php

  include "db/config.php";
  
    $cat_id = $_POST['cat_id'];
    
    if($cat_id=='0'){
    $list = mysqli_query($conn,"SELECT * FROM category");
    $data=mysqli_fetch_row($list);
    $string="";
    foreach($list as $data)
    {
        $string= $string."<option value='".$data['category_id']."'>".$data['category_name']."</option>";
    }
    print_r(json_encode($string)); 
    }
    
    else
    {
       $list = mysqli_query($conn,"SELECT * FROM products");
    $data=mysqli_fetch_row($list);
    $string="";
    foreach($list as $data)
    {
        $string= $string."<option value='".$data['product_id']."'>".$data['product_name']."</option>";
    }
    print_r(json_encode($string)); 
    }
    
?>