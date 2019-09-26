<?php

namespace App\Controller;

use App\Entity\Team\EsportMember;
use App\Entity\Team\Role;
use App\Form\ContactForm;
use App\Repository\Team\MemberRepository;
use Swift_Mailer;
use Swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/team")
 */
class TeamController extends AbstractController
{
    /**
     * @Route("/a-propos", name="about", methods={"GET"})
     */
    public function about(MemberRepository $memberRepository): Response
    {
        return $this->render(
            'views/team/about.html.twig',
            [
                'direction' => $memberRepository->getByCategory(Role::CATEGORY_DIRECTION),
                'administration' => $memberRepository->getByCategory(Role::CATEGORY_ADMINISTRATION),
                'members' => $memberRepository->getByCategory(Role::CATEGORY_MEMBERS),
                'esports' => $this->getDoctrine()->getRepository(EsportMember::class)->findAll(),
            ]
        );
    }

    /**
     * @Route("/contact", name="contact", methods={"GET", "POST"})
     */
    public function contact(Request $request, Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = new Swift_Message();
            $message->setFrom($data['email'])
                ->setSubject($data['nickname'].': '.$data['subject'])
                ->setTo('contact@gameher.fr')
                ->setBody($data['message']);

            $mailer->send($message);

            $this->addFlash('success', 'message sent');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
        }

        return $this->render(
            'views/team/contact.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/recruitment", name="recruitment", methods={"GET", "POST"})
     */
    public function recruitment(Request $request, Swift_Mailer $mailer): Response
    {
        $form = $this->createForm(ContactForm::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $message = new Swift_Message();
            $message->setFrom($data['email'])
                ->setSubject($data['nickname'].': '.$data['subject'])
                ->setTo('recrutement@gameher.fr')
                ->setBody($data['message']);

            $mailer->send($message);

            $this->addFlash('success', 'message sent');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            foreach ($form->getErrors() as $error) {
                $this->addFlash('danger', $error->getMessage().$error->getCause());
            }
        }

        return $this->render(
            'views/team/recruitment.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
