<?php
require_once APP_ACTION_PATH . '/AdminBaseAction.class.php';

class IndexAction extends AdminBaseAction
{
    public function index()
    {
        
        $this->display();
    }
}

