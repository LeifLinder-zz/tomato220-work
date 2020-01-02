<?PHP
class categorytree extends conn{

    function show_categories_with_associated_keywords(){
        print('<table class="table">');
        print('<div class="alert alert-warning" role="alert">Category Tree</div>');
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                    print('<tr><td><p><a class="btn btn-primary" data-toggle="collapse" href="#'.$value[$i]['id'].'" role="button" aria-expanded="false" aria-controls="collapseExample">');
                    print($value[$i]['category']);
                    print('</a></p>');
                    print('<div class="collapse" id="'.$value[$i]['id'].'">
                    <div class="card card-body">');
                    $this->get_keywords($value[$i]['id']);
                    print('</div></div>');
                    print('</td></tr>');
                }
            }
            print('</table>');
    }

    function get_keywords($categoryid){
        print('<ul>');
            $sth = $this->conn->prepare("SELECT keywords.keyword, keywords.id
            FROM tomato220.keywords 
            JOIN tomato220.link_cat_to_keywords
            ON link_cat_to_keywords.keyword_id = keywords.id
            WHERE link_cat_to_keywords.cat_id = :CATEGORYID ORDER BY keywords.keyword ASC");
            $sth->bindParam(':CATEGORYID',$categoryid);
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                    print('<li>'.$value[$i]['keyword'].'</li>');

                }
            }
            print('</ul>');
    }

}

?>