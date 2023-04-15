@extends('layouts.app')

@section('title', 'Detail Product')

@section('content')
    @php
        $harga_diskon = $product->Price*$product->Discount/100;
        $harga_diskon = $product->Price-$harga_diskon;
    @endphp

    <div class="container">
        <div class="row">
            <div class="col-md-6">
            <img src="{{ $product->Foto }}" class="card-img-top" alt="{{ $product->ProductName }}" height="500px">
            </div>
            <div class="col-md-6">
                <h1 class="mb-4">{{ $product->ProductName }}</h1>
                @if($product->Discount>0)
                    <h5 class="card-subtitle mb-2 my-3" style="color: red"><del>{{ $product->Currency }} {{ number_format($product->Price,0,',','.') }}</del></h5>
                    <h3 class="card-subtitle mb-2 my-3 text-muted">{{ $product->Currency }} {{ number_format($harga_diskon,0,',','.') }}</h3>
                @else
                    <h5 class="card-subtitle mb-2 my-3" style="color: red">&nbsp;</h5>                                    
                    <h3 class="card-subtitle mb-2 my-3 text-muted">{{ $product->Currency }} {{ number_format($product->Price,0,',','.') }}</h3>
                @endif
                <p class="my-3">Dimension: {{ $product->Dimension }}</p>
                <p class="my-3">Price Unit: {{ $product->Unit }}</p>
                <button class="btn btn-primary btn-lg" onClick="chart({{ $product->ProductId }})">Buy Now</button>
            </div>
        </div>
    </div>

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