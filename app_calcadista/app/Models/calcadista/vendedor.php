<?php

namespace App\Models\calcadista;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class vendedor extends Model
{
    use HasFactory;

    /**
     * @return Collection
     */
    public function buscaVendedores():Collection
    {
        return DB::table('vendedor')->get();
    }

    /**
     * @param int $idVendedor
     * @return Collection
     */
    public function buscaVendedorId(int $idVendedor): Collection
    {
        return DB::table('vendedor')->where('id', $idVendedor)->get();
    }
}
