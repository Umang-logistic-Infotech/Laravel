@extends('layout.appOld')


@section('title', 'Add Student Page')

@section('header')
    @include('Components.header', ['pagename' => 'Add Student'])
@endsection


@section('style')
    @include('Components.style')

@endsection
@section('content')
    @include('Components.addStudentContent')
@endsection


@section('sidebar')
    @include('Components.sidebar')
@endsection


@section('footer')
    @include('Components.footer')
@endsection
