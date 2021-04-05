<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends AbstractController {

    public function index(string $path) : Response
    {
        try {
            return $this->render($path . '.html.twig');
        }
        catch (Exception $err) {
            return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
        }
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




