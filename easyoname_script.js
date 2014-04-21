M.qtype_easyoname = {
    insert_structure_into_applet: function() {
        var textfieldid = 'id_answer_0';
        if (document.getElementById(textfieldid).value != '') {
            var s = document.getElementById(textfieldid).value;
            document.MSketch.setMol(s, 'cxsmiles');
        }
    },
    insert_applet: function(Y, moodleurl, marvinpath) {
        var warningspan = document.getElementById('appletdiv');
        warningspan.innerHTML = '';
        var newApplet = document.createElement("applet");
        newApplet.code = 'chemaxon.marvin.applet.JMSketchLaunch';
        newApplet.archive = 'appletlaunch.jar';
        newApplet.name = 'MSketch';
        newApplet.width = '650';
        newApplet.height = '460';
        newApplet.tabIndex = -1; // Not directly tabbable
        newApplet.mayScript = true;
        newApplet.id = 'MSketch';
        newApplet.setAttribute('codebase', marvinpath);
        var param = document.createElement('param');
        param.name = 'codebase_lookup';
        param.value = 'false';
        newApplet.appendChild(param);
        var param = document.createElement('param');
        param.name = 'menubar';
        param.value = 'false';
        newApplet.appendChild(param);
        var param = document.createElement('param');
        param.name = 'menuconfig';
        param.value = moodleurl + '/question/type/easyoname/customization_mech_instructor.xml';
        newApplet.appendChild(param);
        var param = document.createElement('param');
        param.setAttribute('bondDraggedAlong', 'false');
        newApplet.appendChild(param);
        var param = document.createElement('param');
        param.name = 'chargeWithCircle';
        param.value = 'true';
        newApplet.appendChild(param);
        warningspan.appendChild(newApplet);
    }
}
M.qtype_easyoname.init_getanswerstring = function(Y, moodle_version) {
    var handleSuccess = function(o) {};
    var handleFailure = function(o) { /*failure handler code*/
        };
    var callback = {
        success: handleSuccess,
        failure: handleFailure
    };
    if (moodle_version >= 2012120300) { //Moodle 2.4 or higher
        YAHOO = Y.YUI2;
    }
    Y.all(".id_insert").each(function(node) {
        node.on("click", function() {
            var buttonid = node.getAttribute('id');
            var s = document.MSketch.getMol('cxsmiles:u');
            textfieldid = 'id_answer_' + buttonid.substr(buttonid.length - 1);
            document.getElementById(textfieldid).value = s;
        });
    });
};
