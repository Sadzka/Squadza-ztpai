<?php
// src/Controller/ArticleController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController {

    
/*
	private $messages = [];
	const MAX_FILE_SIZE = 1024 * 1024;
	const SUPPORTED_TYPES = ['image/png', 'image/jpeg'];
    const UPLOAD_DIRECTORY = '/../public/uploads/articles-icons/';
    
	private function validateImage($file) : bool {

		if ($file['size'] > self::MAX_FILE_SIZE) {
			$this->messages[] = 'File is too large. Max size is'. self::MAX_FILE_SIZE . '.';
			return false;
		}
		
		if (isset($file['type']) && !in_array($file['type'], self::SUPPORTED_TYPES)) {
			$this->messages[] = 'Invalid file format';
			return false;
		}
		return true;
    }
    
    public function index()
    {
        $articles = ArticleRepository::getInstance()->getArticles();
        $this->render('index', ['articles' => $articles]);
    }

    public function newArticle()
    {

        if ($this->currentUser == null
        || !$this->currentUser->haveModPerms()) {
            $this->messages[] = 'All fields all required.';
            return $this->render('newArticle', ['messages' => $this->messages]);
        }
        
		if (!$this->isPost()) {
            return $this->render('newArticle');
        }

        $failed = false;

		if (!isset($_POST['title'])
		||  !isset($_POST['body'])
		||  !isset($_FILES['file']['tmp_name'])) {
            $this->messages[] = 'All fields all required.';
            $failed = true;
        }

        if (strlen($_POST['title']) < 8) {
            $this->messages[] = 'Title must have minimum 8 characters.';
            $failed = true;
        }

        if (strlen($_POST['body']) < 32) {
            $this->messages[] = 'Content must have minimum 32 characters.';
            $failed = true;
        }

        if ($failed) {
            return $this->render('newArticle', ['messages' => $this->messages]);
        }
        
        $title = $_POST['title'];
        $content = $_POST['body'];

        $content = str_replace("\n", "<br>", $content);

        if ($this->isPost()
		&& is_uploaded_file( $_FILES['file']['tmp_name'])
		&& $this->validateImage($_FILES['file']))
		{
			$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
			$filename = $title . '_' . bin2hex(random_bytes(16)) . '.' . $ext;

			if (move_uploaded_file(
			$_FILES['file']['tmp_name'],
			dirname(__DIR__) . self::UPLOAD_DIRECTORY . $filename
			)) {
				ArticleRepository::getInstance()->addArticle($title, $content, $filename);
				$this->messages[] = 'Article added.';
			}
			else {
				$this->messages[] = 'Unknown error. Try again.';
			}
        }
        else {
            $this->messages[] = 'Unknown image type.';
        }
        
        $this->render('newArticle', ['messages' => $this->messages]);
    }

    public function article() {
        if (isset($_GET['id'])) {
            $this->messages[] = 'Article not found.';
        }

        $article = ArticleRepository::getInstance()->getArticleById($_GET['id']);

        if ($article == null) {
            $this->messages[] = 'Article not found.';
        }

        $this->render('article', ['messages' => $this->messages, 'article' => $article]);
    }
*/
}