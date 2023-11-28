<div class="preloader flex-column justify-content-center align-items-center" style="background-image: radial-gradient(circle, #ffffff, #fff2fd, #ffe4ec, #ffd8cc, #ffd4a9, #f8c68c, #eeba6e, #e2ae4f, #d38b36, #c36824, #b04318, #9b1212);">

    {{-- Preloader logo --}}
    <img src="{{ asset(config('adminlte.preloader.img.path', 'vendor/adminlte/dist/img/AdminLTELogo.png')) }}"
         class="{{ config('adminlte.preloader.img.effect', 'animation__shake') }}"
         alt="{{ config('adminlte.preloader.img.alt', 'AdminLTE Preloader Image') }}"
         width="{{ config('adminlte.preloader.img.width', 60) }}"
         height="{{ config('adminlte.preloader.img.height', 60) }}">

</div>
