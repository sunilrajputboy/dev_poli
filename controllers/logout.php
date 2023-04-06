<?php
class Logout extends Controller{
    
	public function index(){
        if (isset($_COOKIE['uid_c'])) {
            unset($_COOKIE['uid_c']); 
        } 	    
        $cookie_name = "uid_c";
        $cookie_value = 0;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
        if (session_status() === PHP_SESSION_NONE) {
           session_destroy();
        }    
        session_destroy();
        header('Location:'. BASE_URL.'login');
    }
	
}
?>