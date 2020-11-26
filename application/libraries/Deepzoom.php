<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deepzoom
{
	protected $CI;
	public $dz;


	public function __construct()
	{
		require_once APPPATH."third_party/Deepzoom.php";
		require_once APPPATH."third_party/DeepzoomFactory.php";
//		$this->CI =& get_instance();
		require_once  FCPATH."vendor/autoload.php";


		$deepzoom = Jeremytubbs\Deepzoom\DeepzoomFactory::create([
			'path' => 'images', // Export path for tiles
			'driver' => 'imagick', // Choose between gd and imagick support.
			'format' => 'jpg',
		]);
		$this->dz= $deepzoom;

	}


	public function makeTiles($img, $file = null,$folder = null)
	{
		$response = $this->dz->makeTiles($img, $file, $folder);
		return $response;
	}
}
