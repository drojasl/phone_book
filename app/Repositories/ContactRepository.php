<?php

namespace App\Repositories;

use App\Models\Contact;

class ContactRepository
{
    public function getAllContacts($page=1, $perPage=10, $search="")
    {
        try {
            $query = Contact::query();

            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%')->orWhere('phone', 'like', '%' . $search . '%');
                });
            }
            return $query->paginate($perPage, ['id', 'name', 'phone'], 'page', $page);

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
