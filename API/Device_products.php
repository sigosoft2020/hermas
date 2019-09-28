<?php 

include 'Device_connection.php';

$Key=$_POST['Key'];

if($Key=='Brand')
{

$BrandID=$_POST['BrandID'];
   $query="SELECT * FROM products WHERE BrandId='$BrandID'"; 
   $result=mysqli_query($conn,$query);



if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $Product[]=$row;

}

}
else
{
   $Product[]="No Products";
}




$output['Product']=$Product;





$pass=$output;




}
elseif($Key=='SubCategory')
{

$SubategoryID=$_POST['SubCategoryID'];
$status=$_POST['loc_stat'];

if($status == '1'){
    //$query="SELECT * FROM products WHERE Subcategory_ID='$SubategoryID' AND pflag='1'";
    
    //$result=mysqli_query($conn,$query);
    
    
    $query="SELECT * from products WHERE Subcategory_ID='$SubategoryID' AND pflag='1' ";
}
else{
    //$query="SELECT * FROM products WHERE Subcategory_ID='$SubategoryID'";
    //$result=mysqli_query($conn,$query);
    $query="SELECT * FROM products WHERE Subcategory_ID='$SubategoryID'";
}

$result=mysqli_query($conn,$query);


if(mysqli_num_rows($result)>0)

{

while($row=mysqli_fetch_assoc($result))
{
   $Product[]=$row;

}

}
else
{
   $Product[]="No Products";
}

$output['Product']=$Product;

$pass=$output;

};

print_r(json_encode($pass));

?>