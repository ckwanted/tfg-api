@extends('master')

@section('body')

    <div class="mt-3">
        <img class="img-center logo" src="{{asset('images/ulpgc-course.png')}}" alt="logo">
    </div>

    <div class="container">

        <div class="shadow">

            <header class="mt-3 header separator">Confirmación de compra de {{\Carbon\Carbon::now()->format('d-m-Y')}}</header>
            <main class="main separator">

                @foreach($courses as $course)
                <div class="d-flex align-items-center">

                    <div>
                        <p class="f-s-12px color-gray m-0">{{$course->user->name}}</p>
                        <p class="f-s-16px">{{$course->name}}</p>
                    </div>

                    <div class="ml-auto">
                        <p class="m-0">{{$course->price}}€</p>
                    </div>

                </div>
                @endforeach

                <hr>

                <div>
                    <p class="m-0"><strong>ID de factura: </strong>1</p>
                    <p class="m-0"><strong>Comprador: </strong>{{ (auth()->user()) ? auth()->user()->name : ''}}</p>
                </div>

            </main>

        </div>

    </div>

@endsection