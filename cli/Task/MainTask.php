<?php
namespace Task;
use Phalcon\Cli\Task;
class MainTask
{
    public function indexAction(array $params=[])
    {
        echo "Asdfasd";
    }

    public function isRun()
    {
        return true;
                
    }

    public function run()
    {
        echo "1asfaaaaa \r\n";
        echo "2asfaaaaa \r\n";
        echo "3asfaaaaa \r\n";
        echo "4asfaaaaa \r\n";
        echo "5asfaaaaa \r\n";
        echo "6asfaaaaa \r\n";

    }
}