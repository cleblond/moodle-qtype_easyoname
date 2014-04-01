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
 * Unit tests for the easyoname question definition class.
 *
 * @package    qtype
 * @subpackage easyoname
 * @copyright  2008 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/easyoname/question.php');
require_once($CFG->dirroot . '/question/engine/simpletest/helpers.php');
require_once($CFG->dirroot . '/question/type/easyoname/simpletest/helper.php');


/**
 * Unit tests for the short answer question definition class.
 *
 * @copyright  2008 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_easyoname_question_test extends UnitTestCase {
    public function test_compare_string_with_wildcard() {
        // Test case sensitive literal matches.
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog', 'Frog', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog', 'frog', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   Frog   ', 'Frog', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Frogs', 'Frog', false));

        // Test case insensitive literal matches.
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog', 'frog', true));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   FROG   ', 'Frog', true));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Frogs', 'Frog', true));

        // Test case sensitive wildcard matches.
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog', 'F*og', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Fog', 'F*og', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   Fat dog   ', 'F*og', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Frogs', 'F*og', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Fg', 'F*og', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'frog', 'F*og', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                '   fat dog   ', 'F*og', false));

        // Test case insensitive wildcard matches.
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog', 'F*og', true));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Fog', 'F*og', true));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   Fat dog   ', 'F*og', true));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Frogs', 'F*og', true));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'Fg', 'F*og', true));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'frog', 'F*og', true));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   fat dog   ', 'F*og', true));

        // Test match using regexp special chars.
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '   *   ', '\*', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '*', '\*', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'Frog*toad', 'Frog\*toad', false));
        $this->assertFalse(qtype_easyoname_question::compare_string_with_wildcard(
                'a', '[a-z]', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '[a-z]', '[a-z]', false));
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                '\{}/', '\{}/', true));

        // See http://moodle.org/mod/forum/discuss.php?d=120557
        $this->assertTrue(qtype_easyoname_question::compare_string_with_wildcard(
                'ITÁLIE', 'Itálie', true));
    }

    public function test_is_complete_response() {
		$question = qtype_easyoname_test_helper::make_a_easyoname_question();

        $this->assertFalse($question->is_complete_response(array()));
        $this->assertFalse($question->is_complete_response(array('answer' => '')));
        $this->assertTrue($question->is_complete_response(array('answer' => '0')));
        $this->assertTrue($question->is_complete_response(array('answer' => '0.0')));
        $this->assertTrue($question->is_complete_response(array('answer' => 'x')));
    }

    public function test_is_gradable_response() {
        $question = qtype_easyoname_test_helper::make_a_easyoname_question();

        $this->assertFalse($question->is_gradable_response(array()));
        $this->assertFalse($question->is_gradable_response(array('answer' => '')));
        $this->assertTrue($question->is_gradable_response(array('answer' => '0')));
        $this->assertTrue($question->is_gradable_response(array('answer' => '0.0')));
        $this->assertTrue($question->is_gradable_response(array('answer' => 'x')));
    }

	public function test_grading() {
        $question = qtype_easyoname_test_helper::make_a_easyoname_question();

        $this->assertEqual(array(0, question_state::$gradedwrong),
                $question->grade_response(array('answer' => 'x')));
        $this->assertEqual(array(1, question_state::$gradedright),
                $question->grade_response(array('answer' => 'frog')));
        $this->assertEqual(array(0.8, question_state::$gradedpartial),
                $question->grade_response(array('answer' => 'toad')));
    }

    public function test_get_correct_response() {
        $question = qtype_easyoname_test_helper::make_a_easyoname_question();

        $this->assertEqual(array('answer' => 'frog'),
                $question->get_correct_response());
    }

    public function test_get_question_summary() {
        $easyoname = qtype_easyoname_test_helper::make_a_easyoname_question();
        $qsummary = $easyoname->get_question_summary();
        $this->assertEqual('Name an amphibian: __________', $qsummary);
    }

    public function test_summarise_response() {
        $easyoname = qtype_easyoname_test_helper::make_a_easyoname_question();
        $summary = $easyoname->summarise_response(array('answer' => 'dog'));
        $this->assertEqual('dog', $summary);
    }

    public function test_classify_response() {
        $easyoname = qtype_easyoname_test_helper::make_a_easyoname_question();
        $easyoname->start_attempt(new question_attempt_step(), 1);

        $this->assertEqual(array(
                new question_classified_response(13, 'frog', 1.0)),
                $easyoname->classify_response(array('answer' => 'frog')));
        $this->assertEqual(array(
                new question_classified_response(14, 'toad', 0.8)),
                $easyoname->classify_response(array('answer' => 'toad')));
        $this->assertEqual(array(
                new question_classified_response(15, 'cat', 0.0)),
                $easyoname->classify_response(array('answer' => 'cat')));
        $this->assertEqual(array(
                question_classified_response::no_response()),
                $easyoname->classify_response(array('answer' => '')));
    }
}
