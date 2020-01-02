<?php
include ("../classes/config/class.conn.php");
include ('../classes/class.today.php');

$zingdot = new class_today;
$page_title = "Today";
$today_date = date("Y/m/d");
$page_description = "<p>Add up all the tomatoes for today " . $today_date . "</p>";

include('includes/header.php');
include ('includes/menu.php');
//include ('includes/posthead.php');



print("<p><hr/></p>");


$tables = $zingdot->create_table_name_array_list();

// instantiate array
$table_names=array();
foreach($tables as $key => $value){
    $value= substr($value,9);
    $table_names[] = $value;
}
for($i=0; $i<sizeof($table_names); $i++){
    print("<p align='center'><a href=''>".$table_names[$i]."</a></p><br/>");
    
}

