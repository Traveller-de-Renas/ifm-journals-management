<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Uuid;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'phone',
        'email',
        'gender',
        'password',
        'salutation_id',
        'country_id',
        'affiliation',
        'pf_number',
        'degree',
        'interests',
        'biography',
        'profile_photo_path',
        'status',
        'journal',
        'added',
        'areas_of_specialization'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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
        ];
    }

    public function journals()
    {
        return $this->belongsToMany(Journal::class)->withTimestamps();
    }

    public function journal_users()
    {
        return $this->belongsToMany(Journal::class);
    }

    public function article_users()
    {
        return $this->belongsToMany(Article::class)->withPivot('id', 'role', 'number')->withTimestamps();
    }

    public function salutation()
    {
        return $this->belongsTo(Salutation::class);
    }


    public function journal_us()
    {
        return $this->hasMany(JournalUser::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }


    public function reviewSectionsComments()
    {
        return $this->hasMany(ReviewSectionsComment::class);
    }
}
