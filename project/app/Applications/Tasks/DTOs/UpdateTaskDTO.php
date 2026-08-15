<?php

namespace App\Applications\Tasks\DTOs;

use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;

class UpdateTaskDTO
{
    public function __construct(
        readonly ?StatusTask $status = null,
        readonly ?PriorityTask $priority = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            status: isset($data['status']) ? StatusTask::from($data['status']) : null,
            priority: isset($data['priority']) ? StatusTask::from($data['priority']) : null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'status'   => $this->status?->value,
            'priority' => $this->priority?->value,
        ], fn($value) => $value !== null);
    }
}