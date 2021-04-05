<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{
    const newsPerPage = 3;

    public function page($number = 1) : Response
    {
        if ($number <= 0) $number = 1;

        $articles = $this->getDoctrine()
        ->getRepository(Article::class)
        ->findBy(
            array(),
            array('date' => 'DESC'),
            self::newsPerPage,
            ($number - 1) * self::newsPerPage
        );

        return $this->render('homepage.html.twig', [
            'articles' => $articles,
        ]);
    }

    public function article($article_id) : Response
    {
        $article = $this->getDoctrine()
        ->getRepository(Article::class)
        ->findOneBy(
            array('id' => $article_id)
        );

        return $this->render('article/article.html.twig', [
            'article' => $article,
        ]);
    }
    
    public function newArticle() : Response
    {
        return $this->render('article/newArticle.html.twig');
    }

    public function editArticle($article_id) : Response
    {
        
    }
}

