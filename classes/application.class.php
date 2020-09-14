<?php
class Application {
        public $error;
	private $code;
	function sendCode($phone) {
                require_once $_SERVER['DOCUMENT_ROOT'] . '/mommyfy/core/_dataRowUpdater.class.php';
                $updater = new DataRowUpdater('dir_users');
        	$updater->setKey('phone', $phone);
                $updater->setDataFields(array('code' => "'" . $code . "'"));
                $result = $updater->update();
                if (!$result) {
                        $this->error = $updater->error;
                        return $this->error;
                }
        	return $result;
	}
	function loginCheck($phone) {
		require_once $_SERVER['DOCUMENT_ROOT'] . '/mommyfy/core/_dataRowSource.class.php';
                $dataRow = new DataRowSource('select phone, code from dir_users where phone="' . $phone . '"');
                $html = '';
                if (!$dataRow) {
                        $this->code = random_int(1000, 9999);
                }
                else {
                        $this->code = $dataRow->getValue('code');
                }
                $sendCode = $this->sendCode($phone);
                return $sendCode;
        	}
        function checkCode($phone, $code) {
        	require_once $_SERVER['DOCUMENT_ROOT'] . '/mommyfy/core/_dataRowSource.class.php';
                $dataRow = new DataRowSource('select code from dir_users where phone="' . $phone . '" and code="' . $code . '"');
                if (!$dataRow) {
                        return false;
                }
                return true;
	}
}
?>