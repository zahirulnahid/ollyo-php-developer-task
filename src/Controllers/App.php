<?php

class App{

    private function spiltURL(){
        $URL = $_GET['url']??'app';
        $URL = explode("/",$URL);
        return $URL;
    }
    public function loadController(string $name, array $data){
        $URL=$this->spiltURL();
    
        $filename="src/Views/".$name.".php";
    
        if(file_exists($filename)){
            require $filename;
        }else{
            $filename="src/Views/404.php";
            require $filename;
        }
        
    }
}