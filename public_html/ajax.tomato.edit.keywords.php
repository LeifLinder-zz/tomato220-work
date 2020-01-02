<?php
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.edit.php');
$keywords_edit = new keywordedit;
//$form_elements_object = new form_elements;
// get all keywords associated with category
// and create a lot of check boxes
//$form_elements_object->keywords($_GET['categoryid']);
$keywords_edit->keywords_edit_with_current_selected($_GET['categoryid']);
?>