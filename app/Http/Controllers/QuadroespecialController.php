<?php

namespace App\Http\Controllers;

use App\Models\Quadro_especial;
use App\Http\Requests\StoreQuadro_especialRequest;
use App\Http\Requests\UpdateQuadro_especialRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class QuadroespecialController extends Controller
{
    //constructor do quadroespecial
    public function __construct(private Quadro_especial $quadro_especialRepository)
    {
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
            $quadro_especial = $this->quadro_especialRepository->all();
            return DataTables::of($quadro_especial)->make(true);
        }

        return view('Quadro_especial.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('Quadro_especial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreQuadro_especialRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQuadro_especialRequest $request)
    {
        //
        DB::beginTransaction();
        try {

            $quadro_especial = $this->quadro_especialRepository->create($request->all());

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar Quadro_especial!');
        }
        DB::commit();
       return redirect()->route('quadro_especial.index')->with('success', 'Quadro_especial criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Quadro_especial  $quadro_especial
     * @return \Illuminate\Http\Response
     */
    public function show(Quadro_especial $quadro_especial)
    {
        //
        return view('Quadro_especial.show', compact('quadro_especial'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Quadro_especial  $quadro_especial
     * @return \Illuminate\Http\Response
     */
    public function edit(Quadro_especial $quadro_especial)
    {
        //
        return view('Quadro_especial.update', compact('quadro_especial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQuadro_especialRequest  $request
     * @param  \App\Models\Quadro_especial  $quadro_especial
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQuadro_especialRequest $request, Quadro_especial $quadro_especial)
    {
        //
        DB::beginTransaction();
        try {
            $quadro_especial = $quadro_especial->update($request->all());

        } catch (\Throwable $th) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao atualizar Quadro_especial!');
        }
        DB::commit();
        return redirect()->route('quadro_especial.index')->with('success', 'Quadro_especial atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Quadro_especial  $quadro_especial
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quadro_especial $quadro_especial)
    {
        //
        DB::beginTransaction();
        try {
            $quadro_especial->delete();

        } catch (\Throwable $th) {
            DB::rollback();
            return response(['message'=>'Erro ao deletar Quadro_especial!',
                             'success'=>false],422);//redirect()->back()->with('error', 'Erro ao deletar Quadro_especial!');
        }
        DB::commit();
        return response(['message'=>'Quadro_especial deletado com sucesso!',
                         'success'=>true],200);

    }
}
