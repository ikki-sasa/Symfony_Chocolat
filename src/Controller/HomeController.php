<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository, ArticleRepository $articleRepository): Response
    {

        $products = $productRepository->findLastThree();
        $category = $categoryRepository->findLastThree();
        $articles = $articleRepository->findThisThree();
        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $category,
            'articles' => $articles
        ]);
    }
}
