<?PHP

class setupaux extends conn{
    
        public function setup_section_menu(){
            $setupwmenu ='<ul>
                        <li><a href="home.php?page=setup&function=setupweeklygoals">Weekly Goals</a></li>
                        <li><a href="home.php?page=setup&function=setupcustomviews">Custom Views</a></li>
                        <li><a href="home.php?page=setup&function=setupcustomcomparisons">Custom Comparisons</a></li>
                        <li><a href="home.php?page=setup&function=setupdownloads">data downloads</a></li>
            </ul>';
            return $setupwmenu;
    }
    
    public function setup_section_menu_achors(){
        $setupmenu ='
        <a class="dropdown-item" href="home.php?page=setup&function=setupweeklygoals">Weekly Goals</a>
        <a class="dropdown-item" href="home.php?page=setup&function=setupmonthgoals">Month Goals</a>
        <a class="dropdown-item" href="home.php?page=setup&function=setupcategorypriority">Category Priority</a>
        ';
        return $setupmenu;
}
}
?>