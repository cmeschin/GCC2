<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    /**
     * Get the user that owns the demande.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
