<?php

namespace LuigiMarzinotto\LaravelRDStation\Services;

use Illuminate\Http\JsonResponse;
use LuigiMarzinotto\LaravelRDStation\DTO\Contacts\ContactDTO;
use LuigiMarzinotto\LaravelRDStation\Http\Client\RDStationClient;

class ContactsService extends RDStationClient
{
    protected $http;

    public function __construct(RDStationClient $client)
    {
        $this->http = $client->http();
    }

    /**
     * @param  string  $channel  telegram, whatsapp or both
     */
    public function showContacts(int $page = 1, int $limit = 10, string $channel = 'whatsapp'): array
    {
        $contacts = $this->http->get('/customers', [
            'page' => $page,
            'limit' => $limit,
            'channel' => $channel,
        ]);

        return $contacts->json();
    }

    /**
     * @param  list<ContactDTO>  $contacts
     */
    public function create(ContactDTO ...$contact): JsonResponse
    {
        $response = $this->http->post('/contacts', ['contacts' => $contact]);

        return $response->json();
    }

    public function update(ContactDTO ...$contact): JsonResponse
    {
        foreach ($contact as $c) {
            if (! $c instanceof ContactDTO) {
                throw new \InvalidArgumentException('Expected instance of ContactDTO');
            }
            $uri = '/contacts'.$c->cel_phone;
            $response = $this->http->patch($uri, ['contacts' => $contact]);

            return $response->json();
        }

        return JsonResponse::error('Failed to update contacts');
    }
}
