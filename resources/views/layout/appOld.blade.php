<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @yield('style')
</head>

<body class="bg-light">
    <div class="d-flex flex-column">
        <header class="header bg-dark text-light p-3 ">
            @yield('header')
        </header>

        <div class="main-body d-flex overflow-hidden"style="height:85vh;">
            <aside class="sidebar bg-body-secondary text-white p-3 border rounded " style="width: 10%; height: 100%;">
                @yield('sidebar')
            </aside>

            <div class="header-content flex-grow-1  bg-light" style="height: 100%;overflow-y:auto;">
                @yield('content')

            </div>
        </div>

        <footer class="footer bg-dark text-light text-center fixed-bottom p-1 ">
            @yield('footer')
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>
</body>

</html>
