<?php
// src/Controller/ItemController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ItemController extends AbstractController {
    
    public function item()
    {
        return $this->render('item/item.html.twig');
    }
    
/*
require_once 'AppController.php';
require_once __DIR__ . '/../repository/ItemRepository.php';

class ItemController extends AppController {
	
    public function item()
    {
        if (!$this->isGet()) {
            return;
        }
        $this->render('item');
    }

    public function itemSearch()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $items = ItemRepository::getInstance()->searchItems($decoded);
            echo json_encode($items);
        }
    }

    public function itemRender()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $item = ItemRepository::getInstance()->getItem($decoded['id']);

            echo include_once(__DIR__ . '/../common/renderItem.php');
        }
    }

    public function itemComments()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $comments = ItemRepository::getInstance()->getItemComments($decoded['id']);
            if ($this->currentUser != null) {
                foreach ($comments as $key => $comment) {
                    if ($this->currentUser->getUsername() == $comment['username']) {
                        $comments[$key]['editable'] = 1;
                    } else {
                        $comments[$key]['editable'] = 0;
                    }
                }
            } else {
                foreach ($comments as $key => $comment) {
                    $comments[$key]['editable'] = 0;
                }
            }

            echo json_encode($comments);
        }
    }

    public function setItemCommentVote()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $ok = '';
            if ($this->currentUser != null)
            {
                $ok = ItemRepository::getInstance()->setItemCommentVote(
                    $decoded['comment_id'],
                    $this->currentUser->getId(),
                    $decoded['value']
                );
            } else {
                $ok = ['err' => 'Login to vote!'];
            }
            echo json_encode($ok);
        }
    }

    public function getItemCommentsResponse()
    {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $responses = '';
            if ($this->currentUser != null)
            {
                $responses = ItemRepository::getInstance()->getItemCommentsResponse(
                    $decoded['comment_ids'],
                    $this->currentUser->getId()
                );
            } else {
                $responses = '';
            }
            
            echo json_encode($responses);
        }
    }

    public function deleteComment() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $responses = ItemRepository::getInstance()->deleteItemComment(
                $decoded['item_comment_id'],
                $this->currentUser->getId(),
                $this->currentUser->getPermissions()
            );
            
            //echo $responses;
        }
    }

    public function addComment() {
        $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

        if ($contentType === "application/json") {
            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            header('Content-type: application/json');
            http_response_code(200);

            $data = ItemRepository::getInstance()->addItemComment(
                $decoded['item_id'],
                $this->currentUser->getId(),
                $decoded['comment']
            );

            $response = [];
            $response['username'] = $this->currentUser->getUsername();
            $response['date'] = $data['date'];
            $response['items_comment_id'] = $data['items_comment_id'];

            echo json_encode($response);
        }
    }
*/
}

