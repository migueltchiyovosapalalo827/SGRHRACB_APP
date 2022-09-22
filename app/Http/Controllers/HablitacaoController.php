<?php

namespace App\Http\Controllers;

use App\Enum\HablitacaoTipoEnum;
use App\Models\Hablitacao;
use App\Http\Requests\StoreHablitacaoRequest;
use App\Http\Requests\UpdateHablitacaoRequest;
use App\Models\Efectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class HablitacaoController extends Controller
{
    private  $hablitacaoTipoEnum;
   public function __construct(private Hablitacao $Reposytoryhablitacao,private Efectivo $Repositoryefectivo,
   )
    {
        //$this->middleware('auth');
     $this->hablitacaoTipoEnum = HablitacaoTipoEnum::cases();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            # code...
           $hablitacao = $this->Reposytoryhablitacao->with('efectivo')->get();
            return DataTables::of($hablitacao)->make(true);
        }
        return view('Hablitacao.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $efectivos = $this->Repositoryefectivo->all();
        $tipos = $this->hablitacaoTipoEnum;
        return view('Hablitacao.create', compact('efectivos', 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHablitacaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHablitacaoRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $efectivo = $this->Repositoryefectivo->find($request->efectivo);
            $efectivo->hablitacoes()->create($request->except('efectivo'));

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar Hablitação!');
        }
        DB::commit();
        return redirect()->route('hablitacao.index')->with('success', 'Hablitação criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hablitacao  $hablitacao
     * @return \Illuminate\Http\Response
     */
    public function show(Hablitacao $hablitacao)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hablitacao  $hablitacao
     * @return \Illuminate\Http\Response
     */

    public function edit(Hablitacao $hablitacao)
    {
        //
        $efectivos = $this->Repositoryefectivo->all();
        $tipos = $this->hablitacaoTipoEnum;
        $hablitacao = $hablitacao->fresh(['efectivo']);
        return view('Hablitacao.update', compact('hablitacao', 'efectivos', 'tipos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHablitacaoRequest  $request
     * @param  \App\Models\Hablitacao  $hablitacao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHablitacaoRequest $request, Hablitacao $hablitacao)
    {
        //
        DB::beginTransaction();
        try {
            $hablitacao->update([
                'efectivo_id' => $request->efectivo,
                'tipo' => $request->tipo,
                'nivel' => $request->nivel,
                'nome' => $request->nome,
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar Hablitacao!');
        }
        DB::commit();
        return redirect()->route('hablitacao.index')->with('success', 'Hablitacao atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hablitacao  $hablitacao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hablitacao $hablitacao)
    {
        //
        DB::beginTransaction();
        try {
            $hablitacao->delete();

        } catch (\Exception $e) {
            DB::rollback();
          return response([
            'message' => 'Erro ao remover Hablitacao!',
            'success' => false
          ], 422);

        }
        DB::commit();
       // return redirect()->route('hablitacao.index')->with('success', 'Hablitacao removida com sucesso!');
        return response([
            'message' => 'Hablitacao removida com sucesso!',
            'success' => true
        ], 200);
    }
}
