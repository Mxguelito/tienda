<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
    'nombre',
    'email',
    'direccion',
    'carrito',
    'total',
    'estado',
    'user_id',
    'numero_orden'  // <-- IMPORTANTE
];


    protected $casts = [
        'carrito' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
