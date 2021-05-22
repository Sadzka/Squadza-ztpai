<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ArticleComment;
use App\Entity\Item;
use App\Entity\ItemComment;
use App\Entity\Quest;
use App\Entity\QuestComment;
use App\Entity\Npc;
use App\Entity\NpcComment;
use App\Entity\Comment;
use App\Entity\CommentLike;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CommentController extends AbstractController
{
    public function addComment(Request $request, $type) : JsonResponse
    {
        if (!$this->getUser()) {
            return new JsonResponse("Unauthorized", Response::HTTP_UNAUTHORIZED, ['content-type' => 'application/json']);
        }

        $entityManager = $this->getDoctrine()->getManager();

        $data = $request->toArray();

        $comment = new Comment();
        $comment->setUser($this->getUser());
        $comment->setComment($data['comment']);
        $comment->setDate(new \DateTime('@' . strtotime('now')));

        $typeComment = Null;

        $doctrine = $this->getDoctrine();
        $getRepofunc = 'getRepository';
        $class_name = "App\\Entity\\" . ucfirst($type) . "::class";
        $repo = $doctrine->{$getRepofunc}(eval("return $class_name;"));
        $variable_name = "App\\Entity\\" . ucfirst($type) . "Comment";
        $function_name = "set" . $type;

        try {
            $object = $repo->findOneById($data['type_id']);
            if ($object) {
                $typeComment = new $variable_name();
                $typeComment->{$function_name}($object);
            }
        } catch (\Throwable $e) {
            return new JsonResponse("BAD REQUEST", Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
        }

        $typeComment->setComment($comment);
        $entityManager->persist($typeComment);
        $entityManager->persist($comment);
        $entityManager->flush();

        $data = [
            'date' => ['date' => "few seconds ago"],
            'content' => $data['comment'],
            'author' => $this->getUser()->getUsername(),
            'comment_id' => $typeComment->getComment()->getId()
        ];

        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function getComments(Request $request, $type, $type_id) : JsonResponse
    {
        $articleRepository = $this->getDoctrine()->getRepository(Article::class);
        $articleCommentRepository = $this->getDoctrine()->getRepository(ArticleComment::class);

        $itemRepository = $this->getDoctrine()->getRepository(Item::class);
        $itemCommentRepository = $this->getDoctrine()->getRepository(ItemComment::class);

        $npcRepository = $this->getDoctrine()->getRepository(Npc::class);
        $npcCommentRepository = $this->getDoctrine()->getRepository(NpcComment::class);

        $questRepository = $this->getDoctrine()->getRepository(Quest::class);
        $questCommentRepository = $this->getDoctrine()->getRepository(QuestComment::class);

        $commentLikeRepository = $this->getDoctrine()->getRepository(CommentLike::class);

        $comments = [];
        $object = null;
        try {
            $mainRep = eval("return $" . $type . "Repository;");
            $secondRep = eval("return $" . $type . "CommentRepository;");

        } catch (\Throwable $e) {
            return new JsonResponse("BAD REQUEST", Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
        }

        $object = $mainRep->findOneById($type_id);
        if ($object) {
            $comments = $secondRep->findBy([$type => $object]);
        }

        $data = [];

        foreach ($comments as $comment) {
            $comment = $comment->getComment();

            $editable = false;
            if ( $this->getUser() != null) {
                $editable = ($comment->getUser()->getId() == $this->getUser()->getId());
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

        return new JsonResponse(json_encode($data), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function deleteComment(Request $request, $comment_id) : JsonResponse
    {
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $entityManager  = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $comment = $commentRepository->findOneById($comment_id);
        if (!$comment) {
            return new JsonResponse(json_encode("Bad Request"), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
        }
        else {
            $comment->dropForeignKeys($this->getDoctrine());
        }

        if (! ($user == $comment->getUser()
            || in_array($user->getRoles(), ["ROLE_ADMIN", "ROLE_MOD"])) )
            return new JsonResponse(json_encode("Unauthorized"), Response::HTTP_UNAUTHORIZED, ['content-type' => 'application/json']);

        $entityManager->remove($comment);
        $entityManager->flush();

        return new JsonResponse(json_encode("OK"), Response::HTTP_OK, ['content-type' => 'application/json']);
    }

    public function editComment(Request $request, $comment_id) : JsonResponse
    {
        $entityManager = $this->getDoctrine()->getManager();
        $commentRepository = $this->getDoctrine()->getRepository(Comment::class);
        $data = $request->toArray();

        $comment = $commentRepository->findOneById($comment_id);
        if (!$comment) {
            return new JsonResponse(json_encode("Bad Request"), Response::HTTP_BAD_REQUEST, ['content-type' => 'application/json']);
        }

        if ($this->getUser() != $comment->getUser())
            return new JsonResponse(json_encode("Unauthorized"), Response::HTTP_UNAUTHORIZED, ['content-type' => 'application/json']);

        $comment->setComment($data['comment']);
        $comment->setLastEdit(new \DateTime('@' . strtotime('now')));
        $entityManager->flush($comment);

        return new JsonResponse(json_encode("OK"), Response::HTTP_OK, ['content-type' => 'application/json']);
    }
}