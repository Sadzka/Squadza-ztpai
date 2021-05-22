<?php
// src/Controller/ItemController.php
namespace App\Controller;

use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ItemController extends AbstractController {

    public function item(): Response {
        return $this->render('item/item.html.twig');
    }

    public function item_info($item_id): Response {

        $itemRepository = $this->getDoctrine()->getRepository(Item::class);

        $item = $itemRepository->findOneById($item_id);
        //$comments = $item->findComments();
        return $this->render('item/item.html.twig', ["item" => $item]);
    }

    public function searchItems(Request  $request) : JsonResponse
    {
        $itemRepository = $this->getDoctrine()->getRepository(Item::class);

        $data = $request->toArray();

        $name           = $data['name'];
        $ilvmin         = $data['ilvmin'];
        $ilvmax         = $data['ilvmax'];
        $reqlvmin       = $data['reqlvmin'];
        $reqlvmax       = $data['reqlvmax'];
        $slots          = $data['slot'];
        $rarities       = $data['rarity'];

        $items = $itemRepository->findItems($name, $ilvmin, $ilvmax, $reqlvmin, $reqlvmax, $slots, $rarities);

        $data = [];
        foreach ($items as $item) {
            array_push($data, $item->toJson());
        }
        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

}

