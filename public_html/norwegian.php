<?php
include ("../classes/config/class.conn.php");
include ('../classes/class.norwegian.php');

$zingdot = new class_today;
$page_title = "Today";
$today_date = date("Y/m/d");
$page_description = "<p>Add up all the tomatoes for today " . $today_date . "</p>";

include('includes/header.php');
include ('includes/menu.php');
//include ('includes/posthead.php');



print("<p><hr/></p>");
$zingdot->norwegian_language_today();
