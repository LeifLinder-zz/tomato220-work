<?PHP
SESSION_START();
include ("../classes/config/class.conn.php");
include ('../classes/class.setup.goals.php');
//check_goal_if_changed($catid, $goal)
$goals_edit_object = new setupgoals;
/*
print('<pre>');
print_r($_POST);
print('</pre>');
*/
$update = $goals_edit_object->check_goal_if_changed($_POST['categoryid'], $_POST['hours']);
if($update == 0){
  $goals_edit_object->create_new_goal($_POST['categoryid'], $_POST['hours'], $_POST['categoryname'], $_SESSION['userid']);
}
header('Location: home.php?page=setup&function=setupweeklygoals');
/*
if(isset($_POST['updategoals'])){
    /*
    [updategoals] => updategoals
    [Norsk] => 20
    [Code] => 10
    [Design] => 6
    [Guitar] => 6
    [Task] => 10
    [Study] => 2
    [Exercise] => 2
    [Job_Search] => 14
   */
 // $Norsk = $_POST['Norsk'];
    /*
    $tomid = $_POST['tomid'];
    $userid=$_POST['userid'];
    $title=$_POST['title'];
    $tomdate=$_POST['tomdate'];
    $tomcount=$_POST['count'];
    $categoryid=$_POST['categoryid'];
    $notes=$_POST['notes'];
    $url=$_POST['url'];
    */
    /*
    $tomato_edit_object->upload_edit_query($tomid, $title, $tomdate, $tomcount, $categoryid, $notes);
    */
// header("Location: home.php?page=tomato&function=tomatoedit&tomid=$tomid");
//}

/*
if(isset($_POST)){
  print('<p>POST has values</p>');
  print('<p>POST has '.sizeof($_POST).' values</p>');
  print('<ul>');
  print('<pre>');
  print_r($_POST);
  print('</pre>');
  */
/*
  foreach($_POST AS $key => $value){
    print('<hr/>');
    print('<p>'.$key.' => '.$value.'</p>');
    $goals_edit_object->check_goal_if_changed($key, $value);
    print('<hr/>');
  }
  print('</ul>');
  */
  /*
  for($i=0;$i<sizeof($_POST['catnames']);$i++){
    print('<p>'.$_POST['catnames'][$i].'</p>');
   print('<p>'.$_POST['catids'][$i].'</p>');
   print('<p>'.$_POST['goals'][$i].'</p>');
   print('<p>'.$_POST['active'][$i].'</p>');
    $update = $goals_edit_object->check_goal_if_changed($_POST['catids'][$i], $_POST['goals'][$i]);
    if($update == 0){
      $goals_edit_object->create_new_goal($_POST['catids'][$i], $_POST['goals'][$i], $_POST['catnames'][$i], '1001');
    }
    */
  //}
//}
?>