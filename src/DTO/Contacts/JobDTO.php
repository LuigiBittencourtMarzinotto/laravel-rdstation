<?php

declare(strict_types=1);

namespace LuigiMarzinotto\LaravelRDStation\DTO\Contacts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final readonly class JobDTO implements Arrayable
{
    public function __construct(
        public ?string $title = null,
        public ?string $department = null,
        public ?string $company = null,
        public ?string $email = null,
        public ?string $phone = null,
        public ?string $cnpj = null,
        public ?string $site = null,
        public ?string $occupation_area = null,
    ) {}

    public static function fromArray(?array $a): self
    {
        $a ??= [];

        return new self(
            title: $a['title'] ?? null,
            department: $a['department'] ?? null,
            company: $a['company'] ?? null,
            email: $a['email'] ?? null,
            phone: self::normalizePhone($a['phone'] ?? null),
            cnpj: self::onlyDigits($a['cnpj'] ?? null),
            site: $a['site'] ?? null,
            occupation_area: $a['occupation_area'] ?? null,
        );
    }

    public function toArray(): array
    {
        return Arr::where([
            'title' => $this->title,
            'department' => $this->department,
            'company' => $this->company,
            'email' => $this->email,
            'phone' => $this->phone,
            'cnpj' => $this->cnpj,
            'site' => $this->site,
            'occupation_area' => $this->occupation_area,
        ], fn ($v) => $v !== null);
    }

    private static function normalizePhone(?string $raw): ?string
    {
        if (! $raw) {
            return null;
        }
        $raw = trim($raw);
        $plus = str_starts_with($raw, '+') ? '+' : '';

        return $plus.preg_replace('/\D+/', '', $raw);
    }

    private static function onlyDigits(?string $v): ?string
    {
        return $v ? preg_replace('/\D+/', '', $v) : null;
    }
}
