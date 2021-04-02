<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {

    public function index(string $path) : Response
    {
        return $this->render($path . '.html.twig');
    }
    
    /*
    public function login() : Response
    {
        return $this->render('login.html.twig');
    }

    public function register() : Response
    {
        return $this->render('register.html.twig');
    }
    */
}




