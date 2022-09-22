<?php

namespace App\Http\Controllers;

use App\Enum\EfectivoFpsEnum;
use App\Models\Efectivo;
use App\Http\Requests\StoreEfectivoRequest;
use App\Http\Requests\UpdateEfectivoRequest;
use App\Models\Cargo;
use App\Models\Categoria;
use App\Models\Promocoes;
use App\Models\Quadro_especial;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class EfectivoController extends Controller
{
    //constructor
    public function __construct(
        private Efectivo $Repositoryefectivo,
        private Unidade $Repositoryunidade,
        private Categoria $Repositorycategoria,
        private Quadro_especial $Repositoryquadro_especial,
        private Cargo $RepositoryCargo,
        private $foto = null
    ) {
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
            $efectivos = $this->Repositoryefectivo->with([
                'unidade', 'subcategoria', 'quadro_especial',
                'promocoes', 'hablitacoes', 'cargo'
            ])->get();
            return DataTables::of($efectivos)->make(true);
        }
        return view('Efectivo.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $unidades = $this->Repositoryunidade->all();
        $quadros = $this->Repositoryquadro_especial->all();
        $fps = EfectivoFpsEnum::cases();
        $cargos = $this->RepositoryCargo->all();
        $categorias = $this->Repositorycategoria->all();
        return view('Efectivo.create', compact('unidades', 'quadros', 'fps', 'cargos', 'categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEfectivoRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEfectivoRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            # code...
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $name = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $name);
                $this->foto = $name;
            }
            $efectivo = $this->Repositoryunidade->find($request->unidade)
                ->efectivos()->create([
                    'nome' => $request->nome,
                    'nip' => $request->nip,
                    'numero_do_bi' => $request->numero_do_bi,
                    'data_de_emissao' => $request->data_de_emissao,
                    'data_de_nascimento' => $request->data_de_nascimento,
                    'data_de_incorporacao' => $request->data_de_incorporacao,
                    'genero' => $request->genero,
                    'iban' => $request->iban,
                    'fliacao' => $request->fliacao,
                    'fps' => $request->forma_de_prestacao_de_servico,
                    'quadro_especial_id' => $request->quadro_especial,
                    'subcategoria_id' => $request->subcategoria,
                    'cargo_id' => $request->cargo,
                    'foto' => $this->foto
                ]);
                $efectivo->promocoes()->create([
                    'actual' => $request->data_de_incorporacao,
                ]);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar Efectivo!');
        }
        DB::commit();
        return redirect()->route('efectivos.index')->with('success', 'Efectivo criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Efectivo  $efectivo
     * @return \Illuminate\Http\Response
     */
    public function show(Efectivo $efectivo)
    {
        //
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes', 'cargo'
        ])->find($efectivo->id);
        return view('Efectivo.show', compact('efectivo'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Efectivo  $efectivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Efectivo $efectivo)
    {
        //
        $fps = EfectivoFpsEnum::cases();
        $unidades = $this->Repositoryunidade->all();
        $quadros = $this->Repositoryquadro_especial->all();
        $cargos = $this->RepositoryCargo->all();
        $categorias = $this->Repositorycategoria->all();
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial', 'cargo'
        ])->find($efectivo->id);

        return view('Efectivo.update', compact('efectivo', 'unidades', 'quadros', 'fps', 'cargos', 'categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEfectivoRequest  $request
     * @param  \App\Models\Efectivo  $efectivo
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEfectivoRequest $request, Efectivo $efectivo)
    {
        //
        DB::beginTransaction();
        try {
            # code...
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $name = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $name);
                $this->foto = $name;
            }

            $efectivo->nome = $request->nome;
            $efectivo->nip = $request->nip;
            $efectivo->numero_do_bi = $request->numero_do_bi;
            $efectivo->data_de_emissao = $request->data_de_emissao;
            $efectivo->data_de_nascimento = $request->data_de_nascimento;
            $efectivo->data_de_incorporacao = $request->data_de_incorporacao;
            $efectivo->genero = $request->genero;
            $efectivo->iban = $request->iban;
            $efectivo->fliacao = $request->fliacao;
            $efectivo->fps = $request->forma_de_prestacao_de_servico;
            $efectivo->quadro_especial_id = $request->quadro_especial;
            $efectivo->subcategoria_id = $request->subcategoria;
            $efectivo->unidade_id = $request->unidade;
            $efectivo->foto = $this->foto ?? $efectivo->foto;
            ($efectivo->user) ? $efectivo->user->cargos->sync($request->cargo) :
                $efectivo->cargo_id = $request->cargo;
            $efectivo->save();
        } catch (\Exception $e) {
            DB::rollback();
             return redirect()->back()->with('error', 'Erro ao atualizar Efectivo!');
        }
        DB::commit();
        return redirect()->route('efectivos.index')->with('success', 'Efectivo atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Efectivo  $efectivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Efectivo $efectivo)
    {
        //
        DB::beginTransaction();
        try {
            # code...
            $efectivo->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'message' => 'Erro ao remover Efectivo!',
                'success' => false
            ], 422);
        }
        DB::commit();
        return response([
            'message' => 'Efectivo removido com sucesso!',
            'success' => true
        ], 200);
    }
    //lista de efectivo por unidade
    public function listaEfectivoUnidade($id)
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes'
        ])->where('unidade_id', $id)->get();
        return response()->json($efectivo);
    }

    //lista de efectivo por subcategoria
    public function listaEfectivoSubcategoria($id)
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes'
        ])->where('subcategoria_id', $id)->get();
        return response()->json($efectivo);
    }

    //lista de efectivo por quadro especial
    public function listaEfectivoQuadroEspecial($id)
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes'
        ])->where('quadro_especial_id', $id)->get();
        return response()->json($efectivo);
    }


    //lista de efectivo por habilitacao
    public function listaEfectivoHabilitacao()
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'hablitacoes'
        ])->all();
        return response()->json($efectivo);
    }
    //lista de efectivo por idade
    public function listaEfectivoIdade()
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes'
        ])->orderBy('data_de_nascimento', 'asc')->get();
        return response()->json($efectivo);
    }

    //lista de efectivo por tempo de servico
    public function listaEfectivoTempoServico()
    {
        $efectivo = $this->Repositoryefectivo->with([
            'unidade', 'subcategoria', 'quadro_especial',
            'promocoes', 'hablitacoes'
        ])->orderBy('data_de_incorporacao', 'asc')->get();
        return response()->json($efectivo);
    }
}
