<?PHP

class viewaux extends conn{
    
        public function view_section_menu(){
            $viewmenu ='<ul>
            <li><a href="home.php?page=views&function=viewtoday">Today</a></li>
            <li><a href="home.php?page=views&function=viewyesterday">Yesterday</a></li>
            <li><a href="home.php?page=views&function=viewthisweek">This Week</a></li>
            <li><a href="home.php?page=views&function=viewlastweek">Last Week</a></li>
            <li><a href="home.php?page=views&function=viewcomparisons">Comparisons</a></li>
            <li><a href="home.php?page=views&function=viewcustomviews">Custom Views</a></li>
            </ul>';
            return $viewmenu;
    }
    
    public function view_section_menu_achors(){
        $viewmenu ='
        <a class="dropdown-item" href="home.php?page=views&function=viewtoday">Today</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewyesterday">Yesterday</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewweeks">Weeks</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewcomparisons">Comparisons</a>
        <a class="dropdown-item" href="home.php?page=views&function=viewcustomviews">Custom Views</a>
        ';
        return $viewmenu;
}
}
?>