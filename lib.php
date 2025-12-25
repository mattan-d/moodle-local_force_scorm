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
 * Newblock block caps.
 *
 * @package   block_force_scorm
 * @copyright  Daniel Neis <danielneis@gmail.com>
 * @copyright  2025 CentricApp LTD
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

function local_force_scorm_extend_navigation(global_navigation $navigation) {
    global $DB, $USER, $PAGE, $CFG;
    if (is_siteadmin()) {
        return null;
    }
    $modules = get_config('local_force_scorm', 'coursemodulesids');
    $roles = get_config('local_force_scorm', 'roles');
    if (empty($modules) || $modules == '') {
        return null;
    }
    $modules = explode(',', $modules);
    $pagetype = $PAGE->__get('pagetype');
    $page = explode("-", $pagetype);
    $notexecute = [];
    $courses = ["1"];
    $mods = [];
    $a = new stdclass();
    $a->coursesreq = '';
    foreach ($modules as $mod) {
        if (!$cm = $DB->get_record('course_modules', ['id' => $mod])) {
            continue;
        }
        $type = $DB->get_field('modules', 'name', ['id' => $cm->module]);
        $context = context_course::instance($cm->course);
        if (!$instance = $DB->get_record($type, array("id" => $cm->instance))) {
            continue;
        }
        if ($type == 'scorm') {
            if (!$scorms = $DB->get_record_sql("SELECT *
                                                 from {scorm_scoes}
                                                 where scorm = ? and  launch <> ?", array($instance->id, ""))) {
                continue;
            }
            $comp = $DB->get_record_sql('SELECT *
	        							 from {scorm_scoes_track}
	        							 where element = \'cmi.core.lesson_status\' and scoid = ? and userid = ?
	        							 ORDER BY id DESC
                                         LIMIT 1 ', array($scorms->id, $USER->id));
        } else {
            $comp = $DB->get_record_sql('SELECT *
                                         FROM {course_modules_completion}
                                         WHERE coursemoduleid = ? and userid = ? and completionstate > 0', [$cm->id, $USER->id]);
        }

        $userrole = $DB->get_records_sql("SELECT *
	    	                              from {role_assignments}
	    								  where userid = ? and contextid = ? and roleid in (" . $roles .")"
            , array($USER->id, $context->id));
        if (!empty($userrole) && (!$comp || !isset($comp) || empty($comp))) {
            $notexecute[$cm->id] = ['cm' => $mod, 'course' => $cm->course, 'type' => $type];
            if(!in_array($cm->course, $courses)) {
                array_push($courses, $cm->course);
            }
            $url = $CFG->wwwroot . '/mod/' . $type . '/view.php?id=' . $cm->id;
            $a->coursesreq .= '<a href="' . $url . '">' . $instance->name . '</a> , ';
            if(!in_array($modules, $mods)) {
                array_push($mods, $modules);
            }
        }
    }
    if (count($notexecute) > 0) {
        $cmm = $PAGE->cm;
        $a->coursesreq = substr($a->coursesreq, 0, -2);
        if ($pagetype != 'site-index' && !in_array($PAGE->course->id, $courses) || (($page[0] != 'course' || $page[1] != 'view') &&
                (!isset($PAGE->cm->id) || !isset($notexecute[$PAGE->cm->id]) || $notexecute[$PAGE->cm->id]['cm'] != $PAGE->cm->id))
        ) {
            if (!empty($cmm)) {
                $type = $DB->get_field('modules', 'name', ['id' => $PAGE->cm->module]);
                if (isset($type) && $type != '') {
                    $name = $DB->get_field($type, 'name', ['id' => $PAGE->cm->instance]);
                } else {
                    $name = '';
                }
            } else {
                $name = $PAGE->course->shortname;
            }

            $a->coursename = $name;
            if ($pagetype != 'my-index' && $pagetype != 'site-index') {
                redirect($CFG->wwwroot, get_string('mass', 'local_force_scorm', $a), null, \core\output\notification::NOTIFY_WARNING);
            }
        }
    }
}
