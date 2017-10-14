<?php


class Folder
{

       private $path;
    
    private $name;
    
    public function __construct($path = null, $name = null)
    {
        $this->path = $path;
        
        $this->name = $name;
        
        $this->create_folder();
    }
    
    private function create_folder()
    {
        
    }
}