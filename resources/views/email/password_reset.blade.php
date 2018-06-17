@extends('master')

@section('body')

    <div class="mt-3">
        <img class="img-center logo" src="{{asset('images/ulpgc-course.png')}}" alt="logo">
    </div>

    <div class="container">

        <div class="shadow">

            <header class="mt-3 header separator">Restablecer Contraseña</header>
            <main class="main separator">

                <p>Hola <strong>{{$user->name}} {{$user->last_name}}</strong></p>
                <p><strong>¡Gracias por confiar en nosotros!</strong></p>
                <p>Haga click en el botón de abajo para establecer su contraseña.</p>
                <p class="mt-3">Este enlace será valido durante <strong>{{config('auth.passwords.users.expire') / 60}} horas.</strong></p>

                <p>
                    <a href="{{ env('FRONT_END_END_POINT') . '/password/reset/' . $token . '?email=' . $user->email }}" class="btn" target="_blank">Establecer Contraseña</a>
                </p>

            </main>

        </div>

    </div>

@endsection