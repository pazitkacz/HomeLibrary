<?php

namespace controllers;

use controllers\Controller;

class SwitchController extends Controller
{
    protected ?Controller $controller;
    function process(array $parameters): void
    {
        $parsedURL =$this->parseURL($parameters[0]);
        if (empty($parsedURL[0])) {
            $this->controller = new LibraryController();
            $this->controller->process([]);
        }
    $this->view ='layout';
    }

    private function parseURL(string $url): string
    {
        $parsedURL = parse_url($url);
        $parsedURL['path'] = ltrim($parsedURL['path'], '/');
        $parsedURL = str_replace("/", " ", $parsedURL);
        $parsedURL["path"] = trim($parsedURL["path"]);
        $splitPath = explode("/", $parsedURL["path"]);
        return $splitPath;
    }
}