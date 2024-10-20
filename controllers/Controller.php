<?php

namespace controllers;

abstract class Controller
{

    protected array $data = [];
    protected string $view = "";
    protected array $header = ['title' => '', 'description' => '', 'keywords' => ''];
    abstract function process(array $parameters): void;

    public function getView(bool $layout = false): void
    {
        if($this->view)
        {
            extract($this->treat($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require(dirname(__FILE__)."\\..\\views\\".$this->view . ".phtml");
        }
    }

    private function treat(mixed $input = null): mixed
    {
        if (!isset($input))
            return null;
        elseif (is_string($input))
            return htmlspecialchars($input, ENT_QUOTES);
        elseif (is_array($input)) {
            foreach($input as $part => $component) {
                $input[$part] = $this->treat($component);
            }
            return $input;
        } else
            return $input;
    }

    public function addMessage(string $message): void
    {
        if (isset($_SESSION['messages']))
            $_SESSION['messages'][] = $message;
        else
            $_SESSION['messages'] = array($message);
    }

    public function returnMessage(): array
    {
        if (isset($_SESSION['messages'])) {
            $message = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $message;
        } else
            return array();
    }

    public function route(string $url): never
    {
        header("Location: /$url");
        exit;
    }
}