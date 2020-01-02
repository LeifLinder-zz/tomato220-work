<?PHP
class link_to_category extends conn
{
    private $categoryids;
    public $cat_ids_to_key_ids; // PDO::FETCH_FUNC array 
    public $keyword_associated_id_cat; // PDO::FETCH_FUNC array 
    public $array_of_categories_with_catid_as_index = array();
    public $array_of_categories_indexes_with_catid_as_value = array();
    
    
    // helper function to get all keywords associated with a single category
    function links_by_cat_id($category_id)
    {
        // nested function
        // Resource array but only use cat_id and key_id 
        // Funcion uses the special PDO FETCH_FUNC to 
        // specifically return columns from nested array
        function link_resource_by_cat_id($cat_id, $key_id)
        {
            return "{$cat_id}: {$key_id}";
        }
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`link_cat_to_keywords` WHERE `link_cat_to_keywords`.`cat_id`=:id");
        $sth->bindParam(':id', $category_id, PDO::PARAM_INT);
        $sth->execute();
        //$value = $sth->fetch(PDO::FETCH_ASSOC);
        //$value = $sth->fetchall();
        //$value = $sth->fetchAll(PDO::FETCH_COLUMN, 1);
        $value = $sth->fetchAll(PDO::FETCH_FUNC, "link_resource_by_cat_id");
        // send result upstairs to member property
        $this->cat_ids_to_key_ids = $value;
    }
    
    
    
    // helper function get all category ids
    function get_all_category_ids()
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category`");
        $sth->execute();
        $value = $sth->fetchAll();
        $rough_resource = $value;
        // now create a new array
        // with category name, category id, empty element (for an array of keyuword)
        for ($i = 0; $i < sizeof($rough_resource); $i++) {
            // yes. nested for loop. I hate this construct
            // completely confusting, Take rough resouce and build
            // nice tight organized nested array
            print('<h3>' . $rough_resource[$i]['category'] . ' ' . $rough_resource[$i]['id'] . '</h3>');
            $resource = $this->get_keywords_by_category_id(1);
            print($resource[$i]['keyword'] . ' ' . $resource[$i]['keyword_id']);
        }
    }
    
    // helper function builds nested array. Array with three
    // elements category name, categoy id, number of keywords associated and the fourth element is a nested array. The nested array has two elements keyword name, keyword id.
    function get_keywords_by_category_id($category_id)
    {
        // PDO function to convert raw resource into array
        // of cat ids and keywords
        function cat_id_with_linked_keywords($cat_id, $keyword)
        {
            return "{$cat_id}: {$keyword}";
        }
        $sth = $this->conn->prepare("SELECT `link_cat_to_keywords`.`cat_id`, `keywords`.`keyword` 
            FROM `tomato220`.`keywords`
            JOIN `tomato220`.`link_cat_to_keywords`
            ON `keywords`.`id` = `link_cat_to_keywords`.`keyword_id`        
            WHERE `link_cat_to_keywords`.`cat_id` = :id ORDER BY `keywords`.`keyword`");
        $sth->bindParam(':id', $category_id, PDO::PARAM_INT);
        $sth->execute();
        // $value= $sth->fetch(PDO::FETCH_ASSOC);
        // $value = $sth->fetchall();
        $value                           = $sth->fetchAll(PDO::FETCH_FUNC, "cat_id_with_linked_keywords");
        $this->keyword_associated_id_cat = $value;
        return $value;
    }
    
    // helper function take cat id and returns actual name
    private function name_of_category($cat_id)
    {
        $sth = $this->conn->prepare("SELECT `category` AS 'name' FROM `tomato220`.`category` WHERE `category`.`id`= :id");
        $sth->bindParam(':id', $cat_id, PDO::PARAM_INT);
        $sth->execute();
        // $value= $sth->fetch(PDO::FETCH_ASSOC);
        // $value = $sth->fetchall();
        $value = $sth->fetch(PDO::FETCH_ASSOC);
        return $value['name'];
    }
    
    // helper function take keyword id and returns actual name
    private function return_name_of_keyword_id($keyword_id)
    {
        
    }
    
    
    ///// ***** Again? Is this a repeat????
    function all_cats_associated_with_keyid($keyid)
    {
        $this_is_the_keyword_id = $keyid;
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`link_cat_to_keywords` WHERE `link_cat_to_keywords`.`keyword_id` = :id");
        $sth->bindParam(':id', $keyid, PDO::PARAM_INT);
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        // first build array of categories associated with this keyword  
        $category_titles_linked_to_this_keyword = array();
        
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            $category_titles_linked_to_this_keyword[] = $this->name_of_category($resource[$i]['cat_id']);
        }
        //// **** Problem? Some IDs repeating so the accordion for some items does not work.
        print('<div id="'. $keyid .'" class="collapse"><form action="" name="keyword_associations" method="POST"/>
        <input type="hidden" name="keyid" value="' . $keyid . '"/>');
        $this->array_of_categories_with_catid_as_index();
        // make short variable name
        $cats = $this->array_of_categories_with_catid_as_index;
        
        // just iterate over simple array with categoy titles (as value)
        // and category ids (as index)
        // make $cats array aphabetical
        asort($cats);
        foreach ($cats AS $cat_id => $value) {
            if (in_array($cats[$cat_id], $category_titles_linked_to_this_keyword)) {
                print('<div id="collapseOne">
                    <input type="checkbox" checked name="cats[]" value="' . $cat_id . '"> <label>' . $value . '</label>
                </div>');
            } else {
                print('<div id="collapseOne">
            <input type="checkbox" name="cats[]" value="' . $cat_id . '">
            <label>' . $value . '</label>
            </div>');
            }
        }
        print('<input type="submit" value="Update" class="btn btn-dark" name="submit"/></form><br/></div>');
    }
    
    function array_of_categories()
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`categories`");
        $sth->execute();
        $resource            = $sth->fetchall(PDO::FETCH_ASSOC);
        $array_of_categories = array();
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            $array_of_categories[] = $resource[$i]['category'];
        }
        return $array_of_categories;
    }
    
    function array_of_categories_with_catid_as_index()
    {
        $sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category`");
        $sth->execute();
        $value         = $sth->fetchall(PDO::FETCH_ASSOC);
        $scratch_array = array();
        for ($i = 0; $i < (sizeof($value)); $i++) {
            $scratch_array[$value[$i]['id']] = $value[$i]['category'];
        }
        $this->array_of_categories_with_catid_as_index = $scratch_array;
    }
    
    
    function print_all_keywords()
    {
        $sth = $this->conn->prepare("SELECT `keywords`.`keyword`, `keywords`.`id` FROM `tomato220`.`keywords` ORDER BY `keywords`.`keyword` ASC");
        $sth->execute();
        $resource = $sth->fetchall(PDO::FETCH_ASSOC);
        //  $resource = $sth->fetchall();
        // $resource = $sth->fetch(PDO::FETCH_ASSOC);
        
        print('<ul class="list-group">');
        for ($i = 0; $i < (sizeof($resource)); $i++) {
            /*
            print('<href data-toggle="collapse" data-target="#'.$resource[$i]['id'].'"><li class="list-group-item">'.$resource[$i]['keyword'].'</li></href>');
            $this->all_cats_associated_with_keyid($resource[$i]['id']);
            */
            
            print('<p>
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#'.$resource[$i]['keyword'].'" aria-expanded="false" aria-controls="'. $resource[$i]['keyword'].'">
            '.$resource[$i]['keyword'].'
            </button>
            </p>
            <div class="collapse" id="'.$resource[$i]['keyword'].'">
            <div class="card card-body"><ul>'.$this->all_cats_associated_with_keyid($resource[$i]['id']).'
            </ul></div>
            </div>'); 
        }
        print('</ul>');
    }
    
    function change_array_of_category_titles_to_indexes($keyword_index, $category_titles = NULL)
    {
        // note: value is keyword ID and index is category IDs. So 
        // the value of all array elements is the same, keyword ID but the index are all differnt, cat ID.
        // if the $category_titles array is empty, do nothing
        if (empty($category_titles)) {
            // do nothing
        } else {
            for ($i = 0; $i < sizeof($category_titles); $i++) {
                // here, I populate an array. The construct makes an array where the categori
                // is the index and the keyword is the value. The final array is stored as a global variable.
                // array_of_categories_indexes_with_catid_as_value
                $this->array_of_categories_indexes_with_catid_as_value[$category_titles[$i]] = $keyword_index;
                
            }
        }
    }
    
    function update_assoc_between_keyword_and_categories($keyword, $array_of_categories = NULL)
    {
        // then, gulp... delete all current keyword-to-categoy associations in dbase for that single keyword.
        $sth = $this->conn->prepare("DELETE FROM `tomato220`.`link_cat_to_keywords` WHERE `link_cat_to_keywords`.`keyword_id` = :keyid");
        $sth->bindParam(':keyid', $keyword, PDO::PARAM_INT);
        $sth->execute();
        
        // now that you have deleted everything like a crazy fuck - check if the array of categories 
        // is empty (no cetegories were selected in form). If it is empty then exit this function. you're done.
        if (empty($array_of_categories)) {
            return;
        }
        
        // helper function create global array of category indexs to a single keyword index
        // (creates associations and then populates globay array)
        $this->change_array_of_category_titles_to_indexes($keyword, $array_of_categories);
        
        // then, remake association by interating through $array_of_categories_indexes_with_catid_as_value array and creating new rows of associations between keyword and categories.
        // make short title ($cats_to_key) for array_of_categories_indexes_with_catid_as_value global array
        // alternatively, if $array_of_categories is empty (no category checkboxes were selected in form), 
        // then do not continue with script
        $cats_to_key = $this->array_of_categories_indexes_with_catid_as_value;
        
        // UPLOAD the values
        $cats_to_key = $this->array_of_categories_indexes_with_catid_as_value;
        $sth         = $this->conn->prepare("INSERT INTO `tomato220`.`link_cat_to_keywords` (`cat_id`, `keyword_id`) VALUES (?,?)");
        
        for ($i = 0; $i < sizeof($array_of_categories); $i++) {
            $sth->bindParam(1, $array_of_categories[$i]);
            $sth->bindParam(2, $keyword);
            $sth->execute();
        }
        $count = $sth->rowCount();
        if ($count == '0') {
            print('<div class="alert alert-danger">Upload Failure</div>');
        } else {
            print('<div class="alert alert-success">Upload Success</div>');
        }
        
    }
}

?>