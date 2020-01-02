<?PHP

class viewtoday {

    private $current_week;
    private $dbase_resource_current_week_category;
    private $target_hours_for_category;
    private $ideal_category_target_hours;

    /** 
     *  'category_hours_this_week($category)' function pulls the accumulated tomatoes
     *  of a specific category over the course of the current week
     * it populates the class member variable, $dbase_resource_current_week_category property
     * with returned database resource.
    **/ 

    public function __toString(){
        $section_menu = $this->sectmenu();
        $return = $section_menu;
        return $return;
    }



    private function todaydate(){
        return date("Y-m-d");
    }  

    private function currentweek(){
            $currentWeekNumber = date('Y')."-W".date('W');
            $this->current_week = $currentWeekNumber;
            return $currentWeekNumber;
        }

    // helper function
    private function show_ideal_target_category_hours($category){
        $sth = $this->conn->prepare("SELECT `weeklygoals`.`targethours` FROM `tomato220`.`weeklygoals` WHERE `weeklygoals`.`categoryid` LIKE :CATEGORYID");
        $sth->bindParam(':CATEGORYID', $category, PDO::PARAM_INT );
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        // set member variable of target category hours per week
        $this->ideal_category_target_hours = $result['targethours'];
        return;
    }
    
    private function category_hours_this_week($category){
        // (1) Populate $this->current_week variable with value of currentweek() function.
        // (2) Populate $this->dbase_resource_current_week_category with dbase resource query on accumulative tomotatoes on a specific category (like Norsk, ID 2).
        $this->current_week = $this->currentweek();
        $sth = $this->conn->prepare("SELECT sum(`tomato`.`count`) AS 'toms' FROM `tomato220`.`tomato` WHERE `tomato`.`tomweek` LIKE :CURRENTWEEK AND `tomato`.`category` = :CATEGORYID");
        $sth->bindParam(':CATEGORYID', $category, PDO::PARAM_INT );
        $sth->bindParam(':CURRENTWEEK', $this->current_week, PDO::PARAM_STR );
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        // set member variable dbase_resource_currentweek_norsk_study
        $this->dbase_resource_current_week_category = $result;
        return;
    }

    protected function target_hours_for_category($categoryid){
        // What is the target amount? 
        /** because target goals change choose we will have multiple entries for 
         * specific categories. Therefore choose the goal that has active = 1 
         */
        $sth = $this->conn->prepare("SELECT `weeklygoals`.`targethours` FROM `tomato220`.`weeklygoals` WHERE `weeklygoals`.`categoryid` = :CATEGORYID AND `weeklygoals`.`active`=1");
        $sth->bindParam(':CATEGORYID', $categoryid);
        $sth->execute();
        $result = $sth->fetch(PDO::FETCH_ASSOC);
        $this->target_hours_for_category = $result['targethours'];
        //return $result['targethours'];
    }

    public function print_out_category_for_this_week($cat_id){
        // (1) Populate $this->dbase_resource_current_week_category member variable with  $this->category_hours_this_week($cat_id) private 'helper' function, with category ID as parameter.
        // (2) 
        $this->category_hours_this_week($cat_id);
        $this->show_ideal_target_category_hours($cat_id);
        $number_of_rows = sizeof($this->dbase_resource_current_week_category);
           $tomatos_of_specific_category = $this->dbase_resource_current_week_category['toms'];
           $hours_from_tomatoes = .5*($tomatos_of_specific_category);
           // use this function to find out
           // target hours
           $this->target_hours_for_category($cat_id);
           $targethours = $this->target_hours_for_category - 1;
            if($hours_from_tomatoes > $targethours){
                $butt_style = "btn-info";
            }else{
                $butt_style = "btn-secondary";
            }
           print('<button type="button" class="btn '.$butt_style.'">'.$hours_from_tomatoes.'</button>');
           print('<span style="color:#ccc;">&nbsp;&nbsp;'.$this->ideal_category_target_hours.'</span>');
    }
    
}
?>