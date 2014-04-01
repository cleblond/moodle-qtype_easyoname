<?
defined('MOODLE_INTERNAL') || die();

function xmldb_qtype_easyoname_upgrade($oldversion = 0) {

    global $CFG, $DB;

    $dbman = $DB->get_manager();



   if ($oldversion < 2014022800) {

        // Define field orderimportant to be added to question_easyoname.
        $table = new xmldb_table('question_easyoname');
        $field = new xmldb_field('implicithydrogen', XMLDB_TYPE_CHAR, '10', null, null, null, 'hetero', 'autofeedback');

        // Conditionally launch add field orderimportant.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // easyoname savepoint reached.
        upgrade_plugin_savepoint(true, 2014022800, 'qtype', 'easyoname');
    }






    if ($oldversion < 2013111500) {

        // Define field orderimportant to be added to question_easyoname.
        $table = new xmldb_table('question_easyoname');
        $field = new xmldb_field('autofeedback', XMLDB_TYPE_INTEGER, '2', null, null, null, 0, 'userandom');

        // Conditionally launch add field orderimportant.
        if (!$dbman->field_exists($table, $field)) {
            $dbman->add_field($table, $field);
        }

        // easyoname savepoint reached.
        upgrade_plugin_savepoint(true, 2013111500, 'qtype', 'easyoname');
    }




    return true;


}



?>
