<?php

namespace Phi\VirtualFileSystem;


class Manager
{

    protected static $mainInstance;

    protected $virtualPathes = [];
    protected $virtualPathesByName = [];


    /**
     * @return static
     *
     */
    public static function getInstance()
    {
        if(!static::$mainInstance) {
            static::$mainInstance = new static();
        }
        return static::$mainInstance;
    }


    public function registerPath($realPath, $virtualPath, $name = null)
    {

        if(is_dir($virtualPath)) {
            $this->virtualPathes[$virtualPath] = $this->normalizePath(realpath($virtualPath));

            if($name) {
                $this->virtualPathesByName[$name] = &$this->virtualPathes[$virtualPath];
            }
            return $this;
        }

        $path = $this->normalizePath(realpath($realPath));

        if(!$path) {
            throw new Exception('Path "'.$realPath.'" does not exists');
        }

        $this->virtualPathes[$virtualPath] = $path;
        $this->virtualPathes[$realPath] = $path;



        if($name) {
            $this->virtualPathesByName[$name] = &$this->virtualPathes[$virtualPath];
        }

        return $this;
    }

    protected function normalizePath($path)
    {
        return str_replace('\\', '/', $path);
    }

    public function getPathByName($name)
    {
        if(array_key_exists($name, $this->virtualPathesByName)) {
            return $this->virtualPathesByName[$name];
        }
        else {
            throw new Exception('Virtual path with name "'.$name.'" is not registered');
        }
    }


    public function getPath($path)
    {
        if(is_dir(realpath($path))) {
            return $this->normalizePath(realpath($path));
        }



        if(array_key_exists($path, $this->virtualPathes)) {
            return $this->virtualPathes[$path];
        }
        else {
            throw new Exception('Virtual path "'.$path.'" is not registered');
        }
    }


    public function buildSymlinks()
    {

        foreach ($this->virtualPathes as $virtual => $real) {

            echo $real ."\t=>\t".$virtual."\n";

            if(!is_dir(realpath($virtual))) {
                symlink($real, $virtual);
            }
        }
    }







}