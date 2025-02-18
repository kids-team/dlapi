<?php

namespace Contexis\Controllers;

use Contexis\Core\Controller;
use Contexis\Core\ControllerInterface;
use Contexis\Twig\Renderer;


class Login extends Controller implements ControllerInterface{
    public function __construct($site) {
        
        parent::__construct($site);
    }

    public function render() {
        echo Renderer::compile("pages/login.twig", $this->site->get());
    }
}