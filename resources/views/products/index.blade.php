@extends('layout.crud')
@section('content')
    <h1>All the products</h1>

    <!-- will be used to show any messages -->
    @if (Session::has('message'))
        <div class="alert alert-info">{{ Session::get('message') }}</div>
    @endif

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <td>id</td>
            <td>Title</td>
            <td>Price</td>
            <td>eId</td>
            <td>Actions</td>
        </tr>
        </thead>
        <tbody>
        @foreach($products as $key => $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->title }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->eId }}</td>

                <!-- we will also add show, edit, and delete buttons -->
                <td>

                    <!-- delete the product (uses the destroy method DESTROY /products/{id} -->
                    <!-- we will add this later since its a little more complicated than the other two buttons -->

                    <!-- show the product (uses the show method found at GET /products/{id} -->
                    <a class="btn btn-small btn-success" href="{{ URL::to('products/' . $product->id) }}">Show this product</a>

                    <!-- edit this product (uses the edit method found at GET /products/{id}/edit -->
                    <a class="btn btn-small btn-info" href="{{ URL::to('products/' . $product->id . '/edit') }}">Edit this product</a>
                    <!-- edit this product (uses the edit method found at DELETE /products/{id} -->
                    {{ Form::model($product, ['route' => ['products.destroy',$product->id], 'method' => 'DELETE']) }}
                    {{ Form::submit('Delete this product!', array('class' => 'btn btn-danger')) }}

                    {{ Form::close() }}

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection