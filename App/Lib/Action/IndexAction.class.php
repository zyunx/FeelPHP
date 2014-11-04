<?php

class IndexAction
{
    public function index()
    {
        $hello = 'Hello Template';
        
        require APP_TEMPLATE_PATH . '/_Layout/layout.template.php';
    }
}

