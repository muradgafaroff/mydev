<?php


namespace App\Services;

use App\Repositories\Interfaces\ContactRepositoryInterface;
use App\Jobs\SendContactMail;

class ContactService {
    protected $contactRepo;

    public function __construct(ContactRepositoryInterface $contactRepo) {
        $this->contactRepo = $contactRepo;
    }

    public function handleContactForm(array $data) {
        // 1. Bazaya yazırıq (Repository vasitəsilə)
        $contact = $this->contactRepo->store($data);

        // 2. Maili Redis növbəsinə atırıq (Sürət üçün)
        SendContactMail::dispatch($data);

        return $contact;
    }
}