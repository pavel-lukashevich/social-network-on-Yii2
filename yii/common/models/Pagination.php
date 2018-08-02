<?php

namespace common\models;
// для нормального отображения должен быть подключен
//  файл bootstrap.css, проверено на версии 3.3.4

class Pagination {
    
    //номер страницы
    private $page;
    
    //количество записей в базе
    private $countString;
    
    //количество записей на странице
    // значение по умалчанию 10
    private $stringToPage;
    
    //количество страниц
    private $countPages;
    
    // префикс в ссылке
    private $index;
    
    /**
     * 
     * @param type $page - int
     * @param type $countString - int
     * @param type $stringToPage - int
     * @param type $countPages - int
     * @param type $index - string
     */
    public function __construct( $page, $countString, $stringToPage = 10, $index = 'p-'){
        
        $this->countPages = ceil($countString / $stringToPage);
        if ( $page < 1 || !$page || $page >$this->countPages) {
            $this->page = 1;
        } else $this->page = $page;
        $this->countString = $countString;
        $this->stringToPage = $stringToPage;
        $this->index = $index;
    }
    
    /**
     * 
     * @return string - HTML разметка пагинатора
     */
    public function get() {
         
        //получаем адрес страницы с пагинатором
        $path = rtrim($_SERVER['REQUEST_URI'], '/') . '/';
        $change = $this->index . '[0-9]+/?';
        $path = preg_replace( "~$change~", '', $path);
        
		/*
		* собираем строку HTML
		* разметка сделана с использованием Bootstrap3
		*/	
		$htmlString = "<center><nav><ul class='pagination'>";

        // если больше 5 страниц
	if ($this->countPages >= 5) {

        //первая страница
        $htmlString .= "<li";
        if ($this->page == 1) $htmlString .= " class='active'";
        $htmlString .= "><a href='" . $path . $this->index . "1'>1</a></li>";

        //вторая страница
        $htmlString .= "<li";
        if ($this->page == 2) $htmlString .= " class='active'";
        $htmlString .= "><a href='" . $path . $this->index . "2'>2</a></li>";

        // если сейчас первая, вторая или третья страница,
        // или общее количество страниц меньше пяти,
        // то кнокпа "предыдущая" не ставится
        // если нет - добавляем
        if ($this->page <= 3 || $this->countPages <= 5) $htmlString .= "<li class='hidden'></li>";
        else {
            $htmlString .= "<li><a href='"  . $path . $this->index . ($this->page - 1) ."'  aria-label='Previous'>
				<span aria-hidden='true'>предыдущая  &laquo;</span></a></li>";
        }

        //от третьей до предпредпоследней
//        $htmlString .= "<li><a  style='background: #337ab7;'><select onchange='window.location.href=this.options[this.selectedIndex].value'>";
        $htmlString .= "<li><a";
        if ($this->page > 2 && $this->page < $this->countPages - 2) $htmlString .= " style='background: #337ab7;'";
        $htmlString .= "><select onchange='window.location.href=this.options[this.selectedIndex].value'>";
        for ($z=3; $z <= $this->countPages - 2; $z++) {
            $htmlString .= "<option value='" . $path . $this->index . $z . "'";
            if ($z == $this->page) $htmlString .= " selected";
            $htmlString .= ">$z</option>";
        }
        $htmlString .= "</select></a></li>";

        // если последняя
        // или общее количество страниц меньше пяти,
        // то кнокпа "следующая" не ставится
        // если нет - добавляем
        if ($this->page >= ($this->countPages-2)  || $this->countPages <= 5) $htmlString .= "<li class='hidden'></li>";
        else {
            $htmlString .= "<li><a href='"  . $path . $this->index . ($this->page + 1) . "'  aria-label='Next'>
					<span aria-hidden='true'>&raquo; следующая</span>
				</a></li>";
        }

        //предпоследная страница
        $htmlString .= "<li";
        if ($this->page == $this->countPages - 1) $htmlString .= " class='active'";
        $htmlString .= "><a href='" . $path . $this->index . ($this->countPages - 1) . "'>" . ($this->countPages - 1) . "</a></li>";

        //последная страница
        $htmlString .= "<li";
        if ($this->page == $this->countPages) $htmlString .= " class='active'";
        $htmlString .= "><a href='" . $path . $this->index . $this->countPages . "'>" . $this->countPages . "</a></li>";

	} elseif ($this->countPages >= 1) {
            // если страниц меньше пяти и больше одного
		for ($i=1; $i<=$this->countPages; $i++){
			$htmlString .= "<li";
            if ($this->page == $i) $htmlString .= " class='active'";
             $htmlString .= "><a href='"  . $path . $this->index . $i . "'>" . $i . "</a></li>";
		}
	}//если всего одна страница, то ничего не происходит и не выводится

	$htmlString .= "</ul></nav></center>";
       
        return $htmlString; 
    }
}
