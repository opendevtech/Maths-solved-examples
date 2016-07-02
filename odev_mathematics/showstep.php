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
$PAGE->set_context(context_system::instance());
$url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/showstep.php');
$PAGE->set_url($url);
$PAGE->set_title('Maths Question Steps');
$PAGE->set_heading('Maths Questions');
$PAGE->set_pagelayout('standard');
echo $OUTPUT->header();
global $CFG,$DB,$USER;
$page_cur=(isset($_GET['page']))?$_GET['page']:1;
$displaydata;
$displaydata=html_writer::start_tag('span',array('id'=>'viewlink_que'));
$displaydata.='<input type = "button"  onClick = "view_que();"  value= "View Question">';
$displaydata.=html_writer::end_tag('span');
echo $displaydata;

$table = new html_table(array('id'=>'steptable'));
$table->head = array('Question no.','Que_name', 'Method','Step_no','steps','Step_Desc','Step_Wtg','Edit');

$sql_question = "SELECT  id,question_desc from {block_maths_question} ORDER BY id DESC LIMIT 1";
$question_received1= $DB->get_records_sql($sql_question); 
foreach($question_received1 as $question){
	    $qestion_id = $question->id;
	    $que_name   = $question->question_desc;
		
		$sql_answer = "SELECT * FROM {block_maths_answer} where qid ='$qestion_id'";
		$answer_recieved = $DB->get_records_sql($sql_answer);
		foreach($answer_recieved as $answer){
			$stepid   = $answer->id;
			$m_count  = $answer->method;
			$s_count  = $answer->step_no;
			$step     = $answer->step;
			$s_desc   = $answer->step_desc;
			$s_wtg    = $answer->step_weigt;
			$editparam = array('action'=>'edit','que_id'=>$qestion_id,'step_id'=>$stepid,'mno'=>$m_count,'sno'=>$s_count,'pageid'=>$page_cur);
		    $edit_url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/display_math.php',$editparam);
			$editlink = html_writer::link($edit_url,'Edit');
			$table->data[] = array($qestion_id,format_text($que_name),$m_count, $s_count, format_text($step),$s_desc,$s_wtg,$editlink);
		}
}

echo html_writer::table($table); 
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/maths.js'));
echo $OUTPUT->footer();
?>