<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="{{ asset('/vendor/adminlte/dist/css/adminlte.css') }}" href="style.css">
    @yield('css')
    <title>@yield('titulo')</title>
    <style>
        body {
            background: rgb(204, 204, 204);
            font-family: "Lucida Console", Monaco, monospace;
        }

        page {
            background: white;
            display: block;
            margin: 0 auto;
            margin-bottom: 0.5cm;
            box-shadow: 0 0 0.5cm rgba(0, 0, 0, 0.5);
        }

        page[size="A4"] {
            width: 21cm;
            height: 29.7cm;
        }

        page[size="A4"][layout="portrait"] {
            width: 29.7cm;
            height: 21cm;
        }

        @media print {

            body,
            page {
                margin: 0;
                box-shadow: 0;
            }

            .only-print {
                display: none !important;
            }
        }

        .header {
            padding-top: 10px;
            text-align: center;
            border: 2px solid #ddd;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 80%;
        }

        table th {
            background-color: rgb(182, 176, 176);
            color: black;
            text-align: center;
            text-decoration-color: black
        }

        th,
        td {
            border: 1px solid #ddd;
            text-align: left;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

        .nrPage {
            text-align: right;
            margin-right: 10px;
        }

        .visto_texto {
            padding: 0px;
            mso-ignore: padding;
            color: windowtext;
            font-size: 10.0pt;
            font-weight: 400;
            font-style: normal;
            text-decoration: none;
            font-family: Tahoma, sans-serif;
            mso-font-charset: 0;
            mso-number-format: General;
            text-align: center;
            vertical-align: bottom;
            mso-background-source: auto;
            mso-pattern: auto;
            white-space: nowrap;
        }
    </style>
</head>

<body>

    <div class="content">
        <page size='A4'>
            <div class="container">

                <div class="row">
                    <div class="col-md-12  text-center">
                        <h6 class="text-uppercase text-center mt-0 mb-0">REGIÃO AÉREA SUL</h6>
                        <h6 class=" text-center mt-0 mb-0"><img width=88 height=67
                                src="{{ asset('/dist/logoracb2.png') }}">
                        </h6>
                        <h6 class=" text-center mt-0 mb-0">REGIMENTO AÉREO DE CAÇA-BOMBARDEIROS</h6>
                        <h6 class=" text-center mt-0 mb-0"><u>SECÇÃO DE PESSOAL E QUADROS</u></h6>
                    </div>
                </div>
                <div class="row">
                    <div class="text-left" style="justify-content:left;height:7.0pt;">
                        <p class="visto_texto">VISTO</p>
                        <p class="visto_texto">O CMDTE DO RACB</p>
                        <p class="visto_texto"> JOÃO MOISÉS VAZ</p>
                        <p class="visto_texto">COR/PILAV</p>
                        <p class="visto_texto">10194892</p>

                    </div>



                </div>
                @yield('conteudo')

            </div>
        </page>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    @yield('js')
</body>

</html>
