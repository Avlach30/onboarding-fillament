<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
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

    // Get the role details
    public function getRole(): Role {
        return $this->belongsTo(Role::class, 'role_id', 'id')->first();
    }

    public function getPosts() {
        return $this->hasMany(Post::class, 'creator_id', 'id')->get();
    }

    public function countData(): int {
        return $this->count();
    }

    public function getPermissionsById(int $id): array {
        // Get user by ID
        $user = $this->where('id', $id)->first();

        // Get the role of the user
        $role = $user->getRole();

        // Get the permissions of the role
        return $role->permissions->pluck('name')->toArray();
    }

    public function isIdHasPermission(int $id, Permission $permission): bool {
        // Get the permissions of the user
        $permissions = $this->getPermissionsById($id);

        // Check if the permission exists in the permissions array
        return in_array($permission->value, $permissions);
    }
}
