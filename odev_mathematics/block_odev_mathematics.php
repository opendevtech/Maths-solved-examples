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
 class block_odev_mathematics extends block_base{
	public function init()	{ 
	 $this->title = get_string('blockname', 'block_odev_mathematics');		
	 }	
	 public function get_content() {
	 global $CFG, $DB, $OUTPUT;	
	 $var;
     $this->content = new stdClass;	 
	 $url=$CFG->wwwroot.'/blocks/odev_mathematics/view.php';
	 $var = html_writer::link($url,"View more");
	 $this->content->text = '';
	 $this->content->text =$var;
	 
	 $this->content->footer = '';
      return $this->content; 
	 
    }
 }
?>