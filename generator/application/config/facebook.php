<?php defined('BASEPATH') OR exit('No direct script access allowed');
$config['facebook_app_id']              = '2018780051676322';
$config['facebook_app_secret']          = '7e660fd9d178d4eecf9c238dd9f0f876';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = base_url().'users/socialWithFb';
$config['facebook_logout_redirect_url'] = base_url().'users/logout';
$config['facebook_permissions']         = array('email');
$config['facebook_graph_version']       = 'v2.12';
$config['facebook_auth_on_load']        = TRUE;