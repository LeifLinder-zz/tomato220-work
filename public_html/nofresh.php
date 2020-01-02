<html>
<title>Submit Form without Page Refresh - PHP/jQuery - TecAdmin.net</title>
<head>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/submit.js"></script>
</head>
<body>
    <!--
	<form id="myForm" method="post">
	   Name:    <input name="name" id="name" type="text" /><br />
	   Email:   <input name="email" id="email" type="text" /><br />
	   Phone No:<input name="phone" id="phone" type="text" /><br />
	   Gender:  <input name="gender" type="radio" value="male">Male
	 	        <input name="gender" type="radio" value="female">Female<br />
	 
	   <input type="button" id="submitFormData" onclick="SubmitFormData();" value="Submit" />
	 </form>
	 <br/>
	 Your data will display below..... <br />
     ==============================<br />
-->
<?php
if(!isset($_POST['green'])){
    $green="";
}
if(!isset($_POST['red'])){
    $red="";
}
?>
<div id="results">
<form id="myForm" method="post" action="">

    <div><input type="checkbox" id="red" name="red" value="checked" <?PHP print($red) ?>> <label for="red">Red</label></div>

    <div><input type="checkbox" id="green" name="green" value="checked" <?PHP print($green) ?>> <label for="green">green</label></div>

    <input type="hidden" name="submitted" id="submitted" value="submitted"/>

    <div><input type="button" id="submitFormData" onclick="SubmitFormData();" value="Submit"/></div>

</form>
     </div>
</body>
</html>
