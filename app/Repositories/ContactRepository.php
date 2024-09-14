<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    public function getAllContacts()
    {
        try {
            return Contact::all();

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function createContact(array $data)
    {
        try {
            return Contact::create($data);

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function deleteContact($id)
    {
        try {
            $contact = Contact::findOrFail($id);
            return $contact->delete();

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
