<?PHP

class keywordaux extends conn{
    
        public function keyword_section_menu_anchors(){
                $keywordmenu =' 
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordshow">Show</a> 
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordcreate">Add</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordedit">Edit</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keyworddelete">Delete</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordlinktocategory">Link To Category</a>
                <a class="dropdown-item" href="home.php?page=keywords&function=keywordtree">Keyword Tree</a>
                ';
                return $keywordmenu;
        }
}
?>