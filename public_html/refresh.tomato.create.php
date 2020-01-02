<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.add.php');
$tomato_add_object = new addtomato;
if(isset($_POST['tomato_submit'])){
    $userid=$_POST['userid'];
    $title=$_POST['title'];
    $date=$_POST['date'];
    $week=$_POST['week'];
    $count=$_POST['count'];
    $category=$_POST['categories'];
    $notes=$_POST['notes'];
    $url=$_POST['url'];
        if(!(isset($_POST['keywords']))){
            $keywords = array();
        }else{
            $keywords = $_POST['keywords']; 
        }
    $created_tomato_id = $tomato_add_object->upload_tomato_with_keyword_array(
        $userid,
        $title,
        $date,
        $week,
        $count,
        $category,
        $notes,
        $url,
        $keywords);
}

//header("Location: home.php?newkeyid=$created_tomato_id");
header("Location: home.php");
?>