<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank]
    private ?string $lastName = null;
    #[Assert\NotBlank]
    private ?string $firstName = null;
    #[Assert\NotBlank]
    #[Assert\Email]
    private ?string $email = null;

    private ?string $phone = null;
    private ContactType $type = ContactType::Person;

    #[Assert\LessThan('today')]
    private ?\DateTimeImmutable $birthdate = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): Contact
    {
        $this->email = $email;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): Contact
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): Contact
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): Contact
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeImmutable
    {
        return $this->birthdate;
    }

    public function setBirthdate(?\DateTimeImmutable $birthdate): Contact
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getType(): ContactType
    {
        return $this->type;
    }

    public function setType(ContactType $type): Contact
    {
        $this->type = $type;

        return $this;
    }
}
