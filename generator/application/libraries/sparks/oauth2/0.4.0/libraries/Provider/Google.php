<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Google OAuth2 Provider
 *
 * @package    CodeIgniter/OAuth2
 * @category   Provider
 * @author     Phil Sturgeon
 * @copyright  (c) 2012 HappyNinjas Ltd
 * @license    http://philsturgeon.co.uk/code/dbad-license
 */

class OAuth2_Provider_Google extends OAuth2_Provider
{
	/**
	 * @var  string  the method to use when requesting tokens
	 */
	public $method = 'POST';

	/**
	 * @var  string  scope separator, most use "," but some like Google are spaces
	 */
	public $scope_seperator = ' ';

	public function url_authorize()
	{
		return 'https://accounts.google.com/o/oauth2/auth';
	}

	public function url_access_token()
	{
		return 'https://accounts.google.com/o/oauth2/token';
	}

	public function __construct(array $options = array())
	{
		// Now make sure we have the default scope to get user data
		  empty($options['scope']) and $options['scope'] = array(
        'https://www.googleapis.com/auth/userinfo.profile',
        'https://www.googleapis.com/auth/userinfo.email',
        'https://www.google.com/m8/feeds',
    );
	
		// Array it if its string
		$options['scope'] = (array) $options['scope'];
		
		parent::__construct($options);
	}

	/*
	* Get access to the API
	*
	* @param	string	The access code
	* @return	object	Success or failure along with the response details
	*/	
	public function access($code, $options = array())
	{
		if ($code === null)
		{
			throw new OAuth2_Exception(array('message' => 'Expected Authorization Code from '.ucfirst($this->name).' is missing'));
		}

		return parent::access($code, $options);
	}

	public function get_user_info(OAuth2_Token_Access $token)
	{
		$url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&'.http_build_query(array(
			'access_token' => $token->access_token,
		));
		
		$user = json_decode(file_get_contents($url), true);
		return array(
			'uid' => $user['id'],
			'nickname' => url_title($user['name'], '_', true),
			'name' => $user['name'],
			'first_name' => $user['given_name'],
			'last_name' => $user['family_name'],
			'email' => $user['email'],
			'location' => null,
			'image' => (isset($user['picture'])) ? $user['picture'] : null,
			'description' => null,
			'urls' => array(),
		);
	}




public function curl_file_get_contents($email, OAuth2_Token_Access $token) {
    $url = "https://www.google.com/m8/feeds/contacts/$email/full?max-results=" . 25 . "&oauth_token=" . $token->access_token;
    $curl = curl_init();
    $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
    curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect. 

    curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
    curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
    curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

    $contents = curl_exec($curl);
    curl_close($curl);

    return $contents;
}
}
