<?php

namespace Phi\VirtualFileSystem;


class Path
{


    protected $calledPath = '';
    protected $realpath  ='';



    public function __construct($path)
    {
        $this->calledPath = $path;
        $this->realpath = realpath($path);
    }


    public function exists()
    {
        if(is_dir($this->realpath)) {
            return true;
        }
        else if(is_file($this->realpath)) {
            return true;
        }
        else {
            return false;
        }
    }



    public function getNormalized()
    {
        return $this->normalizePath($this->realpath);
    }



    public function __toString()
    {
        return $this->getNormalized($this->realpath);
    }


    /**
     * @param $path
     * @return string
     */
    protected function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }




}