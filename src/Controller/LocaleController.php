<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Locale;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LocaleController extends AbstractController
{
    #[Route('/locale', methods: 'POST')]
    public function set(
        Request $request,
        ValidatorInterface $validator,
    ): Response {
        $locale = $request->request->get('locale');
        $violationList = $validator->validate($locale, new Locale());
        if (0 < $violationList->count()) {
            throw new \InvalidArgumentException('Invalid locale');
        }
        $request->getSession()->set('locale', $locale);

        return $this->redirectToRoute('app_default_index');
    }
}
