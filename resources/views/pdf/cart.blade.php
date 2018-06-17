@extends('master')

@section('body')

    <div class="mt-3">
        <img class="img-center logo" src="{{asset('images/ulpgc-course.png')}}" alt="logo">
    </div>

    <div class="container">

        <div class="shadow">

            <header class="mt-3 header separator">Confirmación de compra de {{\Carbon\Carbon::now()->format('d-m-Y')}}</header>
            <main class="main separator">

                <div class="d-flex align-items-center">

                    <div>
                        <p class="f-s-12px color-gray m-0">Junior Kozey</p>
                        <p class="f-s-16px">José Antonio Nava Hijo</p>
                    </div>

                    <div class="ml-auto d-flex align-items-center">
                        <p class="f-s-20px m-0">460.00€</p>
                    </div>

                </div>

                <div class="d-flex align-items-center">

                    <div>
                        <p class="f-s-12px color-gray m-0">Junior Kozey</p>
                        <p class="f-s-16px">José Antonio Nava Hijo</p>
                    </div>

                    <div class="ml-auto d-flex align-items-center">
                        <p class="f-s-20px m-0">460.00€</p>
                    </div>

                </div>

                <hr>

                <div>
                    <p class="m-0"><strong>ID de factura: </strong>1</p>
                    <p class="m-0"><strong>Comprador: </strong>{{ (auth()->user()) ? auth()->user()->name : 'John Doe'}}</p>
                    <p class="m-0"><strong>Vendido por: </strong>ULPGC COURSE</p>
                </div>

            </main>

        </div>

    </div>

@endsection