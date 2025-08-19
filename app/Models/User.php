<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'occupation',
        'avatar',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Event ketika user baru dibuat
        static::created(function (User $user) {
            try {
                // Log untuk debugging
                \Log::info('User created event triggered for: ' . $user->email);

                // Cek apakah user sudah punya role
                if ($user->roles()->count() === 0) {
                    // Assign role student
                    $user->assignRole('student');
                    \Log::info('Student role assigned to: ' . $user->email);
                }
            } catch (\Exception $e) {
                \Log::error('Error assigning role: ' . $e->getMessage());
            }
        });
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_students');
    }

    public function subscribe_transaction()
    {
        return $this->hasMany(SubscribeTransaction::class);
    }

    public function hasActiveSubscription()
    {
        $latestSubscription = $this->subscribe_transaction()
            ->where('is_paid', true)
            ->latest('updated_at')
            ->first();

        if (!$latestSubscription) {
            return false;
        }

        $subscriptionEndDate = Carbon::parse($latestSubscription->subscription_start_date)->addMonth(1);
        return Carbon::now()->lessThanOrEqualTo($subscriptionEndDate);
    }
}
