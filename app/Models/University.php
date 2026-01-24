<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class University extends Model
{
    protected $fillable = ['name', 'country_id', 'website', 'logo'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
