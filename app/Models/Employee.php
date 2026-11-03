<?php

namespace App\Models;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasRoles;
    protected $fillable = [

    'employee_code',
    'first_name',
    'last_name',
    'email',
    'phone',
    'date_of_birth',
    'gender',
    'profile_photo',
    'address',
    'city',
    'state',
    'postal_code',
    'country',
    'department_id',
    'designation',
    'employment_type',
    'joining_date',
    'reporting_manager_id',
    'emergency_contact_name',
    'emergency_contact_phone',
    'emergency_contact_relation',
    'employment_status',
];
public function department(): BelongsTo
{
    return $this->belongsTo(Department::class);
}

public function reportingManager(): BelongsTo
{
    return $this->belongsTo(Employee::class, 'reporting_manager_id');
}
protected static function booted(): void
{
    static::creating(function ($employee) {
        if (blank($employee->employee_code)) {
            $lastNumber = static::query()
                ->whereRaw("employee_code REGEXP '^EMP[0-9]+$'")
                ->selectRaw(
                    "MAX(CAST(SUBSTRING(employee_code, 4) AS UNSIGNED)) as last_number"
                )
                ->value('last_number');

            $employee->employee_code = 'EMP' . ((int) $lastNumber + 1);
        }
    });

    static::created(function ($employee) {
        if ($employee->user_id) {
            return;
        }

        \Illuminate\Support\Facades\DB::transaction(function () use ($employee) {
            $user = \App\Models\User::create([
                'name' => trim($employee->first_name . ' ' . $employee->last_name),
                'email' => $employee->email,
                'password' => \Illuminate\Support\Facades\Hash::make(
                    $employee->phone
                ),
                'is_active' => true,
            ]);



            $employee->user_id = $user->id;
            $employee->saveQuietly();
        });
    });
}
public function getProfileUrlAttribute(): string
{
    if (
        $this->profile_photo &&
        \Illuminate\Support\Facades\Storage::disk('public')
            ->exists($this->profile_photo)
    ) {
        return \Illuminate\Support\Facades\Storage::disk('public')
            ->url($this->profile_photo);
    }

    $initial = strtoupper(
        mb_substr($this->first_name ?: $this->name ?? 'U', 0, 1)
    );

    return 'https://ui-avatars.com/api/?name=' . urlencode($initial)
        . '&background=E0E7FF&color=4338CA&size=128&bold=true';
}
public function user(): BelongsTo
{
    return $this->belongsTo(User::class);
}
public function getFullNameAttribute()
{
    return $this->first_name ." ".$this->last_name;
}
public function getAvtarAttribute():string
{
  $initial = strtoupper(
        mb_substr($this->first_name ?: $this->name ?? 'U', 0, 1)
    );

    return 'https://ui-avatars.com/api/?name=' . urlencode($initial)
        . '&background=E0E7FF&color=4338CA&size=128&bold=true';

}
}
