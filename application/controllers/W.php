<?php
defined('BASEPATH') or exit('No direct script access allowed');

class W extends CI_Controller
{


//    GE_1_1_1969 
//    GE_{repo}_{creator}_{identifier}
	// repo - saitsorio || uaxlesig
	public $lvl = array("fondi" => '1', "anaweri" => '2', "saqme" => '3', 'failebi' => '4');

	public function __construct()
	{
		parent::__construct();
		$this->load->helper("david");
		$this->output->enable_profiler(false);
	}

	public function index()
	{
		$data = $this->db->query("SELECT `id` FROM `io_object` WHERE `level_of_description_id` = 1 order by `id` DESC")->result();

		foreach ($data as $key => $value):
			echo "<a href='".base_url('w/test/').$value->id."' > {$value->id} </a> <br>";
		endforeach;
	}

	private function check_table_connection ($id){

		$sql = "SELECT archive_db_checker.io_object_i18n.id 
				FROM 
            	archive_db_checker.io_object_i18n
        		WHERE
            	archive_db_checker.io_object_i18n.id = {$id}";
		$io_obj_18 = $this->db->query($sql)->row();

		if (empty($io_obj_18)) {
			$insert = "INSERT INTO `io_object_i18n` (`check_status`,`title`, `is_start_exect_creation`, `start_year_creation`, `start_month_creation`, `start_day_creation`, `is_end_exect_creation`, `end_year_creation`, `end_month_creation`, `end_day_creation`, `is_start_exect_accumulation`, `start_year_accumulation`, `start_month_accumulation`, `start_day_accumulation`, `is_end_exect_accumulation`, `end_year_accumulation`, `end_month_accumulation`, `end_day_accumulation`, `language_and_script_notes`, `publication`, `extent_and_medium`, `archival_history`, `acquisition`, `scope_and_content`, `appraisal`, `accruals`, `arrangement`, `access_conditions`, `reproduction_conditions`, `physical_characteristics`, `finding_aids`, `location_of_originals`, `location_of_copies`, `related_units_of_description`, `id`, `culture`, `note`) VALUES (1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '{$id}', '', NULL)";
			$this->db->query($insert);

		} else {
			$update = "UPDATE io_object_i18n set check_status = 1 WHERE id = {$id}";
			$this->db->query($update);
		}
	}

	public function get_children ($id, $level = 1)
	{
		$get_current = "select id,level_of_description_id as level, parent_id from io_object where level_of_description_id  = {$level} and parent_id = {$id}";
		$current = $this->db->query($get_current)->result();
		return $current;
	}

	public function count_children($id, $level = 1)
	{
		$get_current = "select count(id) as children_count from io_object where level_of_description_id = {$level} and parent_id = {$id}";
		$current = $this->db->query($get_current)->row()->children_count;
		return $current;
	}


	public function set_io_status($status_code, $id)
	{
		$sql = "update io_object set check_status = {$status_code} where id = {$id}";
		$this->db->query($sql);
	}

	public function reset() {
		$update = "UPDATE io_object set check_status = 0 WHERE check_status > 0";
		$this->db->query($update);
		redirect("/");
	}

	public function get_by_id($id, $level = 1)
	{
		$sql = "select id,level_of_description_id as level, parent_id from io_object where level_of_description_id  = {$level} and id = {$id}";
		return $this->db->query($sql)->result();
	}

//	Dependent FN-s
	public function parent_have_children_in_nextlevel($id, $level)
	{
			$ch_count = $this->count_children($id, $level);
			if ($level > 2 && $ch_count > 0) {
				$this->set_io_status(1,$id);
			} else if ($level > 2) {
				// skips first level
				$this->set_io_status(2, $id);
			}
	}

	protected function init ($id, $level = 1) {
		if ($level == 1) $this->fond_check_history($id);

		$this->check_table_connection($id);
		$this->parent_have_children_in_nextlevel($id, $level);
		return $this->get_children($id, $level);
	}

	public function fond_check_history($id)
	{
		$table = 'checked_fond_list';
		$io_id_name = 'io_objet_id';
		$count = $this->db->from($table)->where($io_id_name,$id)->count_all_results();
		if ($count > 0 ) {
			$this->db->insert($table, [$io_id_name=>$id]);
		} else {
			$this->db->where($io_id_name, $id);
			$this->db->update($table, [$io_id_name=>$id]);
		}

	}


	public function not_checked_list()
	{
		$sql = "SELECT * FROM `io_object` WHERE io_object.level_of_description_id = 1 and io_object.id not in (SELECT checked_fond_list.io_objet_id from checked_fond_list) ORDER BY `io_object`.`id` ASC ";
		$this->db->query($sql)->result();
	}


	public function test ($id) {
		$data = $this->get_by_id($id);
		foreach ($data as $k1 => $v1):
			print("├── l1_i{$v1->id}\n<br>");
			$data2 = $this->init($v1->id, 2);

			foreach ($data2 as $k2 => $v2):
				print("│\t├── l2_i{$v2->id}_p{$v1->id}\n<br>");

				$data3 = $this->init($v2->id, 3);
				foreach ($data3 as $k3 => $v3):
					print("│\t│\t├── l3_i{$v3->id}_p{$v2->id}\n<br>");

					$data4 = $this->init($v3->id, 4);
					foreach ($data4 as $k4 => $v4):

						print("│\t│\t│\t├──  l4_i{$v4->id}_p{$v3->id}\n<br>");
						$data5 = $this->init($v4->id, 5);

					endforeach;
				endforeach;
			endforeach;
		endforeach;

	}





}


/*
 *
 *
 *
 *





























 */
