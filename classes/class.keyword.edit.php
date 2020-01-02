<?php
class keywordedit extends conn
{

    function number_keyword_used($keyid){
        $times_used = new keyworddelete;
        $rows = $times_used->times_keyword_used($keyid);
        return $rows;
    }
    
   protected $alphabet = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
    
    function upload_edited_keyword($keyword_id, $edited)
    {
        // first check if keyword exists already
        $stm = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :EDITED");
        $stm->bindParam(':EDITED', $edited);
        $stm->execute();
        if ($stm->rowCount() > 0) {
            print('<p>Opps... Keyword "' . $edited . '" already exists in dBase.</p>');
        } else {
            // since edit keyword does not exist, create it...
            $stm = $this->conn->prepare("UPDATE `tomato220`.`keywords` SET `keywords`.`keyword` = :EDITED WHERE `keywords`.`id` = :KEYWORDID;");
            $stm->bindParam(':KEYWORDID', $keyword_id);
            $stm->bindParam(':EDITED', $edited);
            if ($stm->execute() == TRUE) {
                print('<div class="alert alert-success" role="alert">' . $edited . ' Edited</div>');
            } else {
                print('<div class="alert alert-danger" role="alert">' . $edited . ' Not Edited</div>');
            }
            
        }
        
        $this->conn = NULL;
    }
    
    function show_all_keywords_with_edit_delete_links()
    {
        $sth = $this->conn->prepare("SELECT `keywords`.`keyword`, `keywords`.`id` FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        print('<table class="table">');
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            print('<tr>
            <td><a href="" data-toggle="modal" data-target="#'. $resource[$i]['id'] . '">' . $resource[$i]['keyword'] . '</link></td><td><a href=""  data-toggle="modal" data-target="#' . $resource[$i]['id'] . '">Edit</a></td></tr>');
            
            // code for modal pop-up box
            print('
            <div id="' . $resource[$i]['id'] . '" class="modal fade" role="dialog">
              <div class="modal-dialog">
            
                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">' . $resource[$i]['id'] . '</h4>
                  </div>
                  <div class="modal-body">
                    <form method="post" action="">
                        <div class="form-group">
                            <label for="new_keyword">Edit Keyword</label>
                            <input type="text" name="edit_keyword" class="form-control" id="edit_keyword" aria-describedby="keyHelp" value="' . $resource[$i]['keyword'] . '">
                            <input type="hidden" name="keywordid" value="' . $resource[$i]['id'] . '"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
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
    
  // use this function inside letter accordion
    function show_keywords_by_first_letter_with_edit_delete_links($firstleter="a")
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :FIRSTLETTER ORDER BY `keywords`.`keyword` ASC");
        // its so crazy that you have to add wildcard to the variable, not the bound parameter
        // bound parametes will not take wild card % symbol.
        // see php.net https://www.php.net/manual/en/pdostatement.bindparam.php
        $firstleter = $firstleter."%";
        $sth->bindParam(':FIRSTLETTER', $firstleter, PDO::PARAM_STR);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        print('<table class="table">');
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            print('<tr>
            <td>'.$resource[$i]['keyword'].'</td>
            <td><a href="" data-toggle="modal" data-target="#delete'.$resource[$i]['id'].'" class="delete_label">Delete</a></td>
            <td><a href="" data-toggle="modal" data-target="#edit'.$resource[$i]['id'].'">Edit</a></td>
            </tr>');
            print('<div class="modal fade keyword_edit_modal" id="edit'.$resource[$i]['id'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <form action="/action_page.php">
                    <div class="form-group">
                        <input type="text" class="form-control" value="'.$resource[$i]['keyword'].'" id="keywordedit">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </form>
              </div>
            </div>
          </div>');
          // delete keyword modal
          print('
          <div id="delete' . $resource[$i]['id'] . '" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                <h2>Really?</h2>
                <p><span class="bigandbad">' . $resource[$i]['keyword'] . '</span> is used on '.$this->number_keyword_used($resource[$i]['id']).' tomato entries</p>
                <form method="post" action="refresh.deletekeyword.php">
                <input type="hidden" name="keyid" value="' . $resource[$i]['id'] . '"/>
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



    function form_create_keyword($keyword_to_edit, $keyword_id)
    {
        print('<form method="post" action="">');
        print('<input type="hidden" name="edit_keyword">');
        print('<input type="hidden" name="keyword_id" value="' . $keyword_id . '">');
        print('<input type="submit">' . $keyword_to_edit . '</input>');
        print('</form>');
        print('<br/>');
    }
    
    
    function keywords_edit_with_current_selected($category_param = 1)
    {
        if ($category_param) {
            $this->category = $category_param;
        } else {
            $this->category = 1;
        }
        $sth = $this->conn->prepare("SELECT tomato220.keywords.keyword AS keyword, tomato220.keywords.id AS id 
                FROM tomato220.link_cat_to_keywords 
                JOIN tomato220.keywords 
                ON tomato220.link_cat_to_keywords.keyword_id = tomato220.keywords.id
                WHERE tomato220.link_cat_to_keywords.cat_id = " . $this->category . " ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $table = $sth->fetchAll();
        foreach ($table as $value) {
            print('<div class="form-check">
                <input class="form-check-input" name="keywords[]" type="checkbox" value="' . $value['id'] . '" id="' . $value['id'] . '">
                <label class="form-check-label" for="' . $value['id'] . '">
                ' . $value['keyword'] . '</label>
              </div>');
        }
    }
    
    /*
    function upload_edited_keyword222($keyword_id, $edited)
    {
        // first check if keyword exists already
        $stm = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` WHERE `keywords`.`keyword` LIKE :EDITED");
        $stm->bindParam(':EDITED', $edited);
        $stm->execute();
        if ($stm->rowCount() > 0) {
            print('<p>Opps... Keyword "' . $edited . '" already exists in dBase.</p>');
        } else {
            // since edit keyword does not exist, create it...
            $stm = $this->conn->prepare("UPDATE `tomato220`.`keywords` SET `keywords`.`keyword` = :EDITED WHERE `keywords`.`id` = :KEYWORDID;");
            $stm->bindParam(':KEYWORDID', $keyword_id);
            $stm->bindParam(':EDITED', $edited);
            if ($stm->execute() == TRUE) {
                print('<div class="alert alert-success" role="alert">' . $edited . ' Edited</div>');
            } else {
                print('<div class="alert alert-danger" role="alert">' . $edited . ' Not Edited</div>');
            }
            
        }
        
        $this->conn = NULL;
    }
    */

    // helper function
    private function get_first_char_of_string($string){
        $first_letter = substr($string, 0, 1);
      return $first_letter;
    }

    // helper function
    private function check_array_index_for_value($value, $array){
      $truefalse = array_key_exists($value, $array);
      return $truefalse;
    }


    public function alphabet_accordion_with_keywords(){
        $letter = $this->alphabet;
        for($i=0;$i<sizeof($letter);$i++){
            $letter[$i];
        print('<p><a class="btn btn-primary" data-toggle="collapse" href="#'.$letter[$i].'" role="button" aria-expanded="false" aria-controls="collapseExample">'.$letter[$i].'</a>');
        print('<div class="collapse" id="'.$letter[$i].'">');
        // use this function to print out all keywords that start with the leter
        print($this->show_keywords_by_first_letter_with_edit_delete_links($letter[$i]));
        print('</div>');
        }
    }

    /*
    public function show_all_keywords_group_by_first_letter()
    {
        $sth = $this->conn->prepare("SELECT `keywords`.`keyword`, `keywords`.`id` FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        // take the $resource and build array using first letter
       // $first_letters = array();
       $letters=array();
        for ($i = 0; $i < (sizeof($resource)); $i++) {    
           $letter = $this->get_first_char_of_string($resource[$i]['keyword']);
          print('<p>'.$resource[$i]['keyword'].'</p>');
          print('<p>'.$letter.'</p>'); 
           
           $inarray = $this->check_array_index_for_value($letter,$letters);
          // print('<p>Index Exists '.$inarray.'</p>');
            if ($inarray == 1) {
              // do nothing
            }else{
                //array_push($letters_of_keywords, 1);
                $letters[$letter] = NULL;
            }
           /*      
           print('<p id="'.$resource[$i]['id'].'">'.$resource[$i]['keyword'].'</p>');
           print('<ul data-toggle="collapse" data-target="#demo"><li class="alphabet_accordian">A</li></ul>');
           print('<div id="demo" class="collapse">');
           print('<p>asdfasdf</p><p>asdfasdf</p><p>asdfasdf</p><p>asdfasdf</p>');
           print('</div>');
           
        }
        
        ksort($letters);
        print('<pre>');
        print_r($letters);
        print('<pre>');
        
    }
    */
}
?>