<?php

namespace App\Http\Controllers;

use App\Models\Promocoes;
use App\Http\Requests\StorePromocoesRequest;
use App\Http\Requests\UpdatePromocoesRequest;
use App\Models\Categoria;
use App\Models\Efectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PromocoesController extends Controller
{
    public function __construct(private Promocoes $RepositoryPromocoes, private Efectivo $RepositoryEfectivo,
     private Categoria $Repositorycategoria)

    {
        //
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
            $promocoes = $this->RepositoryPromocoes->with('efectivo','Subcategoria_anterior')->get();
            return DataTables::of($promocoes)->make(true);
        }
        return view('Promocoes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $efectivos = $this->RepositoryEfectivo->all();
        $categorias = $this->Repositorycategoria->all();
        return view('Promocoes.create', compact('efectivos','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePromocoesRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePromocoesRequest $request)
    {
        //
        DB::beginTransaction();
        try {

         $efectivo = $this->RepositoryEfectivo->find($request->efectivo);
         $promocoes = Promocoes::where(['efectivo_id' => $efectivo->id])->get();

         if ($promocoes->count() > 0) {
             $promocoes  =  Promocoes::where(['efectivo_id' => $efectivo->id])->first();
             $promocoes->anterior = $promocoes->actual;
             $promocoes->actual = $request->data_da_actual_promocao;
             $promocoes->anterior_subcategoria_id = $efectivo->subcategoria->id;
             $promocoes->save();
             $efectivo->subcategoria_id = $request->subcategoria;
             $efectivo->save();
             }else{
                $efectivo->promocoes()->create([
                    'actual' => $request->data_da_actual_promocao,
                    'anterior_subcategoria_id' => $request->subcategoria->id,
                    'anterior' => $efectivo->data_de_incorporacao

                ]);

             }


        } catch (\Exception $e) {
            DB::rollback();
            return dd($e->getMessage());
           // return redirect()->back()->with('error','ocorreu um erro ao registrar a promoção  '.$e->getMessage());
        }
        DB::commit();
        return redirect()->route('promocoes.index')->with('success', 'Promoção registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Promocoes  $promocoes
     * @return \Illuminate\Http\Response
     */
    public function show(Promocoes $promoco)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Promocoes  $promocoes
     * @return \Illuminate\Http\Response
     */
    public function edit(Promocoes $promoco)
    {
        //
        $efectivos = $this->RepositoryEfectivo->all();
        $categorias = $this->Repositorycategoria->all();
        return view('Promocoes.update', compact('promoco', 'efectivos','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePromocoesRequest  $request
     * @param  \App\Models\Promocoes  $promocoes
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePromocoesRequest $request, Promocoes $promoco)
    {
        //
        DB::beginTransaction();
        try {
            $promoco->actual = $request->data_da_actual_promocao;
            $promoco->efectivo_id = $request->efectivo;
            $promoco->save();
            $promoco->efectivo->subcategoria_id = $request->subcategoria;
            $promoco->efectivo->save();

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error','ocorreu um erro ao atualizar a promoção  '.$e->getMessage());
        }
        DB::commit();
        return redirect()->route('promocoes.index')->with('success', 'Promoção atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Promocoes  $promocoes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Promocoes $promoco)
    {
        //
        DB::beginTransaction();
        try {
            $promoco->delete();

        } catch (\Exception $e) {
            DB::rollback();
           return response([
                'message' => 'ocorreu um erro ao remover a promoção  '.$e->getMessage(),
               'success' =>false
            ], 422);
        }
        DB::commit();
        return response([
            'message' => 'Promoção removida com sucesso!',
            'success' =>true
        ], 200);
    }

    //get promocoes by efectivo
    public function getPromocoesByEfectivo($id)
    {
        $promocoes = $this->RepositoryPromocoes->where('efectivo_id', $id)->frist();
        return response()->json($promocoes);
    }
}
