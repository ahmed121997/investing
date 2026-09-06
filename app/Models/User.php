<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements FilamentUser, HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, InteractsWithMedia, Notifiable;

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_active !== false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::saving(function (User $user): void {
            if (! $user->exists || ! $user->isDirty(['role', 'is_active'])) {
                return;
            }

            if ($user->isCurrentUser() && ! $user->is_active) {
                throw ValidationException::withMessages([
                    'is_active' => ['You cannot deactivate your own account.'],
                ]);
            }

            if ($user->getOriginal('role') === 'admin'
                && ($user->role !== 'admin' || ! $user->is_active)
                && static::query()->where('role', 'admin')->where('is_active', true)->count() <= 1) {
                throw ValidationException::withMessages([
                    'role' => ['The last active administrator cannot be removed or deactivated.'],
                ]);
            }
        });

        static::deleting(function (User $user): void {
            if ($user->isAdmin() && static::query()->where('role', 'admin')->where('is_active', true)->count() <= 1) {
                throw ValidationException::withMessages([
                    'role' => ['The last active administrator cannot be deleted.'],
                ]);
            }
        });
    }

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function withdrawals()
    {
        return $this->hasMany(Withdrawal::class);
    }

    public function trades()
    {
        return $this->hasMany(Trade::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCurrentUser(): bool
    {
        return (int) $this->id === (int) Auth::id();
    }

    public function getProfileImageUrl(): ?string
    {
        if ($this->hasMedia('avatars')) {
            return $this->getFirstMediaUrl('avatars');
        }

        return null;
    }

    public function hasProfileImage(): bool
    {
        return $this->hasMedia('avatars');
    }
}
