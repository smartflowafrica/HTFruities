<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    # email verification notification
    public function sendVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    # fillable - explicitly whitelist mass-assignable fields
    # Note: user_type, is_banned, is_active, user_balance are excluded for security
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'postal_code',
        'provider_id',
        'verification_code',
        'new_email_verification_code',
        'email_or_otp_verified',
        'email_verified_at',
        'remember_token',
        'role_id',
        'shop_id',
        'location_id',
        'address',
        'salary',
    ];

    # hidden for serializations
    protected $hidden = [
        'password',
        'remember_token',
    ];

    # should be casted
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    # user shop
    public function shop()
    {
        return $this->hasOne(Shop::class, 'id', 'shop_id');
    }

    # role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    # address
    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    # order Group
    public function orderGroups()
    {
        return $this->hasMany(OrderGroup::class);
    }
    # orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    # carts
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    # wishlist
    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    # rewards
    public function rewards()
    {
        return $this->hasMany(RewardPoint::class);
    }

    # wallets
    public function wallets()
    {
        return $this->hasMany(WalletHistory::class);
    }

    # refunds
    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }

    # location
    public function location()
    {
        return $this->belongsTo(Location::class)->withDefault([
            'name'=>'Location not found'
        ]);
    }

    function payouts(){
        return $this->hasMany(Payout::class);
    }

}
