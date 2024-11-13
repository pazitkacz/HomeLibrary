<?php

namespace controllers;

use controllers\Controller;

class ErrorController extends Controller
{

    /**
     * @param array $parameters
     * @return void
     * function routes to error view
     */
    function process(array $parameters): void
    {
       header("HTTP/1.1 404 Not Found");
       $this->view = 'error';
    }
}