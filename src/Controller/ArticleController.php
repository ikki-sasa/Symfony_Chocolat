<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use CodeInc\StripAccents\StripAccents;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    #[Route('/admin/article', name: 'article_admin_index')]
    public function index(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findAll();
        return $this->render('admin/adminArticleIndex.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/articles', name: 'article_index')]
    public function articles(ArticleRepository $articleRepository): Response
    {
        $articles = $articleRepository->findBy(['category' => 2], ['name' => 'ASC']);
        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/article/{slug}', name: 'article_category')]
    public function article($slug, ArticleRepository $articleRepository, CategoryRepository $categoryRepository): Response
    {
        $article = $articleRepository->findOneBy(['slug' => $slug]);
        $sousArticles = $articleRepository->findBy(['category' => $article->getId()]);

        if (!empty($sousArticles)) {
            return $this->render('article/article.html.twig', [
                'article' => $article,
                'sousArticles' => $sousArticles
            ]);
        } else {
            $categories = $categoryRepository->findBy(['articles_id' => $article->getId()], ['comment' => 'ASC']);
        }

        return $this->render('article/index.html.twig', [
            'article' => $article,
            'categories' => $categories
        ]);
    }

    #[Route('/admin/article/new', name: 'article_create')]
    public function create(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $slug = StripAccents::strip(str_replace([' ', '\'', '"', '&'], ['-', '-', '-', 'et'], strtolower($form['title']->getData())));
            $article->setSlug($slug);

            $artImg = $form['featured_img']->getData();
            $extensionImg = $artImg->guessExtension();
            $nameImg = time() . '.' . $extensionImg;

            $artImg->move($this->getParameter('dossier_photos_category'), $nameImg);
            $article->setFeaturedImg($nameImg);

            $article->setCreatedAt(new \DateTime);

            $article->setUserId($this->getUser());

            $manager = $managerRegistry->getManager();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('success', 'L\'article a bien été ajoutée.');
            return $this->redirectToRoute('article_admin_index');
        }
        return $this->render('admin/adminArticleForm.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    #[Route('/admin/article/update/{id}', name: 'article_update')]
    public function update(ArticleRepository $articleRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $article = $articleRepository->find($id);
        $form = $this->createForm(Article::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slug = StripAccents::strip(str_replace([' ', '\'', '"', '&'], ['-', '-', '-', 'et'], strtolower($form['name']->getData())));
            $article->setSlug($slug);
            $artImg = $form['featured_img']->getData();
            $nameOldImg = $article->getFeaturedImg();
            if ($artImg !== null) {
                $pathOldImg = $this->getParameter('dossier_photos_category') . '/' .
                    $nameOldImg;
                if (file_exists($pathOldImg)) {
                    unlink($pathOldImg);
                }
                $extensionImg = $artImg->guessExtension();
                $nameImg = time() . '.' . $extensionImg;
                $artImg->move($this->getParameter('dossier_photos_category'), $nameImg);
                $article->setFeaturedImg($nameImg);
            } else {
                $article->setFeaturedImg($nameOldImg);
            }

            $article->setUpdatedAt(new \DateTime);

            $manager = $managerRegistry->getManager();
            $manager->persist($article);
            $manager->flush();
            $this->addFlash('success', 'L\'article a bien été modifiée.');
            return $this->redirectToRoute('article_admin_index');
        }

        return $this->render('admin/adminArticleForm.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    #[Route('/admin/article/delete/{id}', name: 'article_delete')]
    public function delete(ArticleRepository $articleRepository, int $id, ManagerRegistry $managerRegistry)
    {
        $article = $articleRepository->find($id);
        $nameImg = $article->getFeaturedImg();
        if ($nameImg !== null) {
            $pathImg = $this->getParameter('dossier_photos_category') . '/' . $nameImg;
            if (file_exists($pathImg)) {
                unlink($pathImg);
            }
        }

        $manager = $managerRegistry->getManager();
        $manager->remove($article);
        $manager->flush();
        $this->addFlash('success', 'L\'article a bien été suprimée.');
        return $this->redirectToRoute('article_admin_index');
    }

    // 1. articles (crud)
    // 2. user (register, login, logout, email, crud)
    // 3. comment (crud)
}
