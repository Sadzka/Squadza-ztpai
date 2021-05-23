<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Npc;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class LocationController extends AbstractController
{
    public function location(Request $request, $location_id): Response
    {
        $locationRepository = $this->getDoctrine()->getRepository(Location::class);
        $npcRepository = $this->getDoctrine()->getRepository(Npc::class);

        $location = $locationRepository->findOneById($location_id);

        $marker = null;
        if ($request->query->get('x') && $request->query->get('y'))
            $marker = ['x' => $request->query->get('x'), 'y' => $request->query->get('y')];

        $npcs = $npcRepository->findByLocation($location);

        return $this->render('location/location.html.twig', [
            'location' => $location,
            'marker' => $marker,
            'npcs' => $npcs
        ]);
    }
}
