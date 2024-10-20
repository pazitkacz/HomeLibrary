<?php

namespace controllers;

class BooksController extends Controller
{
    public function process(array $parameters): void
    {

    }

    public function getView(bool $layout = false): void
    {
        parent::getView($layout);
    }
}