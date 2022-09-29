<!DOCTYPE html>
<html lang="pt">

<head>
    <!-- Carrega paper.css para uma boa impressão -->
    <link rel="stylesheet" href="{{asset('/css/normalize.min.css') }}">
    <link rel="stylesheet" href="{{asset('/dist/bootstrap.css') }}">
    <link rel="stylesheet" href="{{asset('/css/paper.min.css') }}">
    <style>
        @page {
            size: A4;


        }

        .image-center {
            display: block;
            margin-left: auto;
            margin-right: auto;
            width: 50%;
        }

        .A4 {
            background: #ffffff
        }

        .bg-psd {
            background: #0b4e86;
            color: #fff;
        }

        .mt-0 {
            margin-top: 3px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .pt-5 {
            padding-top: 15px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-end {
            justify-content: flex-end;
        }

        .justify-content-center {
            justify-content: center;
        }

        .justify-content-end {
            justify-content: flex-end;
        }

        .justify-content-between {
            justify-content: space-between;
        }

        .justify-content-around {
            justify-content: space-around;
        }

        .align-items-center {
            align-items: center;
        }

        .flex-column {
            flex-direction: column;
        }

        .bg-print1 {
            background-color: rgb(210 209 209) !important;
            color: rgb(14, 14, 14) !important;

        }

        /*Flex box*/
        @media print {
            .print-menu {
                display: none !important;
            }

            body {
                background: #ffffff !important;
            }

            .bg-print {
                background-color: rgb(210 209 209) !important;
                color: #0e0e0e !important;

            }

            tr.bg-print {
                background-color: rgb(210 209 209) !important;
                color: #0e0e0e !important;
                font-weight: bold !important;
            }

            tr th {
                background-color: rgb(210 209 209) !important;
                color: #0e0e0e !important;
                font-weight: bold !important;
            }

            tr th.bg-psd {
                background-color: rgb(210 209 209) !important;
                color: #0e0e0e !important;
                font-weight: bold !important;
            }
        }

        .fixed-top {
            left: 82% !important;
        }
    </style>
    <title>Imprimir relatorio</title>
</head>

<body class="A4 ">

    <section class="sheet padding-10mm" style="height: auto;">
        <div class="image-center">
            <img src="{{asset('/dist/logoracb.png')}}" alt="" >
        </div>
        <h5 class="text-uppercase text-center mt-0 mb-0">Republica de Angola</h5>
        <h5 class=" text-center mt-0 mb-0"> REGIÃO AÉREA SUL</h5>
        <h5 class=" text-center mt-0 mb-0">REGIMENTO AÉREO DE CAÇA-BOMBARDEIROS</h5>
        <h6 class=" text-center mt-0 mb-0">SECÇÃO DE PESSOAL E QUADROS</h6>
        <br>
        <h6 class="text-center mt-0 mb-0">LISTA DE EFECTIVIDADE DOS MILITARES DO RACB/RAS REFERENTE AO MÊS DE {{ mb_strtolower($mes_e_ano,"utf-8" ); }}</h6>
        <hr class="mb-0 mt-0">
        <h6 class="text-center mt-0 mb-0">SUB-UNIDADE {{$unidade->nome}}</h6>

        <table class="table  table-sm tabela  table-bordered">
            <thead>
                <tr class="b text-white">
                    <th class="bg-psd bg-print">Nº</th>
                    <th class="bg-psd bg-print">Nome</th>
                    <th class="bg-psd bg-print">Feleciação</th>
                    <th class="bg-psd bg-print">Data de nascimento</th>
                    <th class="bg-psd bg-print">Data de incorporação</th>
                    <th class="bg-psd bg-print">NIP</th>
                    <th class="bg-psd bg-print">Nº BI</th>
                    <th class="bg-psd bg-print">IBAN</th>

                </tr>
            </thead>
            <tbody class="table-bordered">
                @foreach ($unidade->efectivos as $efectivo)
                <tr>
                <td>{{$loop->index + 1}}</td>
                <td>{{$efectivo->nome}}</td>
                <td>{{$efectivo->feleciacao}}</td>
                <td>{{$efectivo->data_de_nascimento}}</td>
                <td>{{$efectivo->data_de_incorporacao}}</td>
                <td>{{$efectivo->nip}}</td>
                <td>{{$efectivo->bi}}</td>
                <td>{{$efectivo->iban}}</td>
                </tr>
                @endforeach


            </tbody>
        </table>
        <hr>
        <p class="text-center mt-0 mb-0">catumbela em  {{date("d-m-Y")}} </p>
    </section>
</body>

</html>
