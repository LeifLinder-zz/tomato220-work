<?PHP
class showtomatoes extends conn{

  function todaydate(){
    return date("Y-m-d");
}  

    function get_keywords_for_tom_id($tom_id){
        $sth = $this->conn->prepare("SELECT tomato220.keywords.keyword 
        AS 'keyword'
        FROM  tomato220.link_tom_to_keywords
        JOIN tomato220.keywords
        ON tomato220.link_tom_to_keywords.keyword_id = tomato220.keywords.id
        WHERE tomato220.link_tom_to_keywords.tom_id= ".$tom_id."");
        $sth->execute();
        $result = $sth->fetchAll();
        return $result;
      }

    function show_tomatoes($dbase_resource){
        print('<br/>');
        print('<table class="table">');
        print('<tr><th>Title</th><th>Count</th><th>Cat</th></tr>');

        for($i=0; $i < sizeof($dbase_resource); $i++ ){
            // first lets get the tomato id
            $tomato_id = $dbase_resource[$i]['tom_id'];
            // now get the function that returns all 
            // keywords associated with the tom id

            //$keywords_by_tom_id = $this->get_keywords_for_tom_id($tomato_id);
            /*
            print('<tr>
                        <td valign="top"><a href data-toggle="modal" data-target="#'.$dbase_resource[$i]['tom_id'].'">'.$dbase_resource[$i]['title'].'</a></td> 
                        <td valign="top" align="center" class="hrstd"><span class="i-circle">'.(.5)*($dbase_resource[$i]['count']).'</span></td> 
                        <td valign="top" class="categorytd">
                        '.$dbase_resource[$i]['category'].'
                        </td>
                </tr>');
                */
            
            print('<tr>
                        <td valign="top"><a href data-toggle="modal" data-target="#'.$dbase_resource[$i]['tom_id'].'">'.$dbase_resource[$i]['title'].'</a></td> 
                        <td valign="top" align="center"><button type="button" class="btn btn-primary">'.(.5)*($dbase_resource[$i]['count']).'</button></td> 
                        <td valign="top" class="categorytd">
                        '.$dbase_resource[$i]['category'].'
                        </td>
                </tr>');
/*
            print('
                <div id="'.$dbase_resource[$i]['tom_id'].'" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">'.$dbase_resource[$i]['tom_id'].'</h4>
                      </div>
                      <div class="modal-body">
                      <form method="post" action="refresh.tomcount.php">
                      <input type="hidden" name="change_tomato_on_the_fly" value="hexon8"/>
                      <input type="hidden" name="tomid" value="'.$tomato_id.'"/>
                       <p>Category: '.$dbase_resource[$i]['category'].'</p>
                        <p>Notes: '.$dbase_resource[$i]['notes'].'</p>
                        <p>Tomato ID: '.$tomato_id.'</p>
                        <p>Tomato Count '.$dbase_resource[$i]['count'].'</p>
                        <p>Update Count? <input type="text" name="tomcount"></input></p>
                        <p>Keywords: '.$this->show_keywords_by_link_id($keywords_by_tom_id).'</p>
                        <p><input type="submit" value="Update"/></p>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>');

                print('
                <div id="Edit'.$tomato_id.'" class="modal fade" role="dialog" tabindex="-1" aria-labelledby="Edit'.$tomato_id.'Label">
                  <div class="modal-dialog">
                
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="Edit'.$tomato_id.'Label">Edit '.$tomato_id.'</h5>
                      </div>
                      <div class="modal-body">
                        <p>'.$dbase_resource[$i]['notes'].'</p>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                
                  </div>
                </div>');
                */
                print('<div id="'.$dbase_resource[$i]['tom_id'].'" class="modal fade" role="dialog">
                <div class="modal-dialog">
              
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">'.$dbase_resource[$i]['tom_id'].'</h4>
                    </div>
                    <div class="modal-body">');
                $edit_single_tomato = new edittomato;
                $edit_single_tomato->edit_single_tomato_form(
                  $dbase_resource[$i]['tom_id'], 
                  'userid', 
                  'title', 
                  'tomdate', 
                  'tomweek',
                  'count', 
                  'categorytitle', 
                  '4', 
                  'Notes', 
                  'URL'
                );
                
              
                print('<pre>');
                print_r($dbase_resource[$i]);
                print('</pre>');
                
                print('<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>');
            }

            

       print("</table>");   
    }

        function show_keywords_by_link_id($dbase_resource){
            $return_string="";
            for($i=0; $i < sizeof($dbase_resource); $i++ ){
                $return_string = $return_string.($dbase_resource[$i]['keyword']).'<br/>';       
        }
        return $return_string;
    }
    function show_tomato_by_tomid($tom_id=1){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`id` =:id");
        $sth->bindParam(':id', $tom_id, PDO::PARAM_INT);
        $sth->execute();
        $value = $sth->fetch(PDO::FETCH_ASSOC);

        // good place to 
        return $value;
    }

      function query_table_for_tomdate_today(){
        
        $sth = $this->conn->prepare("SELECT tomato220.tomato.title AS 'title', tomato220.category.category, tomato220.tomato.count, tomato220.tomato.notes, tomato220.tomato.id AS 'tom_id', tomato220.tomato.timestamp
        FROM tomato220.category
        JOIN tomato220.tomato
        ON tomato220.category.id = tomato220.tomato.category
        WHERE tomato220.tomato.tomdate
        LIKE '".$this->todaydate()."%'");

        
      $sth->execute();
      $result = $sth->fetchAll();
          //$result = $sth->fetch(PDO::FETCH_ASSOC);
         return $result;
    }
}

?>