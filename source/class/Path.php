<?php

namespace Phi\VirtualFileSystem;


class Path
{


    private $calledPath = '';
    private $realpath  ='';



    public function __construct($path)
    {
        $this->calledPath = $path;
        $this->realpath = realpath($path);
    }


    /**
     * @return bool
     */
    public function isSymLink()
    {
        return is_link($this->calledPath);
    }


    /**
     * @return bool
     */
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


    /**
     * @return string
     */
    public function getNormalized()
    {
        return $this->normalizePath($this->realpath);
    }


    /**
     * @return string
     */
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