<?php

namespace App\Controller;

use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\CommentRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/admin/user', name: 'user_admin_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('admin/adminUser.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/admin/user/delete/{id}', name: 'user_delete', methods: ['GET'])]
    public function delete(UserRepository $userRepository, int $id, ManagerRegistry $managerRegistry): Response
    {
        $user = $userRepository->find($id);
        $manager = $managerRegistry->getManager();
        $manager->remove($user);
        $manager->flush();
        $this->addFlash('success', 'L\'utilisateur a bien été supprimer.');
        return $this->redirectToRoute('user_admin_index');
    }

    #[Route('/user', name: 'user_index')]
    public function users(UserRepository $userRepository, CommentRepository $commentRepository): Response
    {
        $comments = $commentRepository->findBy(["user_id" => $this->getUser()]);
        $user = $userRepository->find($this->getUser()->getId());
        return $this->render('user/user.html.twig', [
            'comments' => $comments,
            'user' => $user
        ]);
    }
    #[Route('/user/update/{id}', name: 'user_update')]
    public function update(UserRepository $userRepository, int $id, Request $request, ManagerRegistry $managerRegistry)
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $managerRegistry->getManager();
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Vos informations ont bien été modifiées.');
            return $this->redirectToRoute('user_index');
        }


        return $this->render('user/user_update.html.twig', [
            'userForm' => $form->createView(),
            'user' => $user
        ]);
    }
}
