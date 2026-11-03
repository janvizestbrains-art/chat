<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Override;

class Notification extends Model
{
    protected $fillable = [
        'title',
        'sender_id',
        'description',
        'user_ids',
    ];
    #[Override]
    protected function casts():array
    {
        return [
            'user_ids'=>'array',
        ];
    }
     protected function userNames(): Attribute
{
    return Attribute::make(
        get: fn () => User::whereIn('id', $this->user_ids ?? [])
            ->pluck('name')
            ->implode(', ')
    );
}

}
