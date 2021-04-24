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

        $comment = $this->getDoctrine()->getRepository(ArticleComment::class)->findOneById($data['comment_id']);
        if(!$comment) {
            throw $this->createNotFoundException('No article found for id '. $id);
        }
        
        $commentLikes = $this->getDoctrine()->getRepository(ArticleCommentLike::class)->findByArticleComment($comment);

        $entityManager  = $this->getDoctrine()->getManager();

        // Check if exists
        $commentLike = $this->getDoctrine()->getRepository(ArticleCommentLike::class)->findOneBy([
            'User' => $this->getUser(),
            'articleComment' => $comment,
        ]);

        $value = intval($data['value']);
        if ($commentLike) { //exist
            $commentLike->setValue($value);
            $response_data = $value * 2;
        }
        else { // create new
            $articleCommentLike = new ArticleCommentLike();
            $articleCommentLike->setArticleComment($comment);
            $articleCommentLike->setUser($this->getUser());
            $articleCommentLike->setValue(intval($data['value']));

            $entityManager->persist($articleCommentLike);
        }

        $entityManager->flush();

        $response = new JsonResponse(json_encode(["score" => $this->sumLikes($commentLikes)]), Response::HTTP_OK, ['content-type' => 'application/json']);

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
    
    private function sumLikes($likes)
    {
        $score = 0;
        foreach ($likes as $like) {
            $score += $like->getValue();
        }
        return $score;
    }
}
