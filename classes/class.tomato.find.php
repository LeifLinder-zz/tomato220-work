<?PHP
class findtomato extends conn{

    public $lastid;
    private $existing_categories;
    private $defaultWeekNumber;
    private $week_value_from_db;

private function default_week_setting(){
        $currentWeekNumber = date('Y')."-W".date('W');
        $this->defaultWeekNumber=$currentWeekNumber;
}



function fix_null_titles(){
  $statement = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`title` IS NULL OR `tomato`.`title` = ''");
  //$statement = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`title` LIKE 'two'");
  $statement->execute();
  $value = $statement->fetchall(PDO::FETCH_ASSOC);
  $size=sizeof($value);
    for ($i = 0; $i < $size; $i++){
      print('<p>'.$value[$i]['id'].'</p>');
      print('<p>'.$value[$i]['notes'].'</p>');
      $statement = $this->conn->prepare("UPDATE `tomato220`.`tomato` 
      SET `tomato`.`title` = '".$value[$i]['notes']."'
      WHERE `tomato`.`id` = ".$value[$i]['id']."");
      $statement->execute();
  }
}

function fix_null_dates(){
  $statement = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomdate` IS NULL OR `tomato`.`tomdate` = ''");
  $statement->execute();
  $value = $statement->fetchall(PDO::FETCH_ASSOC);
  $size=sizeof($value);
    for ($i = 0; $i < $size; $i++){
      print('<p>'.$value[$i]['id'].'</p>');
      print('<p>'.$value[$i]['timestamp'].'</p>');
      $change_to_date = $value[$i]['timestamp'];
      // new date value from timestamp
      $date_from_stamp = substr($change_to_date, 0, -9);
      print('<p>Date to:  '.$date_from_stamp.'</p>');
      $statement = $this->conn->prepare("UPDATE `tomato220`.`tomato` 
      SET `tomato`.`tomdate` = '".$date_from_stamp ."'
      WHERE `tomato`.`id` = ".$value[$i]['id']."");
      $statement->execute();
  }
}


function fix_null_week_number(){
  $statement = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` IS NULL OR `tomato`.`tomweek` = ''");
  $statement->execute();
  $value = $statement->fetchall(PDO::FETCH_ASSOC);
  $size=sizeof($value);
    for ($i = 0; $i < $size; $i++){
      print('<p>'.$value[$i]['id'].'</p>');
      print('<p>'.$value[$i]['timestamp'].'</p>');
      $change_to_date = $value[$i]['timestamp'];
      $date_from_stamp = substr($change_to_date, 0, -9);
      $week_value = date("W", strtotime($date_from_stamp));
      $year_value =date("Y", strtotime($date_from_stamp));
      $tomato_week = $year_value ."-W".$week_value;
      print('<p>Week is:  '.$tomato_week.'</p>');
      $statement = $this->conn->prepare("UPDATE `tomato220`.`tomato` 
      SET `tomato`.`tomweek` = '".$tomato_week."'
      WHERE `tomato`.`id` = ".$value[$i]['id']."");
      $statement->execute();
  }
}


function words_in_title_column(){
  $statment = $this->conn->prepare("SELECT `tomato`.`title` FROM `tomato220`.`tomato`");
}

function search_categories(){
  $statement = $this->conn->prepare("");
}

public function find_tomato_form(){
    // set default "week" and send upstairs
    $this->default_week_setting();
    // reset link below to empty form fields
    print('<p><a href="home.php?page=addtomato">Reset</a></p>');

    print('<form method="post" id="upload_form_tomato" action="http://localhost/tomato220.com/public_html/refresh.tomato.find.php">');
    print('<input type="hidden" name="userid" value="'.$_SESSION['userid'].'">');
    print('<input type="hidden" name="tomato_submit" value="yes">');

// Title
   echo'<div class="form-group">
    <label for="tomatoTitle_FormElement">SEARCH WORD IN TITLE</label>
    <input type="text" name="title" class="form-control" id="tomatoTitle_FormElement" aria-describedby="titleHelp" placeholder="Tomato Title">
    <small id="titleHelp" class="form-text text-muted">Keep it short and sweet.</small>
  </div>';

// Description
echo '<div class="form-group">
<label for="tomatoDescription_FormElement">Notes</label>
 <textarea name="notes" class="form-control" id="tomatoDescription_FormElement" placeholder="Notes" rows="3"></textarea>
 <small id="notesHelp" class="form-text text-muted">Write a lot of notes.</small>
</div>';

    // Count
    echo'<div class="form-group">
    <label for="tomatoCount_FormElement">Count</label>
    <input type="number" name="count" class="form-control" id="tomatoCount_FormElement" aria-describedby="countHelp" placeholder="Count">
    <small id="countHelp" class="form-text text-muted">Number of tomatos.</small>
  </div>';

// Date
    echo'<div class="form-group">
    <label for="tomatoDate_FormElement">Date</label>
    <input type="date" name="date" class="form-control" id="tomatoDate_FormElement" aria-describedby="dateHelp" placeholder="Date">
    <small id="dateHelp" class="form-text text-muted">Enter date of tomato.</small>
  </div>';

 // Week
  echo'<div class="form-group">
  <label for="tomatoWeek_FormElement">Week</label>
  <input type="text" name="week" class="form-control" id="tomatoWeek_FormElement" aria-describedby="weekHelp" placeholder="Tomato Week" value="'.$this->defaultWeekNumber.'">
  <small id="weekHelp" class="form-text text-muted">Automatically created by default.</small>
</div>';

     // URL
     echo'<div class="form-group">
     <label for="tomatoUrl_FormElement">URL</label>
     <input type="url" name="url" class="form-control" id="tomatoUrl_FormElement" aria-describedby="urlHelp" placeholder="Tomato URL">
     <small id="urlHelp" class="form-text text-muted">Nice but not necessary.</small>
   </div>';

// Categories
$categories = new form_elements; 
$categories->categories();

// Keywords
echo '<div class="form-group"><label for="tomatoKeywords_FormElement">Keywords</label><br/>';
?>
<div id="ajaxKeywords"></div>
<?PHP
echo '</div>';


// Submit
   echo ' <div class="form-group">
   <button type="submit" class="btn btn-primary mb-2">Submit</button>
   </div>';
   echo '</form>';
   print('<br/><br/>');
}

}

?>