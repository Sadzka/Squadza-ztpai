<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Entity\CommentLike;
use App\Entity\ArticleComment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends AbstractController
{
    public function addComment(Request $request) : JsonResponse
    {   
        $entityManager  = $this->getDoctrine()->getManager();

        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articleCommentRepository = $this->getDoctrine()->getRepository(ArticleComment::class);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $data = $request->toArray();

        $comment = new Comment();
        $comment->setUser( $this->getUser() );
        $comment->setComment( $data['comment'] );
        $comment->setDate( new \DateTime('@'.strtotime('now')) );

        $article = $this->getDoctrine()->getRepository(Article::class)->findOneById($data['article_id']);
        if ($article) {
            $articleComment = new ArticleComment();
            $articleComment->setArticle($article);
            $articleComment->setComment($comment);
            $entityManager->persist($articleComment);
        }
        else {
            // ...
        }

        $entityManager->persist($comment);
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
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $commentLikeRepository = $this->getDoctrine()->getRepository(CommentLike::class);

        $comments;
        $article = $articleRepository->findOneById($article_id);
        if ($article) {
            $comments = $articleCommentRepository->findByArticle($article);
        }
        else {
            // $items = $articleRepository->findOneById($article_id);
            // if ($article) {
            //     $comments = $articleCommentRepository->findByArticle($article);
            // }
        }


        $data = [];

        foreach ($comments as $comment) {
            $comment = $comment->getComment();
            $commentLikes = $commentLikeRepository->findByComment($comment);
            
            $editable = false;
            if ( $this->getUser() != null) {
                $editable = ($comment->getUser()->getId() == $this->getUser()->getId() ? true : false);
            }

            $score = $commentLikeRepository->sumCommentLikes($comment);

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
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        
        $entityManager  = $this->getDoctrine()->getManager();
        $user = $this->getUser();


        $comment = $commentRepository->findOneById($comment_id);
        if (!$comment) {
            throw $this->createNotFoundException('No comment found for id '. $comment_id);
        }
        else {
            $comment->dropForeignKeys($this->getDoctrine());
        }
        
        if (! ($user == $comment->getUser()
        || in_array($user->getRoles(), ["ROLE_ADMIN", "ROLE_MOD"])) )
            return new JsonResponse(json_encode("No Permissions"), Response::HTTP_OK, ['content-type' => 'application/json']);

        $entityManager->remove($comment);
        $entityManager->flush();

        $response = new JsonResponse(json_encode("OK"), Response::HTTP_OK, ['content-type' => 'application/json']);
        return $response;
    }
}