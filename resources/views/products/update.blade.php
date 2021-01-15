@extends('layout.crud')
@section('content')

    <h1>Update a product</h1>

    <!-- if there are creation errors, they will show here -->
    {{ Html::ul($errors->all()) }}

    {{ Form::model($product, ['route' => ['products.update',$product->id], 'method' => 'PUT']) }}

    <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', request('title', $product->title), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('price', 'Price') }}
        {{ Form::number('price', request('price', $product->price), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('eId', 'eId') }}

        {{ Form::number('eId', request('eId', $product->eId), array('class' => 'form-control')) }}    </div>

    {{ Form::submit('Update the product!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection