<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\ArticleCommentLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class ArticleCommentController extends AbstractController
{
    public function addComment(Request $request) : JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data = $request->toArray();

        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById($data['article_id']);
        if(!$article) {
            throw $this->createNotFoundException('No article found for id '. $id);
        }

        $entityManager  = $this->getDoctrine()->getManager();
        $articleComment = new ArticleComment(
            $article,
            $this->getUser(),
            $data['comment'],
            $date = new \DateTime('@'.strtotime('now')),
        );
        $entityManager->persist($articleComment);
        $entityManager->flush();

        $response = new JsonResponse('OK', Response::HTTP_OK, ['content-type' => 'application/json']);

        return $response;
    }

    public function getComments(Request $request, $article_id) : JsonResponse
    {
        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById($article_id);
        $comments = $this->getDoctrine()->getRepository(ArticleComment::class)->findByArticle($article);

        $data = [];

        foreach ($comments as $c) {
            $commentLikes = $this->getDoctrine()->getRepository(ArticleCommentLike::class)->findByArticleComment($c);
            
            $editable = false;
            if ( $this->getUser() != null) {
                $editable = ($c->getUser()->getId() == $this->getUser()->getId() ? true : false);
            }
            array_push($data, [
                "comment_id" => $c->getId(),
                "content" => $c->getComment(),
                "author" => $c->getUser()->getUsername(),
                "date" => $c->getDate(),
                "last_edit" => $c->getLastEdit(),
                "editable" => $editable,
                "score" => $this->sumLikes($commentLikes)
            ]);
        }
        //var_dump(json_encode($data));
        
        $response = new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
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
