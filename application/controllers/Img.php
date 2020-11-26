<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Img extends CI_Controller
{
	public function index()
	{
		$this->load->library('Deepzoom');
		$response = $this->deepzoom->makeTiles(FCPATH."images/Airbus_Pleiades_50cm_8bit_RGB_Yogyakarta.jpg", "some","folder1");
//		$response = $deepzoom->makeTiles('https://www.goodfreephotos.com/albums/united-states/wisconsin/madison/large-sunflowers-blooming-at-the-pope-conservancy-farm.jpg');


//		$response = $deepzoom->makeTiles('https://www.goodfreephotos.com/albums/united-states/wisconsin/madison/large-sunflowers-blooming-at-the-pope-conservancy-farm.jpg');
//		json_resp($response);
		$this->load->view('viewer',['data' => $response]);
	}

	public function imgs($id=null)
	{
		$this->load->library('Deepzoom');
		$response = $this->deepzoom->makeTiles(FCPATH."images/test2.png", "some","folder1");
//		$response = $deepzoom->makeTiles('https://www.goodfreephotos.com/albums/united-states/wisconsin/madison/large-sunflowers-blooming-at-the-pope-conservancy-farm.jpg');


//		$response = $deepzoom->makeTiles('https://www.goodfreephotos.com/albums/united-states/wisconsin/madison/large-sunflowers-blooming-at-the-pope-conservancy-farm.jpg');
		json_resp($response);

	}
}
