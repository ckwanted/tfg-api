@extends('master')

@section('body')

    <div class="mt-3">
        <img class="img-center logo" src="{{asset('images/ulpgc-course.png')}}" alt="logo">
    </div>

    <div class="container">

        <div class="shadow">

            <header class="mt-3 header separator">Bienvenido a {{env('APP_NAME')}}</header>
            <main class="main separator">

                <p>Hola {{$newUser->name}} {{$newUser->last_name}}, Queremos darte la bienvenida a {{env('APP_NAME')}}.</p>
                <p>{{env('APP_NAME')}} es una plataforma de enseñanza online asociada a la universidad de las Palmas de Gran Canaria. Esta plataforma ofrece cursos online para aquellas personas que quieran adquirir nuevos conocimientos o mejorar los conocimientos existentes.</p>

            </main>

        </div>

    </div>

@endsection