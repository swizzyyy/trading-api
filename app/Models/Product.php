<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'unique_code', 'quantity', 'type', 'manufacture_date', 'expiry_date', 'added_by'];

    public function getRouteKeyName()
    {
        return 'unique_code';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
