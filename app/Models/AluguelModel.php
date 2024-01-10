<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AluguelModel extends Model
{
    protected $table = 'alugueis';
    protected $fillable = ['livro_id', 'usuario_id', 'dt_aluguel_ini', 'dt_aluguel_fim'];
}