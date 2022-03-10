<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/admin/article', name: 'article_admin_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('admin/adminArticleIndex.html.twig', [
            'articles' => $articles,
        ]);
    }
    // #[Route('/article', name: 'article')]
    // public function index(): Response
    // {
    //     return $this->render('article/index.html.twig', [
    //         'controller_name' => 'ArticleController',
    //     ]);
    // }
    // #[Route('/article', name: 'article')]
    // public function index(): Response
    // {
    //     return $this->render('article/index.html.twig', [
    //         'controller_name' => 'ArticleController',
    //     ]);
    // }
    // #[Route('/article', name: 'article')]
    // public function index(): Response
    // {
    //     return $this->render('article/index.html.twig', [
    //         'controller_name' => 'ArticleController',
    //     ]);
    // }

    // 1. articles (crud)
    // 2. user (register, login, logout, email, crud)
    // 3. comment (crud)
}
