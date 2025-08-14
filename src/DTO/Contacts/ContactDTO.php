<?php

declare(strict_types=1);

namespace LuigiMarzinotto\LaravelRDStation\DTO\Contacts;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;

final readonly class ContactDTO implements Arrayable
{
    public function __construct(
        public string $full_name,
        public ?string $integration = null,
        public ?string $description = null,
        public ?string $cel_phone = null,
        public ?string $email = null,
        public ?string $birth_date = null,
        public ?string $cnpj = null,
        public ?string $cpf = null,
        public ?string $rg = null,
        public ?string $code = null,
        public ?string $department_name = null,
        public ?string $wallet_name = null,
        public ?string $workflow_title = null,
        public ?string $workflow_stage_title = null,
        public ?AddressDTO $address = null,
        public ?JobDTO $job = null,
        /** @var string[]|null */
        public ?array $tags = null,
    ) {}

    /**
     * Monta o DTO a partir de um array (ex.: Request->all()).
     */
    public static function fromArray(array $input): self
    {
        $cel  = self::normalizePhone($input['cel_phone'] ?? null);
        $cpf  = self::onlyDigits($input['cpf'] ?? null);
        $cnpj = self::onlyDigits($input['cnpj'] ?? null);

        return new self(
            full_name:            (string) $input['full_name'],
            integration:          $input['integration']         ?? null,
            description:          $input['description']         ?? null,
            cel_phone:            $cel,
            email:                $input['email']               ?? null,
            birth_date:           $input['birth_date']          ?? null,
            cnpj:                 $cnpj,
            cpf:                  $cpf,
            rg:                   $input['rg']                  ?? null,
            code:                 $input['code']                ?? null,
            department_name:      $input['department_name']     ?? null,
            wallet_name:          $input['wallet_name']         ?? null,
            workflow_title:       $input['workflow_title']      ?? null,
            workflow_stage_title: $input['workflow_stage_title']?? null,
            address:              isset($input['address']) ? AddressDTO::fromArray((array) $input['address']) : null,
            job:                  isset($input['job'])     ? JobDTO::fromArray((array) $input['job'])         : null,
            tags:                 isset($input['tags'])    ? array_values((array) $input['tags'])             : null,
        );
    }

    /** Mapeia exatamente para o JSON que a API espera. */
    public function toArray(): array
    {
        return Arr::where([
            'full_name'             => $this->full_name,
            'integration'           => $this->integration,
            'description'           => $this->description,
            'cel_phone'             => $this->cel_phone,
            'email'                 => $this->email,
            'birth_date'            => $this->birth_date,
            'cnpj'                  => $this->cnpj,
            'cpf'                   => $this->cpf,
            'rg'                    => $this->rg,
            'code'                  => $this->code,
            'department_name'       => $this->department_name,
            'wallet_name'           => $this->wallet_name,
            'workflow_title'        => $this->workflow_title,
            'workflow_stage_title'  => $this->workflow_stage_title,
            'address'               => $this->address?->toArray(),
            'job'                   => $this->job?->toArray(),
            'tags'                  => $this->tags,
        ], fn ($v) => $v !== null);
    }

    private static function normalizePhone(?string $raw): ?string
    {
        if (!$raw) return null;
        $raw = trim($raw);
        $plus = str_starts_with($raw, '+') ? '+' : '';
        return $plus . preg_replace('/\D+/', '', $raw);
    }

    private static function onlyDigits(?string $v): ?string
    {
        return $v ? preg_replace('/\D+/', '', $v) : null;
    }
}
