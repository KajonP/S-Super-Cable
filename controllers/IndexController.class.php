<?php


class IndexController {

    public function handleRequest(string $action="index", array $params=null) {
        $this->$action();
    }
    private function getRememberMe(){
    	$arReturn = array(
    		'Username_Employee'=>'',
    		'Password_Employee'=>''
    	);

    	if(isset($_COOKIE["remember_me_username_employee"]) && isset($_COOKIE["remember_me_password_employee"]))
        {
    		$username = base64_decode(base64_decode( $_COOKIE["remember_me_username_employee"] ));
    		$password = base64_decode(base64_decode( $_COOKIE["remember_me_password_employee"] ));
    	
    		$arReturn['Username_Employee'] = $username;
    		$arReturn['Password_Employee'] = $password;
    	}
    	return $arReturn;
    }
    private function index() {
        $remember_me = $this->getRememberMe();
        include Router::getSourcePath()."views/login.inc.php";
    }

}