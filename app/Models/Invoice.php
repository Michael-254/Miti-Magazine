<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference',
        'transaction',
        'discount',
        'sales_order_no',
        'invoice_no',
        'invoice_date',
        'currency'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalAmount()
    {
        return $this->items->sum('amount');
    }
}
