<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['table_name', 'status'];

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
