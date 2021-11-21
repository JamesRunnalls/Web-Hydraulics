<?php

class Generic {
    private $data = array();

    public function __call($name, $arguments){
        switch(substr($name, 0, 3)){
            case 'get':
                if(isset($this->data[substr($name, 3)])){
                    return $this->data[substr($name, 3)];
                }else{
                    die('Unknown variable.');
                }
            break;
            case 'set':
                $this->data[substr($name, 3)] = $arguments[0];
                return $this;
            break;
            default: 
                die('Unknown method.');
        }
    }
}

?>