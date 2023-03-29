<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Mazer Admin Dashboard</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('/assets/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ url('/assets/vendors/iconly/bold.css') }}">

    <link rel="stylesheet" href="{{ url('/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/vendors/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ url('/assets/vendors/sweetalert2/sweetalert2.min.css') }}">
    <link rel="shortcut icon" href="{{ url('/assets/images/favicon.svg') }}" type="image/x-icon">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @include('layouts.sidebar')
        <div id="main">

            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
                <div class="float-end">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-xl">
                            <img src="assets/images/faces/1.jpg" alt="Face 1">
                        </div>
                        <div class="ms-3 name">
                            <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                            <h6 class="text-muted mb-0">{{ Auth::user()->role->name }}</h6>
                        </div>
                    </div>
                </div>


            </header>
            {{-- @include('layouts.header') --}}
            <div class="page-heading">
                <h3>Elearning</h3>
            </div>

            <div class="page-content">
                <section class="row">
                    @yield('content')
                </section>
            </div>
        </div>
    </div>
    <script src="{{ url('/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ url('/assets/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ url('/assets/vendors/apexcharts/apexcharts.js') }}"></script>
    <script src="{{ url('/assets/js/pages/dashboard.js') }}"></script>

    <script src="{{ url('/assets/js/extensions/sweetalert2.js') }}"></script>
    <script src="{{ url('/assets/vendors/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ url('/assets/vendors/simple-datatables/simple-datatables.js') }}"></script>
    <script>
        // Simple Datatable
        let table1 = document.querySelector('#table1');
        let dataTable = new simpleDatatables.DataTable(table1);
    </script>
    <script src="{{ url('/assets/js/main.js') }}"></script>
</body>

</html>
