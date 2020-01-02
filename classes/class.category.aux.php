<?PHP

class categoryaux extends conn{
    
        public function category_section_menu(){
            $viewmenu ='<ul>
            <li><a href="home.php?page=categories&function=categorycreate">Category Create</a></li>
              <li><a href="home.php?page=categories&function=categorydedit">Category Edit</a></li>
              <li><a href="home.php?page=categories&function=categorydelete">Category Delete</a></li>
              <li><a href="home.php?page=categories&function=categorytree">Category Tree</a></li>
         </ul>';
            return $viewmenu;
    }
    
    public function category_section_menu_achors(){
        $categorymenu ='
        <a class="dropdown-item" href="home.php?page=categories&function=categorycreate">Category Create</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorydedit">Category Edit</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorydelete">Category Delete</a>
        <a class="dropdown-item" href="home.php?page=categories&function=categorytree">Category Tree</a>
        ';
        return $categorymenu;
}
}
?>