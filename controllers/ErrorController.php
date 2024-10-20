<?php

namespace controllers;

use controllers\Controller;

class ErrorController extends Controller
{

    function process(array $parameters): void
    {
       header("HTTP/1.1 404 Not Found");
       $this->view = 'error';
        // TODO: Implement process() method.
    }
}