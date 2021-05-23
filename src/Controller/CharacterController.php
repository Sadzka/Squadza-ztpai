<?php

namespace App\Controller;

use App\Entity\Character;
use App\Entity\GuildMember;
use App\Entity\Guild;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CharacterController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('character/index.html.twig');
    }

    public function searchCharacters(Request  $request) : JsonResponse
    {
        $characterRepository = $this->getDoctrine()->getRepository(Character::class);
        $guildMemberRepository = $this->getDoctrine()->getRepository(GuildMember::class);
        $guildRepository = $this->getDoctrine()->getRepository(Guild::class);

        $data = $request->toArray();

        $name        = $data['name'];
        $lvmin       = $data['lvmin'];
        $lvmax       = $data['lvmax'];
        $guild_name  = $data['guild'];
        if ($lvmin == '') $lvmin = "1";
        if ($lvmax == '') $lvmax = "9999";

        $guilds = $guildRepository->findLike($guild_name);

        $characters = $characterRepository->findCharacters($name, $lvmin, $lvmax);

        $data = [];
        foreach ($characters as $character) {
            $arr = $character->getArray();

            foreach ($guilds as $guild) {
                $guildInfo = $guildMemberRepository->findOneBy(['guild' => $guild, 'member' => $character]);
                if ($guildInfo) {
                    $arr['guild']['id'] = $guildInfo->getGuild()->getId();
                    $arr['guild']['name'] = $guildInfo->getGuild()->getName();
                    break;
                }
            }
            if ($guild_name == '')
                array_push($data, $arr);
            else if ($arr['guild']['id'])
                array_push($data, $arr);
        }

        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function character($character_id): Response
    {
        $character = $this->getDoctrine()->getRepository(Character::class)->findOneById($character_id);
        return $this->render('character/character.html.twig', [
            'character' => $character,
        ]);
    }
}
