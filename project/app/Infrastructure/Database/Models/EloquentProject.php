<?php

namespace App\Infrastructure\Database\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentProject extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'status',
    ];

    protected static function newFactory()
    {
        return \Database\Factories\ProjectFactory::new();
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(EloquentTask::class, 'project_id', 'id')
            ->whereNull('deleted_at');
    }
}
