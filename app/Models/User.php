<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
        ];
    }

    public function suppliesExpenses()
    {
        return $this->hasMany(SuppliesExpense::class);
    }
    public function transportationExpenses()
    {
        return $this->hasMany(TransportationExpense::class);
    }
    public function entertainmentExpenses()
    {
        return $this->hasMany(EntertainmentExpense::class);
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isGeneral()
    {
        return $this->role === 'general';
    }
    public function isManager()
    {
        return $this->role === 'manager';
    }
    public function isStaff()
    {
        return $this->role === 'staff';
    }
    public function isUser()
    {
        return $this->role === 'user';
    }
    public function isGuest()
    {
        return $this->role === 'guest';
    }
    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
    public function isSuperUser()
    {
        return $this->role === 'super_user';
    }
    public function isSuperGuest()
    {
        return $this->role === 'super_guest';
    }
    public function isSuperManager()
    {
        return $this->role === 'super_manager';
    }
    public function isSuperStaff()
    {
        return $this->role === 'super_staff';
    }
    public function isSuperGeneral()
    {
        return $this->role === 'super_general';
    }
    public function isSuperAdminOrManager()
    {
        return $this->isSuperAdmin() || $this->isSuperManager();
    }
    public function isSuperAdminOrStaff()
    {
        return $this->isSuperAdmin() || $this->isSuperStaff();
    }
    public function isSuperAdminOrGeneral()
    {
        return $this->isSuperAdmin() || $this->isSuperGeneral();
    }
    public function isSuperAdminOrUser()
    {
        return $this->isSuperAdmin() || $this->isSuperUser();
    }
    public function isSuperAdminOrGuest()
    {
        return $this->isSuperAdmin() || $this->isSuperGuest();
    }
    public function isSuperAdminOrSuperUser()
    {
        return $this->isSuperAdmin() || $this->isSuperUser();
    }
    public function isSuperAdminOrSuperGuest()
    {
        return $this->isSuperAdmin() || $this->isSuperGuest();
    }
    public function isSuperAdminOrSuperManager()
    {
        return $this->isSuperAdmin() || $this->isSuperManager();
    }
    public function isSuperAdminOrSuperStaff()
    {
        return $this->isSuperAdmin() || $this->isSuperStaff();
    }
    public function isSuperAdminOrSuperGeneral()
    {
        return $this->isSuperAdmin() || $this->isSuperGeneral();
    }
    public function isSuperAdminOrSuperAdmin()
    {
        return $this->isSuperAdmin() || $this->isSuperAdmin();
    }
    public function isSuperAdminOrSuperUserOrSuperGuest()
    {
        return $this->isSuperAdmin() || $this->isSuperUser() || $this->isSuperGuest();
    }
    public function isSuperAdminOrSuperManagerOrSuperStaff()
    {
        return $this->isSuperAdmin() || $this->isSuperManager() || $this->isSuperStaff();
    }
    public function isSuperAdminOrSuperGeneralOrSuperUser()
    {
        return $this->isSuperAdmin() || $this->isSuperGeneral() || $this->isSuperUser();
    }
    public function isSuperAdminOrSuperManagerOrSuperUser()
    {
        return $this->isSuperAdmin() || $this->isSuperManager() || $this->isSuperUser();
    }
    public function isSuperAdminOrSuperManagerOrSuperGuest()
    {
        return $this->isSuperAdmin() || $this->isSuperManager() || $this->isSuperGuest();
    }
    public function isSuperAdminOrSuperManagerOrSuperGeneral()
    {
        return $this->isSuperAdmin() || $this->isSuperManager() || $this->isSuperGeneral();
    }
}
