<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

class ContactController extends AbstractController
{
    /**
     * @Route("/", name="contact")
     */
    public function index(Request $request, MailerInterface $mailer)
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $contactFormData = $form->getData();
            
            $message = (new Email())
            ->from('stageservicepublic@gmail.com')
            ->to('stageservicepublic@gmail.com')
            ->subject('Nouvelle demande')
            ->text('Nom :'.$contactFormData['nom'].\PHP_EOL.
                      'Email : '.$contactFormData['email'].\PHP_EOL.
                      'Numéro : '.$contactFormData['numero'].\PHP_EOL.
                      'Demande : '.$contactFormData['message'],
                    'text/plain');
            $mailer->send($message);
            $message = (new TemplatedEmail())
            ->from('stageservicepublic@gmail.com')
            ->to($contactFormData['email'])
            ->subject('accusé de réception ')
            ->htmlTemplate('mailler/message.html.twig')
            ->context([
                 'nom'=> $contactFormData['nom']
                ]);
            $mailer->send($message);

            $this->addFlash('success', 'Vore message a été envoyé');

            return $this->redirectToRoute('home');
        }

        return $this->render('home/home.html.twig', [
            'contactForm' => $form->createView()
        ]);
    }
    
}