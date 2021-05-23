<?php

namespace App\Controller;

use App\Entity\Guild;
use App\Entity\GuildMember;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GuildController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('guild/index.html.twig');
    }

    public function guild($guild_id): Response
    {
        $guild = $this->getDoctrine()->getRepository(Guild::class)->findOneById($guild_id);
        return $this->render('guild/guild.html.twig', [
            'guild' => $guild,
        ]);
    }

    public function searchGuilds(Request  $request) : JsonResponse
    {
        $guildMemberRepository = $this->getDoctrine()->getRepository(GuildMember::class);
        $guildRepository = $this->getDoctrine()->getRepository(Guild::class);

        $data = $request->toArray();

        $guild_name     = $data['name'];

        $guilds = $guildRepository->findLike($guild_name);

        $data = [];

        foreach ($guilds as $guild) {
            $members = $guildMemberRepository->countMembers($guild);
            array_push($data, [
                'id' => $guild->getId(),
                'name' => $guild->getName(),
                'members' => $members
            ]);
        }

        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

}
