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

namespace mod_modernvideoplayer;

use advanced_testcase;
use grade_item;
use stdClass;

/**
 * Tests for gradebook integration callbacks in mod_modernvideoplayer.
 *
 * @package    mod_modernvideoplayer
 * @category   test
 * @copyright  2026 Adebare Showemmo
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers     ::modernvideoplayer_grade_item_update
 * @covers     ::modernvideoplayer_grade_item_delete
 * @covers     ::modernvideoplayer_get_user_grades
 * @covers     ::modernvideoplayer_update_grades
 */
final class gradebook_test extends advanced_testcase {
    /** @var stdClass */
    private $course;

    /** @var stdClass */
    private $cm;

    /** @var stdClass */
    private $instance;

    /** @var stdClass */
    private $student;

    /**
     * Build a course with a graded video activity (grademax=100).
     */
    protected function setUp(): void {
        global $CFG, $DB;

        parent::setUp();
        $this->resetAfterTest();
        $this->setAdminUser();

        require_once($CFG->dirroot . '/mod/modernvideoplayer/lib.php');

        $this->course = $this->getDataGenerator()->create_course();
        $this->student = $this->getDataGenerator()->create_and_enrol($this->course, 'student');

        $this->cm = $this->getDataGenerator()->create_module('modernvideoplayer', [
            'course'          => $this->course->id,
            'name'            => 'Graded video',
            'requiredpercent' => 100.0,
            'grade'           => 100,
        ]);
        $this->instance = $DB->get_record('modernvideoplayer', ['id' => $this->cm->id], '*', MUST_EXIST);
    }

    /**
     * Helper: seed a progress row for the current student with an explicit percent.
     *
     * @param float $percent Completion percentage to seed (0.0-100.0).
     */
    private function seed_percent(float $percent): void {
        global $DB;

        $DB->insert_record('modernvideoplayer_progress', (object) [
            'modernvideoplayerid' => $this->instance->id,
            'userid'              => $this->student->id,
            'sessiontoken'        => 'seed',
            'duration'            => 120.0,
            'lastposition'        => 0.0,
            'maxverifiedposition' => 0.0,
            'totalsecondswatched' => 0.0,
            'percentcomplete'     => $percent,
            'completed'           => (int) ($percent >= 100.0),
            'completiontime'      => null,
            'timecreated'         => time(),
            'lastheartbeat'       => time(),
            'lastplaybackrate'    => 1.0,
            'lastvisibility'      => 'visible',
            'suspiciousflags'     => 0,
            'integrityfailures'   => 0,
            'timemodified'        => time(),
        ]);
    }

    /**
     * Creating an activity registers a grade item in the gradebook.
     */
    public function test_grade_item_exists_after_create(): void {
        $gradeitem = grade_item::fetch([
            'itemtype'     => 'mod',
            'itemmodule'   => 'modernvideoplayer',
            'iteminstance' => $this->instance->id,
            'courseid'     => $this->course->id,
        ]);

        $this->assertNotFalse($gradeitem);
        $this->assertSame('Graded video', $gradeitem->itemname);
        $this->assertEquals(100.0, (float) $gradeitem->grademax);
        $this->assertEquals(0.0, (float) $gradeitem->grademin);
    }

    /**
     * get_user_grades returns an empty array when nobody has watched yet.
     */
    public function test_get_user_grades_empty_without_progress(): void {
        $grades = modernvideoplayer_get_user_grades($this->instance);
        $this->assertSame([], $grades);
    }

    /**
     * get_user_grades maps percentcomplete proportionally onto grademax.
     */
    public function test_get_user_grades_scales_percent_by_grademax(): void {
        $this->seed_percent(75.0);

        $grades = modernvideoplayer_get_user_grades($this->instance);

        $this->assertArrayHasKey((int) $this->student->id, $grades);
        $this->assertEqualsWithDelta(75.0, (float) $grades[$this->student->id]->rawgrade, 0.01);
    }

    /**
     * With a non-standard grademax the raw grade scales linearly.
     */
    public function test_get_user_grades_respects_custom_grademax(): void {
        global $DB;

        $DB->set_field('modernvideoplayer', 'grade', 20, ['id' => $this->instance->id]);
        $this->instance->grade = 20;
        $this->seed_percent(50.0);

        $grades = modernvideoplayer_get_user_grades($this->instance);

        $this->assertEqualsWithDelta(10.0, (float) $grades[$this->student->id]->rawgrade, 0.01);
    }

    /**
     * update_grades pushes the computed grade into the gradebook.
     */
    public function test_update_grades_writes_to_gradebook(): void {
        $this->seed_percent(80.0);

        $status = modernvideoplayer_update_grades($this->instance, (int) $this->student->id);
        $this->assertSame(GRADE_UPDATE_OK, $status);

        $gradeitem = grade_item::fetch([
            'itemtype'     => 'mod',
            'itemmodule'   => 'modernvideoplayer',
            'iteminstance' => $this->instance->id,
            'courseid'     => $this->course->id,
        ]);
        $gradegrades = \grade_grade::fetch_users_grades($gradeitem, [$this->student->id]);

        $this->assertNotEmpty($gradegrades);
        $learnergrade = reset($gradegrades);
        $this->assertEqualsWithDelta(80.0, (float) $learnergrade->rawgrade, 0.01);
    }

    /**
     * grade_item_delete removes the grade item from the gradebook.
     */
    public function test_grade_item_delete_removes_item(): void {
        $this->assertNotFalse(grade_item::fetch([
            'itemtype'     => 'mod',
            'itemmodule'   => 'modernvideoplayer',
            'iteminstance' => $this->instance->id,
            'courseid'     => $this->course->id,
        ]));

        modernvideoplayer_grade_item_delete($this->instance);

        $this->assertFalse(grade_item::fetch([
            'itemtype'     => 'mod',
            'itemmodule'   => 'modernvideoplayer',
            'iteminstance' => $this->instance->id,
            'courseid'     => $this->course->id,
        ]));
    }
}
