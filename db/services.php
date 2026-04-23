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
 * External functions and service definitions.
 *
 * @package    mod_modernvideoplayer
 * @copyright  2025 Adebare Showemmo | adebareshowemimo@gmail.com | support@agunfoninteractivity.com | www.agunfoninteractivity.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$functions = [
    'mod_modernvideoplayer_get_progress' => [
        'classname' => 'mod_modernvideoplayer\external\get_progress',
        'description' => 'Return learner progress and activity configuration for the player.',
        'type' => 'read',
        'ajax' => true,
        'capabilities' => 'mod/modernvideoplayer:view',
    ],
    'mod_modernvideoplayer_heartbeat' => [
        'classname' => 'mod_modernvideoplayer\external\heartbeat',
        'description' => 'Validate and persist playback heartbeat progress.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'mod/modernvideoplayer:submitprogress',
    ],
    'mod_modernvideoplayer_mark_complete' => [
        'classname' => 'mod_modernvideoplayer\external\mark_complete',
        'description' => 'Request completion recalculation after playback ends.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'mod/modernvideoplayer:submitprogress',
    ],
    'mod_modernvideoplayer_reset_progress' => [
        'classname' => 'mod_modernvideoplayer\external\reset_progress',
        'description' => 'Reset learner progress back to zero for restart from beginning.',
        'type' => 'write',
        'ajax' => true,
        'capabilities' => 'mod/modernvideoplayer:submitprogress',
    ],
];
