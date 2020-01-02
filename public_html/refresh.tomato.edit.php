<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.edit.php');

$tomato_edit_object = new edittomato;
if(isset($_POST['tomid'])){
    $tomid = $_POST['tomid'];
    $userid=$_POST['userid'];
    $title=$_POST['title'];
    $tomdate=$_POST['tomdate'];
   // $tomweek=$_POST['tomweek'];
    $tomcount=$_POST['count'];
    $categoryid=$_POST['categoryid'];
    $notes=$_POST['notes'];
    $url=$_POST['url'];

    $tomato_edit_object->upload_edit_query($tomid, $title, $tomdate, $tomcount, $categoryid, $notes);
/*
    $tomato_edit_object->upload_edit_query('1001', '893', 'asdfasdf', $date, $week, $count, $notes, $url);
*/
   // upload_edit_query($userid, $tomid, $title, $tomdate, $tomweek, $tomcount, $notes, $url)

// header("Location: home.php?page=tomato&function=tomatoedit&tomid=$tomid");
header("Location: home.php");
}

/*
print('<pre>');
print_r($_POST);
print('</pre>');
*/

?>