<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\ContactType;
use App\Form\LeavePeriodType;
use App\Model\Contact;
use App\Model\ContactType as ModelContactType;
use App\Model\DateRange;
use App\Model\LeavePeriod;
use App\Service\ContactDeliver;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ContactController extends AbstractController
{
    #[Route('/contact/new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        ContactDeliver $deliver,
    ): Response {
        $contact = new Contact();
        $contact->setType(ModelContactType::Company);
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $deliver->deliver($contact);
        }

        return $this->render('contact/new.html.twig', [
            'form' => $form,
            'ranges' => [
                new DateRange(new \DateTimeImmutable('2024-11-25'), new \DateTimeImmutable('2024-11-30')),
                new DateRange(new \DateTimeImmutable('2024-01-01'), new \DateTimeImmutable('2024-12-31')),
            ] + iterator_to_array((function () {
                    for ($i = 1; $i <= 12; $i++) {
                        $firstDayOfMonth = new \DateTimeImmutable('2024-' . $i . '-01');
                        yield new DateRange(
                            $firstDayOfMonth,
                            $firstDayOfMonth->modify('last day of this month'),
                        );
                    }
                }) ()),
        ]);
    }

    #[Route('/leave/new', methods: ['GET', 'POST'])]
    public function newLeavePeriod(
        Request $request,
        MailerInterface $mailer,
        NormalizerInterface $normalizer,
        string $projectDir,
    ): Response {
        $leavePeriod = new LeavePeriod();
        $form = $this->createForm(LeavePeriodType::class, $leavePeriod, [
            'validation_groups' => ['Default', 'planning']
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $to = new Address('test@example.com', 'Mr Test');
            $message = new TemplatedEmail();
            $message
                ->to($to)
                ->from('no-reply@example.com')
                ->subject('Leave Period')
                ->htmlTemplate('contact/mail.html.twig')
                ->textTemplate('contact/mail.txt.twig')
                /*
                 * As LeavePeriod has a File property, it should be
                 * normalized before Messenger serialization.
                 */
                ->context([
                    'leave_period' => $normalizer->normalize($leavePeriod),
                ]);

            $message->addPart(new DataPart(new File($projectDir.'/assets/images/symfony.svg'), 'logo', 'image/svg+xml'));


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
