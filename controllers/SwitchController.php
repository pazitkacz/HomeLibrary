<?php

namespace controllers;

use controllers\Controller;

class SwitchController extends Controller
{
    /**
     * @var \controllers\Controller|null
     */
    protected ?Controller $controller = null;

    /**
     * @param array $parameters
     * @return void
     * function requests Controller according to used parameters and routes to correct view
     */
    function process(array $parameters): void
    {
        $parsedURL =$this->parseURL($parameters[0]);
        if (empty($parsedURL[0])) {
            $this->route('Library');
        }
        $controllerClass = array_shift($parsedURL).'Controller';
        if (file_exists('controllers\\'.$controllerClass.'.php')) {
            $this->controller = new ('controllers\\'.$controllerClass);
        }
        else {
            $this->route('error');
        }
        $this->controller->process($parsedURL);
        $this->data['title'] = $this->controller->header['title'];
        $this->view = 'Layout';

    }

    /**
     * @param string $url
     * @return array
     * fucntion for parsing requested URL
     */
    private function parseURL(string $url): array
    {
        $parsedURL = parse_url($url);
        $parsedURL['path'] = ltrim($parsedURL['path'], '/');
        $parsedURL = str_replace("/", " ", $parsedURL);
        $parsedURL["path"] = trim($parsedURL["path"]);
        $splitPath = explode(" ", $parsedURL["path"]);
        return $splitPath;
    }
}