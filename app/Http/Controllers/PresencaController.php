<?php

namespace App\Http\Controllers;

use App\Enum\PresencaMotivoEnum;
use App\Models\Presenca;
use App\Http\Requests\StorePresencaRequest;
use App\Http\Requests\UpdatePresencaRequest;
use App\Models\Efectivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PresencaController extends Controller
{
    //constructor da classe presencaController
    private $presencaMotivoEnum;
    public function __construct(private Presenca $presencaRepository, private Efectivo $efectivoRepository)
    {
        //  $this->middleware('auth');
    $this->presencaMotivoEnum = PresencaMotivoEnum::cases();
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
            $presenca = $this->presencaRepository->with(['efectivo'])->get();
            return DataTables::of($presenca)->make(true);
        }
        return view('Presenca.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $efectivos = $this->efectivoRepository->all();
        $motivos = $this->presencaMotivoEnum;

        return view('Presenca.create', compact('efectivos', 'motivos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePresencaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePresencaRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $efectivo = $this->efectivoRepository->find($request->efectivo);
            $presenca = $efectivo->presencas()->create(
                [
                   'ausente' =>  $request->ausente,
                    'motivo' => $request->motivo,
                ]
            );
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar Presenca!');
        }
        DB::commit();
        return redirect()->route('presenca.index')->with('success', 'Presenca criada com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Presenca  $presenca
     * @return \Illuminate\Http\Response
     */
    public function show(Presenca $presenca)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Presenca  $presenca
     * @return \Illuminate\Http\Response
     */
    public function edit(Presenca $presenca)
    {
        //
        $efectivos = $this->efectivoRepository->all();
        $motivos = $this->presencaMotivoEnum;
        $presenca = $presenca->fresh(['efectivo']);
        return view('Presenca.update', compact('presenca', 'efectivos', 'motivos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePresencaRequest  $request
     * @param  \App\Models\Presenca  $presenca
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePresencaRequest $request, Presenca $presenca)
    {
        //
        DB::beginTransaction();
        try {
            $presenca->update( [
                'ausente' =>$request->ausente,
                 'motivo' => $request->motivo,
             ]);
            $efectivo = $this->efectivoRepository->find($request->efectivo);
            $presenca->efectivo()->associate($efectivo);
            $presenca->save();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao editar Presenca!');
        }
        DB::commit();
        return redirect()->route('presenca.index')->with('success', 'Presenca actualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Presenca  $presenca
     * @return \Illuminate\Http\Response
     */
    public function destroy(Presenca $presenca)
    {
        //


        DB::beginTransaction();
        try {
            $presenca->delete();
        } catch (\Exception $e) {
            DB::rollback();
           // return redirect()->route('presenca.index')->with('error', 'Erro ao excluir Presenca!');
           return response([
            'message' =>  'Erro ao excluir Presenca!',
            'success' => false
           ],422);
        }
        DB::commit();
        return response([
            'message' =>  'presença excluida com sucesso!',
            'success' => false
           ],200);

    }
}
