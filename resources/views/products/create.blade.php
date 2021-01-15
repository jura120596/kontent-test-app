@extends('layout.crud')
@section('content')

    <h1>Create a product</h1>

    <!-- if there are creation errors, they will show here -->
    {{ Html::ul($errors->all()) }}

    {{ Form::open(array('url' => 'products')) }}

    <div class="form-group">
        {{ Form::label('title', 'Title') }}
        {{ Form::text('title', request('title'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('price', 'Price') }}
        {{ Form::number('price', request('price'), array('class' => 'form-control')) }}
    </div>

    <div class="form-group">
        {{ Form::label('eId', 'eId') }}

        {{ Form::number('eId', request('eId'), array('class' => 'form-control')) }}    </div>

    {{ Form::submit('Create the product!', array('class' => 'btn btn-primary')) }}

    {{ Form::close() }}
@endsection