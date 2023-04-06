<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
    class Template 
    {
        var $ci;
         
        function __construct() 
        {
            $this->ci =& get_instance();
        }
        function load($tpl_view, $body_view = null, $data = null) 
		{ 
			
			
		if ( ! is_null( $body_view ) ) 
		{
      
        if ( file_exists( APPPATH.'views/admin/'.$body_view.'.php' ) ) 
        {
            $body_view_path = $body_view.'.php';
        }
        
         
         $body = $this->ci->load->view('admin/'.$body_view_path, $data, TRUE);
         
        if ( is_null($data) ) 
        {
            $data = array('body' => $body);
        }
        else if ( is_array($data) )
        {
            $data['body'] = $body;
        }
        else if ( is_object($data) )
        {
            $data->body = $body;
        }
    }
     
   $this->ci->load->view('admin/common/templates/'.$tpl_view, $data);
}

    }
    
