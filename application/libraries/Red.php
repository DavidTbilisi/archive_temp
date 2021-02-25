<?php
defined('BASEPATH') or exit('Error');
require_once APPPATH.'third_party/rb.php';

class Red
{
	protected $CI;

	public function __construct(){
		$this->CI =& get_instance();
		$this->CI->load->database();
		if(!R::testConnection()){
			R::setup("mysql:host=".$this->CI->db->hostname.";dbname=".$this->CI->db->database,$this->CI->db->username,$this->CI->db->password);
		}
	}
}
