<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\GuildMember;
use App\Entity\Item;
use App\Entity\Npc;
use App\Entity\Quest;
use App\Entity\Character;
use App\Entity\Guild;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends AbstractController {

    public function index(string $path) : Response
    {
        return $this->render($path . '.html.twig');
    }

    public function favicon() : BinaryFileResponse
    {
        $path = $this->getParameter('kernel.project_dir');
        $filename = "/public/img/favicon.ico";
        return new BinaryFileResponse($path . $filename);
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

    public function ranking()
    {
        $characters = $this->getDoctrine()->getRepository(Character::class)->findBy([], ['level' => 'DESC'], 10);
        $guilds = $this->getDoctrine()->getRepository(Guild::class)->findAll();
        foreach ($guilds as &$guild) {
            $members_no = $this->getDoctrine()->getRepository(GuildMember::class)->countMembers($guild);
            if ($members_no == null) $members_no = 1;
            $guild->setMembersNo($members_no);

            $average_level = $this->getDoctrine()->getRepository(GuildMember::class)->averageLevel($guild);
            if ($average_level == null) $average_level = 1;
            $guild->setAverageLevel($average_level);
        }

        usort($guilds, function ($a, $b) {
            $points_a = $a->getMembersNo() / $a->getAverageLevel();
            $points_b = $b->getMembersNo() / $b->getAverageLevel()  ;
            return $points_a > $points_b;
        });
        array_slice($guilds, 0, 10);

        return $this->render('ranking.html.twig', [
            'characters' => $characters,
            'guilds' => $guilds,
        ]);
    }
}




