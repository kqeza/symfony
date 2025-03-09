<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

final class UserController extends AbstractController
{

    #[Route('/user', name: 'index_user', methods: ['GET'])]
    public function index(UserRepository $userRepository,  Request $request, EntityManagerInterface $em): Response
    {
        $qb = $userRepository->createQueryBuilder('u');
        $qb->andWhere('u.last_name LIKE :search OR u.email LIKE :search')
            ->setParameter('search', '' . $request->query->get('search') . '%');
        $users = $qb->getQuery()->getResult();
        return $this->render('/user/index.html.twig', ['users' => $users]);
    }

    #[Route('/user/{user}', name: 'delete_user', methods: ["DELETE"])]
    public function delete(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();
        return $this->redirect('/user');
    }

    #[Route('/user/{user}/edit', name: 'update_user', methods: ["PUT"])]
    public function update(User  $user, Request $request, EntityManagerInterface $em): Response
    {
        $user->setFirstName($request->request->get('first_name'));
        $user->setLastName($request->request->get('last_name'));
        $user->setAge($request->request->get('age'));
        $user->setEmail($request->request->get('email'));
        $user->setTelegram($request->request->get('telegram'));
        $user->setAddress($request->request->get('address'));
        $em->flush();
        return $this->redirect('/user');
    }

    #[Route('/user/{user}/edit', name: 'edit_user', methods: ["GET"])]
    public function edit(User  $user): Response
    {
        return $this->render('/user/editUser.html.twig', ['user' => $user]);
    }

    #[Route('/user', name: 'create_user', methods: ['POST'])]
    public function create(EntityManagerInterface $em, Request $request): Response
    {
        $user = new User();
        $user->setFirstName($request->request->get('first_name'));
        $user->setLastName($request->request->get('last_name'));
        $user->setAge($request->request->get('age'));
        $user->setStatus($request->request->get('status'));
        $user->setTelegram($request->request->get('telegram'));
        $user->setEmail($request->request->get('email'));
        $user->setAddress($request->request->get('address'));


        $em->persist($user);
        $em->flush();

        return $this->redirect('/user');
    }

    #[Route('/user/create')]
    public function formCreate(): Response
    {
        return $this->render('user/createUser.html.twig');
    }
}
