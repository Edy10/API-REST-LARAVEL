<?php

namespace App\Http\Controllers\calcadista;

use App\Http\Controllers\Controller;
use App\Models\calcadista\vendedor;
use Illuminate\Http\Request;

class controleVendedor extends Controller
{
    /**
     * @var vendedor
     */
    private $vendedores;

    public function __construct()
    {
        $this->vendedores = new vendedor();
    }

    /**
     * @return mixed
     */
    public function index(){
        $vendedores = $this->vendedores->buscaVendedores();

        if(count($vendedores) > 0):
            $vendedores = $this->getLote($vendedores);
        else:
            $vendedores['atencao'] = "Não foi localizado vendedores cadastrado.";
        endif;

        return json_decode(json_encode($vendedor), true);
    }

    /**
     * @param int $idVendedor
     * @return mixed
     */
    public function buscaVendedoresId(int $idVendedor){
        $vendedor = $this->vendedores->buscaVendedorId($idVendedor);

        if(count($vendedor) > 0):
            $vendedor = $this->getLote($vendedor);
        else:
            $vendedor['atencao'] = "Vendedor não localizado.";
        endif;

        return json_decode(json_encode($vendedor), true);
    }

    /**
     * @param $vendedores
     * @return array
     */
    public function getLote($vendedores): array
    {
        foreach ($vendedores as $key => $value) {
            $vendedor[$key]['id']       = $value->id;
            $vendedor[$key]['cpf']      = $value->cpf;
            $vendedor[$key]['nome']     = $value->name;
            $vendedor[$key]['email']    = $value->email;
            $vendedor[$key]['situacao'] = $value->situacao;
        }
        return $vendedor;
    }
}
