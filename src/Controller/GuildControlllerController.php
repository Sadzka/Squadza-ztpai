<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GuildControlllerController extends AbstractController
{
    /**
     * @Route("/guild/controlller", name="guild_controlller")
     */
    public function index(): Response
    {
        return $this->render('guild_controlller/index.html.twig', [
            'controller_name' => 'GuildControlllerController',
        ]);
    }
}
