<?php

namespace App\Model;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
class LeavePeriod
{
    private ?Contact $contact = null;
    #[Assert\Valid]
    private ?DateRange $dateRange = null;

    #[Vich\UploadableField('files', fileNameProperty: 'supportingFilename')]
    private ?File $supportingFile = null;

    private ?string $supportingFilename = null;

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): LeavePeriod
    {
        $this->contact = $contact;

        return $this;
    }

    public function getDateRange(): ?DateRange
    {
        return $this->dateRange;
    }

    public function setDateRange(?DateRange $dateRange): LeavePeriod
    {
        $this->dateRange = $dateRange;

        return $this;
    }

    public function getSupportingFile(): ?File
    {
        return $this->supportingFile;
    }

    public function setSupportingFile(?File $supportingFile): LeavePeriod
    {
        $this->supportingFile = $supportingFile;

        return $this;
    }

    public function getSupportingFilename(): ?string
    {
        return $this->supportingFilename;
    }

    public function setSupportingFilename(?string $supportingFilename): LeavePeriod
    {
        $this->supportingFilename = $supportingFilename;

        return $this;
    }
}
