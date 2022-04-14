<?php

namespace App\Models\calcadista;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class lote extends Model
{
    use HasFactory;

    /**
     * @return Collection
     */
    public function buscaLote(): Collection
    {
        return DB::table('lote')->get();
    }

    /**
     * @param int $idLote
     * @return Model|Builder|object|null
     */
    public function buscaLoteId(int $idLote)
    {
        return DB::table('lote')->where('id', $idLote)->get();
    }
}
