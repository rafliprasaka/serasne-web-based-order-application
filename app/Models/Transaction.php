<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['invoice_id', 'table_id', 'sub_total', 'ppn', 'total_amount', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
