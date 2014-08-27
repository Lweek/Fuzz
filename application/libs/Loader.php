<?php
/**
 * Loader - automatically load project scripts
 */

namespace Fuzz;


class Loader {

    static protected $sharedLoader;
    protected $paths;

// Public part - api

    static public function shared() {
        if (!isset(self::$sharedLoader)) {
            self::$sharedLoader = new self();
        }
        return self::$sharedLoader;
    }

    public function __construct() {
        spl_autoload_register(array($this, 'autoloader'), true, false);
    }

    public function addNamespacePath($namespace, $path) {
        if (!isset($this->paths[$namespace])) {
            $this->paths[$namespace] = $path;
        }
        else {
            throw new \Exception('Trying to rewrite existing namespace path in Loader', 1);
        }
    }

    public function path($className) {
        $path = null;
        $namespace = $this->extractNamespace($className);
        if (isset($this->paths[$namespace])) {
            $class = $this->extractClass($className);
            $namespace = $this->translateMarks($this->paths[$namespace], $class);
            $path = $namespace . '/' . $class . '.php';
        }
        return $path;
    }

// Private part - black box

    protected function extractNamespace($className) {
        $lastBackslashPosition = strrpos($className, '\\');
        $namespace = substr($className, 0, $lastBackslashPosition);
        return $namespace;
    }

    protected function extractClass($className) {
        $lastBackslashPosition = strrpos($className, '\\');
        $class = ($lastBackslashPosition > 0)? substr($className, $lastBackslashPosition + 1): $className;
        return $class;
    }

    protected function translateMarks($path, $class) {
        $path = str_replace('{class}', strtolower($class), $path);
        return $path;
    }

    protected function autoloader($className) {
        $path = $this->path($className);
        if (file_exists($path)) {
            require_once $path;
        }
    }

// Another api

    public function __sleep() {
        return array('paths');
    }
}
