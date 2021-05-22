<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\CommentLike;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentLikeController extends AbstractController
{
    public function setCommentVote(Request $request): Response
    {
        if (!$this->getUser()) {
            return new JsonResponse("Unauthorized", Response::HTTP_UNAUTHORIZED, ['content-type' => 'application/json']);
        }
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data = $request->toArray();
        $value = intval($data['value']);

        $entityManager  = $this->getDoctrine()->getManager();
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $commentLikeRepository = $this->getDoctrine()->getRepository(CommentLike::class);

        $id = $data['comment_id'];
        $comment = $commentRepository->findOneById($id);
        if(!$comment) {
            return new JsonResponse("Bad Request", Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
        }

        $commentLike = $commentLikeRepository->findOneBy([
            'comment' => $comment,
            'user' => $this->getUser()
        ]);

        if ($commentLike) { //exist
            if ($value == $commentLike->getValue()) { // remove reaction
                $commentLike->setValue(0);
            } else {
                $commentLike->setValue($value);
            }
        }
        else { // create new
            $commentLike = new CommentLike();
            $commentLike->setComment($comment);
            $commentLike->setUser($this->getUser());
            $commentLike->setValue(intval($data['value']));

            $entityManager->persist($commentLike);
        }

        $entityManager->flush();

        $score = $commentLikeRepository->sumCommentLikes($comment);
        
        $commentLikes = $commentLikeRepository->findByComment($comment);

        return new JsonResponse(json_encode(["score" => $score]), Response::HTTP_OK, ['content-type' => 'application/json']);
;
    }

    public function getUserCommentVote(Request $request, $comment_id): Response
    {
        if (!$this->getUser()) {
            return new JsonResponse("Unauthorized", Response::HTTP_UNAUTHORIZED, ['content-type' => 'application/json']);
        }
        $comment = $this->getDoctrine()->getRepository(comment::class)->findOneById($comment_id);

        $commentLikes = $this->getDoctrine()->getRepository(CommentLike::class)->findOneBy([
            "comment" => $comment,
            "user" => $this->getUser()
        ]);

        $data = 0;
        if ($commentLikes)
            $data = $commentLikes->getValue();

        return new JsonResponse(
            json_encode(["comment_id" => $comment_id,
            "value" => $data]),
            Response::HTTP_OK,
            ['content-type' => 'application/json']
        );
    }
}