<?php

class Scripter
{
    protected $argv;
    protected $file;

    public function __construct($argv)
    {
        $opt = getopt("f:");

        if ( !isset($opt['f'])) {
            $this->usage();
        }
        
        if ( !file_exists($opt['f'])) {
            throw new \Exception('ERROR: script file is not exists');
        }
        $this->argv = $argv;
        $this->file = realpath($opt['f']);

    }
    protected function usage()
    {
        echo "Example: php scripter.php -f /tmp/test.php a b c" . PHP_EOL;
        exit("Usage: -f   script file ");
    }
    
    public function run()
    {
        array_shift($this->argv);
        array_shift($this->argv);
        array_shift($this->argv);

        require_once($this->file);

        $className = pathinfo($this->file)['filename'];

        $obj = new $className;
        
        call_user_func_array([$obj, 'index'],$this->argv);

        

    }



}