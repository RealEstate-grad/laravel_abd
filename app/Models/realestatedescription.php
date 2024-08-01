<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class realestatedescription extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = "realestate_description";
    // a realestate_description belongs to a realestate
    public function realestate(): HasOne
    {
        return $this->hasOne(realestate::class);
    }
    
}
