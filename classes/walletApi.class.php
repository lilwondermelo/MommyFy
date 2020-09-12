<?php

class WalletApi {
	private $path;
	public function __construct() {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/_sysSet.class.php';
		$set = new SysSet();
		$this->path = $set->getVa
	}
	function getCode() {
		$paramsYandex = array(
			'client_id'     => $sysSet->getValue('client_id_yandex'),
			'redirect_uri'  => $sysSet->getValue('auth_path') . 'yandexLogin.php',
			'response_type' => 'code',
			'state'         => '123'
		);
		$urlYandex = 'https://oauth.yandex.ru/authorize?' . urldecode(http_build_query($paramsYandex));
		return ("Location: " . $urlYandex);
		header 
	}
}



if (!empty($_GET['code'])) {
	session_start ();
	
	$state = $_GET['state'];
	$params = array(-
		'grant_type'    => 'authorization_code',
		'code'          => $_GET['code'],
		'client_id'     => $sysSet->getValue('client_id_yandex'),
		'client_secret' => $sysSet->getValue('client_secret_yandex')
	);
	
	$ch = curl_init('https://oauth.yandex.ru/token');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $params); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$data = curl_exec($ch);
	curl_close($ch);	
			 
	$data = json_decode($data, true);
	if (!empty($data['access_token'])) {
		// Токен получили, получаем данные пользователя.
		$ch = curl_init('https://login.yandex.ru/info');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('format' => 'json')); 
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: OAuth ' . $data['access_token']));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HEADER, false);
		$info = curl_exec($ch);
		curl_close($ch);
 
		$info = json_decode($info, true);

	$_SESSION['authData'] = array(
			'socId' => $info['id'],
			'email' => $info['emails'][0],
			'display_name'  => $info['display_name'],
			'first_name'   => $info['first_name'],
			'last_name'  => $info['last_name'],
			'authType'   => 'yandex'
		);
	}
	header("Location: ".$sysSet->getSiteUrl);


}
else {
	
}
?>