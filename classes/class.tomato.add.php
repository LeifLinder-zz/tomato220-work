<?php
class addtomato extends conn{

    public $lastid;
    private $existing_categories;
    private $defaultWeekNumber;
    private $week_value_from_db;
    private $todaydate;

private function default_week_setting(){
        $currentWeekNumber = date('Y')."-W".date('W');
        $this->defaultWeekNumber=$currentWeekNumber;
}

private function todaydate(){
    $today = '2019-04-15';
    return $today;
}

function week_value_from_week_table(){
	$sth = $this->conn->prepare("SELECT `week`.`week` FROM `tomato220`.`week` WHERE `week`.`id` = 1 LIMIT 1");
	$sth->execute();
	$week = $sth->fetchColumn();
    $this->week_value_from_db = $week;
}

function set_week(){
	echo '<form method="POST" id="set_week_form" action="">
	<input type="week" name="week" id="week">
	<input type="submit"/>
	</form>';
}


    public function upload_form_tomato(){
        // set default "week" and send upstairs
        $this->default_week_setting();
        // reset link below to empty form fields
        print('<p><a href="home.php?page=addtomato">Reset</a></p>');

        print('<form method="post" id="upload_form_tomato" action="refresh.tomato.create.php">');
        print('<input type="hidden" name="userid" value="1001">');
        print('<input type="hidden" name="tomato_submit" value="yes">');

    // Title
       echo'<div class="form-group">
        <label for="tomatoTitle_FormElement">Title</label>
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
        <input type="date" name="date" class="form-control" id="tomatoDate_FormElement" aria-describedby="dateHelp" placeholder="Date" value="'.date('Y-m-d').'">
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

        function upload_tomato_with_keyword_array($userid,$title,$tomdate,$tomweek,$count,$category,$notes,$url, $keywords){
            $stmt = $this->conn->prepare("INSERT INTO `tomato220`.`tomato` (
                `tomato`.`id`,
                `tomato`.`userid`,
                `tomato`.`title`,
                `tomato`.`tomdate`,
                `tomato`.`tomweek`,
                `tomato`.`count`,
                `tomato`.`category`,
                `tomato`.`notes`,
                `tomato`.`URL`,
                `tomato`.`timestamp`
                )VALUES (
                    NULL,
                    :userid,
                    :title,
                    :tomdate,
                    :week,
                    :count,
                    :category,
                    :notes,
                    :URL,
                    CURRENT_TIMESTAMP
                    )");
            $stmt->bindParam(':userid', $userid, PDO::PARAM_STR);
            $stmt->bindParam(':title', $title, PDO::PARAM_STR);
            $stmt->bindParam(':tomdate', $tomdate, PDO::PARAM_STR);
            $stmt->bindParam(':week', $tomweek, PDO::PARAM_STR);
            $stmt->bindParam(':count', $count, PDO::PARAM_INT);
            $stmt->bindParam(':category', $category, PDO::PARAM_INT);
            $stmt->bindParam(':notes', $notes, PDO::PARAM_STR);
            $stmt->bindParam(':URL', $url, PDO::PARAM_STR);
            $stmt->execute();
            $last_id = $this->conn->lastInsertId();
            $tomid=$last_id;
            $pdo = null;
            // now upload keywords array
            $stmt = $this->conn->prepare("INSERT INTO `tomato220`.`link_tom_to_keywords` (`link_tom_to_keywords`.`id`, `link_tom_to_keywords`.`userid`, `link_tom_to_keywords`.`tom_id`, `link_tom_to_keywords`.`keyword_id`, `link_tom_to_keywords`.`timestamp`) VALUES (NULL, :userid, :tomid, :keywordid, CURRENT_TIMESTAMP)");
            $keywords_for_tomato = sizeof($keywords);
            for($i=0; $i < $keywords_for_tomato; $i++ ){
                $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
                $stmt->bindParam(':tomid', $tomid, PDO::PARAM_INT);
                $stmt->bindParam(':keywordid', $keywords[$i], PDO::PARAM_INT);
                $stmt->execute();
            }
            return $tomid;
        }
    }
?>