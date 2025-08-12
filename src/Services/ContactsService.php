<?php

namespace LuigiMarzinotto\LaravelRDStation\Services;

use Illuminate\Http\JsonResponse;
use LuigiMarzinotto\LaravelRDStation\Http\Client\RDStationClient;

class ContactsService extends RDStationClient
{
    protected $http;

    public function __construct(RDStationClient $client)
    {
        $this->http = $client->http();
    }

    public function showContancts() : array
    {
        $contacts = $this->http->get('/customers');
        return $contacts->json();
    }

    public function createContact(array $data) : JsonResponse
    {
        $response = $this->http->post('/contacts', $data);
        return $response->json();
    }
}
