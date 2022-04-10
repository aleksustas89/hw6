<?php

class Autoloader
{

    protected $prefixes = array();

    public function addNamespace(string $prefix, string $dir)
    {
        $prefix = trim($prefix, '\\') . '\\';

        // normalize the base directory with a trailing separator
        $dir = rtrim($dir, DIRECTORY_SEPARATOR) . '/';

        // initialize the namespace prefix array
        if (isset($this->prefixes[$prefix]) === false) {
            $this->prefixes[$prefix] = array();
        }

        array_push($this->prefixes[$prefix], $dir);
        
    }

    public function register()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    public function autoload($class)
    {

        foreach ($this->prefixes as $k => $base_dir) {

            $file = str_replace("\\", "/", str_replace($k, $base_dir[0], $class))
                    . '.php';

            if ($this->requireFile($file)) {
                return $file;
            }
        }

        return false;

    }

    protected function requireFile($file)
    {
        if (file_exists($file)) {
            require $file;
            return true;
        }
        return false;
    }
}

$autoloader = new Autoloader();
$autoloader->addNamespace('Hillel', 'src');
$autoloader->addNamespace('My', 'src2');
$autoloader->register();
