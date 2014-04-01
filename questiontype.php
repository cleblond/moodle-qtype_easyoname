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
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir . '/questionlib.php');
require_once($CFG->dirroot . '/question/engine/lib.php');
require_once($CFG->dirroot . '/question/type/easyoname/question.php');
require_once($CFG->dirroot . '/question/type/shortanswer/questiontype.php');

//	echo "HERE";
/**
 * The easyoname question type.
 *
 * @copyright  1999 onwards Martin Dougiamas  {@link http://moodle.com}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
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





protected function createrandomsmiles($mode){  ////CREATE RANDOM SMILES STRING FINCTION CRL

/*
if(!$mode=$_GET['mode']){$mode="simplealkane";}
if(!$mode=$_POST['modeselect']){$mode="simplealkane";}
*/



//echo "mode=".$mode;

////this mode for simple alkanes
if ($mode=="simplealkane"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

}
///////////////////////END SIMPLE ALKANES




////this mode for simple aromatic
if ($mode=="simplearomatic"){
///generate carbon chain between 1 and 20
//$num_C=rand(1, 10);
//echo $num_C;


$num_subs=rand(0, 2);
//$num_subs=3;
if($num_subs==0){
$smiles="c1ccccc1";
}
else{
//$subs = array("Br", "Cl", "I", "F", "O", "N","O=C", "CC(=O)", "C(O)=O");
$subs = array("(Br)", "(Cl)", "(I)", "(F)", "(O)", "(N)", "(C=O)", "(C(O)=O)");
}

if($num_subs==1){
$rand_sub=array_rand($subs, 1);
$sub1=$subs[$rand_sub];
$smiles=$sub1."c1ccccc1";
}




if($num_subs==2){
$rand_sub=array_rand($subs, 1);
$sub1=$subs[$rand_sub];
$rand_sub=array_rand($subs, 1);
$sub2=$subs[$rand_sub];
//$smiles=$sub1."c1ccccc1";
$rand_omp=rand(1, 3);
//$rand_omp=3;
	if($rand_omp==1){
	$smiles="c1".$sub1."c".$sub2."cccc1";	
	}

	if($rand_omp==2){
	$smiles="c1".$sub1."cc".$sub2."ccc1";	
	}

	if($rand_omp==3){
	$smiles="c1".$sub1."ccc".$sub2."cc1";	
	}
}


}
///////////////////////END SIMPLE aromatics





////this mode for complex aromatic
if ($mode=="complexaromatic"){
///generate carbon chain between 1 and 20
//$num_C=rand(1, 10);
//echo $num_C;

$subs = array("(Br)", "(Cl)", "(I)", "(F)", "(O)", "(N)", "(C=O)", "(C(O)=O)");
$num_subs=3;

if($num_subs==3){

$rand_sub=array_rand($subs, 1);
$sub1=$subs[$rand_sub];
$rand_sub=array_rand($subs, 1);
$sub2=$subs[$rand_sub];
$rand_sub=array_rand($subs, 1);
$sub3=$subs[$rand_sub];

//$smiles=$sub1."c1ccccc1";
$rand_omp=rand(1, 4);
//$rand_omp=3;
	if($rand_omp==1){
	$smiles="c1".$sub1."c".$sub2."c".$sub3."ccc1";	
	}

	if($rand_omp==2){
	$smiles="c1".$sub1."cc".$sub2."c".$sub3."cc1";	
	}

	if($rand_omp==3){
	$smiles="c1".$sub1."ccc".$sub2."c".$sub3."c1";	
	}

	if($rand_omp==4){
	$smiles="c1".$sub1."cc".$sub2."cc".$sub3."c1";	
	}

}

}
///////////////////////END complex aromatics




////////////////////////this mode for branched alkanes
if($mode=="complexalkane"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1=$branchsmiles.")";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;

$branch_pos=rand(2, strlen ($smiles)-1);

//add branch to random position on carbon chain
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);



//add another branch
$branchnum_C=rand(1, 5);
$branchsmiles2="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles2=$branchsmiles2."C";
}
$branchsmiles2=$branchsmiles2.")";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;

$branch_pos2=rand(2, strlen ($smiles)-1);

if($branch_pos2 <= $branch_pos){
$smiles = substr_replace($smiles, $branchsmiles2, $branch_pos2, 0);
}
if($branch_pos2 > $branch_pos){
$pos=strlen($branchsmiles1)+$branch_pos2;
$smiles = substr_replace($smiles, $branchsmiles1, $pos, 0);
}



//add branch to random position on carbon chain
}

//////////END BRANCHED ALKANES





///////////////simplealkenes
////this mode for simple alkenes
if ($mode=="simplealkene"){
///generate carbon chain between 1 and 20
$num_C=rand(2, 10);
//echo "num_C=".$num_C ;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}


//$smiles="CC";
$branch_pos=rand(2, strlen($smiles)-1);
//echo "branch_pos=".$branch_pos ;
//$branch_pos="4";
//$smiles="CCCCC";

$smiles = substr_replace($smiles, "=", $branch_pos-1, 0);

///add E/Z if not terminal

$eorz=rand(1, 2);
//$eorz="1";
if($eorz=="1"){$ez1="/"; $ez2="\\";}else{$ez1="/"; $ez2="/";}

if($branch_pos>2 AND $branch_pos<(strlen($smiles)-1)){
$smiles = substr_replace($smiles, $ez1, $branch_pos-2, 0);
$smiles = substr_replace($smiles, $ez2, $branch_pos+2, 0);
}


}
///////////////////////END SIMPLE ALKENES



if ($mode=="simplealkyne"){
///generate carbon chain between 1 and 20
$num_C=rand(2, 10);
//echo "num_C=".$num_C ;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}


//$smiles="CC";
$branch_pos=rand(2, strlen($smiles)-1);
//echo "branch_pos=".$branch_pos ;
//$branch_pos="4";
//$smiles="CCCCC";

$smiles = substr_replace($smiles, "#", $branch_pos-1, 0);

//echo $smiles;
///add E/Z if not terminal

//$eorz=rand(1, 2);
//$eorz="1";
//if($eorz=="1"){$ez1="/"; $ez2="\\";}else{$ez1="/"; $ez2="/";}




}
///////////////////////END SIMPLE ALKYNES







////////////simplealcohol simplealcohol

if($mode=="simplealcohol"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1="(O)";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain

$branch_pos=rand(2, strlen ($smiles)-1);
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLEALCOHOL

////////////simpleketone simplealcohol

if($mode=="simpleketone"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1="(=O)";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain

$branch_pos=rand(2, strlen ($smiles)-1);
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLEketone



////////////simplealdehyde

if($mode=="simplealdehyde"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
//$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$smiles=$branchsmiles."C=O";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain

$branch_pos="1";
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLE Aldehydes



////////////simplecarboyylic

if($mode=="simplecarboxylic"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1="(C(=O)O)";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain


$branch_pos=rand(1, strlen ($smiles)-1);
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLE carboxylic Acids





////////////simpleesters

if($mode=="simpleesters"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1="OC(=O)";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain

//$branch_pos="1";
$branch_pos=rand(2, strlen ($smiles)-1);
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLE esters


////////////simpleamides

if($mode=="simpleamides"){
///generate carbon chain between 1 and 20
$num_C=rand(1, 10);
//echo $num_C;
$smiles="";
for ($i = 1; $i <= $num_C; $i++) {
    $smiles=$smiles."C";
}

//add a branch
$branchnum_C=rand(1, 5);
$branchsmiles="(";
for ($i = 1; $i <= $branchnum_C; $i++) {
    $branchsmiles=$branchsmiles."C";
}
$branchsmiles1="(N)=O";


//echo "smiles before branch=".$smiles;
//echo "Branch=".$branchsmiles;
//add OH to random position on carbon chain

$branch_pos=strlen ($smiles);
//$branch_pos=rand(2, strlen ($smiles)-1);
$smiles = substr_replace($smiles, $branchsmiles1, $branch_pos, 0);

}

////////////////   END SIMPLE amides








return $smiles;

} ////////////END CREATE RANDOM SMILES FUNCTION



	
	/**
    * Provide export functionality for xml format
    * @param question object the question object
    * @param format object the format object so that helper methods can be used 
    * @param extra mixed any additional format specific data that may be passed by the format (see format code for info)
    * @return string the data to append to the output buffer or false if error
    */
 /*   function export_to_xml( $question, qformat_xml $format, $extra=null ) {
		// Write out all the answers
		$expout = $format->write_answers($question->options->answers);
        return $expout;
    }

    function import_from_xml($data, $question, qformat_xml $format, $extra=null) {
        if (!array_key_exists('@', $data)) {
            return false;
        }
        if (!array_key_exists('type', $data['@'])) {
            return false;
        }
        if ($data['@']['type'] == 'easyoname') {

            // get common parts
            $question = $format->import_headers($data);

            // header parts particular to easyoname
            $question->qtype = 'easyoname';

		// run through the answers
            $answers = $data['#']['answer'];  
            $a_count = 0;
            foreach ($answers as $answer) {
                $ans = $format->import_answer( $answer );
                $question->answer[$a_count] = $ans->answer;
                $question->fraction[$a_count] = $ans->fraction;
                $question->feedback[$a_count] = $ans->feedback;
                ++$a_count;
            }
			
			$format->import_hints($question, $data);

            return $question;
        }
        return false;
    }*/
}
