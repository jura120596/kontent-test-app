@extends('layout.crud')
@section('content')
    <h1>Showing {{ $product->name }}</h1>

    <div class="jumbotron text-center">
        <h2>{{ $product->name }}</h2>
        <p>
            <strong>eId:</strong> {{ $product->eId }}<br>
            <strong>Title:</strong> {{ $product->title }}<br>
            <strong>Price:</strong> {{ $product->price }}
        </p>
    </div>
@endsection