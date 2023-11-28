@extends('layouts.app_admin')

@section('title', 'Asistencia UMA')

@section('content_header')
<section style="margin-top: 20px;">
    <h1>Bienvenido al Dashboard - Asistencia<strong> UMA</strong></h1>
</section>
@stop

@section('content_body')
<section class="content" style="margin-top: 30px;">
    <div class="container-fluid">
        <div class="row">
            @foreach ($data as $item)
            <div class="col-lg-4 col-6">
                <x-adminlte-small-box title="{{ $item['total'] }}" text="{{ $item['nameText'] }}" icon="fas {{ $item['icon'] }} text-white" theme="{{ $item['color'] }}" url="{{ route($item['viewName']) }}" url-text="Ver {{ strtolower($item['nameText']) }}" />
            </div>
            @endforeach
        </div>
    </div>
</section>
@stop

@section('footer')
<h1></h1>
@stop

