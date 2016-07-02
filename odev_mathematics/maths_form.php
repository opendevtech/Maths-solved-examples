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
require_once("../../config.php"); 
require_once("../../lib/formslib.php");
class odev_maths_form extends moodleform {

    public function definition() {
        global $CFG, $DB;
        $mform    = $this->_form;
		$action = $this->_customdata['action'];
		$mform->setType('action', PARAM_RAW);
		$context=$this->_customdata['context'];
		$editoroptions=$this->_customdata['editoroptions'];
		$pageid = required_param('pageid',PARAM_INT);
		
		$elem = $mform->addElement('text', 'qname', get_string('questionname', 'block_odev_mathematics'));
		$mform->addRule('qname', null,'required', null, 'client');
		$mform->setType('qname', PARAM_RAW);
			
		$elem3 = $mform->addElement('editor','summary_editor',get_string('quetiontext', 'block_odev_mathematics'),null,$editoroptions); //editor
		$mform->addRule('summary_editor', null,'required', null, 'client');
		$mform->setType('summary_editor', PARAM_RAW);
      
		$elem1 = $mform->addElement('text', 'queweightage', get_string('questionweightage', 'block_odev_mathematics'));
		$mform->addRule('queweightage','Numeric','numeric', null, 'client');
		$mform->setType('queweightage', PARAM_RAW);
			
		$elem2 = $mform->addElement('text', 'date', get_string('date', 'block_odev_mathematics'));
		$mform->setType('date', PARAM_RAW);
		if($action == 'editq'){
		  
          $mform->addElement('html', '<input type = "button" name = "save_qtn" id = "qestion" class = "savequestion" onclick = "saveq('.$pageid.',\''.$action.'\');" value = "Update Question">');	
		}
		
		elseif($action != 'edit'){
			
            $mform->addElement('html', '<div id="que" >');
			$mform->addElement('html', '<input type = "button" name = "save_qtn" id = "qestion" class = "savequestion" onclick = "saveq('.$pageid.',\''.$action.'\');" value = "Save Question">');
			$mform->addElement('html', '</div>');
			
			$mform->addElement('html', '<div id="method"  style="display:none;" >');
			$mform->addElement('html', '<input type = "button" name = "add_method" id = "method_count" onclick ="method1();" value = "Add Method">');
			$mform->addElement('html', '</div>');
			
			$mform->addElement('html', '<div id="step"  style="display:none;" >');
			
			$mform->addElement('html','<div id = "stepalert" class = "alert alert-danger" style ="display:none;">');
            $mform->addElement('html','<strong>Fill The Required Fields!</strong>');
			$mform->addElement('html', '</div>');
			
			$mform->addElement('html','<div id = "stepsuccessalert" class = "alert alert-success" style ="display:none;">');
            $mform->addElement('html','<strong>Step Added Successfully...</strong>');
			$mform->addElement('html', '</div>');
			
			$mcount = html_writer::start_tag('div',array('id'=>'meth_count')).''.html_writer::end_tag('div');
			$scount = html_writer::start_tag('div',array('id'=>'step_count')).''.html_writer::end_tag('div');
			
			$mform->addElement('static', 'questionmethod',get_string('method', 'block_odev_mathematics'),$mcount ); 
			
			$mform->addElement('static', 'questionstep',get_string('step', 'block_odev_mathematics'),$scount); 
			
			$mform->addElement('editor','textfield_editor',get_string('steptext', 'block_odev_mathematics'),null,$editoroptions); //editor
			$mform->addRule('textfield_editor', null,'required', null, 'client');
			$mform->setType('textfield_editor', PARAM_RAW);
			
			
		    $mform->addElement('textarea', 'introduction',get_string('stepdescription', 'block_odev_mathematics'));
			$mform->addRule('introduction', null,'required', null, 'client');
			
			$mform->addElement('text', 'stepweightage',get_string('stepweightage', 'block_odev_mathematics'));
			$mform->addRule('stepweightage','Numeric','numeric', null, 'client');
			$mform->setType('stepweightage', PARAM_RAW);  
			  
			$mform->addElement('html', '<input type = "button" name = "add_step" id = "stepcount" class = "step_scount" onclick = "savestp(\''.$action.'\');" value = "Save & Add Step">');
			
			$mform->addElement('html','<input type = "button" id="viewstep" onClick = "show_step();"  value= "View Step">');
			$mform->addElement('html', '</div>');
			
		}
		if($action == 'edit'){
			$mid = required_param('mno',PARAM_INT);
			$stpid = required_param('sno',PARAM_INT);
			
			$elem->freeze();
			$elem1->freeze();
			$elem2->freeze();
			 
			$mform->addElement('html','<div id = "stepupdatealert" class = "alert alert-success" style ="display:none;">');
            $mform->addElement('html','Step Added Successfully...');
			$mform->addElement('html', '</div>');  
			 
			$mform->addElement('static', 'questionmethod',get_string('method', 'block_odev_mathematics'),$mid); 
			$mform->addElement('static', 'questionmethod',get_string('step', 'block_odev_mathematics'),$stpid);
			
			$mform->addElement('editor','textfield_editor',get_string('steptext', 'block_odev_mathematics'),null,$editoroptions);
			$mform->setType('textfield_editor', PARAM_RAW);
			 
		    $mform->addElement('textarea', 'introduction',get_string('stepdescription', 'block_odev_mathematics'));
			 
			$mform->addElement('text', 'stepweightage',get_string('stepweightage', 'block_odev_mathematics'));
			$mform->addRule('stepweightage','Numeric','numeric', null, 'client');
			$mform->setType('stepweightage', PARAM_RAW);  
			  
			$mform->addElement('html', '<input type = "button" name = "update_step" id = "step_update" class = "step_scount" onclick = "savestp(\''.$action.'\');" value = "Update Step">');
			
		}
		    $qid = '';
			$sid = '';
			$mform->addElement('hidden', 'action', $action);
			$mform->addElement('text', 'que_id', $qid);
			$mform->setType('que_id', PARAM_RAW);
			
			$mform->addElement('text', 'step_id', $sid);
			$mform->setType('step_id', PARAM_RAW); 
			
			$mform->addElement('text', 'mno', '');
			$mform->setType('mno', PARAM_RAW); 
			
			$mform->addElement('text', 'sno', '');
			$mform->setType('sno', PARAM_RAW); 
			
			$mform->addElement('html', '<input type="hidden" name="hidden1" id="hidden1">');
			$mform->addElement('html', '<input type="hidden" name="hidden2" id="hidden2">');
			 
	}
}
?>
