<?php

namespace App\Http\Controllers;

use App\Models\Permissao;
use App\Http\Requests\StorePermissaoRequest;
use App\Http\Requests\UpdatePermissaoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermissaoController extends Controller
{  //constructor
    public function __construct(private Permissao $Repositorypermissao)
    {
        //$this->middleware('auth');
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
            $permissaos = $this->Repositorypermissao->all();
            return DataTables::of($permissaos)->make(true);
        }
        return view('Permissao.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Permissao.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissaoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePermissaoRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $permissao = $this->Repositorypermissao->create($request->all());
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao cadastrar permissão');
        }
        DB::commit();
        return redirect()->route('permissao.index')->with('success', 'Permissão cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permissao  $permissao
     * @return \Illuminate\Http\Response
     */
    public function show(Permissao $permissao)
    {
        //
        $permissao = $permissao->fresh(['cargos']);
        return view('Permissao.show', compact('permissao'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permissao  $permissao
     * @return \Illuminate\Http\Response
     */
    public function edit(Permissao $permissao)
    {
        //
        return view('Permissao.update',compact('permissao'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissaoRequest  $request
     * @param  \App\Models\Permissao  $permissao
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissaoRequest $request, Permissao $permissao)
    {
        //
        DB::beginTransaction();
        try {
            $permissao->update($request->all());
        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar permissão');
        }
        DB::commit();
        return redirect()->route('permissao.index')->with('success', 'Permissão atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permissao  $permissao
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permissao $permissao)
    {
        //
        DB::beginTransaction();
        try {
            $permissao->delete();
        } catch (\Throwable $th) {
        DB::rollback();
          return response([
            'message' => 'Erro ao excluir permissão',
            'success' => false
          ], 422);
        }
        DB::commit();
        return response([
            'message' => 'Permissão excluída com sucesso',
            'success' => true
        ], 200);
    }
}
