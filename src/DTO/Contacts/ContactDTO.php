<?php

final readonly class ContactDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public string $email,
        public ?string $phone = null,
        public ?string $company = null,
        public ?string $jobTitle = null,
        public ?string $website = null,
        public ?string $city = null,
        public ?string $state = null,
        public ?string $country = null,
        public ?string $zipCode = null,
        public ?string $address = null
    ) {
    }
}
