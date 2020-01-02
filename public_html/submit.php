<?php
if(!isset($_POST['green'])){
    $green="";
}
if(!isset($_POST['red'])){
    $red="";
}
?>
<?php
/*
  echo $_POST['name'] . "<br />";
  echo $_POST['email'] . "<br />";
  echo $_POST['phone'] . "<br />";
  echo $_POST['gender'] . "<br />";
  echo "==============================<br />";
*/
  echo "All Data Submitted Successfully!";
?>
<form id="myForm" method="post" action="">

<div><input type="checkbox" id="red" name="red" value="checked" <?PHP print($red) ?>> <label for="red">Red</label></div>

<div><input type="checkbox" id="green" name="green" value="checked" <?PHP print($green) ?>> <label for="green">green</label></div>

<input type="hidden" name="submitted" id="submitted" value="submitted"/>

<div><input type="button" id="submitFormData" onclick="SubmitFormData();" value="Submit"/></div>

</form> 