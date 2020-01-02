<?PHP

class viewauxiliary extends viewsabstract{


    public function __toString(){
        $section_menu=$this->sectmenu();
        $return = $section_menu;
        return $return;
    }

}
?>