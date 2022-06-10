<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
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



    #[Route('/users', name: 'user_index')]
    public function users(UserRepository $userRepository): Response
    {
        $user = $userRepository->find($this->getUser());
        return $this->render('user/user.html.twig', [
            'user' => $user
        ]);
        // version qui fonctionne vite fais
    }

    // #[Route('/users/{id}', name: 'user_index', methods: ['GET'])]
    // public function show(User $user): Response
    // {

    //     return $this->render('user/index.html.twig', [
    //         'user' => $user,
    //     ]);
    // }

    // #[Route('/users/{id}', name: 'user_index')]
    // public function show(UserRepository $userRepository, int $id)
    // {
    //     $id = $userRepository->find($id);
    //     return $this->render('user/index.html.twig');
    // }

    // #[Route('/users/{id}', name: 'user_index', methods: ['GET'])]
    // public function show(User $users, UserRepository $userRepository, int $id): Response
    // {
    //     $users = $userRepository->find($id);
    //     return $this->render('user/index.html.twig', [
    //         'users' => $users
    //     ]);
    // }

}
