<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Scopes extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper("david");
		$this->output->enable_profiler(false);
		$this->load->library("red");
	}

	public function index()
	{
		$saqmes = $this->db->query("SELECT DISTINCT(saqme) as saqme FROM `scope3` WHERE 1 ")->result();
		foreach($saqmes as $saqme){
			echo "<p><a href='".base_url("scopes/saqme_count/{$saqme->saqme}")."'>  საქმე $saqme->saqme</a></p>";
		}
	}


	public function saqme_count($saqme_id)
	{
		$saqme = $this->db->where('saqme',$saqme_id)->get("scope3")->row();
		$count = $this->db
			->select( "count(saqme) as count_file")
			->where("creator",$saqme->creator)
			->where("fond",$saqme->fond)
			->where("anaweri",$saqme->anaweri)
			->where("saqme",$saqme->saqme)
			->get("scope3")->row();
		$sq = R::findOne("saqmereport", 'saqme_id = ?', [$saqme->saqme]);
		if (!$sq) {
			$sq = R::dispense("saqmecount");
		}
		$sq->saqmeId = $saqme->saqme;
		$sq->fileCount = $count->count_file;
		R::store($sq);


		echo $count->count_file;
	}


	public function x()
	{
//        $this->db->distinct('creator');
		$this->db->select('distinct(creator)');
//        $this->db->where('level_of_description_id','4');
//        $this->db->where('check_status','0');
//        $this->db->limit('2');
		$file_query = $this->db->get('scope3');
		$creator_array = $file_query->result_array();

//        echo '<pre>';
//        print_r($creator_array);

		$filename = APPPATH.'logs/scope3_2.log';
		foreach ($creator_array as $creator_key => $creator_value)
		{
			echo '<br>'.$creator_value['creator'];
			file_put_contents($filename, "\n".$creator_value['creator'], FILE_APPEND );


			$this->db->select('distinct(fond)');
			$this->db->where('creator',$creator_value['creator']);
			$file_query = $this->db->get('scope3');
			$fond_array = $file_query->result_array();

			foreach ($fond_array as $fond_key => $fond_value)
			{
				echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$fond_value['fond'];
				file_put_contents($filename, "\n\t".$fond_value['fond'], FILE_APPEND );
				$this->db->select('distinct(anaweri)');
				$this->db->where('fond',$fond_value['fond']);
				$file_query = $this->db->get('scope3');
				$anaweri_array = $file_query->result_array();

				foreach ($anaweri_array as $anaweri_key => $anaweri_value)
				{
					echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$anaweri_value['anaweri'];
					file_put_contents($filename, "\n\t\t".$anaweri_value['anaweri'], FILE_APPEND );

					$this->db->select('distinct(saqme)');
					$this->db->where('anaweri',$anaweri_value['anaweri']);
					$file_query = $this->db->get('scope3');
					$saqme_array = $file_query->result_array();


					foreach ($saqme_array as $saqme_key => $saqme_value)
					{
						$this->db->select('faili');
						$this->db->where('creator',$creator_value['creator']);
						$this->db->where('fond',$fond_value['fond']);
						$this->db->where('anaweri',$anaweri_value['anaweri']);
						$this->db->where('saqme',$saqme_value['saqme']);
						$file_query = $this->db->get('scope3');
						$file_array = $file_query->result_array();

                       clog($this->db->last_query());

						echo '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$saqme_value['saqme'];
						echo ' - '.count($file_array);
						file_put_contents($filename, "\n\t\t\t".$saqme_value['saqme']. " - " .count($file_array), FILE_APPEND );

					}
				}
			}
		}


//        echo $this->db->last_query();
//        echo '<pre>';
//        print_r($fond_array);
	}

}
