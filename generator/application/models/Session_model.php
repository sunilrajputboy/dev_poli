<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * This Class used as manage authorized users
 * @package   CodeIgniter
 * @category  Model
 * @author    Shahnawaz
 */

class Session_model Extends CI_Model {

    /**
     * Function Name: checkAdminSession
     * Description:   To check admin session
     */
    public function checkAdminSession()
    {
        if ($this->session->userdata('id')==TRUE)
        {
            $this->session->set_userdata('user_activity',time());
        }
        else
        {
            redirect('/');
        }
    }

	
}

/* End of file Session_model.php */
/* Location: ./application/models/Session_model.php */

?>