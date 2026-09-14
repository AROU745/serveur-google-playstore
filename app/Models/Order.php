<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';
    public const STATUS_AWAITING = 'awaiting_confirmation';
    public const STATUS_PAID = 'paid';
    public const STATUS_FAILED = 'failed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'order_number',
        'customer_id',
        'project_name',
        'package_name',
        'amount',
        'currency',
        'duration_months',
        'payment_method',
        'status',
        'notes',
        'nif',
        'nif_document_path',
        'rccm',
        'rccm_document_path',
        'cfe',
        'cfe_document_path',
        'id_document_type',
        'id_document_path',
        'company_years',
        'company_eligible_confirmed',
        'dossier_submitted_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'duration_months' => 'integer',
        'company_years' => 'integer',
        'company_eligible_confirmed' => 'boolean',
        'dossier_submitted_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function latestPayment(): HasOne
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function isPaid(): bool
    {
        return $this->status === self::STATUS_PAID;
    }

    public function formattedAmount(): string
    {
        return number_format((float) $this->amount, 0, ',', ' ').' '.$this->currency;
    }

    public function formattedDuration(): string
    {
        if ($this->duration_months === null || (int) $this->duration_months === 0) {
            return config('services.plan.duration_label', 'Indéterminée');
        }

        return $this->duration_months.' mois';
    }

    public static function generateOrderNumber(): string
    {
        do {
            $number = 'GPSS-'.strtoupper(substr(uniqid(), -8)).'-'.random_int(100, 999);
        } while (self::where('order_number', $number)->exists());

        return $number;
    }
}
