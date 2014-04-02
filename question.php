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
 * easyoname Molecular Editor question definition class.
 *
 * @package    qtype
 * @subpackage easyoname
 * @copyright  2011 The Open University
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */


defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/question/type/shortanswer/question.php');

class qtype_easyoname_question extends qtype_shortanswer_question {

    // All comparisons in easyoname are case sensitive.
    public function compare_response_with_answer(array $response, question_answer $answer) {
        global $question;
        $autofeedback = $this->autofeedback;
        // Check to see if correct or not.
        if (self::compare_string_with_wildcard($response['answer'], $answer->answer, false)) {
            return true;
        }
        if ($this->autofeedback == 0) {
            return false;
        }
        // Must be wrong answer....lets see where they went wrong.
        $anssmiles = $answer->answer;
        $usrsmiles = $response['answer'];
        $eofeedback = '';
        // Check to see if user submitted correct type (reaction or not reaction).
        if (self::smiles_is_reaction($anssmiles)) {
            if (!self::smiles_is_reaction($usrsmiles)) {
                $this->usecase = "<ol><li>You were asked to draw a reaction, but you neglected to add a reaction arrow!</li></ol>";
                return false;
            }
        } else {
            if (self::smiles_is_reaction($usrsmiles)) {
                $this->usecase = "<ol><li>You were asked to draw structures, but you drew a reaction!</li></ol>";
                return false;
            }

        }

        // Breakdown into reactions and not reactions and analyze each!

        if (self::smiles_is_reaction($anssmiles)) {   // Reaction!

            // Split into reactants and products.
            $reactantsandproducts = explode('>>', $anssmiles);
            $ansreactants = $reactantsandproducts[0];
            $ansproducts = $reactantsandproducts[1];

            $reactantsandproducts = explode('>>', $usrsmiles);
            $usrreactants = $reactantsandproducts[0];
            $usrproducts = $reactantsandproducts[1];

            $numincorrect = false;
            $usecasestring = '';
            $usrreactnumincorrect = count(explode(".", $ansreactants)) - count(explode(".", $usrreactants));

            if ($usrreactnumincorrect != '0') {
                if ($usrreactnumincorrect > 0) {
                    $usecasestring .= "<li>You are missing $usrreactnumincorrect reactant molecules in your answer!</li>";
                }
                if ($usrreactnumincorrect < 0) {
                    $usecasestring .= "<li>You have $usrreactnumincorrect too many reactant molecules in your answer!</li>";
                }
                $numincorrect = true;
            }

            $usrprodnumincorrect = count(explode(".", $ansproducts)) - count(explode(".", $usrproducts));

            if ($usrprodnumincorrect != '0') {
                if ($usrprodnumincorrect > 0) {
                    $usecasestring .= "<li>You are missing $usrprodnumincorrect product molecules in your answer!</li>";
                }
                if ($usrprodnumincorrect < 0) {
                    $usecasestring .= "<li>You have $usrprodnumincorrect too many product molecules in your answer!</li>";
                }
                $numincorrect = true;
            }
            if ($numincorrect == true) {
                $this->usecase = $usecasestring;
                return false;
            }
            // End of reaction analysis!
        } else {        // Not reaction.

            $ansnumofmole = $this->smiles_num_of_molecules($anssmiles);
            $usrnumofmole = self::smiles_num_of_molecules($usrsmiles);

            // Check to see if correct number of molecules.

            if ($ansnumofmole !== $usrnumofmole) {
                // Must have wrong num of molecules.
                if ($ansnumofmole > $usrnumofmole) {
                    $this->usecase = "<li>You are missing ".($ansnumofmole - $usrnumofmole)." molecules in your answer!</li>";
                    return false;
                } else {
                    $this->usecase = "<li>You have ".($usrnumofmole - $ansnumofmole)." molecule(s) more than are required!</li>";
                    return false;
                }

            }

            // Combine all feedback from here on out!
            $usecasestring = '';
            // Check to see if stereochemistry is required and if user has add stereochem - just looking for @ !

            // Quik check first.
            if (self::smiles_ischiral1($anssmiles)) {
                if (!self::smiles_ischiral1($usrsmiles)) {
                    $usecasestring .= "<li>You did not indicate the required R/S stereochemistry!</li>";
                }
            } else {
                if (self::smiles_ischiral($usrsmiles)) {
                    $usecasestring .= "<li>You showed stereochemistry in your answer .
                    but it was not required for this problem!</li>";
                }
            }
            // Check to see if wrong enantiomer of entire string!
            if (self::smiles_ischiral1($anssmiles) && self::smiles_ischiral1($usrsmiles)) {
                $anstemp = str_replace("@", "", $anssmiles);
                $usrtemp = str_replace("@", "", $usrsmiles);
                if ($anstemp == $usrtemp) {
                    $usecasestring .= "<li>You likely have the wrong stereochemistry!</li>";
                    $this->usecase = $usecasestring;
                    return false;
                }
            }

            // Check to see if E/Z correct.

            // Quik check first.
            if (strpos($anssmiles, '/') !== false || strpos($anssmiles, '\\') !== false) {
                if (strpos($usrsmiles, '/') == false && strpos($usrsmiles, '\\') == false) {
                    $usecasestring .= "<li>You did not indicate the required E/Z stereochemistry!</li>";
                }
            } else {
                if (strpos($usrsmiles, '/') !== false || strpos($usrsmiles, '\\') !== false) {
                    $usecasestring .= "<li>You showed E/Z stereochemistry in your answer but .
                        it was not required for this problem!</li>";
                }
            }
            // Check for lone pairs.

            if (strpos($anssmiles, 'lp') !== false) {
                if (strpos($usrsmiles, 'lp') == false) {
                    $usecasestring .= "<li>You are missing lone pair electrons!</li>";
                }
            } else {
                if (strpos($usrsmiles, 'lp') !== false) {
                    $usecasestring .= "<li>You showed lone pairs in your answer but they were not required!</li>";
                }
            }

            // Check for radicals.
            if (strpos($anssmiles, '^') !== false) {
                if (strpos($usrsmiles, '^') == false) {
                    $usecasestring .= "<li>You are missing radical electrons!</li>";
                }
            } else {
                if (strpos($usrsmiles, '^') !== false) {
                    $usecasestring .= "<li>You showed radical electrons in your answer but they were not required!</li>";
                }
            }

            // Check for charge.
            if (strpos($anssmiles, '+') !== false || strpos($anssmiles, '-') !== false) {
                if (strpos($usrsmiles, '+') == false && strpos($usrsmiles, '-') == false) {
                    $usecasestring .= "<li>You are missing charges on atoms!</li>";
                }
            } else {
                if (strpos($usrsmiles, '^') !== false) {
                    $usecasestring .= "<li>You showed charges in your answer but they were not required!</li>";
                }
            }

            $this->usecase = $usecasestring;
        }    // End of not reaction analysis.

        return false;
    }

    public function smiles_is_reaction($smiles) {
        if (strpos($smiles, '>>') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function smiles_num_of_molecules($smiles) {
        $molecules = explode(".", $smiles);
        return count($molecules);
    }

    public function smiles_molecules($smiles) {
        return explode(".", $smiles);
    }

    public function smiles_ischiral1($smiles) {
        if (strpos($smiles, '@') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function smiles_ischiral2($smiles) {
        if (strpos($smiles, '@@') !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function smiles_iseorz($smiles) {
        preg_match_all('$\\\(.*?)\\\$', $smiles, $matches);
        preg_match_all('$\\/(.*?)=(.*?)\\/$', $smiles, $matches);
        preg_match_all('$\\/(.*?)=(.*?)\\\$', $smiles, $matches);
        preg_match_all('$\\\(.*?)=(.*?)\\/$', $smiles, $matches);
    }

    public function get_expected_data() {
        return array('answer' => PARAM_RAW, 'easyoname' => PARAM_RAW, 'mol' => PARAM_RAW);
    }

    public function get_xmlattribute($string, $attribute) {
        $xml = simplexml_load_string($string);
        return $xml->MDocument[0]->MChemicalStruct[0]->molecule->atomArray[0][$attribute];
    }
}
