<?php 
include "android_connection.php";

$sql="SELECT * FROM news";
$result = mysqli_query($conn,$sql);

if(mysqli_num_rows($result) > 0)
{
	while ($row= mysqli_fetch_assoc($result)) 
	{
		$news[] = $row;
		$status = "success";
	}
}
else
{
	$news[] = "no news";
	$status = "failed";
}
$output['news'] = $news;
$output['status'] = $status;

$pass = $output;

print_r(json_encode($pass));

?>