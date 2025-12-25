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
 * @copyright  Mattan Dor <mattan@centricapp.co.il>
 * @copyright  2025 CentricApp LTD
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/lib.php');
global $DB, $USER;

require_login();
$scorm = get_config('local_force_scorm', 'local_force_scorm_id');
$link = get_config('local_force_scorm', 'local_force_scorm_link');

if (!$cm = get_coursemodule_from_id('scorm', $scorm, 0, true)) {
    print_error('invalidcoursemodule');
}
if (!$course = $DB->get_record("course", array("id" => $cm->course))) {
    print_error('coursemisconf');
}
if (!$scormi = $DB->get_record("scorm", array("id" => $cm->instance))) {
    print_error('invalidcoursemodule');
}
if (!$scorms = $DB->get_record("scorm_scoes", array("scorm" => $scormi->id, "sortorder" => 2))) {
    print_error('invalidcoursemodule');
}
echo '<pre dir=ltr style=text-align:left>' . mtrace($scorms) . '<br>File: ' . __FILE__ . ' Line: ' . __LINE__ . '</pre>';
$comp = $DB->get_record('scorm_scoes_track',
    array('userid' => $USER->id, 'scoid' => $scorms->id, 'element' => 'cmi.core.lesson_status'));
$link = get_config('local_force_scorm', 'local_force_scorm_link');
if (empty($comp)) {
    redirect($link);
}
if (!empty($comp) && $comp->value == 'incomplete') {
    redirect($link);
}
