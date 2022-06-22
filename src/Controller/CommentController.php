<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Reponse;
use App\Form\ReplyType;
use App\Form\CommentType;
use App\Repository\UserRepository;
use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    #[Route('admin/comment', name: 'comment_admin_index', methods: ['GET'])]
    public function index(CommentRepository $commentRepository): Response
    {
        return $this->render('admin/adminComment.html.twig', [
            'comments' => $commentRepository->findAll(),
        ]);
    }

    #[Route('/comment/new/{id}', name: 'comment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $managerRegistry, int $id, ArticleRepository $articleRepository): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        $article = $articleRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticlesId($article);
            $comment->setCommentStatus(false);
            $comment->setUserId($this->getUser());
            $comment->setCreatedAt(new \DateTime);
            $manager = $managerRegistry->getManager();
            $manager->persist($comment);
            $manager->flush();

            return $this->redirectToRoute('article_index', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('success', 'Votre commentaire à bien été envoyé, il sera traité dans un bref délai merci ! ');
        return $this->render('comment/user_comment.html.twig', [
            'commentForm' => $form->createView(),
            'article' => $article
        ]);
    }

    #[Route('/comment/{id}', name: 'comment_show', methods: ['GET'])]
    public function show(Comment $comment, CommentRepository $commentRepository): Response
    {
        $comment = $commentRepository->findBy(['user' => $this->getUser()]);
        return $this->render('comment/show.html.twig', [
            'comments' => $comment,
        ]);
    }




    #[Route('/admin/comment/{id}/edit', name: 'comment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comment $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/admin/comment/delete/{id}', name: 'comment_delete')]
    public function delete(CommentRepository $commentRepository, int $id, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $comment = $commentRepository->find($id);
        $manager->remove($comment);
        $manager->flush();


        return $this->redirectToRoute('comment_admin_index', [], Response::HTTP_SEE_OTHER);
    }


    #[Route('/admin/comment/publish/{id}', name: 'comment_publish')]
    public function publish(int $id, CommentRepository $commentRepository, ManagerRegistry $managerRegistry): Response
    {
        $manager = $managerRegistry->getManager();
        $comment = $commentRepository->find($id);
        $publish = $comment->getCommentStatus();

        if ($publish == 0) {
            $comment->setCommentStatus('1');
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('success', 'Le commentaire est publié');
            return $this->redirectToRoute('comment_admin_index', [], Response::HTTP_SEE_OTHER);
        } elseif ($publish == 1) {
            $comment->setCommentStatus('0');
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash('danger', 'Le commentaire outrageu a été retirer');
            return $this->redirectToRoute('comment_admin_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    #[Route('/admin/reponse/{id}', name: 'comment_reply')]
    public function reply(int $id, CommentRepository $commentRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $reponse = new Reponse();
        $form = $this->createForm(ReplyType::class, $reponse);
        $form->handleRequest($request);
        $comment = $commentRepository->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $reponse->setFkcomment($comment);
            $manager->persist($reponse);
            $manager->flush();

            return $this->redirectToRoute('comment_admin_index');
        }

        return $this->render('admin/replycomments.html.twig', [
            'formAnswer' => $form->createView()
        ]);
    }
}
