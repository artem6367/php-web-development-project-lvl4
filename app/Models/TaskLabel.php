<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TaskLabel extends Pivot
{
    use HasFactory;

    /**
     * {@inheritdoc}
     */
    public $incrementing = true;

    public function task(): BelongsToMany
    {
        return $this->belongsToMany(Task::class);
    }

    public function label(): BelongsToMany
    {
        return $this->belongsToMany(Label::class);
    }
}
