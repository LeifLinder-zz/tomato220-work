<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.edit.php');
$change_count = new edittomato;
$change_count->edit_tomato_count($_POST['tomcount'], $_POST['tomid']);
header('Location: home.php');
?>