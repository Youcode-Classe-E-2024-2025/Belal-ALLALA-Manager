<?php

function dd($var) {
    echo "<pre>";    
    echo "<code>";
    print_r($var);    
    echo "</code>";    
    echo "</pre>";
    die();  
}

?>