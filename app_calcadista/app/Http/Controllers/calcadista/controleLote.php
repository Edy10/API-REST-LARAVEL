<?php

namespace App\Http\Controllers\calcadista;

use App\Models\calcadista\lote;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class controleLote extends Controller
{
    /**
     * @var lote
     */
    private $lotes;

    public function __construct(){
        $this->lotes = new lote();
    }

    /**
     * @return array
     */
    public function index():array
    {
        $lotes = $this->lotes->buscaLote();

        if(count($lotes) > 0):
            $lote = $this->getLote($lotes);
        else:
            $lote['atencao'] = "Não foi localizado lotes cadastrados";
        endif;

        return json_decode(json_encode($lote), true);

    }

    /**
     * @param int $idLote
     * @return array
     */
    public  function show(int $idLote):array
    {
        $lotes = $this->lotes->buscaLoteId($idLote);

        if(count($lotes) > 0):
            $lote = $this->getLote($lotes);
        else:
            $lote['atencao'] = "Lote não localizado";
        endif;

        return json_decode(json_encode($lote), true);
    }

    /**
     * @param $lotes
     * @return array
     */
    public function getLote($lotes): array
    {
        foreach ($lotes as $key => $value) {
            $lote[$key]['id'] = $value->id;
            $lote[$key]['CodLote'] = $value->codLote;
            $lote[$key]['data'] = date('d/m/Y', strtotime($value->data));
            $lote[$key]['quantidade'] = $value->quantidade;
        }
        return $lote;
    }
}
