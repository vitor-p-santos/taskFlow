<?php

namespace App\Applications\Tasks\DTOs;

use App\Domain\Tasks\Enums\DueDateBoolean;
use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;

class ListTasksFilterDTO
{
    public function __construct(
        readonly ?StatusTask $status = null,
        readonly ?PriorityTask $priority = null,
        readonly ?DueDateBoolean $dueDate = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            status: isset($data['status']) ? StatusTask::tryFrom($data['status']) : null,
            priority: isset($data['priority']) ? PriorityTask::tryFrom($data['priority']) : null,
            dueDate: isset($data['due_date']) ? DueDateBoolean::tryFrom($data['due_date']) : null,
        );
    }
}