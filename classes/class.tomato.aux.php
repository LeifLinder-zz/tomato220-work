<?PHP

class tomatoaux extends conn{
        public function tomato_section_menu_anchors(){
                $sectionmenu ='
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoshow">Show</a>
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoadd">Add</a>
                <a class="dropdown-item" href="home.php?page=tomato&function=tomatoedit">Edit</a>
                ';
                return $sectionmenu;
        }
}
?>