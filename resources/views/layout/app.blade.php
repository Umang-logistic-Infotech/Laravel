<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @yield('style')
</head>

<body>

    <div class="container d-flex flex-column m-3 gap-3 p-2 border rounded">

        <h1>@yield('header')</h1>

        <div class="border p-3 rounded">
            <div>content @yield('content')</div>
        </div>

        <div class=" border p-3 rounded">
            <p>Hello @yield('footer')</p>
        </div>

    </div>

</body>

</html>
