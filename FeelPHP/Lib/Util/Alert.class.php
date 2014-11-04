<?php
class Alert {

    protected $messageList;
    
    public function __construct()
    {
        $this->messageList = array();
    }
    
    public function show() {
        $html = '';
        
        foreach ($this->messageList as $type => $msgs)
        {
            $html .= <<<EOT
<div class="alert alert-$type" role="alert">
    <ul>
EOT;
            
            foreach ($msgs as $msg) {
                $html .= "<li>$msg</li>";
            }
            
            $html .= <<<EOT
    </ul>
</div> 
EOT;
        }
        return $html;
    }
    
    public function alert($type=NULL, $message=NULL)
    {
        if (empty($type) || empty($message)) {
            return FALSE;
        }
        
        if (!isset($this->messageList[$type]) || !is_array($this->messageList[$type]))
                $this->messageList[$type] = array();
                
        $this->messageList[$type][] = $message;
        return TRUE;
    }
}
