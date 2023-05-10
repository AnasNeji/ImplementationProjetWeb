<?php


namespace App\Controller;


use App\Form\ChangePasswordType;
use App\Form\UserType;
use App\Repository\PariRepository;
use App\Repository\PariSingulierRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends AbstractController
{
    /**a
     * @Route("/profile/{id}, name="profile")
     */
    public function profile($id, UserRepository $userRepository, ManagerRegistry $doctrine, Request $request, PariRepository $PariRepository, PariSingulierRepository $repository): Response
    {
//        $session = $request->getSession();
//        if (!($session->has('user_id'))) {return $this->redirect('/login');};
//        $connecteduser=$userRepository->findOneBy(['Username' => $session['Username']]);
        $user = $userRepository->findById($id);
//        if(!$user ||$id!=$connecteduser->getId())
//        {
//            return($this->redirect('/home'));
//        }
        $paris = $PariRepository->findByUserId($id);
        $PasswordForm = $this->createForm(ChangePasswordType::class);
        $form=$this->createForm(UserType::class,$user[0]);
        $entityManager = $doctrine->getManager();


        $form->handleRequest($request);
/*
        if (($form->isSubmitted())&&($form->isValid())) {

                    $entityManager->persist($user[0]);
                    $entityManager->flush();
                    return $this->render('profile/index.html.twig', [
                        'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                        'Passwordform' => $PasswordForm->createView(),'message'=>''
                    ]);

                }*/


        $PasswordForm->handleRequest($request);

        if ($PasswordForm->isSubmitted() ) {
            if (($PasswordForm->isValid())) {

                $data = $PasswordForm->getData();

                // Check if the old password is correct
                $oldPassword = $data['oldPassword'];
                $newPassword = $data['newPassword'];
                $confirmNewPassword = $data['confirmNewPassword'];
                if (!($oldPassword == $user[0]->getPassword())) {
                    $message = "Ancien Mot de Passe erroné";
                    return $this->render('profile/ChangePassword.html.twig', [
                        'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                        'Passwordform' => $PasswordForm->createView(), 'message' => $message,
                    ]);
                } // Set the new password

                else {
                    if ($confirmNewPassword == $newPassword) {
                        $user[0]->setPassword($newPassword);
                        $result = 1;
                        $entityManager->persist($user[0]);
                        $entityManager->flush();

                        $this->addFlash('success', 'Your password has been changed.');
                        return $this->render('profile/index.html.twig', [
                            'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                            'Passwordform' => $PasswordForm->createView(),
                        ]);
                    } else {
                        $message = "Mots de passe non conformes";
                        return $this->render('profile/ChangePassword.html.twig', [
                            'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                            'Passwordform' => $PasswordForm->createView(), 'message' => $message,
                        ]);
                    }
                }
            }
            return $this->render('profile/ChangePassword.html.twig', [
                'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                'Passwordform' => $PasswordForm->createView(),'message'=>"veuillez remplir le form à nouveau"
            ]);
        }

        if ($form->isSubmitted() && ($form->isValid())) {

            $entityManager->persist($user[0]);
            $entityManager->flush();
            return $this->render('profile/index.html.twig', [
                'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
                'Passwordform' => $PasswordForm->createView(),
            ]);


        }

        // Render the Twig template with user data as variables
        return $this->render('profile/index.html.twig', [
            'user' => $user[0], 'paris' => $paris, 'form' => $form->createView(), 'repository' => $repository,
            'Passwordform' => $PasswordForm->createView(),
        ]);
    }
    /*


public function profile($id,Request $request,UserRepository $userRepository,ManagerRegistry $doctrine ): Response
{

    $user=$userRepository->findById($id);
    // Create the form
    $form = $this->createForm(UserType::class, $user);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $doctrine->getManager();
        $entityManager->flush();

        return $this->redirectToRoute('profile', ['id' => $id]);
    }

    return $this->render('profile.html.twig', [
        'form' => $form->createView(),
        'user' => $user,
    ]);




}*/


}

