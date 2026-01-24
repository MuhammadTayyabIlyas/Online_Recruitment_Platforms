<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    protected $fillable = ['name', 'code'];

    public function universities(): HasMany
    {
        return $this->hasMany(University::class);
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class);
    }
}
