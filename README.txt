  Moodle 2.3 plugin: EasyOChem Marvinsketch Mechanism (EasyOMech) question type

  Based on Moodle integration script written by Dan Stowell

  Modifications for Marvinsketch and Reactio arrows by Carl LeBlond


INSTALLATION:

This will NOT work with Moodle 2.0 or older, since it uses the new
question API implemented in Moodle 2.1.

This is a Moodle question type. It should come as a self-contained 
"easyomech" folder which should be placed inside the "question/type" folder
which already exists on your Moodle web server.

Once you have done that, visit your Moodle admin page - the database 
tables should automatically be upgraded to include an extra table for
the EasyOChem Mechanism question type.

You must download a recent copy of Marvinsketch from www.chemaxon.com (free for academic use) and intall it in folder named "marvin" at your web root.  Alternatively you could edit the php scripts if your marvin installation is elsewhere.  This version of easyomech was developed using Marvinsketch 5.10.3_b102  


USAGE:

The EasyOChem Mechanism question can be used to design single step reaction mechanism steps.  You 
can ask questions such as "Please add curved arrows showing the flow of electrons for the following reaction?"  or Please add curved arrows showing how the following resonance structure could be obtained?.

The student then draws the arrows for for the mechanism, and then press a button 
to store the answer in a text box.

