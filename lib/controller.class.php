<?php

class Controller {
    $params = array();
    // Validator:
    //      
    $validators = array();
    function push_param($key, $value){
        $this->params[$key] = $value;
    }
}

class Page extends Controller {

}

class Action extends Controller {

}

?>

