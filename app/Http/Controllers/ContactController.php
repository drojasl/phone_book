<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\ContactService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ContactController extends Controller
{
    protected $contactService;

    /**
     * Constructor to initialize the ContactService dependency
     *
     * @param ContactService $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Fetches a paginated list of contacts.
     * Handles optional search query and pagination parameters.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = $request->get('per_page', 10);
            $search = $request->get('search', 10);

            $contacts = $this->contactService->getContacts($page, $perPage, $search);
            return response()->json($contacts);

        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Stores a new contact in the database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $contact = $this->contactService->createContact($request->all());
            return response()->json($contact, 201);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Deletes a specific contact by its ID.
     * Handles exceptions if the contact is not found.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        try {
            $this->contactService->deleteContact($id);
            return response()->json(['message' => 'Contact deleted successfully']);

        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Contact not found'], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
