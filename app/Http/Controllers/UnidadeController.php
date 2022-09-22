<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use App\Http\Requests\StoreUnidadeRequest;
use App\Http\Requests\UpdateUnidadeRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class UnidadeController extends Controller
{
    private $RepositoryUnidade,$pdf;
    public function __construct(Unidade $unidade)
    {
        $this->RepositoryUnidade = $unidade;
        $this->pdf =  App::make('dompdf.wrapper');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //yarjadatables
        if ($request->ajax()) {
            # code...
            $unidades = $this->RepositoryUnidade->all();
            return Datatables::of($unidades)->make(true);
        }

        return view('unidade.index');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('unidade.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUnidadeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUnidadeRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $this->RepositoryUnidade->create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao cadastrar unidade');
        }
        DB::commit();

        return redirect()->route('unidades.index')->with('success', 'Unidade criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function show(Unidade $unidade)
    {
        //
        $unidade = $unidade->fresh(['efectivos']);
        return view('unidade.show', compact('unidade'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidade $unidade)
    {
        //
        return view('unidade.update', compact('unidade'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUnidadeRequest  $request
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUnidadeRequest $request, Unidade $unidade)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $unidade->update($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar unidade');
        }
        DB::commit();
        return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Unidade  $unidade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidade $unidade)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            if ($unidade->efectivos->count() > 0) {
                # code...
                throw new Exception("Não é possível excluir unidade com efectivos", 1);
            }

            $unidade->delete();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response(['success'=>false,
            'message'=>$th->getMessage()],422);
        }
        DB::commit();
        return response(['success'=>true,
            'message'=>'Unidade excluída com sucesso!'],200);

    }

    //função para retornar todas as unidades com efectivos
    public function getUnidades()
    {
        $unidades = Unidade::with('efectivos')->get();
        return $unidades;
    }

    //função imprimir relatorio de unidades
    public function imprimirRelatorio()
    {
        $unidades = $this->getUnidades();
        $this->pdf->loadView('unidade.imprimirRelatorio', compact('unidades'));
        return $this->pdf->download('lista_de_unidades_efectivos.pdf');
    }
    //função imprimir a lista de efectivos de uma unidade com dompdf
    public function imprimirListaEfectivos(Unidade $unidade)
    {
        $unidade = $unidade->fresh(['efectivos']);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('Africa/luanda');

        $mes_e_ano = strftime('%B DE %Y', strtotime('today'));
        $this->pdf->loadView('unidade.imprimirListaEfectivos', compact('unidade', 'mes_e_ano'));
        return $this->pdf->download('lista_efectivos.pdf');
    }



}
