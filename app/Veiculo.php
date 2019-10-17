<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Veiculo extends Model
{
    protected $fillable = [
        'idModelo',
        'idUsuario',
        'nmPlacaVeiculo',
        'anoVeiculo',
        'dsConsumoVeiculo'
    ];

    protected $guarded = [
        'id',        
        'created_at',
        'updated_at'
    ];

    protected $table = 'tb_veiculo';

}
