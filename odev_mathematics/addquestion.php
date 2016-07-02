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

$action  = $_POST['action'];
$qsnid1  = $_POST['qstn_id'];
$quename = $_POST['que_name'];
$quetext = $_POST['que_text'];
$quewtg  = $_POST['que_wtg'];
$quedate = $_POST['que_date'];
	
$questiondata = new stdclass();
$questiondata->question_type = $quename ;
$questiondata->question_desc = $quetext;
$questiondata->weightage     = $quewtg;
$questiondata->qdate         = $quedate ;
	
if($qsnid1 != null){
	$questiondata->id = $qsnid1;
	$DB->update_record('block_maths_question',$questiondata);
  
}
else{
	$newinsert_question = $DB->insert_record('block_maths_question',$questiondata);
}
?>