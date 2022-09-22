<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Http\Requests\StoreSubcategoriaRequest;
use App\Http\Requests\UpdateSubcategoriaRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class SubcategoriaController extends Controller
{
    public function __construct(
        private Subcategoria $subcategoriarepository,
        private Categoria $categoriarepository
    ) {
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {    if ($request->ajax()) {
            # code...
            $subcategorias = $this->subcategoriarepository->with('categoria')->get();
            return DataTables::of($subcategorias)->make(true);
        }
        return view('subcategoria.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categorias = $this->categoriarepository->all();
        return view('subcategoria.create', compact('categorias'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSubcategoriaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSubcategoriaRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            /*  $categoriarepository = $this->categoriarepository->find($request->categoria);
            $subcategoria = $categoriarepository->subcategorias()->create(['nome' => $request->nome]); */
            $subcategoria = $this->categoriarepository ->find($request->categoria)->subcategorias()->create(['nome' => $request->nome]);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return  redirect()->back()->with('error', 'ocorreu um  erro de sistema  ao cadastrar subcategoria');
        }
        DB::commit();
        return redirect()->route('subcategoria.index')->with('success', 'Subcategoria cadastrada com sucesso');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Subcategoria  $subcategoria
     * @return \Illuminate\Http\Response
     */
    public function show(Subcategoria $subcategorium)
    {
        //
        $subcategoria = $subcategorium->fresh(['categoria']);
        return view('subcategoria.show', compact('subcategoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subcategoria  $subcategoria
     * @return \Illuminate\Http\Response
     */
    public function edit(Subcategoria $subcategorium)
    {
        //
        $categorias = $this->categoriarepository->all();
        $subcategoria = $subcategorium->fresh(['categoria']);
       return view('subcategoria.update', compact('subcategoria', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSubcategoriaRequest  $request
     * @param  \App\Models\Subcategoria  $subcategoria
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSubcategoriaRequest $request, Subcategoria $subcategorium)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $subcategorium->update(
                [
                    'nome' => $request->nome,
                    'categoria_id' => $request->categoria
                ]
            );
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao atualizar subcategoria'.$th->getMessage());
        }
        DB::commit();
        return redirect()->route('subcategoria.index')->with('success', 'Subcategoria atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subcategoria  $subcategoria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategoria $subcategorium)
    {
        //
        DB::beginTransaction();
        try {
            //code...
            $subcategorium->delete();
        } catch (\Throwable $th) {
            //throw $th;

            DB::rollBack();
            return  response([
                'message' => 'Erro ao excluir subcategoria'.$th->getMessage(),
                'success'=>false,
                  ], 422);
        }
        DB::commit();
        return  response([
            'message' => 'Subcategoria excluida com sucesso',
            'success'=>true,
              ], 200);
    }
}
