@extends('layouts/adminLayout')
@section('content')
<div class="cuerpo-content">
    <h1>Últimos Productos</h1>
    @foreach ($latest_products as $category)
        <h2>{{ $category->fullname }}</h2>
         <table class="table table-striped">
            <tr>
                <td>Nombre</td>
                <td>Eam</td>
                <td>Precio</td>
                <td>Creación</td>
                <td>Ver</td>
            </tr>
            @foreach($category->products as $product)
            <tr>
                <td>{{ $product->fullname }}</td>
                <td>{{ $product->eam }}</td>
                <td>{{ $product->precio }}</td>
                <td>{{ $product->created_at }}</td>
                <td width="50"><a href="{{ route('product', [$product->id]) }}" class="btn btn-info">Ver</a> </td>
            </tr>
            @endforeach
         </table>
         <p><a href="{{ route('category', [$category->id]) }}">Ver todos los {{ $category->fullname }}</a> </p>
    @endforeach
</div>
@stop