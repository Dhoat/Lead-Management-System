<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadUpdate extends Model
{
    use HasFactory;

    protected $fillable = [
        'lead_id', 'lead_message', 'user'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
