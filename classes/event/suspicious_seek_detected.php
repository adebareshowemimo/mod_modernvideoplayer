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

namespace mod_modernvideoplayer\event;

defined('MOODLE_INTERNAL') || die();

/**
 * Suspicious seek event.
 */
class suspicious_seek_detected extends \core\event\base {
    protected function init() {
        $this->data['objecttable'] = 'modernvideoplayer';
        $this->data['crud'] = 'u';
        $this->data['edulevel'] = self::LEVEL_OTHER;
    }

    public static function get_name() {
        return get_string('eventsuspiciousseekdetected', 'modernvideoplayer');
    }

    public function get_description() {
        return "The system detected suspicious playback behaviour for user '{$this->relateduserid}' on ".
            "modern video player activity '{$this->objectid}'.";
    }
}
