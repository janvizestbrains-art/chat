<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Leave extends Model
{
    protected $fillable = [
        'from_date',
        'end_date',
        'reason',
        'user_id',
        'status',
        'reject_reason'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
