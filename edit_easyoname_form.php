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
 * Defines the editing form for the easyoname question type.
 *
 * @package    qtype
 * @subpackage easyoname
 * @copyright  2014 onwards Carl LeBlond
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');

class qtype_easyoname_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
        global $PAGE, $CFG;

        $PAGE->requires->js('/question/type/easyoname/easyoname_script.js');
        $PAGE->requires->css('/question/type/easyoname/easyoname_styles.css');

        $mform->addElement('hidden', 'usecase', 1);
        $mform->setType('usecase', PARAM_INT);
        $mform->addElement('static', 'answersinstruct',
                get_string('correctanswers', 'qtype_easyoname'),
                get_string('filloutoneanswer', 'qtype_easyoname'));
        $mform->closeHeaderBefore('answersinstruct');

        $menu = array(
           get_string('autofeedbackdisabled', 'qtype_easyoname'),
           get_string('autofeedbackenabled', 'qtype_easyoname')
        );
        $mform->addElement('select', 'autofeedback',
                get_string('caseautofeedback', 'qtype_easyoname'), $menu);

        $menu = array(
           get_string('implicithhetero', 'qtype_easyoname') => get_string('implicithhetero', 'qtype_easyoname'),
           get_string('implicithoff', 'qtype_easyoname') => get_string('implicithoff', 'qtype_easyoname'),
           get_string('implicithall', 'qtype_easyoname') => get_string('implicithall', 'qtype_easyoname'),
           get_string('implicithheteroterm', 'qtype_easyoname') => get_string('implicithheteroterm', 'qtype_easyoname')
        );
        $mform->addElement('select', 'implicithydrogen',
                get_string('implicith', 'qtype_easyoname'), $menu);

        $mform->addElement('html', html_writer::start_tag('div', array('style' => 'width:650px;', 'id' => 'appletdiv')));
        $mform->addElement('html', html_writer::start_tag('div', array('style' => 'float: right;font-style: italic ;')));
        $mform->addElement('html', html_writer::start_tag('small'));
        $easyonamehomeurl = 'http://www.chemaxon.com';
        $mform->addElement('html', html_writer::link($easyonamehomeurl, get_string('easyonameeditor', 'qtype_easyoname')));
        $mform->addElement('html', html_writer::empty_tag('br'));
        $mform->addElement('html', html_writer::end_tag('small'));
        $mform->addElement('html', html_writer::end_tag('div'));
        $mform->addElement('html', html_writer::end_tag('div'));
        $mform->addElement('html', html_writer::empty_tag('br'));

        $marvinconfig = get_config('qtype_easyoname_options');
        $marvinpath = $marvinconfig->path;

        // Add applet to page.
        $jsmodule = array(
            'name'     => 'qtype_easyoname',
            'fullpath' => '/question/type/easyoname/easyoname_script.js',
            'requires' => array(),
            'strings' => array(
                array('enablejava', 'qtype_easyoname')
            )
        );

        $PAGE->requires->js_init_call('M.qtype_easyoname.insert_applet',
                                      array($CFG->wwwroot, $marvinpath),
                                      true,
                                      $jsmodule);
        // Add structure to applet.
        $jsmodule = array(
            'name'     => 'qtype_easyoname',
            'fullpath' => '/question/type/easyoname/easyoname_script.js',
            'requires' => array(),
            'strings' => array(
                array('enablejava', 'qtype_easyoname')
            )
        );

        $PAGE->requires->js_init_call('M.qtype_easyoname.insert_structure_into_applet',
                                      array(),
                                      true,
                                      $jsmodule);

        $this->add_per_answer_fields($mform, get_string('answerno', 'qtype_easyoname', '{no}'),
                question_bank::fraction_options());

        $this->add_interactive_settings();
        $PAGE->requires->js_init_call('M.qtype_easyoname.init_getanswerstring', array($CFG->version));
    }


    protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
        $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
                $repeatedoptions, $answersoption);
                $scriptattrs = 'class = id_insert';

        $insertbutton = $mform->createElement('button', 'insert', get_string('insertfromeditor', 'qtype_easyoname'), $scriptattrs);
        array_splice($repeated, 2, 0, array($insertbutton));

        return $repeated;
    }

    protected function data_preprocessing($question) {
        $question = parent::data_preprocessing($question);
        return $question;
    }

    public function qtype() {
        return 'easyoname';
    }
}
