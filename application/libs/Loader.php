<?php
/**
 * Loader - automatically load project scripts
 */

namespace Fuzz;


class Loader {

    protected $paths;

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

    public function __sleep() {
        return array('paths');
    }
}
