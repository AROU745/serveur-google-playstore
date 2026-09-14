<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    public const METHOD_WISE = 'wise';
    public const METHOD_ONLINE = 'online';
    public const METHOD_VISA = 'visa';

    public const STATUS_PENDING = 'pending';
    public const STATUS_AWAITING = 'awaiting_confirmation';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'order_id',
        'method',
        'amount',
        'currency',
        'status',
        'transaction_reference',
        'payer_name',
        'payer_email',
        'payment_date',
        'proof_path',
        'metadata',
        'confirmed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'metadata' => 'array',
        'confirmed_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
