@extends('layouts.app')

@section('title', 'Products List')

@section('content')
<style>
    .bd-placeholder-img {
    font-size: 1.125rem;
    text-anchor: middle;
    -webkit-user-select: none;
    -moz-user-select: none;
    user-select: none;
    }

    @media (min-width: 768px) {
    .bd-placeholder-img-lg {
        font-size: 3.5rem;
    }
    }
</style>

    <main>
        <div class="container">
            
            <div class="row">
                <div class="col-12">
                    <h1>Products List</h1>
                </div>
            </div>

            <div class="row">
                @foreach ($products as $product)                
                    @php
                        $harga_diskon = $product->Price*$product->Discount/100;
                        $harga_diskon = $product->Price-$harga_diskon;
                    @endphp

                    <div class="col-md-4">
                        <div class="card mb-4">
                            <img src="{{ $product->Foto }}" class="card-img-top" alt="{{ $product->ProductName }}" height="300px" style="cursor: pointer;" onclick="window.location='{{ url("product/$product->ProductId") }}'">
                            <div class="card-body" style="cursor: pointer;" onclick="window.location='{{ url("product/$product->ProductId") }}'">
                                <h5 class="card-title">{{ $product->ProductName }}</h5>
                                <p class="card-text">{{ $product->Unit }}</p>                                
                                @if($product->Discount>0)
                                    <h6 class="card-subtitle mb-2" style="color: red"><del>{{ $product->Currency }} {{ number_format($product->Price,0,',','.') }}</del></h6>
                                    <h5 class="card-subtitle mb-2 text-muted">{{ $product->Currency }} {{ number_format($harga_diskon,0,',','.') }}</h5>
                                @else
                                    <h6 class="card-subtitle mb-2" style="color: red">&nbsp;</h6>                                    
                                    <h5 class="card-subtitle mb-2 text-muted">{{ $product->Currency }} {{ number_format($product->Price,0,',','.') }}</h5>
                                @endif
                            </div>
                            <button class="btn btn-primary" onClick="chart({{ $product->ProductId }})">Buy</button>
                        </div>
                    </div>
                @endforeach
            </div>


        </div>

    </main>

    <script type="text/javascript">

        $(document).ready(function() {
            
        });



        function chart(ProductId) {
            $.ajax({
                type: "POST",
                url: "/chart",
                data: {
                    ProductId: ProductId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil di tambahkan ke keranjang',
                        showConfirmButton: false,
                        type: 'success',
                        timer: 3500
                    });
                },
                error: function(xhr, status, error) {
                    console.log(status, xhr);
                    swal({
                        title: 'Error!',
                        text: 'Gagal Kirim',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        }

    </script>
@endsection