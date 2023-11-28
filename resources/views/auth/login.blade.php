@extends('layouts.app')

@section('content')
<section class="background-radial-gradient overflow-hidden">
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Martian+Mono:wght@300&family=Oswald:wght@600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Vollkorn:wght@600&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Roboto&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Graduate&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Graduate&family=Playpen+Sans&display=swap');
    .background-radial-gradient {
      background-color: hsl(0, 0%, 0%);
      background-image: radial-gradient(650px circle at center top,
          hsl(0, 0%, 15%) 15%,
          hsl(0, 0%, 10%) 35%,
          hsl(0, 0%, 5%) 75%,
          hsl(0, 0%, 4%) 80%,
          transparent 100%),
          radial-gradient(1250px circle at center bottom,
          hsl(0, 0%, 25%) 15%,
          hsl(0, 0%, 10%) 35%,
          hsl(0, 0%, 5%) 75%,
          hsl(0, 0%, 4%) 80%,
          transparent 100%);
      background-size: 100% 100%;
      background-repeat: no-repeat;
      }

      .gradient-custom-2 {
      background: #fccb90;
      background-image: linear-gradient(to right, #9b1212, #770d1b, #510f1c, #2c0e15, #000000);
      }
      #radius-shape-1 {
          height: 220px;
          width: 220px;
          top: -60px;
          left: -130px;
          background: radial-gradient(#9b1212, #510f1c);
          overflow: hidden;
          position: absolute;
      }

      #radius-shape-2 {
          border-radius: 38% 62% 63% 37% / 70% 33% 67% 30%;
          bottom: -60px;
          right: -110px;
          width: 300px;
          height: 300px;
          background: radial-gradient(#9b1212, #510f1c);
          overflow: hidden;
          position: absolute;
      }

      .bg-glass {
          background-color: hsla(0, 0%, 90%, 0.7) !important;
          backdrop-filter: saturate(200%) blur(25px);
      }

      
  </style>

  <div class="container px-4 py-5 px-md-5 text-center text-lg-start my-5">
    <div class="row gx-lg-5 align-items-center mb-5">
      <div class="col-lg-6 mb-5 mb-lg-0" style="z-index: 10">
        <h1 class="my-5 display-5 fw-bold ls-tight d-none d-md-block" style="color: hsl(0, 79%, 34%); font-family: 'Graduate', serif; font-size: 4rem;">
          Universidad <br />
          <span style="color: hsl(0, 0%, 100%);font-size: 2.5rem;">Modular Abierta</span>
        </h1>
        <h1 class="my-5 display-5 fw-bold ls-tight d-block d-md-none" style="color: hsl(0, 79%, 34%); font-family: 'Graduate', serif; font-size: 3rem;">
            Universidad <br />
            <span style="color: hsl(0, 0%, 100%);font-size: 2rem;">Modular Abierta</span>
          </h1>
        <p class="mb-4 opacity-30" style="color: hsl(0, 0%, 95%);font-family: 'Graduate', serif; font-family: 'Playpen Sans', cursive;">
            La Universidad Modular Abierta (UMA) le da la bienvenida al sistema de asistencia, una plataforma que le permite marcar su asistencia a clases.Este sistema es un compromiso de la UMA con la educación y la excelencia académica.Con él, los estudiantes pueden asegurarse de que están cumpliendo con sus requisitos académicos y de que están en camino de alcanzar sus metas educativas.Juntos, podemos construir un futuro mejor para todos. SOMOS UMA!
            
        </p>
      </div>

      <div class="col-lg-6 mb-5 mb-lg-0 position-relative">
        <div id="radius-shape-1" class="position-absolute rounded-circle shadow-5-strong"></div>
        <div id="radius-shape-2" class="position-absolute shadow-5-strong"></div>

        <div class="card bg-glass">
          <div class="card-body card-body p-md-5 mx-md-4">
            <div class="text-center">
                <img src="{{ asset('/img/uma.svg') }}"style="width: 95px;" alt="logo">
                <h4 class="mt-1 mb-3 pb-1" style="font-family: 'Martian Mono', monospace;
                font-family: 'Oswald', sans-serif;">Comprometidos con la Educación</h4>
            </div>
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <h2 class="text-center" style="font-family: 'Vollkorn', serif;">Iniciar Sesión</h2>
              <div class="form-outline mb-4">
                    <label class="form-label" for="numeroCatedratico" style="font-family: 'Roboto', sans-serif;">N° de Catedrático</label>
                    <input id="numeroCatedratico" type="text" class="form-control @error('numeroCatedratico') is-invalid @enderror" name="numeroCatedratico" value="{{ old('numeroCatedratico') }}" required autocomplete="numeroCatedratico" autofocus placeholder="AA111111111">
                    @error('numeroCatedratico')
                        <span class="invalid-feedback" role="alert">
                            @if ('auth.failed')
                        Estas credenciales no coinciden con nuestros registros.
                    @elseif ($error == 'The user credentials were incorrect.')
                        Las credenciales del usuario son incorrectas.
                    @else
                        {{ $error }}
                    @endif
                        </span>
                    @enderror
              </div>
              <div class="form-outline mb-4">
                  <label class="form-label" for="password" style="font-family: 'Roboto', sans-serif;">Contraseña</label>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Ingresa tu contraseña">
                  @error('password')
                      <span class="invalid-feedback" role="alert">
                          <strong style="color: white;font-size: 1rem;">{{ $message }}</strong>
                      </span>
                  @enderror
              </div>
              <div class="text-center pt-1 mb-5 pb-1">
                <button class="btn btn-login btn-primary btn-block gradient-custom-2" style="font-family: 'Roboto', sans-serif;width: 100%; background-color: transparent; border: none; box-shadow: 0 20px 15px rgba(0, 0, 0, 0.1);" type="submit">Iniciar Sesión</button>
            </div>
          </form>                      
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function() {
            var numeroCatedratico = $("#numeroCatedratico");

            numeroCatedratico.on("input", function() {
                var inputValue = numeroCatedratico.val();
                var sanitizedValue = inputValue.replace(/[^A-Z\d]/g, "").slice(0, 11);
                var firstTwoChars = sanitizedValue.slice(0, 2);
                var nextNineChars = sanitizedValue.slice(2);
                letras = firstTwoChars.replace(/[^A-Z]/g, '')
                numero=nextNineChars.replace(/[^0-9]/g, '')
                var formattedValue = letras + numero;

                numeroCatedratico.val(formattedValue);
            });

            numeroCatedratico.on("focusout", function() {
                if (numeroCatedratico.val().length !== 11) {
                    numeroCatedratico.val("");
                }
            });
        });

</script>
@endsection
