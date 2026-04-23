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

declare(strict_types=1);

namespace mod_modernvideoplayer\completion;

use advanced_testcase;
use cm_info;
use stdClass;

/**
 * Tests for the custom completion rules of mod_modernvideoplayer.
 *
 * @package    mod_modernvideoplayer
 * @category   test
 * @copyright  2026 Adebare Showemmo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     \mod_modernvideoplayer\completion\custom_completion
 */
final class custom_completion_test extends advanced_testcase {
    /** @var stdClass */
    private $course;

    /** @var stdClass */
    private $user;

    /** @var stdClass */
    private $cm;

    /** @var stdClass */
    private $instance;

    /**
     * Common fixtures — a course with an enrolled learner and one video
     * activity configured with automatic completion and both custom rules on.
     */
    protected function setUp(): void {
        parent::setUp();
        $this->resetAfterTest();
        $this->setAdminUser();

        $this->course = $this->getDataGenerator()->create_course([
            'enablecompletion' => 1,
        ]);
        $this->user = $this->getDataGenerator()->create_and_enrol($this->course, 'student');

        $this->cm = $this->getDataGenerator()->create_module('modernvideoplayer', [
            'course'               => $this->course->id,
            'name'                 => 'Completion rules test',
            'completion'           => COMPLETION_TRACKING_AUTOMATIC,
            'completionview'       => 0,
            'requiredpercent'      => 80.0,
            'strictendvalidation'  => 1,
            'graceseconds'         => 3,
            'heartbeatinterval'    => 15,
            'forceservervalidation' => 1,
        ]);

        global $DB;
        $this->instance = $DB->get_record('modernvideoplayer', ['id' => $this->cm->id], '*', MUST_EXIST);
    }

    /**
     * Seed a progress row for the current user.
     *
     * @param array $fields Progress column overrides.
     */
    private function seed_progress(array $fields): void {
        global $DB;

        $row = array_merge([
            'modernvideoplayerid' => $this->instance->id,
            'userid'              => $this->user->id,
            'sessiontoken'        => 'seed-token',
            'duration'            => 0.0,
            'lastposition'        => 0.0,
            'maxverifiedposition' => 0.0,
            'totalsecondswatched' => 0.0,
            'percentcomplete'     => 0.0,
            'completed'           => 0,
            'completiontime'      => null,
            'timecreated'         => time(),
            'lastheartbeat'       => time(),
            'lastplaybackrate'    => 1.0,
            'lastvisibility'      => 'visible',
            'suspiciousflags'     => 0,
            'integrityfailures'   => 0,
            'timemodified'        => time(),
        ], $fields);

        $DB->insert_record('modernvideoplayer_progress', (object) $row);
    }

    /**
     * Build a {@see custom_completion} instance for the seeded user.
     */
    private function completion_for_user(): custom_completion {
        $cminfo = cm_info::create(get_coursemodule_from_id('modernvideoplayer', $this->cm->cmid), (int) $this->user->id);
        return new custom_completion($cminfo, (int) $this->user->id);
    }

    /**
     * The module advertises exactly the two custom rules we expect.
     */
    public function test_defined_custom_rules(): void {
        $this->assertSame(
            ['completionvideopercent', 'completionvideoend'],
            custom_completion::get_defined_custom_rules()
        );
    }

    /**
     * With no progress row, every rule is incomplete.
     */
    public function test_rules_are_incomplete_without_progress(): void {
        $completion = $this->completion_for_user();
        $this->assertSame(COMPLETION_INCOMPLETE, $completion->get_state('completionvideopercent'));
        $this->assertSame(COMPLETION_INCOMPLETE, $completion->get_state('completionvideoend'));
    }

    /**
     * The percent rule flips to complete once the learner meets requiredpercent.
     */
    public function test_percent_rule_completes_when_threshold_met(): void {
        $this->seed_progress(['percentcomplete' => 80.0, 'duration' => 100.0, 'maxverifiedposition' => 50.0]);
        $completion = $this->completion_for_user();

        $this->assertSame(COMPLETION_COMPLETE, $completion->get_state('completionvideopercent'));
    }

    /**
     * Below-threshold watch percent keeps the rule incomplete.
     */
    public function test_percent_rule_incomplete_below_threshold(): void {
        $this->seed_progress(['percentcomplete' => 50.0, 'duration' => 100.0]);
        $completion = $this->completion_for_user();

        $this->assertSame(COMPLETION_INCOMPLETE, $completion->get_state('completionvideopercent'));
    }

    /**
     * The end rule completes once maxverifiedposition reaches duration - grace.
     */
    public function test_end_rule_completes_near_end_with_grace(): void {
        $this->seed_progress(['duration' => 100.0, 'maxverifiedposition' => 98.0]);
        $completion = $this->completion_for_user();

        $this->assertSame(COMPLETION_COMPLETE, $completion->get_state('completionvideoend'));
    }

    /**
     * A watch that stops before the grace window leaves the end rule open.
     */
    public function test_end_rule_incomplete_when_far_from_end(): void {
        $this->seed_progress(['duration' => 100.0, 'maxverifiedposition' => 50.0]);
        $completion = $this->completion_for_user();

        $this->assertSame(COMPLETION_INCOMPLETE, $completion->get_state('completionvideoend'));
    }

    /**
     * If duration is unknown (0), the end rule cannot complete.
     */
    public function test_end_rule_incomplete_without_duration(): void {
        $this->seed_progress(['duration' => 0.0, 'maxverifiedposition' => 500.0]);
        $completion = $this->completion_for_user();

        $this->assertSame(COMPLETION_INCOMPLETE, $completion->get_state('completionvideoend'));
    }

    /**
     * Rule descriptions should surface whichever custom rules the cm_info advertises.
     */
    public function test_rule_descriptions_follow_cm_customdata(): void {
        $cminfo = cm_info::create(get_coursemodule_from_id('modernvideoplayer', $this->cm->cmid), (int) $this->user->id);
        $completion = new custom_completion($cminfo, (int) $this->user->id);

        $descriptions = $completion->get_custom_rule_descriptions();

        $this->assertArrayHasKey('completionvideopercent', $descriptions);
        $this->assertArrayHasKey('completionvideoend', $descriptions);
        $this->assertNotEmpty($descriptions['completionvideopercent']);
        $this->assertNotEmpty($descriptions['completionvideoend']);
    }

    /**
     * The sort order begins with completionview and includes both custom rules.
     */
    public function test_sort_order_places_view_first(): void {
        $completion = $this->completion_for_user();
        $order = $completion->get_sort_order();

        $this->assertSame('completionview', $order[0]);
        $this->assertContains('completionvideopercent', $order);
        $this->assertContains('completionvideoend', $order);
    }
}
