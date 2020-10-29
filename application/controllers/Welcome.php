<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
    
//    GE_1_1_1969 GE_{level}_{creator}_{id}
    
        public $lvl = array("fondi"=>1, "anaweri"=>2, "saqme"=>3, 'failebi'=>4);
        
        public function __construct() {
            parent::__construct();
            $this->load->helper("david");
            $this->output->enable_profiler(TRUE);
        }
        
        public function index()
	{
            
                
                dd ( $this->get_level( $this->lvl['fondi'] ) );
                
		$this->load->view('welcome_message');
	}
        
        
        
        private function get_level($level = 1, $limit = 10, $offset = 10){
            $count = $this->db
                        ->from("io_object")
                        ->where("level_of_description_id", $level)
                        ->limit($limit, $offset)
                        ->count_all_results();
            
            return ['count'=>$count, 
                        "data"=>$this->db
                        ->from("io_object")
                        ->where("level_of_description_id", $level)
                        ->limit($limit, $offset)
                        ->get()->result()
                    ];
        }
        
        public function level($level=1){
            $ds = $this->get_level($level);
            foreach ($ds["data"] as $row):
                if ($row->parent_id != 0) {
                    $row->david = "david";
                }
            endforeach;
            dd($ds);
                    
        }
        
        public function fond($id){
           return $this->db->from("io_object")
                        ->where("level_of_description_id", 1)
                        ->where("identifier", $id)
                        ->get()->result();
        }
        private function by_id($id){
           return $this->db->from("io_object")
                        ->where("identifier", $id)
                        ->get()->row();
        }
        
        
        
        
        private function has_child($id) {
            return $this->db->from("io_object")
             ->where("level_of_description_id", 3)
             ->where("parent_id", $id)
             ->get()->result(); 
        }
        /*
         * Everything but Fonds
        
SELECT
	archive_db_checker.io_object.identifier,
	archive_db_checker.io_object.parent_id,
	archive_db_checker.io_object.level_of_description_id,
	archive_db_checker.io_object_i18n.title,
	archive_db_checker.io_object_i18n.id
FROM
	archive_db_checker.io_object_i18n,
	archive_db_checker.io_object
WHERE
	archive_db_checker.io_object.level_of_description_id != "1"        
        */
        
}
