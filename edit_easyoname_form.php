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
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();


/**
 * easyoname question editing form definition.
 *
 * @copyright  2007 Jamie Pratt
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once($CFG->dirroot . '/question/type/shortanswer/edit_shortanswer_form.php');


/**
 * Calculated question type editing form definition.
 *
 * @copyright  2007 Jamie Pratt me@jamiep.org
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class qtype_easyoname_edit_form extends qtype_shortanswer_edit_form {

    protected function definition_inner($mform) {
		global $PAGE, $CFG;
		
		$PAGE->requires->js('/question/type/easyoname/easyoname_script.js');
		$PAGE->requires->css('/question/type/easyoname/easyoname_styles.css');
	
        $mform->addElement('hidden', 'usecase', 1);
	$mform->setType('usecase', PARAM_INT);

       // $menu = array(
       //     get_string('casenotrandom', 'qtype_easyoname'),
       //     get_string('caserandom', 'qtype_easyoname')
       // );
      //  $mform->addElement('select', 'userandom',
      //          get_string('caseuserandom', 'qtype_easyoname'), $menu);
	


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
           get_string('implicitHhetero', 'qtype_easyoname') => get_string('implicitHhetero', 'qtype_easyoname'),
           get_string('implicitHoff', 'qtype_easyoname') => get_string('implicitHoff', 'qtype_easyoname'),
           get_string('implicitHall', 'qtype_easyoname') => get_string('implicitHall', 'qtype_easyoname'),

           get_string('implicitHheteroterm', 'qtype_easyoname') => get_string('implicitHheteroterm', 'qtype_easyoname')
             
        );
        $mform->addElement('select', 'implicithydrogen',
                get_string('implicitH', 'qtype_easyoname'), $menu);





		
//		$appleturl = new moodle_url('/question/type/easyoname/easyoname/easyoname.jar');


		//get the html in the easyonamelib.php to build the applet
//	    $easyonamebuildstring = "\n<applet code=\"easyoname.class\" name=\"easyoname\" id=\"easyoname\" archive =\"$appleturl\" width=\"460\" height=\"335\">" .
//	  "\n<param name=\"options\" value=\"" . $CFG->qtype_easyoname_options . "\" />" .
//      "\n" . get_string('javaneeded', 'qtype_easyoname', '<a href="http://www.java.com">Java.com</a>') .
//	  "\n</applet>";


	    $easyonamebuildstring = "\n<script LANGUAGE=\"JavaScript1.1\" SRC=\"../../marvin/marvin.js\"></script>".

"<script LANGUAGE=\"JavaScript1.1\">



msketch_name = \"MSketch\";
msketch_begin(\"../../marvin\", 800, 600);
msketch_param(\"menuconfig\", \"../eolms/question/type/easyoname/customization_mech.xml\");
msketch_param(\"lonePairsAutoCalc\", \"false\");
msketch_param(\"lonePairsVisible\", \"true\");
msketch_param(\"importConv\", \"+H\");
msketch_param(\"valencePropertyVisible\", \"false\");
msketch_param(\"background\", \"#ffffff\");
msketch_param(\"molbg\", \"#ffffff\");
msketch_end();
</script> ";

//msketch_param(\"valenceCheckEnabled\", \"false\");





        //output the marvin applet
        $mform->addElement('html', html_writer::start_tag('div', array('style'=>'width:650px;')));
		$mform->addElement('html', html_writer::start_tag('div', array('style'=>'float: right;font-style: italic ;')));
		$mform->addElement('html', html_writer::start_tag('small'));
		$easyonamehomeurl = 'http://www.chemaxon.com';
		$mform->addElement('html', html_writer::link($easyonamehomeurl, get_string('easyonameeditor', 'qtype_easyoname')));
		$mform->addElement('html', html_writer::empty_tag('br'));
//		$mform->addElement('html', html_writer::tag('span', get_string('author', 'qtype_easyoname'), array('class'=>'easyonameauthor')));
		$mform->addElement('html', html_writer::end_tag('small'));
		$mform->addElement('html', html_writer::end_tag('div'));
		$mform->addElement('html',$easyonamebuildstring);
		$mform->addElement('html', html_writer::end_tag('div'));


//		$mform->addElement('html', html_writer::tag('h1', 'Do you want students to determine the charge or add the correct # of lone pairs?'));

		$mform->addElement('html', html_writer::empty_tag('br'));

		

       ///add structure to applet
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
    }
	
	protected function get_per_answer_fields($mform, $label, $gradeoptions,
            &$repeatedoptions, &$answersoption) {
		
        $repeated = parent::get_per_answer_fields($mform, $label, $gradeoptions,
                $repeatedoptions, $answersoption);
		
		//construct the insert button
//crl mrv		$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'cxsmiles:u\')"';
		$scriptattrs = 'onClick = "getSmilesEdit(this.name, \'cxsmiles:u\')"';


        $insert_button = $mform->createElement('button','insert',get_string('insertfromeditor', 'qtype_easyoname'),$scriptattrs);
        array_splice($repeated, 2, 0, array($insert_button));

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
