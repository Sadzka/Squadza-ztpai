<?php

namespace App\Controller;

use App\Entity\Quest;
use App\Entity\Location;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestController extends AbstractController
{
    /**
     * @Route("/quest", name="quest")
     */
    public function quest(): Response
    {
        return $this->render('quest/quest.html.twig');
    }

    public function searchQuests(Request  $request) : JsonResponse
    {
        $questRepository = $this->getDoctrine()->getRepository(Quest::class);
        $locationRepository = $this->getDoctrine()->getRepository(Location::class);

        $data = $request->toArray();

        $name           = $data['name'];
        $reqlvmin       = $data['reqlvmin'];
        $reqlvmax       = $data['reqlvmax'];

        $quests = $questRepository->findQuests($name, $reqlvmin, $reqlvmax);

        $data = [];
        foreach ($quests as $quest) {
            array_push($data, $quest->toJson());
        }
        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function quest_info($quest_id): Response {

        $questRepository = $this->getDoctrine()->getRepository(Quest::class);

        $quest = $questRepository->findOneById($quest_id);
        return $this->render('quest/quest.html.twig', ["quest" => $quest]);
    }

}
