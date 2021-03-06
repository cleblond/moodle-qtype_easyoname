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
 * Question type class for the easyoname question type.
 *
 * @package    qtype
 * @subpackage easyoname
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/easyoname/question.php');
require_once($CFG->dirroot . '/question/type/shortanswer/questiontype.php');

class qtype_easyoname extends qtype_shortanswer {
    public function extra_question_fields() {
        return array('question_easyoname', 'answers', 'userandom', 'autofeedback', 'implicithydrogen');
    }

    public function questionid_column_name() {
        return 'question';
    }
    protected function initialise_question_instance(question_definition $question, $questiondata) {
        $questiondata->options->usecase = false;
                parent::initialise_question_instance($question, $questiondata);
    }
}



