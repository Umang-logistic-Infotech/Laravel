@extends('layout.app')


@section('title', 'Home Page')

@section('header')
    @include('Components.header', ['pagename' => 'Home'])
@endsection

@section('style')
    @include('Components.style')

@endsection
@section('content')
    @include('Components.content')
@endsection


@section('sidebar')
    @include('Components.sidebar')
@endsection


@section('footer')
    @include('Components.footer')
@endsection
