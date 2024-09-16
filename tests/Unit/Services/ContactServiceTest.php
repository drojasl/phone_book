<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\ContactService;
use App\Repositories\ContactRepository;
use App\Models\Contact;
use Illuminate\Validation\ValidationException;
use Mockery;

class ContactServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $contactService;
    protected $contactRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactRepository = Mockery::mock(ContactRepository::class);
        $this->contactService = new ContactService($this->contactRepository);
    }

    public function test_get_contacts_success()
    {
        $contact = Contact::factory()->create();
        $this->contactRepository
            ->shouldReceive('getAllContacts')
            ->with(1, 10, '')
            ->once()
            ->andReturn((object)[
                'items' => [$contact],
                'total' => 1
            ]);

        $result = $this->contactService->getContacts(1, 10, '');

        $this->assertEquals(1, $result->total);
        $this->assertEquals($contact->name, $result->items[0]->name);
    }

    public function test_create_contact_success()
    {
        $contactData = ['name' => 'Diego Test', 'phone' => '+1-234-567-8901'];
        $contact = new Contact($contactData);

        $this->contactRepository
            ->shouldReceive('createContact')
            ->with($contactData)
            ->once()
            ->andReturn($contact);

        $result = $this->contactService->createContact($contactData);

        $this->assertInstanceOf(Contact::class, $result);
        $this->assertEquals($contactData['name'], $result->name);
        $this->assertEquals($contactData['phone'], $result->phone);
    }

    public function test_create_contact_failure_due_to_validation()
    {
        $this->expectException(ValidationException::class);

        $invalidData = ['name' => 'Diego Test'];
        $this->contactService->createContact($invalidData);
    }

    public function test_delete_contact_success()
    {
        $contact = Contact::factory()->create();

        $this->contactRepository
            ->shouldReceive('deleteContact')
            ->with($contact->id)
            ->once();

        $this->contactService->deleteContact($contact->id);

        $this->assertTrue(true);
    }
}
