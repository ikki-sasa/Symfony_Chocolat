<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'category_admin_index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();
        return $this->render('category/adminIndex.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/admin/category/new', name: 'category_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry)
    {
        $category = new Category(); //create new category
        $form = $this->createForm(CategoryType::class, $category); //create the form with the parameter of new Category
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cateImg = $form['img']->getData();
            $extensionImg = $cateImg->guessExtension();
            $nameImg = time() . '.' . $extensionImg;

            $cateImg->move($this->getParameter('dossier_photos_category'), $nameImg);
            $category->setImg($nameImg);

            $category->setSlug($form['name']->getData());

            $manager = $managerRegistry->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été ajoutée.');
            return $this->redirectToRoute('category_admin_index');
        }
        return $this->render('category/categoryForm.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    #[Route('/admin/category/update/{id}', name: 'category_update')]
    public function update(CategoryRepository $categoryRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $category = $categoryRepository->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cateImg = $form['img']->getData();
            $nameOldImg = $category->getImg();
            if ($cateImg !== null) {
                $pathOldimg = $this->getParameter('dossier_photos_category') . '/' .
                    $nameOldImg;
                if (file_exists($pathOldimg)) {
                    unlink($pathOldimg);
                }
                $extensionImg = $cateImg->guessExtension();
                $nameImg = time() . '.' . $extensionImg;
                $cateImg->move($this->getParameter('dossier_photos_category'), $nameImg);
                $category->setImg($nameImg);
            } else {
                $category->setImg($nameOldImg);
            }

            $manager = $managerRegistry->getManager();
            $manager->persist($category);
            $manager->flush();
            $this->addFlash('success', 'La catégorie a bien été modifiée.');
            return $this->redirectToRoute('category_admin_index');
        }

        return $this->render('category/categoryForm.html.twig', [
            'categoryForm' => $form->createView()
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'category_delete')]
    public function delete(CategoryRepository $categoryRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $category = $categoryRepository->find($id);
        $nameImg = $category->getImg();
        if ($nameImg !== null) {
            $pathImg = $this->getParameter('dossier_photos_category') . '/' . $nameImg;
            if (file_exists($pathImg)) {
                unlink($pathImg);
            }
        }

        $manager = $managerRegistry->getManager();
        $manager->remove($category);
        $manager->flush();
        $this->addFlash('success', 'La catégorie a bien été supprimée.');
        return $this->redirectToRoute('category_admin_index');
    }
}
