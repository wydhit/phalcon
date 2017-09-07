<?php

define('CLI_ROOT', __DIR__);
define('START_TIME', time());

$loader = new \Phalcon\Loader();
$loader->registerNamespaces([
    'Task' => CLI_ROOT . '/Task'
]);
$loader->register();

$go = true;
while ($go) {
    sleep(1);
    $taskList = require CLI_ROOT . '/config/taskList.php';
    if (!empty($taskList) && is_array($taskList)) {
        foreach ($taskList as $task) {
            $class = new $task();
            if ($class->isRun()) {
                $class->run();
            }
            unset($class);
        }
    }
    if (!IsGo()) {
        $go = false;
    }
    unset($taskList);
}


function isGo()
{
    if (time() - START_TIME > 20*60) {
        return false;
    }
    return true;
}










