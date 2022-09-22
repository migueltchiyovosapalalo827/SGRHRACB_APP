@extends('adminlte::page')

@section('title', 'efectivos')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1> RACB-SECÇÃO DE PESSOAL E QUADROS</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">efectivos</a></li>
                <li class="breadcrumb-item active">visualizar</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('fotos') }}/{{ $efectivo->foto ?? $efectivo->user->foto }}"
                                    alt="">
                            </div>

                            <h3 class="profile-username text-center">{{ $efectivo->nome }}</h3>

                            <p class="text-muted text-center">Nip nº: {{ $efectivo->nip }}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                @if ($efectivo->cargo !== null)
                                    <li class="list-group-item">
                                        <b>{{ $efectivo->cargo->nome }}</b> <a class="float-right">
                                            {{ $efectivo->created_at->format('d-m-Y') }}</a>
                                    </li>
                                @else
                                    @foreach ($efectivo->user->cargos as $cargo)
                                        <li class="list-group-item">
                                            <b>{{ $cargo->nome }}</b> <a class="float-right">
                                                {{ $efectivo->created_at->format('d-m-Y') }}</a>
                                        </li>
                                    @endforeach
                                @endif


                            </ul>

                            <a href="#" class="btn btn-primary btn-block"><b>Cargos que Exerce</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Perfil</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-book mr-1"></i>categoria Militar</strong>

                            <p class="text-muted">
                                categoria: {{ $efectivo->subcategoria->categoria->nome }}
                                subcategoria: {{ $efectivo->subcategoria->nome }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Unidade-posto</strong>

                            <p class="text-muted">{{ $efectivo->unidade->nome }}</p>



                            <hr>

                            <strong><i class="fas fa-pencil-alt mr-1"></i>Especialidade</strong>

                            <p class="text-muted">

                                <span class="tag tag-success">{{ $efectivo->quadro_especial->nome }}</span>

                            </p>

                            <hr>

                            <strong><i class="far fa-file-alt mr-1"></i> Forma de prestação de serviço</strong>
                            <p class="text-muted">
                                {{ $efectivo->fps }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity"
                                        data-toggle="tab">Informaçõe Pessoais</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Hablitação </a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Promoções</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="activity">
                                    <!-- Post -->
                                    <div class="post">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">BI Numero </h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->numero_do_bi }} emitido aos
                                                    {{ $efectivo->data_de_emissao }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Data de Nascimento
                                                </h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->data_de_nascimento }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Idade</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->age }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Data de incorporação</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->data_de_incorporacao }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Tempo de serviço</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->tempo_de_servico }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <h6 class="mb-0">Filiação</h6>
                                            </div>
                                            <div class="col-sm-9 text-secondary">
                                                <p>
                                                    {{ $efectivo->fliacao }}
                                                </p>
                                            </div>
                                        </div>


                                    </div>
                                    <!-- /.post -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        @foreach ($efectivo->hablitacoes as $hablitacao)
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-success">
                                                    {{ $hablitacao->created_at->format('d-m-Y') }}
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-envelope bg-primary"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header"><a href="#">Curso:</a></h3>

                                                    <div class="timeline-body">
                                                        {{ $hablitacao->nome }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-user bg-info"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0"><a href="#">Nivel:</a>
                                                        {{ $hablitacao->nivel }}
                                                    </h3>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fas fa-comments bg-warning"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header border-0"><a href="#">Tipo:</a>
                                                        {{ $hablitacao->tipo }}
                                                    </h3>
                                                </div>
                                            </div>
                                        @endforeach
                                        <div>
                                            <i class="far fa-clock bg-gray"></i>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="settings">
                                    <div class="container-fluid">

                                        <!-- Timelime example  -->
                                        <div class="row">
                                          <div class="col-md-12">
                                            <!-- The time line -->
                                            @foreach ($efectivo->promocoes as $promocao)
                                            <div class="timeline">
                                              <!-- timeline time label -->
                                              <div class="time-label">
                                                <span class="bg-red"> promoção Anterior - {{$promocao->anterior}}</span>
                                              </div>
                                              <!-- /.timeline-label -->
                                              <!-- timeline item -->
                                              <div>
                                                <i class="fas fa-envelope bg-blue"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header no-border"><a href="#">Categoria :</a> {{$promocao->Subcategoria_anterior->categoria->nome}}</h3>
                                                </div>
                                              </div>
                                              <!-- END timeline item -->
                                              <!-- timeline item -->
                                              <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                  <h3 class="timeline-header no-border"><a href="#">Subcategoria :</a> {{$promocao->Subcategoria_anterior->nome}}</h3>
                                                </div>
                                              </div>
                                              <!-- END timeline item -->
                                              <!-- timeline time label -->
                                              <div class="time-label">
                                                <span class="bg-green">Promoção Actual - {{$promocao->actual}}</span>
                                              </div>
                                              <!-- /.timeline-label -->
                                              <!-- timeline item -->
                                              <div>
                                                <i class="fas fa-envelope bg-blue"></i>
                                                <div class="timeline-item">
                                                    <h3 class="timeline-header no-border"><a href="#">Categoria :</a> {{$efectivo->subcategoria->categoria->nome}}</h3>
                                                </div>
                                              </div>
                                              <!-- END timeline item -->
                                              <!-- timeline item -->
                                              <div>
                                                <i class="fas fa-user bg-green"></i>
                                                <div class="timeline-item">
                                                  <h3 class="timeline-header no-border"><a href="#">Subcategoria :</a> {{$efectivo->subcategoria->nome}}</h3>
                                                </div>
                                              </div>
                                              <!-- END timeline item -->
                                              <!-- timeline time label -->
                                              <!-- END timeline item -->
                                              <div>
                                                <i class="fas fa-clock bg-gray"></i>
                                              </div>
                                            </div>
                                            @endforeach
                                          </div>
                                          <!-- /.col -->
                                        </div>
                                      </div>
                                      <!-- /.timeline -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@stop

@section('css')

@stop

@section('js')

@stop
