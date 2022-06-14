<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function index(Request $request,  MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $email = (new TemplatedEmail())
                ->from(new Address($contact['email'], $contact['firstName'] . ' ' . $contact['lastName']))
                ->to(new Address('manga.samadjine@3wa.io'))
                ->subject('Nous contacter ♥ Les Amoureux du Chocolat ♥')
                ->htmlTemplate('contact/contact_email.html.twig')
                ->context([
                    'firstName' => $contact['firstName'],
                    'lastName' => $contact['lastName'],
                    'emailAddress' => $contact['email'],
                    'phone' => $contact['phone'],
                    'message' => $contact['message'],
                    // ''
                ]);
            $mailer->send($email);
            $this->addFlash('succes', 'Votre message a été envoyé');
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
