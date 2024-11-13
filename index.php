<?php

use controllers\SwitchController;

session_start();

mb_internal_encoding("UTF-8");

/**
 * @param string $class
 * @return void
 * function creates autoload of controllers or models as requested
 */
function autoloadFunction(string $class): void
{

    if (preg_match('/Controller$/', $class)) {
        if (mb_strpos($class, 'controller') === false) {
            $class = 'controllers\\'.$class;
        }
        require(str_replace("\\", "/", $class) . ".php");
    }
    else
        require($class . ".php");
}

spl_autoload_register("autoloadFunction");

\models\Database::connect('localhost', 'root', '', 'library');
$router = new SwitchController();
$router->process(array($_SERVER['REQUEST_URI']));
$router->getView();
$router->returnMessage();
