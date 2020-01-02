<?PHP
SESSION_START();
include ("../classes/config/class.conn.php");
include ('../classes/class.category.delete.php');
$delete_category = new  categorydelete;
$delete_category->replace_with_null($_POST['categoryid']);
$message = $delete_category->delete_actual_category($_POST['categoryid']);
$message2 = $delete_category->delete_actual_goals($_POST['categoryid'],$_SESSION['userid']);
$message = $message.$message2;
header("Location: home.php?page=categories&function=categorydelete&message=$message");
?>