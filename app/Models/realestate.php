<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class  realestate extends Model
{
    use HasFactory;
    protected $guarded = [];
    //a realestate has one description
    public function realestate_description(): BelongsTo
    {
        return $this->belongsTo( realestatedescription::class, 'realestate_description');
    }
    // a realestate will be reviewed by many realestate
    public function user(): BelongsToMany
    {
        return $this->belongsToMany(user::class);
    }
}
