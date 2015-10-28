@extends('layouts/adminLayout')
@section('content')
<div class="cuerpo-content">
     <h1>Compañia: {{ $company->fullname }}</h1>
     <table class="table table-striped">
         <tr>
             <td>Producto</td>
             <td>Eam</td>
             <td>Precio</td>
             <td>Creación</td>
             <td>Ver</td>
         </tr>
         @foreach($company->paginate_products as $product)
         <tr>
             <td>{{ $product->fullname }}</td>
             <td>{{ $product->eam }}</td>
             <td>{{ $product->precio }}</td>
             <td>{{ $product->created_at }}</td>
             <td width="50"><a href="{{ route('product', [$product->id]) }}" class="btn btn-info">Ver</a> </td>
         </tr>
         @endforeach
      </table>
      <!-- Paginador-->
                   <div class="row">
                       <div class="col-md-12">
                           <nav class="text-center">
                               {{ $company->paginate_products->links() }}
                           </nav>
                       </div>
                   </div>
</div>
@stop