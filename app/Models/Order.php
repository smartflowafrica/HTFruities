<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_group_id', 'shop_id', 'user_id', 'guest_user_id',
        'deliveryman_id', 'location_id',
        'delivery_status', 'payment_status',
        'applied_coupon_code', 'coupon_discount_amount',
        'admin_earning_percentage', 'total_admin_earnings', 'total_vendor_earnings',
        'logistic_id', 'logistic_name',
        'pickup_or_delivery', 'shipping_delivery_type', 'scheduled_delivery_info',
        'pickup_hub_id', 'shipping_cost', 'tips_amount',
        'reward_points', 'note',
    ];

    public function scopeIsPaid($query)
    {
        return $query->where('payment_status', paidPaymentStatus());
    }

    public function scopeIsUnpaid($query)
    {
        return $query->where('payment_status', unpaidPaymentStatus());
    }

    public function scopeIsPlaced($query)
    {
        return $query->where('delivery_status', orderPlacedStatus());
    }

    public function scopeIsPending($query)
    {
        return $query->where('delivery_status', orderPendingStatus());
    }

    public function scopeIsPlacedOrPending($query)
    {
        return $query->where('delivery_status', orderPlacedStatus())->orWhere('delivery_status', orderPendingStatus());
    }

    public function scopeIsProcessing($query)
    {
        return $query->where('delivery_status', orderProcessingStatus());
    }

    public function scopeIsPickedUp($query)
    {
        return $query->where('delivery_status', orderPickedUpStatus());
    }

    public function scopeIsOutForDelivery($query)
    {
        return $query->where('delivery_status', orderOutForDeliveryStatus());
    }

    public function scopeIsDelivered($query)
    {
        return $query->where('delivery_status', orderDeliveredStatus());
    }

    public function scopeIsCancelled($query)
    {
        return $query->where('delivery_status', orderCancelledStatus());
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderGroup()
    {
        return $this->belongsTo(OrderGroup::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderUpdates()
    {
        return $this->hasMany(OrderUpdate::class)->latest();
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
