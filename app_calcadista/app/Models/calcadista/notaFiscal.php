<?php

namespace App\Models\calcadista;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class notaFiscal extends Model
{
    use HasFactory;

    /**
     * @return Collection
     */
    public function buscaNotaFiscal():Collection
    {
        return DB::table('notafiscal')->get();
    }

    /**
     * @param int $idNota
     * @return Builder|Model|object
     */
    public function buscaNotaFiscalId(int $idNota)
    {
        return DB::table('notafiscal')->where('id', $idNota)->get();
    }

    /**
     * @param int $idNota
     * @param $valor
     * @return int
     */
    public function alteraNota(int $idNota, $valor){
        return  DB::table('notafiscal')
            ->where('id', $idNota)
            ->update(['total' => $valor]);
    }
}
