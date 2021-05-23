<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Item;
use App\Entity\Npc;
use App\Entity\Quest;
use App\Entity\Character;
use App\Entity\Guild;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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

    public function search(Request $request) : Response {
        $name = $request->query->get('value');

        $articles = $this->getDoctrine()->getRepository(Article::class)->findLike($name);
        $items = $this->getDoctrine()->getRepository(Item::class)->findLike($name);
        $npcs = $this->getDoctrine()->getRepository(Npc::class)->findLike($name);
        $quests = $this->getDoctrine()->getRepository(Quest::class)->findLike($name);
        $characters = $this->getDoctrine()->getRepository(Character::class)->findLike($name);
        $guilds = $this->getDoctrine()->getRepository(Guild::class)->findLike($name);

        // var_dump($article);
        // var_dump($item);
        // var_dump($npc);
        // var_dump($quest);

        return $this->render('search.html.twig', [
            'articles' => $articles,
            'items' => $items,
            'npcs' => $npcs,
            'quests' => $quests,
            'characters' => $characters,
            'guilds' => $guilds
        ]);
    }
}




