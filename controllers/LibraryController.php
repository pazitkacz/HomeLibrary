<?php

namespace controllers;

use controllers\Controller;

class LibraryController extends Controller
{

    /**
     * @param array $parameters
     * @return void
     * generates correct view for main page of the library
     */
    function process(array $parameters): void
    {
        $this->view = 'library';        // TODO: Implement process() method.
    }
}