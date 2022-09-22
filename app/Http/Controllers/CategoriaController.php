<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class CategoriaController extends Controller
{
    private $RepositoryCategoria;
    public function __construct(Categoria $categoria)
    {
        $this->RepositoryCategoria = $categoria;
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
            $categorias = $this->RepositoryCategoria->all();
            return DataTables::of($categorias)->make(true);
        }
        return view('categoria.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('categoria.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoriaRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $categoria = $this->RepositoryCategoria->create($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao cadastrar categoria');
        }
        DB::commit();
        return redirect()->route('categorias.index')->with('success', 'Categoria cadastrada com sucesso');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function show(Categoria $categoria)
    {
        //
        $categoria = $categoria->fresh(['subcategorias']);
        return view('categoria.show', compact('categoria'));


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Categoria $categoria)
    {
        //

        return view('categoria.update', compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoriaRequest  $request
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $categoria->update($request->all());
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return redirect()->back()->with('error',  $th->getMessage());
        }
        DB::commit();
        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Categoria  $categoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categoria $categoria)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            if ($categoria->subcategorias->count() > 0) {
                # code...
                throw new \Exception('Não é possível excluir categoria com  subcategorias');
            }
            $categoria->delete();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            return response(['success'=>false,
            'message'=>$th->getMessage()],422);
        }
        DB::commit();
        return response(['success'=>true,
            'message'=>'Categoria deletada com sucesso'],200);
    }
    //retorna todas as subcategorias de uma categoria
    public function getSubcategorias(Categoria $categoria)
    {
        //
        $subcategorias = $categoria->subcategorias;
        return response()->json($subcategorias);
    }
}
