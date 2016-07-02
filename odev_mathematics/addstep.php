<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.


/**
 *Odevmathematics block definition
 *
 * @package    contrib
 * @subpackage odev_mathematics
 * @copyright  2016 OpendevTechnologies Pvt.Ltd
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
global $CFG,$DB,$USER;

$action = $_POST['action'];
   
$sql_question = "SELECT  id from {block_maths_question} ORDER BY id DESC LIMIT 1";
$question_received1= $DB->get_records_sql($sql_question); 
foreach($question_received1 as $result){
	$qestionid = $result->id;
}

$mcount   = $_POST['method_count'];
$scount   = $_POST['step_count'];
$steps    = $_POST['step'];
$stepdesc = $_POST['stepdesc'];
$stepwtg  = $_POST['step_wtg'];
	
$stepdata = new stdclass();
$stepdata->qid     = $qestionid;
$stepdata->method  = $mcount;
$stepdata->step_no = $scount;
$stepdata->step    = $steps;
$stepdata->step_weigt = $stepwtg;
$stepdata->step_desc = $stepdesc;
    
	if($action == 'edit'){
	 $que_id = $_POST['q_id'];
	 $s_id   = $_POST['s_id'];
	 $m_no   = $_POST['m_no'];
	 $s_no   = $_POST['s_no'];
 
	 $stepdata->id  = $s_id;
	 $stepdata->qid = $que_id;
	 $stepdata->method = $m_no;
	 $stepdata->step_no = $s_no;
	 $DB->update_record('block_maths_answer',$stepdata);
    }
    else{
     $newinsert_step = $DB->insert_record('block_maths_answer',$stepdata);
	}
?>