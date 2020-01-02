<?PHP
class show_categories extends conn{

    function show_categories_no_extras(){
        print('<table class="table">');
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
            $sth->execute();
            $value = $sth->fetchall(PDO::FETCH_ASSOC);
            $result_count = 0;
            $result_count = sizeof($value);
        if($result_count < 1){
            print('<p>Less than 1</p>');
            }else{
                for($i=0; $i<($result_count); $i++){
                    print('<tr><td>'.$value[$i]['category'].'</td></tr>');

                }
            }
            print('</table>');
    }
}

?>