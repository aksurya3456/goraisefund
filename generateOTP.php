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
	$query = "select * from user where mobile = '".$mobile."'";
	$result = mysqli_query($conn,$query);
	echo mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) {
		http_response_code(403);
		$response["http_code"]=403;
		$response["message"]="Mobile number already exists in the system";
	}
	else{
		http_response_code(200);
		$query = "select * from otp where mobile = '".$mobile."'";
		$result = mysqli_query($conn,$query);
		$otp = rand(1000,9999);
		if(mysqli_num_rows($result) > 0)
		{
			$query = "update otp set otp=".$otp." where mobile ='".$mobile."'";
		}
		else
		{
			$query = "insert into otp (mobile,otp) values('".$mobile."',".$otp.")";
		}
		mysqli_query($conn,$query);

		//Integrate sms gateway



		$response["http_code"] = 200;
		$response["message"] = "otp sent successfully";
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
