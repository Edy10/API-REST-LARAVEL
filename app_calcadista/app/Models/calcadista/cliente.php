<?php

namespace App\Models\calcadista;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class cliente extends Model
{
    use HasFactory;

    /**
     * @return Collection
     */
    public function buscaCliente():Collection
    {
        return DB::table('cliente')->get();
    }

    /**
     * @param int $idCliente
     * @return Collection
     */
    public function buscaClienteId(int $idCliente):Collection{
        return DB::table('cliente')->where('id', $idCliente)->get();
    }
}
