<?PHP
// okay, you know how this works?
// the first switch finds out what page
// then the nested switch finds out what function
class pagemaster
{
    function pagefinder($get_page)
    {
        switch ($get_page) {
            //// ***** TOMATO PAGES ***** ////
            case "tomato":
                if (isset($_GET['function'])) {
                    switch ($_GET['function']) {
                        case "tomatalanding":
                        print('<p>Tomato Landing page</p>');
                        $tomato_section_menu = new tomatoaux;
                        print($tomato_section_menu->tomato_section_menu_anchors());
                        break;
                        case "tomatoadd":
                            print('<h2>Add</h2>');
                            $tomato_form = new addtomato;
                            $tomato_form->upload_form_tomato();
                            break;
                        case "tomatoedit":
                            print('<h2>Edit</h2>');
                            $edit_tomatos = new edittomato;
                            if (isset($_GET['tomid'])) {
                                $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                                $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);
                            }
                            $edit_tomatos->pull_tomatos_by_default_this_week();
                           break;
                          case "tomatoshow";
                          print('<h2>Show</h2>');
                          $edit_tomatos = new edittomato;
                          $edit_tomatos->pull_tomatos_by_default_this_week();
                          break;
                        default: print('<p>No Function</p>');
                        break;
                    }
                }
                
                break;

                //// ***** KEYWORDS PAGES ***** ////
                case "keywords":
                if (isset($_GET['function'])) {
                    switch ($_GET['function']) {
                        case "keywordlanding":
                        $keyword_section_menu = new keywordaux;
                        print($keyword_section_menu->keyword_section_menu_anchors());
                        break;
                        case "keywordshow":
                            print('<h2>Create</h2>');
                            $keywordclass = new createKeyword;
                            $keywordclass->form_create_keyword();
                            if (isset($_POST['new_keyword'])) {
                                print('<p>New Keyword Submitted</p>');
                                $keywordclass = new createKeyword;
                                $keywordclass->upload_new_keyword($_POST['new_keyword']);
                            }
                            print('<h2>Show</h2>');
                            $edit = new keywordedit;
                            $edit->alphabet_accordion_with_keywords();
                            break;
                        case "keywordcreate":
                            print('<p>Add</p>');
                            $keywordclass = new createKeyword;
                            $keywordclass->form_create_keyword();
                            if (isset($_POST['new_keyword'])) {
                                print('<p>New Keyword Submitted</p>');
                                $keywordclass = new createKeyword;
                                $keywordclass->upload_new_keyword($_POST['new_keyword']);
                            }
                            $show = new show_keywords;
                            $show->print_only_keywords_no_accordion();
                            break;
                        case "keywordedit":
                            print('<p>Edit</p>');
                            print('<div class="alert alert-info">Function Edit Keyword</div>');
                            $edit = new keywordedit;
                            if (isset($_POST['edit_keyword'])) {
                                $edit->upload_edited_keyword($_POST['keywordid'], $_POST['edit_keyword']);
                            }
                            $edit->show_all_keywords_with_edit_delete_links();
                            break;
                        case "keyworddelete":
                        print('<h5 class="function-title">Delete Keyword</h5>');
                        if (isset($_GET['deletemessage'])) {
                            print("<p><span class='success'>Keyword Deleted</span></p>");
                        }
                        $delete = new keyworddelete;
                        $delete->show_keywords_with_delete_button();
                        break;
                        case "keywordtree":
                        $keywordtree = new keywordtree;
                        $keywordtree->show_categories_with_associated_keywords();
                        break;
                        case "keywordlinktocategory":
                            print('<div class="alert alert-info">Function Keyword Link To Category</div>');

                            $link_categories = new link_category;
                            $link_categories->show_all_keywords();
                            /*
                            $categories = new link_to_category;
                            if (!isset($_POST['cats'])) {
                                $_POST['cats'] = null;
                            }
                            if (isset($_POST['keyid'])) {
                                $categories->update_assoc_between_keyword_and_categories($_POST['keyid'], $_POST['cats']);
                            }
                        */
                        default: print('<p>No Function</p>');
                        break;
                    }
                }          
                break;

            //// ***** VIEWS PAGES ***** ////
            case "views":
                if (isset($_GET['function'])) {
                    switch ($_GET['function']) {
                        case "viewtoday":
                            print('<p>viewtoday</p>');
                            break;
                        case "viewyesterday":
                            print('<p>viewyesterday</p>');
                            break;
                        case "viewweeks";
                            print('<p>viewweeks</p>');
                            $weeks = new viewweeks;
                            $weeks->view_weeks_html();
                            break;
                        case "viewcomparisons":
                            print('<p>viewcomparisons</p>');
                            break;
                        case "viewcustomviews";
                            print('<p>viewcustomviews</p>');
                            break;
                    }
                } else {
                    print('<p>No Function</p>');
                }
                

                //// ***** INDEX PAGE ***** ////
                break;
            case "index":
                // uses file class.tomato.show.php
                $page_display = new showtomatoes;
                print('<h2>This Week</h2>');
                $edit_tomatos = new edittomato;
                if (isset($_GET['tomid'])) {
                    $tomato = $edit_tomatos->return_single_tomato_based_on_tomid($_GET['tomid']);
                    $edit_tomatos->edit_single_tomato_form($tomato['id'], $tomato['userid'], $tomato['title'], $tomato['tomdate'], $tomato['tomweek'], $tomato['count'], $tomato['category_title'], $tomato['category_id'], $tomato['notes'], $tomato['url'], $tomato['keywords']);                   
                }
                $edit_tomatos->pull_tomatos_by_default_this_week();
        // $debase_resource_today_changed = $page_display->query_table_for_tomdate_today();
        // $page_display->show_tomatoes($debase_resource_today_changed);
        // uses file class.pagefunctions.index.php

                print('<h3>Weekly Goals</h3>');
                $goals = new setupgoals;
                $goals->show_goals();
                break;

            //// ***** CATEGORIES PAGES ***** ////
            case "categories":
                $categoryCreatClass = new createCategory;
                if (isset($_GET['message'])) {
                    print('<p><span style="color:green;">' . $_GET['message'] . '</span></p>');
                }
                if (isset($_GET['function'])) {
                    if ($_GET['function'] == "categorycreate") {
                        print('<h2>Category Create</h2>');
                        $create = new createCategory;
                        $create->form_create_category();
                        $show = new show_categories;
                        $show->show_categories_no_extras();
                        // $categoryCreatClass->form_create_category();
                    } elseif ($_GET['function'] == "categorydedit") {
                        print('<h2>Category Edit</h2>');
                        $edit = new editCategory;
                        $edit->show_categories_with_edit();
                        if (isset($_POST['edit_category_new_value'])) {
                            $edit->upload_edited_category($_POST['edit_category_new_value'], $_POST['edit_category_id']);
                            $edit->show_categories_with_edit();
                        }
                    } elseif ($_GET['function'] == "categorydelete") {
                        $delete = new categorydelete;
                        $delete->show_categories_with_delete_button();
                    } elseif ($_GET['function'] == "categorytree") {
                        $showcategytree = new categorytree;
                        $showcategytree->show_categories_with_associated_keywords();
                    } else {
                        print('<h2>No Function Defined</h2>');
                        $edit = new editCategory;
                        $edit->show_categories_with_edit();
                    }

                } else {
                    include('includes/menu.category.functions.html');
                    $show = new show_categories;
                    $show->show_categories_no_extras();
                }
                // Upload Edited Category POST value exists
                if (isset($_POST['edit_category_new_value'])) {
                    $edit_category = new editCategory;
                    $edit_category->upload_edited_category($_POST['edit_category_new_value'], $_POST['edit_category_id']);
                }
                // show all categories
                $categoryShowClass = new show_categories;
                // $categoryShowClass->show_all_categories();
                break;


            
            case "linkkeywords":
                echo "<h3>Now link Keywords</h3>";
                $this->link_keywords_to_tomoato();
                break;
            
            
            
            case "setup":
               // $this->setup();
               if (isset($_GET['function'])) {
                   print('<p>Function used in URL parameter</p>');
                   print('<p>'.$_GET['function'].'</p>');
                   if($_GET['function']=="setupweeklygoals"){
                       $setup = new setupgoals;
                     // $setup->form_set_weekly_goals();
                    // $goals_array = $setup->make_goals_array();
                    // print('<pre>');
                   //  print_r($goals_array);
                    // print('</pre>');
                    $setup->make_goals_array();
                   }else{
                       print('<p>function not defined</p>');
                   }
               }
                break;
            default:
                echo "page has not been defined";
                // $this->index_page();                             
        }
    }

}

?>