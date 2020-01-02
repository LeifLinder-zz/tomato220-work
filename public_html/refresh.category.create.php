<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.category.create.php');
$category_add_object = new createCategory;
if(isset($_POST['category_submit'])){
    
    $new_category=$_POST['new_category'];
    $userid=$_POST['userid'];
    $favorite=$_POST['favorite'];
    $message = $category_add_object->upload_new_category($new_category, $userid=1001, $favorite);
}

header("Location: home.php?page=categories&function=categorycreate&message=$message");
?>