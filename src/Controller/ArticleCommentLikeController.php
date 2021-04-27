<?php

namespace App\Controller;

use App\Entity\ArticleComment;
use App\Entity\ArticleCommentLike;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleCommentLikeController extends AbstractController
{
    public function setArticleCommentVote(Request $request): Response
    {
        $data = $request->toArray();
        $value = intval($data['value']);
        $articleCommentRepository = $this->getDoctrine()->getRepository(ArticleComment::class);
        $articleCommentLikeRepository = $this->getDoctrine()->getRepository(ArticleCommentLike::class);
        $entityManager  = $this->getDoctrine()->getManager();

        $comment = $articleCommentRepository->findOneById($data['comment_id']);
        if(!$comment) {
            throw $this->createNotFoundException('No article found for id '. $id);
        }

        $commentLike = $articleCommentLikeRepository->findOneBy([
            'User' => $this->getUser(),
            'articleComment' => $comment,
        ]);

        if ($commentLike) { //exist
            if ($value == $commentLike->getValue()) { // remove reaction
                $commentLike->setValue(0);
            } else {
                $commentLike->setValue($value);
            }
        }
        else { // create new
            $articleCommentLike = new ArticleCommentLike();
            $articleCommentLike->setArticleComment($comment);
            $articleCommentLike->setUser($this->getUser());
            $articleCommentLike->setValue(intval($data['value']));

            $entityManager->persist($articleCommentLike);
        }

        $entityManager->flush();

        $score = $articleCommentLikeRepository->sumCommentLikes($comment);
        
        $commentLikes = $articleCommentLikeRepository->findByArticleComment($comment);

        $response = new JsonResponse(json_encode(["score" => $score]), Response::HTTP_OK, ['content-type' => 'application/json']);

        return $response;
    }

    public function getUserArticleCommentVote(Request $request, $comment_id): Response
    {
        $articleComment = $this->getDoctrine()->getRepository(ArticleComment::class)->findOneById($comment_id);

        $commentLikes = $this->getDoctrine()->getRepository(ArticleCommentLike::class)->findOneBy([
            "User" => $this->getUser(),
            "articleComment" => $articleComment
        ]);
        $data = 0;
        if ($commentLikes)
            $data = $commentLikes->getValue();
        $response = new JsonResponse(json_encode(["comment_id" => $comment_id, "value" => $data]), Response::HTTP_OK, ['content-type' => 'application/json']);

        return $response;
    }
}
