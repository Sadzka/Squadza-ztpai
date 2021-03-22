<?php
// src/Controller/DefaultController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController {

    public function index(int $path) : Response
    {
        return $this->render('homepage.html.twig');
    }

    public function login() : Response
    {
        return $this->render('login.html.twig');
    }

    public function register() : Response
    {
        return $this->render('register.html.twig');
    }
}




