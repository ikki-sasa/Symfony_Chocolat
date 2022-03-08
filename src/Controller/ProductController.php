<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    // #[Route('/products', name: 'product_index')]
    // public function index(ProductRepository $productRepository): Response
    // {
    //     $products = $productRepository->findAll();
    //     return $this->render('product/index.html.twig', [
    //         'products' => $products
    //     ]);
    // }

    // #[Route('/product/{id}', name: 'product_view')]
    // public function view(ProductRepository $productRepository, int $id): Response
    // {
    //     return $this->render('product/view.html.twig', [
    //         'product' => $productRepository->find($id)
    //     ]);
    // }

    // #[Route('/admin/products',)]
}
