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
require_once('../../lib/formslib.php');
require_once('maths_form.php');
require_once('locallib.php');
require_once('../../lib/moodlelib.php');
require_once('../../lib/filelib.php'); 
$PAGE->set_context(context_system::instance());
$url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/display_math.php');
$PAGE->set_url($url);
$PAGE->set_title('Maths Solved Examples');
$PAGE->set_heading('Maths Questions');
$PAGE->set_pagelayout('standard');

echo $OUTPUT->header();


global $CFG,$DB,$PAGE;

$action = required_param('action',PARAM_TEXT);
$queid = optional_param('que_id', 0, PARAM_INT);
$sid = optional_param('step_id', 0, PARAM_INT);
$page_cur=(isset($_GET['page']))?$_GET['page']:1;
$set_data = '';
$context = block_odev_mathematics_get_context(CONTEXT_COURSE, 1, MUST_EXIST);
$editoroptions = array('maxfiles' => EDITOR_UNLIMITED_FILES, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false, 'subdirs'=>true,'noclean'=>true);
$editoroptions['context'] = $context;
$mform= new odev_maths_form(null,array('action'=>$action,'context'=>$context,'editoroptions'=>$editoroptions));
$fileoptions = array('maxfiles' => 1, 'maxbytes'=>$CFG->maxbytes, 'trusttext'=>false,'noclean'=>true,'subdirs'=>false);
$fileoptions['context'] = $context;  

$fromform = $mform->get_data();

if($action == 'edit'){
   $qrecord = $DB->get_records('block_maths_question' ,array('id'=>$queid)); 
   $srecord = $DB->get_records('block_maths_answer' ,array('id'=>$sid,'qid'=>$queid));//fetch record fron database having specific id

	$retrive_ans= new stdClass();
	$retrive_ques= new stdClass();
	foreach ($qrecord  as $q_record)
    {
		$retrive_ques->qname = $q_record->question_type ;
		$retrive_ques->summary = $q_record->question_desc ;
		$retrive_ques->queweightage = $q_record->weightage;
		$retrive_ques->date = $q_record->qdate;
		$retrive_ques->que_id = $q_record->id;
	}
    foreach ($srecord as $s_records)
    {
		$retrive_ans->textfield = $s_records->step ;
		$retrive_ans->introduction = $s_records->step_desc ; 
		$retrive_ans->stepweightage = $s_records->step_weigt ; 
		$retrive_ans->step_id = $s_records->id ; 
		$retrive_ans->mno = $s_records->method ;
        $retrive_ans->sno = $s_records->step_no ; 		
	} 
	$mform->set_data(file_prepare_standard_editor($retrive_ques, 'summary', $editoroptions, $context, 'course', 'summary', $queid));
	$mform->set_data(file_prepare_standard_editor($retrive_ans, 'textfield', $editoroptions, $context, 'course', 'textfield', $sid));
}
if($action == 'editq'){
    echo "<div class='alert alert-success' id='questionupdate' style='display:none;'>";
    echo  "<strong>".'Question Updated successfully...'."</strong>"; 
    echo "</div>";
	$q_id = required_param('qtnid',PARAM_INT);   
    $qrecord = $DB->get_records('block_maths_question' ,array('id'=>$q_id)); 
    $retrive_ans= new stdClass();
	$retrive_ques= new stdClass();
	foreach ($qrecord  as $q_record)
    {
		$retrive_ques->qname = $q_record->question_type ;
		$retrive_ques->summary = $q_record->question_desc ;
		$retrive_ques->queweightage = $q_record->weightage;
		$retrive_ques->date = $q_record->qdate;
		$retrive_ques->que_id = $q_record->id;
	}
	$mform->set_data(file_prepare_standard_editor($retrive_ques, 'summary', $editoroptions, $context, 'course', 'summary', $queid));
}
elseif($action == 'add'){

$add_url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/display_math.php',array('action'=>'add','pageid'=>$page_cur));
$addlink = html_writer::link($add_url, get_string('addquestions', 'block_odev_mathematics')); 
$displaydata;
$displaydata =html_writer::start_tag('span',array('id'=>'viewlink1'));
$displaydata.='<input type = "button" id="viewquestion" onClick = "view_que();"  value= "View Question">';
$displaydata.=html_writer::end_tag('span');
$displaydata.=html_writer::start_tag('span',array('id'=>'addquelink','onclick'=>'addque_link();'));
$displaydata.=$addlink;
$displaydata.=html_writer::end_tag('span');
$displaydata.=html_writer::start_tag('div',array('id'=>'showalert1','class'=>'alert alert-danger','style'=>'display:none;'));
$displaydata.='<strong>'.'Fill The Required Fields!'.'</strong>';
$displaydata.=html_writer::end_tag('div');
$displaydata.=html_writer::start_tag('div',array('id'=>'showalert','class'=>'alert alert-success','style'=>'display:none;'));
$displaydata.='<strong>'.'Question added successfully...'.'</strong>';
$displaydata.=html_writer::end_tag('div');
echo $displaydata;

}
$mform->display();
$displaydata1;
$displaydata1 =html_writer::start_tag('div',array('id'=>'showque'));
$displaydata1.= html_writer::end_tag('div');
$displaydata1 .=html_writer::start_tag('div',array('id'=>'show'));
$displaydata1.= html_writer::end_tag('div');
echo $displaydata1;

$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/jquery.min.js'));
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/maths.js'));
echo $OUTPUT->footer();
?>

