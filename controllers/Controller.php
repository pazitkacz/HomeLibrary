<?php

namespace controllers;

abstract class Controller
{

    /**
     * @var array
     */
    protected array $data = [];
    /**
     * @var string
     */
    protected string $view = "";
    /**
     * @var array|string[]
     */
    protected array $header = ['title' => '', 'description' => '', 'keywords' => ''];

    /**
     * @param array $parameters
     * @return void
     * generic abstract function that is implemented in each controller separatelly
     */
    abstract function process(array $parameters): void;

    /**
     * @param bool $layout
     * @return void
     * generic function that generates the requested view
     */
    public function getView(bool $layout = false): void
    {
        if($this->view)
        {
            extract($this->treat($this->data));
            extract($this->data, EXTR_PREFIX_ALL, "");
            require(dirname(__FILE__)."\\..\\views\\".$this->view . ".phtml");
        }
    }

    /**
     * @param mixed|null $input
     * @return mixed
     * function that treats input to ensure no dangerous data are added into table
     */
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

    /**
     * @param string $message
     * @return void
     * function that adds message linked to session that can be shown to user
     */
    public function addMessage(string $message): void
    {
        if (isset($_SESSION['messages']))
            $_SESSION['messages'][] = $message;
        else
            $_SESSION['messages'] = array($message);
    }

    /**
     * @return array
     * function returns messages in session
     */
    public function returnMessage(): array
    {
        if (isset($_SESSION['messages'])) {
            $message = $_SESSION['messages'];
            unset($_SESSION['messages']);
            return $message;
        } else
            return array();
    }

    /**
     * @param string $url
     * @return never
     * routing to requested url
     */
    public function route(string $url): never
    {
        header("Location: /$url");
        exit;
    }
}