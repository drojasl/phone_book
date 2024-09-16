<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\ContactRepository;
use App\Models\Contact;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $contactRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactRepository = new ContactRepository();
    }

    public function test_get_all_contacts_success()
    {
        $contact = Contact::factory()->create();

        $result = $this->contactRepository->getAllContacts(1, 10, '');

        $this->assertCount(1, $result->items());
        $this->assertEquals($contact->name, $result->items()[0]->name);
    }

    public function test_create_contact_success()
    {
        $contactData = ['name' => 'Diego Test', 'phone' => '+1-234-567-8901'];

        $contact = $this->contactRepository->createContact($contactData);

        $this->assertInstanceOf(Contact::class, $contact);
        $this->assertEquals($contactData['name'], $contact->name);
    }

    public function test_delete_contact_success()
    {
        $contact = Contact::factory()->create();

        $this->contactRepository->deleteContact($contact->id);

        $this->expectException(ModelNotFoundException::class);
        Contact::findOrFail($contact->id);
    }
}
