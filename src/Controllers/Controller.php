<?php
namespace Ollyo\Task\Controllers;

class Controller{
    public function view($name){
        $filename="Views/".$name.".php";
    
        if(file_exists($filename)){
            require $filename;
        }else{
            $filename="Views/404.php";
            require $filename;
        }
    }
}

?>