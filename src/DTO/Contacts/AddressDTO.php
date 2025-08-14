<?php

declare(strict_types=1);

namespace LuigiMarzinotto\LaravelRDStation\DTO\Contacts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final readonly class AddressDTO implements Arrayable
{
    public function __construct(
        public ?string $country = null,
        public ?string $state = null,
        public ?string $city = null,
        public ?string $district = null,
        public ?string $street = null,
        public ?string $number = null,
        public ?string $complement = null,
        public ?string $zip_code = null, // CEP
    ) {}

    public static function fromArray(?array $a): self
    {
        $a ??= [];

        return new self(
            country:    $a['country']    ?? null,
            state:      $a['state']      ?? null,
            city:       $a['city']       ?? null,
            district:   $a['district']   ?? null,
            street:     $a['street']     ?? null,
            number:     $a['number']     ?? null,
            complement: $a['complement'] ?? null,
            zip_code:   self::onlyDigits($a['zip_code'] ?? null),
        );
    }

    public function toArray(): array
    {
        return Arr::where([
            'country'   => $this->country,
            'state'     => $this->state,
            'city'      => $this->city,
            'district'  => $this->district,
            'street'    => $this->street,
            'number'    => $this->number,
            'complement'=> $this->complement,
            'zip_code'  => $this->zip_code,
        ], fn($v) => $v !== null);
    }

    private static function onlyDigits(?string $v): ?string
    {
        return $v ? preg_replace('/\D+/', '', $v) : null;
    }
}
