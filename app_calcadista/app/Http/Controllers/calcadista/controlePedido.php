<?php

namespace App\Http\Controllers\calcadista;

use App\Http\Controllers\Controller;
use App\Http\Requests\PedidoStoreRequest;
use App\Models\calcadista\notaFiscal;
use App\Models\calcadista\pedido;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class controlePedido extends Controller
{

    /**
     * @var pedido
     */
    private $pedidos;
    /**
     * @var notaFiscal
     */
    private $nf;

    public function __construct()
    {
        $this->pedidos = new pedido();
        $this->nf = new notaFiscal();
    }

    public function index():array
    {
        $dadosVendas = $this->pedidos->buscaPedidos();

        if(count($dadosVendas) > 0):
            $dados = $this->getPedidos($dadosVendas);
        else:
            $dados['atencao'] = "Pedido não localizada";
        endif;

        return json_decode(json_encode($dados), true);
    }

    /**
     * @param int $idUser
     * @return array
     */
    public function show(int $idUser):array
    {
        $dadosVendas = $this->pedidos->buscaPedidosId($idUser);

        return json_decode(json_encode($dadosVendas), true);
    }

    /**
     * @param PedidoStoreRequest $request
     * @return JsonResponse
     */
    public function update(PedidoStoreRequest $request): JsonResponse
    {
        $total = 0;
        $dados = $request->validated();

        try{
            $this->pedidos->updatePedido($dados['idPedido'], $dados['idProduto'], $dados['qtdProduto'], $dados['valor']);
            //Busca os pedidos do cliente e soma o valor para alterar na nota
            $dadosNota = $this->pedidos->verificaPedidoCliente($dados['idCliente'], $dados['idNota']);
            foreach ($dadosNota as $value){
                $total = $total + $value->valor;
            }
            //Altera o valor na nota fiscal.
            $this->nf->alteraNota($dados['idNota'], $total);
        }catch (\Exception $e){
            return response()->json(['status' => 500, 'error' => 'Erro ao realizar a alteração'], 500);
        }

        return response()->json(['status' => 200, 'success' => 'Alterado com sucesso'], 200);
    }

    /**
     * @param $pedidos
     * @return array
     */
    public function getPedidos($pedidos): array
    {
        foreach($pedidos as $key => $value ){
            $dados[$key]['id_cliente']    = $value->id_cliente;
            $dados[$key]['nome_cliente']  = $value->nome_cliente;
            $dados[$key]['id_produto']    = $value->id_produto;
            $dados[$key]['nome_produto']  = $value->nome_produto;
            $dados[$key]['cor_produto']   = $value->cor_produto;
            $dados[$key]['desc_produto']  = $value->desc_produto;
            $dados[$key]['id_lote']       = $value->id_lote;
            $dados[$key]['valor_produto'] = number_format($value->valor_produto, 2, ',', '.');
            $dados[$key]['id_pedido']     = $value->id_pedido;
            $dados[$key]['id_nota']       = $value->id_nota;
            $dados[$key]['qtd_produto']   = $value->qtd_produto;
            $dados[$key]['data_compra']   =  date('d/m/Y', strtotime($value->data_compra));
        }
        return $dados;
    }
}
