<?php
class createCategory extends conn{

    function upload_new_category($new_category, $userid=1001, $favorite=1){
        // first check if keyword exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`category` LIKE :NEWCATEGORY AND `category`.`userid` = :USERID");
        $stm->bindParam(':NEWCATEGORY',$new_category);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        if ($stm->rowCount() > 0){
            $message="Redundant";
            } else {

            $stm = $this->conn->prepare("INSERT INTO `tomato220`.`category` (`category`.`id`, `category`.`userid`, `category`.`category`, `category`.`favorite`, `category`.`timestamp`) VALUES (NULL, :USERID, :NEWCATEGORY, :FAVORITE, CURRENT_TIMESTAMP)"); 
            $stm->bindParam(':USERID',$userid);
            $stm->bindParam(':NEWCATEGORY',$new_category);
            $stm->bindParam(':FAVORITE',$favorite);
            $stm->execute();
            $lastid = $this->conn->lastInsertId(); 
            // create a tomato220.goal entry for the new category
            $this->create_goal_for_new_category($lastid, $new_category, 1001);
            $count = $stm->rowCount();  
            if($count > 0){
                $message='ID: '.$categoryid.' Created';
            }else{
                $message="Problem";
            }


        }

        $this->conn=NULL;
        return $message;
    }

    function create_goal_for_new_category($categoryid, $catname, $userid){
        $stm = $this->conn->prepare("INSERT INTO `tomato220`.`goals` (`goals`.`id`, `goals`.`userid`, `goals`.`categoryid`, `goals`.`catname`,`goals`.`hours`, `goals`.`active`, `goals`.`timeperiod`, `goals`.`timestamp`) VALUES (NULL, :USERID, :CATID, :CATNAME, '0', '1', 'week', CURRENT_TIMESTAMP)"); 
        $stm->bindParam(':CATID',$categoryid);
        $stm->bindParam(':CATNAME',$catname);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();       
    }

    function form_create_category(){ 
        print('<form method="post" action="refresh.category.create.php">');
        print('<input type="hidden" name="category_submit" value="1"/>');
        print('<input type="hidden" name="userid" value="'.$_SESSION['userid'].'"/>');
        print('<input type="hidden" name="favorite" value="1"/>');
        print('<div class="form-group">');
        print('<label for="new_category">New Category</label>');
        print('<input type="text" name="new_category" class="form-control" id="new_category" aria-describedby="catHelp" placeholder="Enter Category">');
        print('<small id="catHelp" class="form-text text-muted">No Spaces. Capitalize.</small>');
        print('</div>');
        print('<button type="submit" class="btn btn-primary">Submit</button>');
        print('</form><br/>');
    }

}
?>