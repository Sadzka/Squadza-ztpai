<?php

namespace App\Controller;

use App\Entity\Npc;
use App\Entity\Location;
use App\Entity\Quest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class NpcController extends AbstractController
{
    public function npc(): Response
    {
        return $this->render('npc/npc.html.twig');
    }
    public function npcInfo($npc_id): Response {

        $npcRepository = $this->getDoctrine()->getRepository(Npc::class);
        $questRepository = $this->getDoctrine()->getRepository(Quest::class);

        $npc = $npcRepository->findOneById($npc_id);
        $location = $npc->getLocation();
        $quests_start = $questRepository->findByStartNpc($npc);
        $quests_end = $questRepository->findByEndNpc($npc);

        return $this->render('npc/npc.html.twig',
            [
                "npc" => $npc,
                'location' => $location,
                'quests_start' => $quests_start,
                'quests_end' => $quests_end
            ]);
    }

    public function searchNpcs(Request  $request) : JsonResponse
    {
        $npcRepository = $this->getDoctrine()->getRepository(Npc::class);
        $locationRepository = $this->getDoctrine()->getRepository(Location::class);

        $data = $request->toArray();

        $name           = $data['name'];
        $lvmin          = $data['lvmin'];
        $lvmax          = $data['lvmax'];
        $locationname   = $data['locationname'];
        $locations = $locationRepository->findAllByNameLike($locationname);

        $npcs = $npcRepository->findNpcs($name, $lvmin, $lvmax, $locations);

        $data = [];
        foreach ($npcs as $npc) {
            array_push($data, $npc->toJson()); // TODO toJson()
        }
        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

}
