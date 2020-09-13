<?php
class Application {
	private $code;
	function sendCode($phone) {
		$this->code = random_int(1000, 9999);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/core/_dataRowUpdater.class.php';
        $updater = new DataRowUpdater('dir_users_tmp');
		$updater->setKey('phone', $phone);
        $updater->setDataFields(array('code' => $this->code));
        $result = $updater->update();
		return $this->code;
	}
	function loginCheck($phone) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/core/_dataRowSource.class.php';
        $dataRow = new DataRowSource('select count(*) from dir_users where phone="' . $phone . '"');
        $html = '';
        if (!$dataRow) {
        	//Это убрать, возвращать форму ввода пароля вместо самого кода. Код в смс отправлять!
        	$sendCode = $this->sendCode();
        	return array('form' => $html, 'code' => $sendCode);
        }
        else {
        	return $html;
        }
	}
	function checkCode($phone, $code) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/core/_dataRowSource.class.php';
        $dataRow = new DataRowSource('select count(*) from dir_users where phone="' . $phone . '" and code="' . $code . '");
	}
}
?>