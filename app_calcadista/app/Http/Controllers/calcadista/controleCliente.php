<?php

namespace App\Http\Controllers\calcadista;

use App\Http\Controllers\Controller;
use App\Models\calcadista\cliente;
use Illuminate\Http\Request;

class controleCliente extends Controller
{
    /**
     * @var controleCliente
     */
    private $clientes;

    public function __construct()
   {
       $this->clientes = new cliente();
   }

   public function index():array
   {
        $clientes = $this->clientes->buscaCliente();

       if(count($clientes) > 0):
           $clientes = $this->getClientes($clientes);
       else:
           $clientes['atencao'] = "Não foi localizado cadastro de clientes.";
       endif;

       return json_decode(json_encode($clientes), true);
   }

   public function show(int $idCliente):array
   {
        $cliente = $this->clientes->buscaClienteId($idCliente);

       if(count($cliente) > 0):
           $cliente = $this->getClientes($cliente);
       else:
           $cliente['atencao'] = "Cliente não localizado.";
       endif;

       return json_decode(json_encode($cliente), true);
   }

    /**
     * @param $clientes
     * @return array
     */
    public function getClientes($clientes): array
    {
        foreach ($clientes as $key => $value) {
            $cliente[$key]['id'] = $value->id;
            $cliente[$key]['cpf'] = $value->cpf;
            $cliente[$key]['nome'] = $value->nome;
            $cliente[$key]['dtnascimento'] = date('d/m/Y', strtotime($value->dtnascimento));
        }
        return $cliente;
    }
}
