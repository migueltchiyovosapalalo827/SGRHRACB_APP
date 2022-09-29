<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Categoria;
use App\Models\Efectivo;
use App\Models\Hablitacao;
use App\Models\Presenca;
use App\Models\Promocoes;
use App\Models\Quadro_especial;
use App\Models\Subcategoria;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use IntlDateFormatter;

class ReporterController extends Controller
{
    //
    private $pdf;
    public function __construct(
        private Efectivo $RepositoryEfectivo,
        private Cargo $RepositoryCargo,
        private Hablitacao $RepositoryHablitacao,
        private Presenca $RepositoryPresenca,
        private Subcategoria $RepositorySubcategoria,
        private Categoria $RepositoryCategoria,
        private Promocoes $RepositoryPromocoes,
        private Quadro_especial $RepositoryQuadro_especial,
        private Unidade $RepositoryUnidade,
        private DB $db,

    ) {
        $this->pdf = App::make('dompdf.wrapper');
    }

    public function  LISTA_DE_EFECTIVIDADE_DOS_MILITARES_POR_MES(Request $request)
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes', 'cargo', 'presencas'
        ])->whereIn('id', function ($query) use ($request) {
            $query->select('id')->from('presencas')->whereMonth('created_at', $request->mes)->whereYear('created_at', $request->ano);
        })->get();

        if ($request->ajax()) {
            return response()->json(array('success' => true, 'dados' => $efectivo));
        }
        return $this->downloadPdf("", 'efectivos', $efectivo);
    }

    public function LISTA_DE_ANTIGUIDADE_DOS_MILITARES_POR_MES(Request $request)
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'quadro_especial',
            'promocoes'
        ])->where('fps', $request->fps)->get();
        return ($request->ajax()) ?  response()->json(array('success' => true, 'dados' => $efectivo)) :
            $this->downloadPdf("", "", $efectivo);
    }

    public function  LISTA_DOS_MILITAR_PO_NIVEL_ACADEMICO_E_MILITAR()
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'hablitacoes'
        ])->all();

        return response()->json(array('success' => true, 'dados' => $efectivo));
    }


    public function LISTA_DOS_MILITARESPOR_IDADE($print=null)
    {
        $efectivos = $this->RepositoryEfectivo->with([
            'unidade', 'hablitacoes'
        ])->orderBy('nome')->get();

       // return response()->json(array('success' => true, 'dados' => $efectivo));

       return   ($print == null) ?
        view('relatorios.listas.lista_dos_militares_do_racb_por_idade',compact('efectivos')) :
        $this->downloadPdf("relatorios.listas.lista_dos_militares_do_racb_por_idade",'efectivos',$efectivos);
    }

    public function LISTA_DOS_MILITARES_POR_QUADRO_ESPECIAL()
    {
        $efectivo = $this->Repositoryefectivo->with(['Quadro_especial' => function ($query) {
            $query->groupBy('nome');
        }, 'unidade'])->all();

        return response()->json(array('success' => true, 'dados' => $efectivo));
    }

    public function downloadPdf(string $view, string $model, $data)
    {
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        $formatter = new IntlDateFormatter('Africa/luanda', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
        $mes_e_ano = $formatter->format(strtotime('today'));
        $this->pdf->loadView($view,["{$model}"=>$data]);
        return $this->pdf->download("lista_de_{$model}.pdf");
    }
}
