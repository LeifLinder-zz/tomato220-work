<?php
class form_elements extends conn
	{
		public $week_value_from_db;
		public $defaultWeekNumber;
		public $selected;
		public $category;
		public $sub_selected;
		public $cat_id;
		public $subcat_select;
		public $counter = 1;

		/*
		* Week Number is set here but changed again on upload script
		* Week number is taken from Tom Date not Timestamp
		* That way you can use Tom Date from yesterday
		*/


function default_week_setting(){
	$currentWeekNumber = date('Y')."-W".date('W');
	$this->defaultWeekNumber=$currentWeekNumber;
}

function week_value_from_week_table(){
	$sth = $this->conn->prepare("SELECT `week`.`week` FROM `tomato220`.`week` WHERE `week`.`id` = 1 LIMIT 1");
	$sth->execute();
	$week = $sth->fetchColumn();
    $this->week_value_from_db = $week;
}
function set_week(){
	echo '<form method="POST" id="set_week_form" action="">
	<input type="week" name="week" id="week">
	<input type="submit"/>
	</form>';
}

function tomdate(){
	$this->default_week_setting();
	print('<input type="text"id="tomdate" name="tomdate" value="'.date("Y-m-d").'"><br/>');
	print('<input type="hidden" name="tomweek" id="tomweek" value="'.$this->defaultWeekNumber.'"/>');
}
function URL(){
	print('<input type="url" id="URL" name="URL" value="">');
}
    function categories(){  
		print('<div class="form-group">');
		print('<label for="categories">Categories</label>');
    	print('<select class="form-control" name="categories" id="categories" onchange="showKeywords(this.value)">');
		$sth = $this->conn->prepare("SELECT * FROM `tomato220`.`category` ORDER BY `category`.`category` ASC");
		$sth->execute();
		$table = $sth->fetchAll();
		// add a selected class if the category has been selected and make black background
        foreach($table as $value){
        	if(isset($_GET['category'])){
        		if($_GET['category']==$value['category']){
        			$this->selected="selected";
        			$this->category=$value['category'];
        			$this->cat_id=$value['id'];

        		}else{
        			$this->selected="not_selected";
        		}
        	}else{
        		$this->selected="not_selected";
        	}
        print("<option value='".$value['id']."'>".$value['category']."</option>");
        }
       print('</select></div>');
   }

   function submit(){
   	print("<input type='submit'>");
   }

   function count(){
   	print("
   		<select name='count' id='count'>
   		<option value=1>1</option>
   		<option value=2>2</option>
   		<option value=3>3</option>
   		<option value=4>4</option>
   		<option value=5>5</option>
   		<option value=6>6</option>
   		<option value=7>7</option>
   		<option value=8>8</option>
   		</select>   		
   		");
   }
   function description(){
   	print("
   		<textarea col='16' row='10' id='description' name='description'>text</textarea>
   		");
   }
   
   function keywords($category_param=1){   
        if($category_param){
        	$this->category=$category_param;
        }else{
			$this->category=1;
		}

		$sth = $this->conn->prepare("SELECT tomato220.keywords.keyword AS keyword, tomato220.keywords.id AS id 
				FROM tomato220.link_cat_to_keywords 
				JOIN tomato220.keywords 
				ON tomato220.link_cat_to_keywords.keyword_id = tomato220.keywords.id
				WHERE tomato220.link_cat_to_keywords.cat_id = ".$this->category." ORDER BY `keywords`.`keyword` ASC");
			$sth->execute();
			$table = $sth->fetchAll();
			foreach($table as $value){
				print('<div class="form-check">
				<input class="form-check-input" name="keywords[]" type="checkbox" value="'.$value['id'].'" id="'.$value['id'].'">
				<label class="form-check-label" for="'.$value['id'].'">
				'.$value['keyword'].'</label>
			  </div>');
			  /*
			print('<div class="keywords"><input id="'.$value['id'].'" type="checkbox" value="'.$value['id'].'"  name="keywords[]"><label for="'.$value['id'].'">'.$value['keyword'].'</label></div>');  
			*/   
			}
    }

	// below functionn seperates model from view
	// by using class.keywords_and_categories
	// instead of puting query in class.form_elements.php
function keywords2($cat){
$keywords_and_categories = new keywords_and_categories;
$keywords_and_categories->links_by_cat_id($cat);
$keywords = $keywords_and_categories->cat_ids_to_key_ids;
return $keywords;
}

}