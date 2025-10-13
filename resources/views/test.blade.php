<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>laravel Project</title>
</head>

<body>
    <h1> Inside Test Page with {{ $data }}</h1>

    @include('subViews.input',[
    'lableFor' => 'Name',
    'myName' => 'Umang'
    ])
</body>

</html>