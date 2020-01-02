<?php
class categorydelete extends conn{
private $number_times_category_used = 0;

    function show_toms_associated_with_category($category_id){
        // first check if category exists already
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`category` = :CATEGORYID");
        $stm->bindParam(':CATEGORYID',$category_id);
        $stm->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        if ($resource->rowCount() < 1){
            print('<div class="alert alert-danger" role="alert">No tomatoes have that category</div>');
        } else {
            $count = sizeof($resource);
            for($i=0; $i < $count; $i++ ){
                $this->get_tomatoes_by_tomatoid($resource['tomid']);
            }
        }
        $this->conn=NULL;
    }

    function get_tomatoes_by_tomatoid($tomid, $userid=1001){
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid` = :USERID  LIMIT 1");
        $stm->bindParam(':TOMID',$tomid);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        $resource= $sth->fetch(PDO::FETCH_ASSOC);
        print('<p>'.$resource['title'].' ID: '.$resource['id'].'</p>');
    }

    function show_categories_with_delete_button($userid=1001){
        $stm =$this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`userid` = :USERID ORDER BY `category`.`category` ASC");
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        $resource= $stm->fetchall(PDO::FETCH_ASSOC);
        $count = sizeof($resource);
        print('<div class="alert alert-warning" role="alert">Delete Category</div>');
        print('<table class="table">');
        for($i=0; $i < $count; $i++){
            print('<tr>
            <td valign="top">'.$resource[$i]['category'].'</td>  
            <td><button type="button" class="btn btn-light" data-toggle="modal" data-target="#'.$resource[$i]['id'].'">Delete</button>
            </td>
            </tr>'); 
            print('
                <div id="'.$resource[$i]['id'].'" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">'.$resource[$i]['category'].'</h4>
                      </div>
                      <div class="modal-body">
                      <h2>Really?</h2>
                      <p><span class="bigandbad">'.$resource[$i]['category'].'</span> is used on ['.$this->times_category_used($resource[$i]['id']).'] tomato entries</p>
                      <form method="post" action="refresh.category.delete.php">
                      <input type="hidden" name="categoryid" value="'.$resource[$i]['id'].'"/>
                        <p><input type="submit" value="Delete"/></p>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>');  
        }
        print('</table>');
    }

    // helper function
    function times_category_used($categoryid, $userid=1001){
        $stm =$this->conn->prepare("SELECT  * FROM `tomato220`.`tomato` WHERE `tomato`.`category` = :CATEGORYID AND `tomato`.`userid` = :USERID");
        $stm->bindParam(':CATEGORYID',$categoryid);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        $resource = $stm->fetchall(PDO::FETCH_ASSOC);
        $rows = sizeof($resource);
        return $rows;      
    }
/*
UPDATE `tomato220`.`tomato` SET `tomato`.`category`= 22 WHERE `tomato`.`category`= 23 AND `tomato`.`userid`= 1001 
*/
    function replace_with_null($categoryid, $null=22, $userid=1001 ){
        /*
        $stm =$this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`category`= :NULLVALUE WHERE `tomato`.`category`= :CATEGORYID AND `tomato`.`userid`= :USERID");
        */
        $stm =$this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`category`= :NULLVALUE WHERE `tomato`.`category`= :CATEGORYID AND `tomato`.`userid`= :USERID");

        $stm->bindParam(':CATEGORYID',$categoryid);
        $stm->bindParam(':USERID',$userid);
        $stm->bindParam(':NULLVALUE',$null);
        $stm->execute();        
    }
    function delete_actual_category($categoryid, $userid=1001){
        $stm =$this->conn->prepare("DELETE FROM `tomato220`.`category` WHERE `category`.`id` = :CATEGORYID AND `category`.`userid`=:USERID");
        $stm->bindParam(':CATEGORYID',$categoryid);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        $count = $stm->rowCount();  
        if($count > 0){
            $message='ID: '.$categoryid.' Deleted';
        }else{
            $message="Problem";
        }
        return $message;      
    }

    function delete_actual_goals($categoryid, $userid=1001){
        $stm =$this->conn->prepare("DELETE FROM `tomato220`.`goals` WHERE `goals`.`categoryid` = :CATEGORYID AND `goals`.`userid`=:USERID");
        $stm->bindParam(':CATEGORYID',$categoryid);
        $stm->bindParam(':USERID',$userid);
        $stm->execute();
        $count = $stm->rowCount();  
        if($count > 0){
            $message2='GOAL: '.$categoryid.' Deleted';
        }else{
            $message2="Problem";
        }
        return $message2;      
    }
}
?>