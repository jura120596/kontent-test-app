<!DOCTYPE html>
<html>
<head>
    <title>Product App</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">

    <nav class="navbar navbar-inverse">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ URL::to('products') }}">Products</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{ URL::to('products') }}">View All products</a></li>
            <li><a href="{{ URL::to('products/create') }}">Create a product</a>
        </ul>
    </nav>

    @yield('content')

</div>
</body>
</html>