
function getSmiles(textfieldid) {
	document.getElementById(textfieldid).value = document.getElementById('EASYONAME' + textfieldid).smiles();
}


/*
function getSmilesEdit(buttonname){
    var buttonnumber= buttonname.slice(7,-1);
	textfieldid = 'id_answer_' + buttonnumber;
	document.getElementById(textfieldid).value = document.getElementById('JME').smiles();
}
*/


///modified by crl for easyoname sketch
function getSmilesEdit(buttonname, format){
    var buttonnumber = buttonname.slice(7,-1);
    var s = document.MSketch.getMol(format);
//	s = unix2local(s); // Convert "\n" to local line separator
	textfieldid = 'id_answer_' + buttonnumber;
	document.getElementById(textfieldid).value = s;
}





M.qtype_easyoname={
    insert_structure_into_applet : function(){
		var textfieldid = 'id_answer_0';
		if(document.getElementById(textfieldid).value != '') {
		
		var s = document.getElementById(textfieldid).value;
		document.MSketch.setMol(s, 'cxsmiles');
		}

	}
}
