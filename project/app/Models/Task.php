<?php

namespace App\Models;

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

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('due_date', '<', now());
    }
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('deleted_at');
    }
}
