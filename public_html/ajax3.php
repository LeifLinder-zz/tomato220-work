<?php
if (isset($_GET['experience'])) {

    echo $_GET['experience'];
    echo '<p>Hubris</p>';
        /* do mysql operations and echo the result here */
    exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
<script type="text/javascript">
function myFunction(value)
{
    if(value!="All")
    {
        $.ajax(
        {
            type: "GET",
            url: '<?php echo $_SERVER['PHP_SELF']; ?>',
            data: { experience: value},
            success: function(data) {
                $('#resultDiv').html(data);
        }
    });
    }
    else
    {
        $('#resultDiv').html("Please select a value.");
    }
}
</script>
</head>

<body>
<p>
<label for="experience">Experience :</label>
<select id="experience" name="experience" onChange="myFunction(this.value)">
    <option value="All" selected="selected">All</option>
    <option value="Fresher">Fresher</option>
    <option value="Experienced">Experienced</option>
</select>
</p>
<div id="resultDiv">
Please select a value.
</div>
</body>
</html>