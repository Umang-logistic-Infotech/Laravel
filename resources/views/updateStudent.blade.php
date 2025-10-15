@extends('layout.app')


@section('title', 'Edit Student Page')

@section('header')
    @include('Components.header', ['pagename' => 'Edit Student'])
@endsection


@section('style')
    @include('Components.style')

@endsection
@section('content')
    @include('Components.updateStudentContent')

@endsection


@section('sidebar')
    @include('Components.sidebar')
@endsection


@section('footer')
    @include('Components.footer')
@endsection
