<?php

namespace App\Infrastructure\Database\Models;

use App\Domain\Tasks\Enums\PriorityTask;
use App\Domain\Tasks\Enums\StatusTask;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;
    public $fillable = [
        'title',
        'description',
        'project_id',
        'status',
        'priority',
        'due_date',
        'deleted_at',
        'deleted'
    ];

    protected function casts(): array
    {
        return [
            'status' => StatusTask::class,
            'priority' => PriorityTask::class,
            'due_date' => 'date',
        ];
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<=', Carbon::yesterday());
    }
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
