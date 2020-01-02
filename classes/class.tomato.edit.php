<?PHP
class edittomato extends conn{
private $defaultWeekNumber;
function default_week_setting()
    {
    $currentWeekNumber = date('Y') . "-W" . date('W');
    $this->defaultWeekNumber = $currentWeekNumber;
    }

function edit_tomato_count($tomcount, $tomid)
    {
    $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`count` = :TOMCOUNT WHERE `tomato`.`id` = :TOMID;");
    $sth->bindParam(':TOMCOUNT', $tomcount);
    $sth->bindParam(':TOMID', $tomid);
    $sth->execute();
    $number_effected_rows = $sth->rowCount();
    return $number_effected_rows;
    }

function pull_tomatos_by_week_value($tomweek)
    {
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :TOMWEEK ORDER BY(`tomato`.`timestamp`) DESC");
    $sth->bindParam(':TOMWEEK', $tomweek);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    return $resource;
    }

function pull_tomatos_by_default_this_week()
    {
    $this->default_week_setting();
    $sth = $this->conn->prepare("SELECT distinct(`tomato`.`tomdate`) FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :TOMWEEK ORDER BY(`tomato`.`timestamp`) DESC");
    $sth->bindParam(':TOMWEEK', $this->defaultWeekNumber);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $size = sizeof($resource);
    for ($i = 0; $i < $size; $i++)
        {
        print ('<p class="no-padding">' . date('l \t\h\e jS', strtotime($resource[$i]['tomdate'])) . '</p>');
        $this->toms_by_tomdate($resource[$i]['tomdate']);
        }
    }

function toms_by_tomdate($tomdate)
    {
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomdate` LIKE :TOMDATE");
    $sth->bindParam(':TOMDATE', $tomdate);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $size = sizeof($resource);
    print ('<ul class="list-group tomatolist">');
    for ($i = 0; $i < $size; $i++)
        {
        print ('<li class="list-group-item d-flex justify-content-between align-items-center border-0"><a href="?page=tomato&function=tomatoedit&tomid=' . $resource[$i]['id'] . '"   data-target="#' . $resource[$i]['id'] . '">' . $this->return_category_name_from_catid($resource[$i]['category']) . '</a><span class="badge badge-primary badge-pill">' . ($resource[$i]['count'] / 2) . ' hrs</span></li>');
        }

    print ('</ul>');
    }

function distinct_tomweek_values($limit_number)
    {
    $sth = $this->conn->prepare("SELECT DISTINCT(`tomato220`.`tomweek`) FROM `tomato220`.`tomato` LIMIT :LIMITNUMBER");
    $sth->bindParam(':LIMITNUMBER', $limit_number);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $rowcount = $sth->rowCount();
    return $resource;
    }

function return_category_name_from_catid($catid)
    {
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` WHERE `category`.`id` = :CATID ORDER BY `id` DESC");
    $sth->bindParam(':CATID', $catid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $categorytitle = $resource[0]['category'];
    return $categorytitle;
    }

function return_name_of_current_category($tomatoid)
    {
    $sth = $this->conn->prepare("SELECT `tomato`.`category` FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID ORDER BY `id` DESC");
    $sth->bindParam(':TOMID', $tomatoid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $categoryid = $resource[0]['category'];
    $categorytitle = $this->return_category_name_from_catid($categoryid);
    return $categorytitle;
    }

function return_single_tomato_based_on_tomid($tomid)
    {
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` = :TOMID");
    $sth->bindParam(':TOMID', $tomid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    $resource_array['id'] = $resource[0]['id'];
    $resource_array['userid'] = $resource[0]['userid'];
    $resource_array['title'] = $resource[0]['title'];
    $resource_array['tomdate'] = $resource[0]['tomdate'];
    $resource_array['tomweek'] = $resource[0]['tomweek'];
    $resource_array['count'] = $resource[0]['count'];
    $resource_array['category_id'] = $resource[0]['category'];
    $resource_array['category_title'] = $this->return_category_name_from_catid($resource[0]['category']);
    $resource_array['notes'] = $resource[0]['notes'];
    $resource_array['url'] = $resource[0]['URL'];
    $resource_array['keywords'] = $this->return_keywords_based_on_tomid($resource[0]['id']);
    return $resource_array;
    }

function return_keywords_based_on_tomid($tomid)
    {
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`tom_id` = :TOMID ORDER BY `link_tom_to_keywords`.`timestamp` DESC");
    $sth->bindParam(':TOMID', $tomid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    return $resource;
    }

function categories($category_id, $category_title, $tomato_id)
    {
    print ('<div class="form-group">');
    print ('<label for="categories">Categories</label>');
    print ('<select class="form-control" name="categories" id="categories" onchange="showKeywordsEdit(this.value)">');
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
    $sth->execute();
    $table = $sth->fetchAll();
    print ("<option value='22'>NULL</option>");
    foreach($table as $value)
        {
        print ("<option value='" . $value['id'] . "'>" . $value['category'] . "</option>");
        }
    print ('</select></div>');
    }


function new_categories()
    {
    print ('<div class="form-group">');
    print ('<label for="new_category">Categories</label>');
    print ('<select class="form-control" name="new_category" id="new_category" onchange="showKeywordsEdit(this.value)">');
    $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
    $sth->execute();
    $table = $sth->fetchAll();
    print ("<option value='22'>NULL</option>");
    foreach($table as $value)
        {
        print ("<option value='" . $value['id'] . "'>" . $value['category'] . "</option>");
        }
    print ('</select></div>');
    }

function return_keywords_linked_to_category($categoryid)
    {
    $sth = $this->conn->prepare("SELECT `link_cat_to_keywords`.`keyword_id` FROM `tomato220`.`link_cat_to_keywords` WHERE `link_cat_to_keywords`.`cat_id` = :CATID LIMIT 50");
    $sth->bindParam(':CATID', $categoryid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    if (sizeof($resource) > 0)
        {
        for ($i = 0; $i < sizeof($resource); $i++)
            {
            print ('<tr><td>' . $this->return_keyword_name_by_keword_id($resource[$i]['keyword_id']) . '</td><td><input type="checkbox" name="edit_keywords[]" value="' . $resource[$i]['keyword_id'] . '"/></td></tr>');
            }
        }
    }

function return_keyword_name_by_keword_id($keyword_id)
    {
    $sth = $this->conn->prepare("SELECT `keywords`.`keyword` FROM `tomato220`.`keywords` WHERE `keywords`.`id` = :KEYWORDID LIMIT 1");
    $sth->bindParam(':KEYWORDID', $keyword_id);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    return $resource[0]['keyword'];
    }

function check_tomid_against_keyword_link($tomid, $keyid)
    {
    $sth = $this->conn->prepare("SELECT * FROM `link_tom_to_keywords` WHERE `tom_id` = :TOMID LIMIT 1");
    $sth->bindParam(':TOMID', $tomid);
    $sth->execute();
    $resource = $sth->fetchall(PDO::FETCH_ASSOC);
    if (sizeof($resource) > 0)
        {
        for ($i = 0; $i < sizeof($resource); $i++)
            {
            if ($resource[$i]['keyid'] == $keyid)
                {
                print ('same');
                }
              else
                {
                print ('different');
                }
            }
        }
    }

function edit_single_tomato_form($tomid, $userid, $title, $tomdate, $tomweek, $count, $category_title, $category_id, $notes, $url, $keywords)
    {
    print ('<form method="post" id="edit_single_tomato" action="bounce.tomato.edit.php">
        <input type=hidden name="tomid" id="tomid" value="'.$tomid.'"/>');
    print ('<input type=hidden name="form_title" value="edit_single_tomato"/>');
    print ('<input type=hidden name="userid" id="userid" value="'.$userid.'"/>');
    print ('<input type=hidden name="old_category_id" value="'.$category_id.'"/>');
    print ('<p>USERID: '. $userid .'</p>');
    // Title
    print ('<div class="form-group">
            <label for="tile">Title</label>
            <input type="text" name="title" class="form-control" id="title" value="' . $title . '"/>
        </div>');
    // Current Tomdate
    print ('<div class="form-group">
            <label for="tomdate">Current Tomdate</label>
            <input type="text" name="tomdate" class="form-control" id="tomdate" value="' . $tomdate . '"/>
        </div>');
    // Update Date
    /*
    echo '<div class="form-group">
            <label for="tomatoDate_FormElement"><span style="color:Blue;">Update Date<span></label>
            <input type="date" name="new_date" class="form-control" id="tomatoDate_FormElement" aria-describedby="dateHelp" placeholder="Date">
            <small id="dateHelp" class="form-text text-muted">Enter date of tomato.</small>
        </div>';
        */
    // Tomweek
    print ('<div class="form-group">
            <label for="tomweek">Tomweek</label>
            <input type="text" name="tomweek" class="form-control" id="tomweek" value="' . $tomweek . '"/>
            </div>');
    // Count
    print ('<div class="form-group">
        <label for="count">Count</label>
        <input type="text" name="count" class="form-control" id="count" value="' . $count . '"/>
        </div>');
    // Notes
    print ('<div class="form-group">
        <label for="notes">Notes</label>
        <textarea name="notes" class="form-control" id="notes">' . $notes . '
        </textarea>
        </div>');
    // URL
    print ('<div class="form-group">
        <label for="url">URL</label>
        <input type="text" name="url" class="form-control" id="url" value="' . $url . '"/>
        </div>');

    print ('<div class="circuit">');
    print ('<table>');
    print ('<tr><td style="width:150px;">Category :</td><td>' . $this->return_name_of_current_category($tomid) . '</td></tr>');
    print ('</table>');
    print('</div>');

    print ('<div class="circuit">');
    print ('<table>');
    print ('<tr><td style="width:150px;">Keywords :</td><td></td></tr>');
    // list of keywords assciated with category
    //$this->return_keywords_linked_to_category($category_id);
   //$keywords = $this->return_keywords_based_on_tomid($tomid);
   for($i=0;$i<sizeof($keywords);$i++){
    print('<tr><td></td><td>'.$this->return_keyword_name_by_keword_id($keywords[$i]['keyword_id']).'</td></tr>');
   }
    print ('</table>');
    print ('</div>');

    // Select List of Categories

    print('<p><span style="color:Blue;">Or, Change Category</span></p>');
    $this->new_categories();
    echo '<div class="form-group">';
?>
        <div id="ajaxKeywordsEdit"></div>
        <?php
    echo '</div>';
    print ('<button type="submit" class="btn btn-primary">Submit</button>');
    print ('</form><br/<br/>');
    }

function upload_edit_query($tomid, $title, $tomdate, $tomcount, $categoryid, $notes)
    {
    $sth = $this->conn->prepare("UPDATE 
        `tomato220`.`tomato` SET 
        `tomato`.`title` = :TITLE, 
        `tomato`.`tomdate` = :TOMDATE, 
        `tomato`.`tomweek` = '2018-W52', 
        `tomato`.`count` = :TOMCOUNT, 
        `category` = :CATEGORYID, 
        `tomato`.`notes` = :NOTES, 
        `tomato`.`url` = 'http://asasdf' 
        WHERE `tomato`.`id` = :TOMID
        AND `tomato`.`userid`=1001");
    /*
    $sth->bindParam(':USERID', $userid);
    $sth->bindParam(':TOMID', $tomid);
    */
    $sth->bindParam(':TOMID', $tomid);
    $sth->bindParam(':TITLE', $title);
    $sth->bindParam(':TOMDATE', $tomdate);
    $sth->bindParam(':TOMCOUNT', $tomcount);
    $sth->bindParam(':CATEGORYID', $categoryid);
    $sth->bindParam(':NOTES', $notes);
    /*
    $sth->bindParam(':TOMCOUNT', $tomcount);
    $sth->bindParam(':TOMURL', $url);
    */
    $resource = $sth->execute();
    return $resource;
    }

    /// update queries ///

    function update_title($tomid, $userid, $title){
        // update title
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`title` = :NEWTITLE WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':NEWTITLE', $title);
        $sth->execute();
    }

    function update_tomdate($tomid, $userid, $tomdate){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`tomdate` = :TOMDATE WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':TOMDATE', $tomdate);
        $sth->execute();
        // update tomdate
    }
    
    function update_tomweek($tomid, $userid, $tomweek){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`tomweek` = :TOMWEEK WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':TOMWEEK', $tomweek);
        $sth->execute();
        // update tomweek
    }

    function update_count($tomid, $userid, $tomcount){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`count` = :TOMCOUNT WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':TOMCOUNT', $tomcount);
        $sth->execute();
        // update count
    }

    function update_notes($tomid, $userid, $notes){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`notes` = :NOTES WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':NOTES', $notes);
        $sth->execute();
        // update notes
    }

    function update_url($tomid, $userid, $url){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`url` = :TOMURL WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':TOMURL', $url);
        $sth->execute();
        // update url   
    }

    function update_new_category($tomid, $userid, $new_category){
        $sth = $this->conn->prepare("UPDATE `tomato220`.`tomato` SET `tomato`.`category` = :CATEGORY WHERE `tomato`.`id` = :TOMID AND `tomato`.`userid`=:USERID");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->bindParam(':CATEGORY', $new_category);
        $sth->execute();
        // update category
    }

    function update_keywords($tomid, $userid, $keywords){
        // first delete all keywords associated with tomid, yeesh...
        $sth = $this->conn->prepare("DELETE FROM `tomato220`.`link_tom_to_keywords` WHERE `link_tom_to_keywords`.`tom_id` = :TOMID AND `link_tom_to_keywords`.`userid`=:USERID LIMIT 4");
        $sth->bindParam(':TOMID', $tomid);
        $sth->bindParam(':USERID', $userid);
        $sth->execute();

        // now upload new keywords
        /*
        INSERT INTO `link_tom_to_keywords` (`id`, `userid`, `tom_id`, `keyword_id`, `timestamp`) VALUES (NULL, '1001', '961', '33', CURRENT_TIMESTAMP);
        */
        $sth = $this->conn->prepare("INSERT INTO `tomato220`.`link_tom_to_keywords` (`link_tom_to_keywords`.`id`, `link_tom_to_keywords`.`userid`, `link_tom_to_keywords`.`tom_id`, `link_tom_to_keywords`.`keyword_id`,`link_tom_to_keywords`.`timestamp`) VALUES (NULL, :USERID, :TOMID, :KEYWORDID, CURRENT_TIMESTAMP)");
        $size = sizeof($keywords);
        for($i=0;$i<$size;$i++){
          //  print('<p>'.$keywords[$i].'</p>');
          $sth->bindParam(':TOMID', $tomid);
          $sth->bindParam(':USERID', $userid);
          $sth->bindParam(':KEYWORDID', $keywords[$i]);
          $sth->execute();
        }
        // update keywords
    }
}
?>