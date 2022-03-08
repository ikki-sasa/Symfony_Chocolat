<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'product_index')]
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/product/{id}', name: 'product_view')]
    public function view(ProductRepository $productRepository, int $id): Response
    {
        return $this->render('product/view.html.twig', [
            'product' => $productRepository->find($id)
        ]);
    }

    #[Route('/admin/products', name: 'admin_product_index')]
    public function adminIndex(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin/products.html.twig', [
            'products' => $products
        ]);
    }

    #[Route('/admin/product/create', name: 'product_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $firstImg = $form['img']->getData();
            $extensionFirstImg = $firstImg->guessExtension();
            $nameImg1 = time() . '-1' . $extensionFirstImg;
            $firstImg->move($this->getParameter('dossier_photos_category'), $nameImg1);
            $product->setImg($nameImg1);
            $secondImg = $form['img2']->getData();
            if ($secondImg !== null) {
                $extensionSecondImg = $secondImg->guessExtension();
                $nameImg2 = time() . '-2.' . $extensionSecondImg;
                $secondImg->move($this->getParameter('dossier_photos_category'), $nameImg2);
                $product->setImg2($nameImg2);
            } else {
                $product->setImg2('null');
            }
            $product->setPublishedAt(new \DateTimeImmutable());
            $manager = $managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été ajouté.');
            return $this->redirectToRoute('admin_product_index');
        }
        return $this->render('admin/productForm.html.twig', [
            'productForm' => $form->createView()
        ]);
    }

    #[Route('/admin/product/update/{id}', name: 'product_update')]
    public function update(ProductRepository $productRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $product = $productRepository->find($id);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstImg = $form['img']->getData();
            $nameOldImg = $product->getImg();
            if ($firstImg !== null) {
                $oldPathImg = $this->getParameter('dossier_photos_category') . '/' . $nameOldImg;
                if (file_exists($oldPathImg)) {
                    unlink($oldPathImg);
                }
                $extensionFirstImg = $firstImg->guessExtension();
                $nameImg1 = time() . '-1' . $extensionFirstImg;
                $firstImg->move($this->getParameter('dossier_photos_category'), $nameImg1);
                $product->setImg($nameImg1);
            } else {
                $product->setImg($nameOldImg);
            }
            $secondImg = $form['img2']->getData();
            $nameOldImg2 = $product->getImg2();
            if ($secondImg !== null) {
                if ($nameOldImg2 !== null) {
                    $oldPathImg2 = $this->getParameter('dossier_photos_category') . '/' . $nameOldImg2;
                    if (file_exists($oldPathImg2)) {
                        unlink($oldPathImg2);
                    }
                }
                $extensionSecondImg = $secondImg->guessExtension();
                $nameImg2 = time() . '-1' . $extensionSecondImg;
                $secondImg->move($this->getParameter('dossier_photos_category'), $nameImg2);
                $product->setImg2($nameImg2);
            } else {
                $product->setImg2($nameOldImg2);
            }
            $manager = $managerRegistry->getManager();
            $manager->persist($product);
            $manager->flush();
            $this->addFlash('success', 'Le produit a bien été modifié.');
            return $this->redirectToRoute('admin_product_index');
        }

        return $this->render('admin/productForm.html.twig', [
            'productForm' => $form->createView(),
            'product' => $product
        ]);
    }

    #[Route('/admin/product/delete/{id}', name: 'product_delete')]
    public function delete(ProductRepository $productRepository, ManagerRegistry $managerRegistry, int $id)
    {
        $product = $productRepository->find($id);
        $firstImg = $product->getImg();
        if ($firstImg !== null) {
            $oldPathImg = $this->getParameter('dossier_photos_category') . '/' . $firstImg;
            if (file_exists($oldPathImg)) {
                unlink($oldPathImg);
            }
        }
        $manager = $managerRegistry->getManager();
        $manager->remove($product);
        $manager->flush();
        $this->addFlash('success', 'Le produit a bien été supprimé ');
        return $this->redirectToRoute('admin_product_index');
    }
}
