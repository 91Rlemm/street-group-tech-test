<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CsvImport extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_reference',
        'content'
    ];


    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
