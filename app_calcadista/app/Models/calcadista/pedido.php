<?php

namespace App\Models\calcadista;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class pedido extends Model
{
    use HasFactory;

    /**
     * @return array
     */
    public function buscaPedidos():array{
        return DB::select("
            SELECT c.nome       as \"nome_cliente\",
                   pd.id        as \"id_produto\",
                   pd.nome      as \"nome_produto\",
                   pd.cor       as \"cor_produto\",
                   pd.desc      as \"desc_produto\",
                   p.qtdProduto as \"qtd_produto\",
                   p.dataCompra as \"data_compra\",
                   pd.valor     as \"valor_produto\",
                   p.id         as \"id_pedido\",
                   p.idNota     as \"cod_nota\"
              FROM pedido p
                 , produto pd
                 , vendedor v
                 , cliente c
                 , lote l
            WHERE p.idProduto  = pd.id
              and p.idVendedor = v.id
              and p.idCliente  = c.id
              and pd.idLote    = l.id
            order by p.id;"
        );
    }

    /**
     * @param int $idUser
     * @return LengthAwarePaginator
     */
    public function buscaPedidosId(int $idUser): LengthAwarePaginator
    {
        return DB::table('pedido')
            ->join('produto', 'produto.id', '=', 'pedido.idProduto')
            ->join('vendedor', 'vendedor.id', '=', 'pedido.idVendedor')
            ->join('cliente', 'cliente.id', '=', 'pedido.idCliente')
            ->join('lote', 'lote.id', '=', 'produto.idLote')
            ->select('pedido.idCliente as id_cliente'
                            , 'cliente.nome as nome_cliente'
                            , 'produto.id as id_produto'
                            , 'produto.nome as nome_produto'
                            , 'produto.cor as cor_produto'
                            , 'produto.desc as desc_produto'
                            , 'produto.idLote as id_lote'
                            , 'produto.valor as valor_produto'
                            , 'pedido.id as id_pedido'
                            , 'pedido.idNota as id_nota'
                            , 'pedido.qtdProduto as qtd_produto'
                            , 'pedido.dataCompra as data_compra'
            )
            ->where('vendedor.id', $idUser)
            ->orderBy('pedido.id')
            ->orderBy('pedido.dataCompra')
            ->paginate(2);

    }

    /**
     * @param int $idCliente
     * @param int $idNota
     * @return Collection
     */
    public function verificaPedidoCliente(int $idCliente, int $idNota): Collection
    {
        return DB::table('pedido')->join('notafiscal', 'pedido.idNota', '=', 'notafiscal.id')
            ->select('pedido.idNota', 'pedido.valor')
            ->where('pedido.idCliente', $idCliente)
            ->where('pedido.idNota', $idNota)
            ->get();
    }

    /**
     * @param int $idPedido
     * @param int $idProduto
     * @param int $qtdProduto
     * @param $valor
     * @return int
     */
    public function updatePedido(int $idPedido, int $idProduto, int $qtdProduto, $valor): int
    {
        return  DB::table('pedido')
                ->where('id', $idPedido)
                ->update(['idProduto'=> $idProduto, 'qtdProduto' => $qtdProduto,'valor' => $valor]);
    }
}
