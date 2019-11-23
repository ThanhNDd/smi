<?php
require '../../../../vendor/autoload.php';

use Automattic\WooCommerce\Client;

class WooAPI
{
    public $woocommerce;

	public function __construct()
    {
        
    }

    public function connect()
    {
    	$url = 'https://shopmein.net';
    	$consumer_key = 'ck_183a813059fc81d1df510f3c620d1e24f8bf904d';
    	$consumer_secret = 'cs_b1bed1d17a93c572f181808b5808f42974c7b0b5';
    	$options = array(
            'version' => 'wc/v3',  
            'verify_ssl' => false, 
            'wp_api' => true);
		return $this->woocommerce = new Client( $url, $consumer_key, $consumer_secret, $options);
    }
}