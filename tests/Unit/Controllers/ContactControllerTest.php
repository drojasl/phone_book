<?php

namespace Tests\Unit\Http\Controllers;

use Illuminate\Http\Response;
use Tests\TestCase;
use Mockery;
use App\Services\ContactService;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ContactControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $contactService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->contactService = Mockery::mock(ContactService::class);
        $this->app->instance(ContactService::class, $this->contactService);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    public function test_index_success()
    {
        $contact = Contact::factory()->make();
        $contactArray = $contact->toArray();

        $this->contactService
            ->shouldReceive('getContacts')
            ->with(1, 10, '')
            ->once()
            ->andReturn((object)[
                'data' => [$contactArray],
                'total' => 1
            ]);

        $response = $this->json('GET', '/api/contacts', [
            'page' => 1,
            'per_page' => 10,
            'search' => ''
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_store_success()
    {
        $contactData = [
            'name' => 'Diego Test',
            'phone' => '1234567890'
        ];

        $this->contactService
            ->shouldReceive('createContact')
            ->with($contactData)
            ->once()
            ->andReturn((object)$contactData);

        $response = $this->json('POST', '/api/contacts', $contactData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJson($contactData);
    }

    public function test_delete_success()
    {
        $contact = Contact::factory()->create();

        $this->contactService
            ->shouldReceive('deleteContact')
            ->with($contact->id)
            ->once()
            ->andReturn(true);

        $response = $this->json('DELETE', '/api/contacts/' . $contact->id);

        $response->assertStatus(Response::HTTP_OK);
        $response->assertJson(['message' => 'Contact deleted successfully']);
    }
}