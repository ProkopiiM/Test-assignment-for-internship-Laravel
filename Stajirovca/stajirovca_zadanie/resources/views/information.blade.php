@extends('layout')
@section('title')
    {{$card->title}}
@endsection
@section('main-content')
    <h1>{{$card->title}}</h1>
    <div>{!! $card->description !!}</div>
@endsection
