<?php
/*
include ("../classes/config/class.conn.php");
include ('../classes/class.upload.php');
        $insert = new upload;
        foreach($_POST['keywords'] as $key => $value){
            $insert->insertkeywords($_POST['tomid'], $value);
        }
    header("location:http://localhost/tomato220.com/public_html/");
*/
print('<p>tomid');
print('<pre>');
print($_POST['tomid']);
print('</pre>');
print('<p>keywords');
print('<pre>');
print($_POST['keywords']);
print('</pre>');

?>