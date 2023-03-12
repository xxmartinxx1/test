<?php

namespace MartinBundle\Controller;

use MartinBundle\Form\AddUserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use MartinBundle\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;




class DefaultController extends Controller
{

    public function indexAction()
    {

        $allUsers = $this->get('app.user_service')->getAllUser();

        $repo = $this->get('MartinBundle\Repository\UserRepository');
        $allUser = $repo->findAllUser();

        return $this->render('MartinBundle:Default:index.html.twig',[
            'users' => $allUser
        ]);
    }

    public function user_pageAction($id, UserService $userService = null)
    {
        if ($userService === null) {
            $userService = $this->get('app.user_service');
        }

        $user = $userService->getOneUser($id);

        return $this->render('MartinBundle:Default:user-page.html.twig',[
            'user' => $user
        ]);
    }

    public function addUserAction(Request $request): Response
    {

        $data = [
            'name' => 'test',
            'email' => 'test@example.com',
        ];

        $form = $this->createForm('MartinBundle\Form\AddUserType', $data);
        $form->handleRequest($request);

        $return = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            dump($data);
            $repo = $this->get('MartinBundle\Repository\UserRepository');
            $return = $repo->addUser($data['name'], $data['email']);

            // przekieruj użytkownika na stronę sukcesu
            //return $this->redirectToRoute('user_add_page');
        }

        return $this->render('MartinBundle:Default:user-add-page.html.twig', [
            'form' => $form->createView(),
            'message' => $return,
        ]);
    }
}
