<?php
class link_category extends conn{
    public function linkcategory(){
        print('<p>Link category</p>');
        print('<p>Show all keywords</p>');
    }

    public function show_all_keywords(){
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`keywords`");
        $sth->bindParam(':keyid', $keyword, PDO::PARAM_INT);
        $sth->execute(); 
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);       
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            print('<p>'.($resource[$i]['keyword']).'</p>');
            print('</div>'.($resource[$i]['keyword']).'</div>');
        }
    }
}