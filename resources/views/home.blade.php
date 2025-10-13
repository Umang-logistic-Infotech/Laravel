@extends('layout.app')

@section('style')

    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Arial', sans-serif;
        }

        .container {
            background-color: #ffffff;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
@endsection

@section('title', 'Home Page')
@section('header')
    <h2>Welcome to the Home Page!</h2>
@endsection

@section('content')
    <p>This is the content of the home page.</p>
    <p>Laravel Blade makes it easy to build dynamic views.</p>
@endsection

@section('footer')
    <p>Home page footer content &copy; 2025</p>
@endsection
