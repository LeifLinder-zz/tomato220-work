   <nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
  <a class="navbar-brand" href="#"><h4>Tomato220</h4></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">Home <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=tomato&function=tomatalanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Tomato
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <?php
            $tomato_section_menu = new tomatoaux;
            print($tomato_section_menu->tomato_section_menu_anchors());
         ?>
        </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=keywords&function=keywordlanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Keywords
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <?php
            $keyword_section_menu = new  keywordaux;
            print($keyword_section_menu->keyword_section_menu_anchors());
         ?>
         </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=category&function=categorylanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Categories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <?php
            $category_section_menu = new categoryaux;
            print($category_section_menu->category_section_menu_achors());
         ?>
         </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=views&function=viewslanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Views
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <?php
            $view_section_menu = new viewaux;
            print($view_section_menu->view_section_menu_achors());
         ?>
         </div>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="home.php?page=setup&function=setuplanding" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Set Up
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
         <?php
            $setup_section_menu = new setupaux;
            print($setup_section_menu->setup_section_menu_achors());
         ?>
         </div>

      </li>
    </ul>
  </div>
</nav>
<br/>
