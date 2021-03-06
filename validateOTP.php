<?php 

// SMS gateway to be integrated
header("Content-Type: application/json; charset=UTF-8");
        
$response = Array();
$request = json_decode(file_get_contents('php://input'),true);
require('./db.php');
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$mobile = $request['mobile'];
	//$mobile="7736156660";
	$query = "select * from otp where mobile = '".$mobile."'";
	$result = mysqli_query($conn,$query);
	echo mysqli_num_rows($result);
	if (mysqli_num_rows($result) == 0) {
		http_response_code(404);
		$response["http_code"]=404;
		$response["message"]="Invalid Mobile Number, Try Again";
	}
	else{

		$row = mysqli_fetch_assoc($result);
		$cond = ($request['otp']==$row['otp']);
		if($cond){
			http_response_code(200);
			$response["http_code"] = 200;
			$response["message"] = "OTP verified successfully";
		}
		else{
			http_response_code(400);
			$response["http_code"] = 400;
			$response["message"] = "Invalid OTP";
		}
	}
}
else
{
	http_response_code(405);
	$response["http_code"] = 405;
	$response["message"] = "Only POST request allowed";
}

echo json_encode($response);

?>
