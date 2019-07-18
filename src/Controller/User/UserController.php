<?php

namespace App\Controller\User;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @IsGranted("ROLE_USER")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/profile", name="display_profile", methods={"GET"})
     */
    public function displayProfileAction(Security $security)
    {
        $user = $security->getUser();

        $form = $this->createFormBuilder($user)
            ->add('displayName', TextType::class)
            ->add('twitter', TextType::class, ['required' => false])
            ->add('twitch', TextType::class, ['required' => false])
            ->add('youtube', TextType::class, ['required' => false])
            ->add('instagram', TextType::class, ['required' => false])
            ->add('discord', TextType::class, ['required' => false])
            ->add('facebook', TextType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
            ->getForm();

        return $this->render('views/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/profile", name="update_profile", methods={"POST"})
     */
    public function updateProfileAction(Request $request, Security $security)
    {
        $user = $security->getUser();

        $form = $this->createFormBuilder($user)
            ->add('displayName', TextType::class)
            ->add('twitter', TextType::class, ['required' => false])
            ->add('twitch', TextType::class, ['required' => false])
            ->add('youtube', TextType::class, ['required' => false])
            ->add('instagram', TextType::class, ['required' => false])
            ->add('discord', TextType::class, ['required' => false])
            ->add('facebook', TextType::class, ['required' => false])
            ->add('save', SubmitType::class, ['label' => 'Sauvegarder'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Profil mis à jour');
            $this->getDoctrine()->getManager()->flush($user);
        }

        return $this->render('views/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
