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
 * Teacher progress report.
 *
 * @package    mod_modernvideoplayer
 * @copyright  2025 Adebare Showemmo | adebareshowemimo@gmail.com | support@agunfoninteractivity.com | www.agunfoninteractivity.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require('../../config.php');
require_once(__DIR__ . '/locallib.php');
require_once($CFG->libdir . '/csvlib.class.php');

use mod_modernvideoplayer\local\reporting;

$id = required_param('id', PARAM_INT);
$completionfilter = optional_param('completionfilter', 'all', PARAM_ALPHA);
$suspiciousonly = optional_param('suspiciousonly', 0, PARAM_BOOL);
$search = trim(optional_param('search', '', PARAM_TEXT));
$download = optional_param('download', '', PARAM_ALPHA);

[$course, $cm, $instance] = modernvideoplayer_get_course_module_and_instance($id, 0);
require_course_login($course, true, $cm);

$context = context_module::instance($cm->id);
require_capability('mod/modernvideoplayer:viewreports', $context);

$pageparams = [
    'id' => $cm->id,
    'completionfilter' => $completionfilter,
    'suspiciousonly' => $suspiciousonly,
    'search' => $search,
];

$service = new reporting();
[$rows, $summary] = $service->get_report_data($instance, $completionfilter, (bool) $suspiciousonly, $search);

if ($download === 'csv') {
    $filename = clean_filename(get_string('downloadreportfilename', 'modernvideoplayer') . '-' . $cm->id);
    $csv = new csv_export_writer('comma');
    $csv->set_filename($filename);
    $csv->add_data([
        get_string('fullname', 'modernvideoplayer'),
        get_string('email', 'modernvideoplayer'),
        get_string('duration', 'modernvideoplayer'),
        get_string('lastposition', 'modernvideoplayer'),
        get_string('maxverifiedposition', 'modernvideoplayer'),
        get_string('totalsecondswatched', 'modernvideoplayer'),
        get_string('percentcomplete', 'modernvideoplayer'),
        get_string('completed', 'modernvideoplayer'),
        get_string('completiontime', 'modernvideoplayer'),
        get_string('lastheartbeat', 'modernvideoplayer'),
        get_string('lastplaybackrate', 'modernvideoplayer'),
        get_string('lastvisibility', 'modernvideoplayer'),
        get_string('suspiciousflags', 'modernvideoplayer'),
        get_string('integrityfailures', 'modernvideoplayer'),
    ]);
    foreach ($rows as $row) {
        $csv->add_data([
            fullname($row),
            $row->email,
            format_float((float) $row->duration, 2),
            format_float((float) $row->lastposition, 2),
            format_float((float) $row->maxverifiedposition, 2),
            format_float((float) $row->totalsecondswatched, 2),
            format_float((float) $row->percentcomplete, 2),
            $row->completed ? get_string('yes', 'modernvideoplayer') : get_string('no', 'modernvideoplayer'),
            $row->completiontime ? userdate($row->completiontime) : '',
            $row->lastheartbeat ? userdate($row->lastheartbeat) : '',
            format_float((float) $row->lastplaybackrate, 2),
            $row->lastvisibility ?? '',
            (int) $row->suspiciousflags,
            (int) $row->integrityfailures,
        ]);
    }
    $csv->download_file();
}

$PAGE->set_url('/mod/modernvideoplayer/report.php', $pageparams);
$PAGE->set_context($context);
$PAGE->set_title(format_string($instance->name) . ': ' . get_string('report', 'modernvideoplayer'));
$PAGE->set_heading(format_string($course->fullname));
$PAGE->set_pagelayout('report');

$entries = [];
foreach ($rows as $row) {
    $entries[] = [
        'fullname' => fullname($row),
        'email' => s($row->email),
        'duration' => format_float((float) $row->duration, 2),
        'lastposition' => format_float((float) $row->lastposition, 2),
        'maxverifiedposition' => format_float((float) $row->maxverifiedposition, 2),
        'totalsecondswatched' => format_float((float) $row->totalsecondswatched, 2),
        'percentcomplete' => format_float((float) $row->percentcomplete, 2) . '%',
        'completed' => $row->completed ? get_string('yes', 'modernvideoplayer') : get_string('no', 'modernvideoplayer'),
        'completiontime' => $row->completiontime ? userdate($row->completiontime) : '-',
        'lastheartbeat' => $row->lastheartbeat ? userdate($row->lastheartbeat) : '-',
        'lastplaybackrate' => format_float((float) $row->lastplaybackrate, 2),
        'lastvisibility' => s($row->lastvisibility ?? '-'),
        'suspiciousflags' => (int) $row->suspiciousflags,
        'integrityfailures' => (int) $row->integrityfailures,
    ];
}

$renderer = $PAGE->get_renderer('mod_modernvideoplayer');
$downloadurl = new moodle_url('/mod/modernvideoplayer/report.php', $pageparams + ['download' => 'csv']);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('reportheader', 'modernvideoplayer'));
echo $renderer->render_report([
    'id' => $cm->id,
    'hasentries' => !empty($entries),
    'entries' => $entries,
    'totallearners' => $summary['totallearners'],
    'completedlearners' => $summary['completedlearners'],
    'completionrate' => format_float($summary['completionrate'], 2) . '%',
    'averagecoverage' => format_float($summary['averagecoverage'], 2) . '%',
    'suspiciousflags' => $summary['suspiciousflags'],
    'integrityfailures' => $summary['integrityfailures'],
    'isall' => $completionfilter === 'all',
    'iscompleted' => $completionfilter === 'completed',
    'isincomplete' => $completionfilter === 'incomplete',
    'suspiciousonly' => !empty($suspiciousonly),
    'search' => s($search),
    'filterurl' => (new moodle_url('/mod/modernvideoplayer/report.php', ['id' => $cm->id]))->out(false),
    'downloadurl' => $downloadurl->out(false),
]);
echo $OUTPUT->footer();
