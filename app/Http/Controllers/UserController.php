<?php

namespace App\Http\Controllers;

use App\Enum\EfectivoFpsEnum;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Cargo;
use App\Models\Categoria;
use App\Models\Efectivo;
use App\Models\Quadro_especial;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{  //constructor
    private $fps;
    public function __construct(private User $Repositoryuser, private Cargo $Repositorycargo,
    private Quadro_especial $Repositoryquadro_especial,private Categoria $Repositorycategoria,
    private Unidade $Repositoryunidade, private Efectivo $Repositoryefectivo, private $foto = null)
    {
        //  $this->middleware('auth');
        $this->fps = EfectivoFpsEnum::cases();
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
            $users = $this->Repositoryuser->with(['cargos', 'efectivo'])->get();
            return DataTables::of($users)->make(true);
        }
        return view('User.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $cargos = $this->Repositorycargo->all();
        $fps = $this->fps;
        $quadros = $this->Repositoryquadro_especial->all();
        $categorias = $this->Repositorycategoria->all();
        $unidades = $this->Repositoryunidade->all();
        return view('User.create', compact('cargos', 'fps', 'quadros', 'categorias', 'unidades'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        //
        DB::beginTransaction();
        try {
            $efectivo = Efectivo::create([
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
                'unidade_id' => $request->unidade,
            ]);
            //guardar a foto do utilizador

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $name = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $name);
                $this->foto = $name;
            }

            $user = $efectivo->user()->create([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'efectivo_id' => $efectivo->id,
                'foto' => $this->foto,
            ]);
            $user->cargos()->sync($request->cargos);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Erro ao criar usuário!');
        }
        DB::commit();
        return redirect()->route('user.index')->with('success', 'Usuário criado com sucesso!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        $user = $this->Repositoryuser->with(['cargos', 'efectivo'])->find($user->id);


        return view('User.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
        $cargos = $this->Repositorycargo->all();
        $user = $this->Repositoryuser->with(['cargos', 'efectivo'])->find($user->id);
        $fps =  $this->fps;
        $quadros = $this->Repositoryquadro_especial->all();
        $categorias = $this->Repositorycategoria->all();
        $unidades = $this->Repositoryunidade->all();
        return view('User.update', compact('user', 'cargos', 'fps','quadros', 'categorias', 'unidades'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //

        DB::beginTransaction();
        try {
            // guardar a foto do utilizador
            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $name = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('fotos'), $name);
                $this->foto = $name;
            }

            $user->update([
                'name' => $request->nome,
                'email' => $request->email,
                'password' => (empty($request->password)) ? $user->password :  Hash::make($request->password),
                'foto' => $this->foto ?? $user->foto,
            ]);

            $user->efectivo->update(
                [
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
                    'unidade_id' => $request->unidade,
                ]
            );
            $user->cargos()->sync($request->cargos);
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e->getMessage());
          //  return redirect()->back()->with('error', 'Erro ao atualizar usuário!');
        }
        DB::commit();
        return redirect()->route('user.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        DB::beginTransaction();
        try {

            foreach ($user->cargos as $cargo) {
                $user->cargos()->detach($cargo->id);
            }

            $user->efectivo->delete();
        } catch (\Exception $e) {
            DB::rollback();
            return response([
                'message' => 'Erro ao excluir usuário!' . $e->getMessage(),
                'success' => false
            ], 422);
        }
        DB::commit();
        return response([
            'message' => 'Usuário excluído com sucesso!',
            'success' => true
        ], 200);
    }
}
