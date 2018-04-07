<?php

header("Content-type: application/json; charset=UTF-8");

$response = Array();
// $response["message"] = Array();
$request = json_decode(file_get_contents('php://input'),true);
require('./db.php');
if($_SERVER['REQUEST_METHOD']=="POST")
{
		$response["http_code"] = 200;
		$response["message"] = "OTP Sent Successfully";
	
}
else
{
	http_response_code(405);
	$response["http_code"] = 405;
	$response["message"] = "Only POST request allowed";


}

echo json_encode($response);

?>
