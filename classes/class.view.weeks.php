<?PHP
    class viewweeks extends conn{

        function pull_tomatos_by_week_value($tomweek){
            $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :TOMWEEK");
            $sth->bindParam(':TOMWEEK', $tomweek);
            $sth->execute();
            $resource= $sth->fetchall(PDO::FETCH_ASSOC);
            $size = sizeof($resource);
            $array_of_titles = array();
            for($i=0; $i < $size; $i++){
                $array_of_titles[] = $resource[$i]['title'];
            }
            return $array_of_titles;
        }

        function distinct_tomweek_values($limit_number=5){
            $sth = $this->conn->prepare("SELECT DISTINCT(`tomato`.`tomweek`) FROM `tomato220`.`tomato` ORDER BY (`tomweek`) DESC LIMIT 5");
            $sth->bindParam(':LIMITNUMBER', $limit_number);
            $sth->execute();
            $resource = $sth->fetchall(PDO::FETCH_ASSOC);
            return $resource;
        }

        function view_weeks_html(){
            $red = "red";
            $week_numbers = $this->distinct_tomweek_values();
            $size = sizeof($week_numbers);
            for($i=0; $i < $size; $i++){

                /*
                print('<p><a data-toggle="collapse" href="#'.$this->weeks_database_resource[$i]['tomweek'].'" aria-expanded="false" aria-controls="collapseExample">'.$this->weeks_database_resource[$i]['tomweek'].'</a></p>');
                */
                $tomweek = $week_numbers[$i]['tomweek'];
                $array_of_titles = $this->pull_tomatos_by_week_value($tomweek);
                $size_titles = sizeof($array_of_titles);

                print('<p><button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#'.$tomweek.'" aria-expanded="false" aria-controls="collapseExample">
                '.$tomweek.'
              </button></p>');

                // create instance variable with dbase resource
               // $this->pull_tomatos_by_week_value($this->weeks_database_resource[$i]['tomweek']);
                print('<div class="collapse" id="'.$tomweek.'">
                <div class="card card-body"><pre>');
               // print_r($array_of_titles);
                
                for($y=0; $y < $size_titles; $y++){
                    print('<p>'. $array_of_titles[$y].'</p>');
                }
                
               // $this->pull_tomatos_by_week_value($tomweek)
               // print($red);
                print('</pre></div></div>');
            }

        }
    }
?>