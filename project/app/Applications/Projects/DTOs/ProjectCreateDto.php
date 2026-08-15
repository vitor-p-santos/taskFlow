<?php

namespace App\Applications\Projects\DTOs;

use App\Domain\Projects\Enums\ProjectStatus;

readonly class ProjectCreateDto
{
    public function __construct(
        public string $name,
        public string $description,
        public ProjectStatus $status,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            status: ProjectStatus::from($data['status'])                 
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'description' => $this->description,
            'status' => $this->status->value,
        ], fn ($value) => $value !== null);
    }
}