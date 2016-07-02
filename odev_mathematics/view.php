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
$url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/view.php');
$PAGE->set_url($url);
global $CFG,$DB,$USER;
$PAGE->set_title('Maths Solved Examples');
$PAGE->set_heading('Maths Questions');
$PAGE->set_pagelayout('standard');
require_login();
echo $OUTPUT->header();

$userid=$USER->id;

$total_count=array();
$sql_question1 = "SELECT * from {block_maths_question}";
$question_received1= $DB->get_records_sql($sql_question1); 
foreach($question_received1 as $quescount){
$total_count[]=$quescount;	
}
$total=count($total_count);	
$dis=1; 
$total_page=ceil($total/$dis);
$page_cur=(isset($_GET['page']))?$_GET['page']:1;
$k=($page_cur-1)*$dis;

$sql_question = "SELECT * from {block_maths_question} ORDER BY id DESC LIMIT $k,$dis ";
$question_received = $DB->get_records_sql($sql_question); 
foreach($question_received as $question_retrived){
	    $qid =      $question_retrived->id;
	    $qname =     $question_retrived->question_type;
	    $qdesc =    $question_retrived->question_desc;
		$qwtg =    $question_retrived->weightage;
	    $qdate =    $question_retrived->qdate;
	    
		$displayqdata;
	    $displayqdata  = html_writer::tag('b',get_string('questionname', 'block_odev_mathematics')).$qname;
		$displayqdata .= "<br>";
		$displayqdata .= html_writer::tag('b',get_string('quetiontext', 'block_odev_mathematics')).format_text($qdesc);
		$displayqdata .= "<br>";
		$displayqdata .= html_writer::tag('b',get_string('qdate', 'block_odev_mathematics')).$qdate;
		$displayqdata .= "<br>";
		$displayqdata .= html_writer::tag('b',get_string('qwtg', 'block_odev_mathematics')).$qwtg;
		$displayqdata .= "<br>";
		echo $displayqdata;
	   
	    $sql_query = "SELECT distinct method from {block_maths_answer} where qid ='$qid' ";
		$result = $DB->get_records_sql($sql_query); 
		foreach($result as $methodid){
		
			$method_id = $methodid->method;
			$methodparam = array('mid'=>$method_id,'qsnid'=>$qid,'page'=>$page_cur);
			$method_url = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/view.php',$methodparam);
			$methodlink = html_writer::link($method_url,get_string('method','block_odev_mathematics'));
			$displaymethod;
			$displaymethod = html_writer::start_tag('div',array('id'=>'link'));
			$displaymethod .= $methodlink.''.$method_id;
			$displaymethod .= html_writer::end_tag('div');
			echo $displaymethod;
		}
		$mid =  optional_param('mid', 0, PARAM_INT);
		$que_id =  optional_param('qsnid', 0, PARAM_INT);
		$expandbutton = '';
		$sql_query = "SELECT * from {block_maths_answer} where method='$mid' and qid ='$que_id'";
	    $result_received = $DB->get_records_sql($sql_query); 
		foreach($result_received as $received_step){
		   $method = $received_step->method;
		   $step_no = $received_step->step_no;
		   $step = $received_step->step;
		   $step_desc = $received_step->step_desc;
		   $step_wtg = $received_step->step_weigt;
           if($step_no == 1){
		     $displaymethod = html_writer::tag('b',get_string('methodno','block_odev_mathematics')).$method;
		     echo $displaymethod;
			 $expandbutton  = html_writer::tag('button', get_string('expand', 'block_odev_mathematics'), array('id'=>'button'));
			 $expandbutton .= html_writer::tag('button', get_string('animate', 'block_odev_mathematics'), array('id'=>'animate'));
			 $expandbutton   .= html_writer::tag('button', get_string('reset', 'block_odev_mathematics'), array('id'=>'reset','onclick'=>'ResetSteps();'));
		  }
		  $displaydiv;
		  $displaydiv  = html_writer::start_tag('div',array('class'=>'container'));
		  $displaydiv .= html_writer::start_tag('div',array('class'=>'invisible'));
		  $displaydiv .= html_writer::tag('b',get_string('stepno', 'block_odev_mathematics')).$step_no;
		  $displaydiv .= "<br>";
		  $displaydiv .= html_writer::tag('b',get_string('stepdesc','block_odev_mathematics')).$step_desc;
		  $displaydiv .= "<br>";
		  $displaydiv .= html_writer::tag('b',get_string('stepwtg','block_odev_mathematics')).$step_wtg;
		  $displaydiv .= "<br>";
		  $displaydiv .= html_writer::tag('b',get_string('step','block_odev_mathematics')).format_text($step);
		  $displaydiv .= "<br>";
		  $displaydiv .= html_writer::end_tag('div');
		  $displaydiv .= html_writer::end_tag('div');
		  echo $displaydiv;
		}
        echo $expandbutton."</br>";
}
$checkuser1 = $DB->get_record('role_assignments',array('userid'=>$userid,'roleid'=>'1'));
$checkuser2 = $DB->get_record('role_assignments',array('userid'=>$userid,'roleid'=>'3'));
if($checkuser1 ||$userid==2 ||$checkuser2 ) 
{
	$addurlparam = array('action'=>'add','pageid'=>$page_cur);
	$addlink = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/display_math.php',$addurlparam);
	$add_link = html_writer::link($addlink,get_string('addquestions', 'block_odev_mathematics'));
	$editurlparam =  array('action'=>'editq','qtnid'=>$qid,'pageid'=>$page_cur);
	$editlink = new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/display_math.php',$editurlparam);
	$edit_link = html_writer::link($editlink,get_string('editquestions','block_odev_mathematics'));
	$displaydata;
	$displaydata = html_writer::start_tag('span',array('class'=>'addlink')).$add_link.html_writer::end_tag('span');
    $displaydata.= html_writer::start_tag('span',array('class'=>'editlink')).$edit_link.html_writer::end_tag('span');
    echo $displaydata;
}
if($page_cur>1)
{
	$displayimg = '<a href="view.php?page='.($page_cur-1).'"><img src="pix/previous.png" class="prev" title=Previous></a>';
    echo $displayimg;
}
else
{	
   $displayimg1 = '<img src="pix/disprevious.png" class="prev" title=Previous>';
   echo $displayimg1;
}
if($page_cur<$total_page)
{	
	$displayimg2 = '<a href="view.php?page='.($page_cur+1).'"><img src="pix/next.png" class="next" title=Next></a>';
    echo $displayimg2;
}
else
{
 $displayimg3 = '<img src="pix/disnext.png" class="next" title=Next disabled = disabled >';
 echo $displayimg3;
 }
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/jquery.min.js')); 
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/jquery-1.8.js')); 
$PAGE->requires->js(new moodle_url($CFG->wwwroot.'/blocks/odev_mathematics/js/maths.js'));
echo $OUTPUT->footer();
?>