<?PHP
class keywordtree extends conn{

    function show_categories_with_associated_keywords(){
      //  print('<table class="table">');
        print('<div class="alert alert-warning" role="alert">Keyword Tree</div>');
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                   // print('<tr><td>;
                    print('<p class="marginleft"><a class="btn btn-primary" data-toggle="collapse" href="#'.$value[$i]['id'].'" role="button" aria-expanded="false" aria-controls="collapseExample">');
                    print($value[$i]['keyword']);
                    print('</a></p>');
                    print('<div class="collapse" id="'.$value[$i]['id'].'">
                    <div class="card card-body">');
                    $this->get_categories($value[$i]['id']);
                    print('</div></div>');
                  //  print('</td></tr>');
                }
            }
          //  print('</table>');
    }

    function get_categories($keywordid){
        print('<ul>');
            $sth = $this->conn->prepare("SELECT category.category, category.id
            FROM tomato220.category 
            JOIN tomato220.link_cat_to_keywords
            ON link_cat_to_keywords.cat_id = category.id
            WHERE link_cat_to_keywords.keyword_id = :KEYWORDID 
            ORDER BY category.category ASC");
            $sth->bindParam(':KEYWORDID',$keywordid);
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                    print('<li>'.$value[$i]['category'].'</li>');

                }
            }
            print('</ul>');
    }

}

?>