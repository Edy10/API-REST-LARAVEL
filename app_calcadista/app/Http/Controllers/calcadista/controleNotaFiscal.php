<?php

namespace App\Http\Controllers\calcadista;

use App\Http\Controllers\Controller;
use App\Models\calcadista\notaFiscal;
use Illuminate\Http\Request;

class controleNotaFiscal extends Controller
{
    /**
     * @var notaFiscal
     */
    private $notaFiscal;

    public function __construct()
    {
         $this->notaFiscal = new notaFiscal();
    }

    public function index(){
        $notas = $this->notaFiscal->buscaNotaFiscal();

        if(count($notas) > 0):
            $notas = $this->getNotaFiscal($notas);
        else:
            $notas['atencao'] = "Não foi localizado Notas Fiscais cadastrados";
        endif;

        return json_decode(json_encode($notas), true);
    }

    public function show(int $idNota){
        $nota = $this->notaFiscal->buscaNotaFiscalId($idNota);

        if(count($nota) > 0):
            $nota = $this->getNotaFiscal($nota);
        else:
            $nota['atencao'] = "Nota Fiscal não localizado";
        endif;

        return json_decode(json_encode($nota), true);
    }

    /**
     * @param $notas
     * @return array
     */
    public function getNotaFiscal($notas): array
    {
        foreach ($notas as $key => $value) {
            $nota[$key]['id'] = $value->id;
            $nota[$key]['total'] = number_format($value->total, 2, ',', '.');
        }
        return $nota;
    }
}
