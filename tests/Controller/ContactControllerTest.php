<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ContactControllerTest extends WebTestCase
{
    public function testSomething(): void
    {
        // This calls KernelTestCase::bootKernel(), and creates a
        // "client" that is acting as the browser
        $client = static::createClient();

        // Request a specific page
        $crawler = $client->request('GET', '/contact/new');
        $form = $crawler->filter('[name=contact]')->form();
        $form['contact[lastName]'] = 'Doe';
        $form['contact[firstName]'] = 'John';
        $form['contact[phone]'] = '+33123456789';

        $client->submit($form);
        $this->assertResponseIsUnprocessable();
        $form['contact[email]'] = 'johndoe@example.com';

        $client->followRedirects(false);
        $client->submit($form);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertResponseIsSuccessful();
    }
}
