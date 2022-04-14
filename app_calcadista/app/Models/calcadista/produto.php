<?php

namespace App\Models\calcadista;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class produto extends Model
{
    use HasFactory;

    /**
     * @return Collection
     */
    public function buscaProdutos():Collection
    {
        return DB::table('produto')->join('lote', 'produto.idLote', '=', 'lote.id')
                 ->select('produto.*', 'lote.quantidade')->get();
    }

    /**
     * @param int $idProduto
     * @return Collection
     */
    public function buscaProdutosId(int $idProduto): Collection
    {
        return DB::table('produto')->join('lote', 'produto.idLote', '=', 'lote.id')
            ->select('produto.*', 'lote.quantidade')
            ->where('produto.id', $idProduto)
            ->get();
    }

    /**
     * @param int $id
     * @param $nome
     * @param int $idLot
     * @param $cor
     * @param $desc
     * @param $valor
     * @return int
     */
    public function updateProduto(int $id, $nome, int $idLot, $cor, $desc, $valor): int
    {
        return  DB::table('produto')
            ->where('id', $id)
            ->update(['nome' => $nome, 'idLote' => $idLot, 'cor' => $cor, 'desc' => $desc, 'valor' => $valor]);
    }
}
