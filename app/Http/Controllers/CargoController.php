<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Http\Requests\StoreCargoRequest;
use App\Http\Requests\UpdateCargoRequest;
use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CargoController extends Controller
{  //constructor da classe
    public function __construct(private Cargo $cargoRepository, private Permissao $permissaoRepository)

    {
        //  $this->middleware('auth');
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
            $cargos = $this->cargoRepository->all();
            return DataTables::of($cargos)->make(true);
        }
           return view('Cargo.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $permissaos = $this->permissaoRepository->all();
        return view('Cargo.create', compact('permissaos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCargoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCargoRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $cargo = $this->cargoRepository->create($request->all());
            $cargo->permissoes()->sync($request->permissao);
        } catch (\Throwable $th) {
            DB::rollback();
           return redirect()->back()->with('error', 'Erro ao cadastrar cargo'.$th->getMessage());
        }
        DB::commit();
        return redirect()->route('cargo.index')->with('success', 'Cargo cadastrado com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function show(Cargo $cargo)
    {
        //
        $cargo = $cargo->fresh(['permissoes']);
        return view('Cargo.show', compact('cargo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function edit(Cargo $cargo)
    {
        //
        $permissaos = $this->permissaoRepository->all();
        $cargo = $cargo->fresh(['permissoes']);
        return view('Cargo.update', compact('cargo', 'permissaos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCargoRequest  $request
     * @param  \App\Models\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCargoRequest $request, Cargo $cargo)
    {
        //

        DB::beginTransaction();
        try {
            $cargo->update($request->all());
            $cargo->permissoes()->sync($request->permissao);
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar cargo');
        }
        DB::commit();
        return redirect()->route('cargo.index')->with('success', 'Cargo atualizado com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cargo  $cargo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cargo $cargo)
    {
        //
        DB::beginTransaction();
        try {

            $cargo->delete();
        } catch (\Throwable $th) {
            DB::rollback();
            //return redirect()->back()->with('error', 'Erro ao deletar cargo');
            return response([
                'message' => 'Erro ao deletar cargo',
                'success' => false
            ], 422);
        }
        DB::commit();
        return response([
            'message' => 'Cargo deletado com sucesso',
            'success' => true
        ], 200);
    }

}
