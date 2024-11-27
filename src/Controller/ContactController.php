<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use App\Form\LeavePeriodType;
use App\Model\Contact;
use App\Model\ContactType as ModelContactType;
use App\Model\LeavePeriod;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
    ): Response {
        $contact = new Contact();
        $contact->setType(ModelContactType::Company);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($contact);
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/leave/new', methods: ['GET', 'POST'])]
    public function newLeavePeriod(
        Request $request,
        MailerInterface $mailer,
    ): Response {
        $leavePeriod = new LeavePeriod();
        $form = $this->createForm(LeavePeriodType::class, $leavePeriod, [
            'validation_groups' => ['Default', 'planning']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $message = new TemplatedEmail();
            $message
                ->to('test@example.com')
                ->from('no-reply@example.com')
                ->subject('Leave Period')
                ->htmlTemplate('contact/mail.html.twig')
                ->textTemplate('contact/mail.txt.twig')
                ->context([
                    'leave_period' => $leavePeriod,
                ]);
            if ($leavePeriod->getSupportingFile()) {
                $message->attachFromPath($leavePeriod->getSupportingFile()->getPathname());
            }

            $mailer->send($message);
        }

        return $this->render('contact/new_leave_period.html.twig', [
            'form' => $form,
        ]);
    }
}
