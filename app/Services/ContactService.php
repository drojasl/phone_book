<?php

namespace App\Services;

use App\Repositories\ContactRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ContactService
{
    protected $contactRepository;

    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    public function getContacts($page=1, $perPage=10, $search="")
    {
        try {
            return $this->contactRepository->getAllContacts($page, $perPage, $search);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createContact(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        try {
            return $this->contactRepository->createContact($data);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteContact($id)
    {
        try {
            return $this->contactRepository->deleteContact($id);

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
