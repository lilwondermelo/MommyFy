<?php
	require_once $_SERVER['DOCUMENT_ROOT'] . '/mommyfy/classes/application.class.php';
		$app = new Application();
	if (isset($_GET['phone'])) {
		$phone = $_GET['phone'];
	}
	else if (isset($_GET['email'])) {
		$email = $_GET['email'];
	}
	if (isset($_GET['code'])) {
		$code = $_GET['code'];
		$result = $app->checkCode($phone, $code) . '1';
	}
	else {
		$result = $app->loginCheck($phone) . '2';
	}
	echo json_encode(array('result' => $result));
?>