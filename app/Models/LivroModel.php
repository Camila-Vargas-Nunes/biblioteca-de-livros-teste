<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LivroModel extends Model
{
    protected $table = 'livros';
    protected $fillable = ['nome_livro'];
}
