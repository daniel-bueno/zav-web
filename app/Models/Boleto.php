<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boleto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nome_devedor',
        'data_vencimento',
        'titulo_numero',
        'valor',
        'juro',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
