<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;
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

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<', now());
    }
}
