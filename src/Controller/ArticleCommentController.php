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

        $data = [
            'date' => ['date' => "few seconds ago"],
            'content' => $data['comment'],
            'author' => $this->getUser()->getUsername(),
            'comment_id' => $articleComment->getId()
        ];
        $response = new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);

        return $response;
    }

    public function getComments(Request $request, $article_id) : JsonResponse
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articleCommentRepository = $this->getDoctrine()->getRepository(ArticleComment::class);
        $articleCommentLikeRepository = $this->getDoctrine()->getRepository(ArticleCommentLike::class);

        $article = $articleRepository->findOneById($article_id);
        $comments = $articleCommentRepository->findByArticle($article);

        $data = [];

        foreach ($comments as $comment) {
            $commentLikes = $articleCommentLikeRepository->findByArticleComment($comment);
            
            $editable = false;
            if ( $this->getUser() != null) {
                $editable = ($comment->getUser()->getId() == $this->getUser()->getId() ? true : false);
            }

            $score = $articleCommentLikeRepository->sumCommentLikes($comment);

            array_push($data, [
                "comment_id" => $comment->getId(),
                "content" => $comment->getComment(),
                "author" => $comment->getUser()->getUsername(),
                "date" => $comment->getDate(),
                "last_edit" => $comment->getLastEdit(),
                "editable" => $editable,
                //"score" => $this->getDoctrine()->getRepository(ArticleCommentLike::class)->sumLikes($comment)
                "score" => $score
            ]);
        }
        //var_dump(json_encode($data));
        
        $response = new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
        return $response;
    }

    public function deleteComment(Request $request, $comment_id) : JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $entityManager  = $this->getDoctrine()->getManager();
        $comment = $this->getDoctrine()->getRepository(ArticleComment::class)->findOneById($comment_id);
        $user = $this->getUser();

        if (!$comment) {
            throw $this->createNotFoundException('No comment found for id '. $comment_id);
        }

        if (! ($user == $comment->getUser()
        || in_array($user->getRoles(), ["ROLE_ADMIN", "ROLE_MOD"])) )
            return new JsonResponse(json_encode("No Permissions"), Response::HTTP_OK, ['content-type' => 'application/json']);

        // drop foreign keys first
        $commentLikes = $this->getDoctrine()->getRepository(ArticleCommentLike::class)->findByArticleComment($comment);
        foreach ($commentLikes as $commentLike) {
            $entityManager->remove($commentLike);
        }

        $entityManager->remove($comment);
        $entityManager->flush();

        $response = new JsonResponse(json_encode("OK"), Response::HTTP_OK, ['content-type' => 'application/json']);
        return $response;
    }
}
