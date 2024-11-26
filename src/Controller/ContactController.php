<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use App\Form\LeavePeriodType;
use App\Model\Contact;
use App\Model\LeavePeriod;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact/new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
    ): Response {
        $contact = new Contact();
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
    ): Response {
        $leavePeriod = new LeavePeriod();
        $form = $this->createForm(LeavePeriodType::class, $leavePeriod);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($leavePeriod);
        }

        return $this->render('contact/new_leave_period.html.twig', [
            'form' => $form,
        ]);
    }
}
