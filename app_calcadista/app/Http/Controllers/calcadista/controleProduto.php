<?php

namespace App\Http\Controllers\calcadista;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProdutoStoreRequest;
use App\Models\calcadista\produto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class controleProduto extends Controller
{
    /**
     * @var produto
     */
    private $produto;

    public function __construct(){
       $this->produto = new produto();
   }

    /**
     * @return array
     */
   public function index():array
   {
        $produtos = $this->produto->buscaProdutos();
       if(count($produtos) > 0):
           $produto = $this->getProduto($produtos);
       else:
           $produto['atencao'] = "Produtos indisponíveis";
       endif;

       return json_decode(json_encode($produto), true);
   }

   public function show(int $idProduto){
       $produtos = $this->produto->buscaProdutosId($idProduto);

       if(count($produtos) > 0):
           $produto = $this->getProduto($produtos);
       else:
           $produto['atencao'] = "Produto não localizado.";
       endif;

       return json_decode(json_encode($produto), true);
   }

    /**
     * @param ProdutoStoreRequest $request
     * @return JsonResponse
     */
   public function update(ProdutoStoreRequest $request): JsonResponse
   {
       $dados = $request->validated();

       try{
           $this->produto->updateProduto($dados['id'], $dados['nome'], $dados['idLote'], $dados['cor'], $dados['desc'], $dados['valor']);
       }catch (\Exception $e){
           return response()->json(['status' => 500, 'error' => 'Erro ao realizar a alteração'], 500);
       }

       return response()->json(['status' => 200, 'success' => 'Alterado com sucesso'], 200);
   }

    /**
     * @param $produtos
     * @return array
     */
    public function getProduto($produtos): array
    {
        foreach ($produtos as $key => $value) {
            $produto[$key]['id_produto'] = $value->id;
            $produto[$key]['nome'] = $value->nome;
            $produto[$key]['codLote'] = $value->idLote;
            $produto[$key]['cor'] = $value->cor;
            $produto[$key]['desc'] = $value->desc;
            $produto[$key]['valor'] = number_format($value->valor, 2, ',', '.');
            $produto[$key]['quantidade'] = $value->quantidade;
        }
        return $produto;
    }
}
