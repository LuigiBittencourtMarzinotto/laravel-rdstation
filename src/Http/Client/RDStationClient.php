<?php

namespace LuigiMarzinotto\LaravelRDStation\Http\Client;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\PendingRequest;

class RDStationClient
{
    protected function http(): PendingRequest
    {
        $cfg = config('rdstation');

        $req = Http::baseUrl(rtrim($cfg['http']['base_uri'], '/'))
            ->timeout($cfg['http']['timeout'])
            ->acceptJson()
            ->withUserAgent($cfg['http']['user_agent'] ?? 'laravel-rdstation/1.x')
            ->retry(
                $cfg['http']['retries']['max'],
                $cfg['http']['retries']['base_ms'],
                fn($e) => in_array(optional($e->response())->status(), $cfg['http']['retries']['retry_on_codes']),
                throw: false
            );


        $token  = (string) ($cfg['auth']['token'] ?? '');
        $header = (string) ($cfg['auth']['header'] ?? 'Authorization');
        $prefix = (string) ($cfg['auth']['prefix'] ?? 'Bearer ');

        if ($token !== '') {
            if (strtolower($header) === 'authorization' && strtolower(trim($prefix)) === 'bearer') {
                $req = $req->withToken($token);
            } else {
                $req = $req->withHeaders([$header => $prefix.$token]);
            }
        }

        return $req;
    }
}
