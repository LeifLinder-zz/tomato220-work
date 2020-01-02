<?php
class createKeyword extends conn
{
    
    function upload_new_keyword($new_keyword)
    {
        // first check if keyword exists already
        $stm = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :new_keyword");
        $stm->bindParam(':new_keyword', $new_keyword);
        $stm->execute();
        if ($stm->rowCount() > 0) {
            print('<p>Keyword "' . $new_keyword . '" already exists in dBase.</p>');
        } else {
            // since keyword does not exist, create it...
            $stm = $this->conn->prepare("INSERT INTO `tomato220`.`keywords` (`keywords`.`id`, `keywords`.`keyword`, `keywords`.`timestamp`) VALUES (NULL, :new_keyword, CURRENT_TIMESTAMP);");
            $stm->bindParam(':new_keyword', $new_keyword);
            if ($stm->execute() == TRUE) {
                print("<p><span class='greeny'>" . $new_keyword . "</span> keyword added.</p>");
            } else {
                print("<p><span class='greeny'>" . $new_keyword . "</span> keyword does NOT exist. Did NOT upload.</p>");
            }
            
        }
        
        $this->conn = NULL;
    }
    
    function form_create_keyword()
    {
        
        print('<form method="post" action="">');
        print('<div class="form-group">');
        print('<label for="new_keyword">New Keyword</label>');
        print('<input type="text" name="new_keyword" class="form-control" id="new_keyword" aria-describedby="keyHelp" placeholder="Enter Keyword">');
        print('<small id="emailHelp" class="form-text text-muted">No Spaces. Capitalize.</small>');
        print('</div>');
        print('<button type="submit" class="btn btn-primary">Submit</button>');
        print('</form><br/>');
    }
    
}
?>