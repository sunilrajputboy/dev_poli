<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This Class used as manage authorized users
 * @package   CodeIgniter
 * @category  Controller
 * @author    Shahnawaz
 */

class User_session_model Extends CI_Model {

    /**
     * Function Name: checkAdminSession
     * Description:   To check user session
     */
    public function checkUserSession()
    {
        if ($this->session->userdata('user_id')==TRUE)
        {
            $this->session->set_userdata('user_activity',time());
        }
        else
        {
            redirect('users/login_page');
        }
    }

	
}

/* End of file User_session_model.php */
/* Location: ./application/models/Session_model.php */

?>