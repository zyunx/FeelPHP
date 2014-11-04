<?php

class Page {

    protected $firstRow;
    protected $listRows;
    protected $defaultListRows;
    protected $totalPages;
    protected $totalRows;
    protected $pageIndex;
    protected $pageRolls;
    protected $defaultPageRolls;
    protected $url;

    public function firstRow() {
        return $this->firstRow;
    }

    public function listRows() {
        return $this->listRows;
    }
    
    public function setDefaultListRows($listRows)
    {
        $this->defaultListRows = intval($listRows);
    }
    public function setDefaultPageRolls($pageRolls)
    {
        $this->defaultPageRolls = intval($pageRolls);
    }
    
    public function setUrl($url) {
        $this->url = $url;
    }

    
    public function __construct($totalRows, $pageIndex = NULL, $listRows = NULL, $pageRolls = NULL) {
        // Get data from method params, $_GET and default value.
        $totalRows = intval($totalRows);
        
        if(!$pageIndex) {
            $pageIndex = filter_input(INPUT_GET, 'page_index', FILTER_VALIDATE_INT);
            if(!$pageIndex) $pageIndex = 1;
        }
        
        if(!$listRows) {
            $listRows = filter_input(INPUT_GET, 'list_rows', FILTER_VALIDATE_INT);
            if(!$listRows) $listRows = 3;
        }
        
        if(!$pageRolls) {
            $pageRolls = filter_input(INPUT_GET, 'page_rolls', FILTER_VALIDATE_INT);
            if(!$pageRolls) $pageRolls = 3;
        }
       

        // sanitize data
        $this->totalRows = $totalRows;
        $this->totalPages = ceil($totalRows / $listRows);

        if ($pageIndex > $this->totalPages)
            $pageIndex = $this->totalPages;
        if ($pageIndex < 1)
            $pageIndex = 1;
        $this->pageIndex = $pageIndex;

        $this->firstRow = ($pageIndex - 1) * $listRows;
        $this->listRows = min($totalRows - $this->firstRow, $listRows);
        $this->pageRolls = $pageRolls;
    }

    public function show() {
        $url = empty($this->url) ? U(ACTION_CLASS . '/' . ACTION_METHOD) : $this->url;
        
        $html = '<ul class="pagination">';
        $html .= '<li><a href="' . $url . '?page_index=' . ($this->pageIndex - $this->pageRolls) . '">&laquo;</a></li>';
        $firstPage = $this->pageIndex - floor($this->pageRolls/2);
        $lastPage = $this->pageIndex + $this->pageRolls - floor($this->pageRolls/2) - 1;
        
        
        if($firstPage < 1 && $lastPage > $this->totalPages ) {
            $firstPage = 1;
            $lastPage = $this->totalPages;
        } else if ($firstPage < 1) {
            $firstPage = 1;
            $lastPage = min($this->pageRolls, $this->totalPages);
        } else if ($lastPage > $this->totalPages) {
            $firstPage = max(1, $this->totalPages - $this->pageRolls + 1);
            $lastPage = $this->totalPages;
        }
        
        for($i = $firstPage; $i <= $lastPage; $i++) {
            if ($this->pageIndex == $i) {
                $html .= '<li class="active"><a>' . $i . '</a></li>';
            } else {
                $html .= '<li><a href="' . $url . '?page_index=' . $i .'">' . $i . '</a></li>';
            }
            
        }

        $html .= '<li><a href="' . $url . '?page_index=' . ($this->pageIndex + $this->pageRolls) . '">&raquo;</a></li></ul>';

        return $html;
    }

}
