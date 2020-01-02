<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.keyword.delete.php');
$delete_keyword = new  keyworddelete;
$delete_keyword->delete_tom_keyword_links($_POST['keyid']);
$delete_keyword->delete_actual_keyword($_POST['keyid']);
header('Location: home.php?page=keywords&function=keyworddelete&deletemessage=deleted');
?>