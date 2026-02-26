<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Candidate Model
 * Stores profile information and relationship to cast votes.
 */
class Candidate extends Model
{
    protected $fillable = ['name', 'party', 'photo_path', 'description'];

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
