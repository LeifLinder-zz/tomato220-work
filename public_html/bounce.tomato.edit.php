<?PHP
include ("../classes/config/class.conn.php");
include ('../classes/class.tomato.edit.php');
$edit_tomato = new edittomato;

if(isset($_POST['tomid'])){
   // print('<p>TOMDID '.$_POST['tomid'].'</p>');
    $tomid =  $_POST['tomid'];
}
if(isset($_POST['userid'])){
    //print('<p>USERID '.$_POST['userid'].'</p>');
    $userid = $_POST['userid'];
}

if(isset($_POST['old_category_id'])){
    //  print('<p>OLD CAT '.$_POST['old_category_id'].'</p>');
      $old_category_id = $_POST['old_category_id'];
  }

  //  ****  Start changing things  ***** //

if(isset($_POST['title'])){
   // print('<p>TITLE '.$_POST['title'].'</p>');
   $title = $_POST['title'];
    $edit_tomato->update_title($tomid, $userid, $title);
}

if(isset($_POST['tomdate'])){
  //  print('<p>TOMEDATE '.$_POST['tomdate'].'</p>');
  $tomdate = $_POST['tomdate'];
  $edit_tomato->update_tomdate($tomid, $userid, $tomdate);
}

/*
if(isset($_POST['new_date'])){
    //  print('<p>TOMEDATE '.$_POST['tomdate'].'</p>');
    $new_date = $_POST['new_date'];
    $edit_tomato->update_tomdate($tomid, $userid, $new_date);
  }
*/

if(isset($_POST['tomweek'])){
   // print('<p>TOMWEEK '.$_POST['tomweek'].'</p>');
   $tomweek = $_POST['tomweek'];
   $edit_tomato->update_tomweek($tomid, $userid, $tomweek);
}

if(isset($_POST['count'])){
    //   print('<p>COUNT '.$_POST['count'].'</p>');
    $count = $_POST['count'];
    $edit_tomato->update_count($tomid, $userid, $count);
}

if(isset($_POST['notes'])){
  //  print('<p>NOTES '.$_POST['notes'].'</p>');
  $notes = $_POST['notes'];
  $edit_tomato->update_notes($tomid, $userid, $notes);
}

if(isset($_POST['url'])){
  //  print('<p>URL '.$_POST['url'].'</p>');
  $url = $_POST['url'];
  $edit_tomato->update_url($tomid, $userid, $url);
}

if(isset($_POST['new_category'])){
        if($_POST['new_category']==22){
        // do nothing
        }else{
            $new_category = $_POST['new_category'];
            $edit_tomato->update_new_category($tomid, $userid, $new_category);
        }
    }else{
        // do nothing, keep old category
}

if(isset($_POST['keywords'])){
        $keywords = $_POST['keywords'];
        $edit_tomato->update_keywords($tomid, $userid, $keywords);
    }else{
       // do nothing
}
 //header("Location: home.php?page=tomato&function=tomatoedit&tomid=$tomid");
 header("Location: home.php");
?>