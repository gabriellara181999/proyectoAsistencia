@extends('layouts.app_admin')

@section('title', 'Crear / Roles | Asistencia UMA')

@section('content_header')
    <h1 style="text-align: center">Creación de Roles</h1>
@stop

@section('content_body')
    <div class="col-lg-9 mb-3 mx-auto">
        <div class="card shadow">
            <div class="card-body">
                <form action="{{ route('roles.index') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row mx-auto">
                        <div class="col">
                            <x-adminlte-input type="text" class="form-control" id="name" name="name" autocomplete="name" aria-describedby="emailHelp" label="Nombre de Rol" fgroup-class="col-me-3" value="{{ old('name') }}"/>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h5>Permisos para los Roles</h5>
                        <div class="form-group">
                            <div class="section">
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-user-lock" title="Usuario">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'usuario'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}
                                                            </label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-lock" title="Roles">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'rol'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton2"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton2"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-university" title="Carrera">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'carrera'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton3"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton3"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-book-open" title="Materia">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'materia'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton4"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton4"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-toggle-on" title="Botones">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'boton'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton5"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton5"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-user-graduate" title="Alumno">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'alumno'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton6"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton6"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-check-square" title="Asistencia">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'asistencia'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton7"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton7"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-calendar-alt" title="Horario">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'horario'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton8"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton8"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-chalkboard-teacher" title="Catedratico">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'catedratico'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label>
                                                        @endif
                                                    @endforeach
                                                    <br>
                                                    <label class="btn btn-dark btn-sm selectAllButton9"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton9"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                    <div class="col-md-4">
                                        <x-adminlte-callout theme="danger" title-class="text-danger" icon="fas fa-user-cog" title="Administrador">
                                            <div class="row">
                                                <div class="col-md-10">
                                                    @foreach ($Permission as $permissions)
                                                        @if (str_starts_with($permissions->name, 'administrador'))
                                                            <label>{{Form::checkbox('permission[]', $permissions->id, false, ['class' => 'name']) }}
                                                                {{ $permissions->name }}</label><br>
                                                        @endif
                                                    @endforeach
                                                    <label class="btn btn-dark btn-sm selectAllButton10"><i class="fas fa-check-double"></i></label>
                                                    <label class="btn btn-dark btn-sm descartAllButton10"><i class="fas fa-history"></i></label>
                                                </div>
                                            </div>
                                        </x-adminlte-callout>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mx-auto">
                        <div>
                            <a href="{{ route('roles.index') }}" class="btn btn-dark mt-3">
                                <i class="fas fa-chevron-left"></i> Regresar
                            </a>
                        </div>
                        <div style="margin-left: 10px">
                            <button type="submit" class="btn btn-danger mt-3" id="agregar">Crear Rol</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        const selectAllButton1 = document.querySelector('.selectAllButton');
        selectAllButton1.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton1 = document.querySelector('.descartAllButton');
        deselectAllButton1.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton2 = document.querySelector('.selectAllButton2');
        selectAllButton2.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton2 = document.querySelector('.descartAllButton2');
        deselectAllButton2.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton3 = document.querySelector('.selectAllButton3');
        selectAllButton3.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton3 = document.querySelector('.descartAllButton3');
        deselectAllButton3.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton4 = document.querySelector('.selectAllButton4');
        selectAllButton4.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton4 = document.querySelector('.descartAllButton4');
        deselectAllButton4.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton5 = document.querySelector('.selectAllButton5');
        selectAllButton5.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton5 = document.querySelector('.descartAllButton5');
        deselectAllButton5.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        
        const selectAllButton6 = document.querySelector('.selectAllButton6');
        selectAllButton6.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton6 = document.querySelector('.descartAllButton6');
        deselectAllButton6.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        
        const selectAllButton7 = document.querySelector('.selectAllButton7');
        selectAllButton7.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton7 = document.querySelector('.descartAllButton7');
        deselectAllButton7.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton8 = document.querySelector('.selectAllButton8');
        selectAllButton8.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton8 = document.querySelector('.descartAllButton8');
        deselectAllButton8.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton9 = document.querySelector('.selectAllButton9');
        selectAllButton9.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton9 = document.querySelector('.descartAllButton9');
        deselectAllButton9.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
        const selectAllButton10 = document.querySelector('.selectAllButton10');
        selectAllButton10.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = true;
            });
        });

        const deselectAllButton10 = document.querySelector('.descartAllButton10');
        deselectAllButton10.addEventListener('click', function () {
            const checkboxes = this.parentElement.querySelectorAll('input[name="permission[]"]');
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = false;
            });
        });
    </script>
@stop

@section('footer')
    <h1></h1>
@stop

@section('css')

@endsection