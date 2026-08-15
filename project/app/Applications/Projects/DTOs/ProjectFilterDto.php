<?php 

namespace App\Applications\Projects\DTOs;

use App\Domain\Projects\Enums\ProjectStatus;

readonly class ProjectFilterDto
{
    public function __construct(
        public ?string $name = null,
        public ?ProjectStatus $status = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            status: !empty($data['status']) 
                ? ProjectStatus::tryFrom($data['status']) 
                : null,
        );
    }

    public function toArray ():array {
        return [
            'name' => $this->name,
            'status' => $this->status?->value,
        ];
    }
}