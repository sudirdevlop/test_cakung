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

    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Chart</h2>
        <table class="table">
          <thead>
            <tr>
              <th>Gambar</th>
              <th width="20%">Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @php
            $subtotal=0;
            @endphp
            @if(count($charts)>0)
                @foreach ($charts as $chart)
                    <tr>
                    <td>
                        <img src="{{ $chart->product->Foto }}" class="img-fluid" width="100px">
                    </td>
                    <td>{{ $chart->product->ProductName }}</td>
                    <td>{{ $chart->product->Currency }} {{ number_format($chart->Price,0,',','.') }}</td>
                    <td><input type="text" class="qty{{$chart->ProductId}}" onChange="ubahQty({{$chart->ProductId}})" value="{{ $chart->Quantity}}" maxlength="4" style="width:60px"> {{ $chart->product->Unit }}</td>
                    <td>{{ $chart->product->Currency }} {{ number_format($chart->Subtotal,0,',','.') }}</td>
                    <td>
                        <button class="btn btn-sm btn-danger" onClick="konfirmasiHapus({{$chart->ProductId}})">Hapus</button>
                    </td>
                    </tr>
                    @php
                        $subtotal += $chart->Subtotal;                
                    @endphp
                @endforeach
            @endif
          </tbody>
          <tfoot>
            <tr>
              <td colspan="4" class="text-end">Total</td>
              <td colspan="2" class="text-end">@if(count($charts)>0) {{ $charts[0]->product->Currency }} @endif {{number_format($subtotal,0,',','.')}}</td>
            </tr>
            <tr>
              <td colspan="5" class="text-end"><a href="/product" class="btn btn-info">Back to List Product</a></td>
              <td colspan="1" align="left"><a href="#" class="btn btn-primary" onclick="konfirmasiCheckout()">Checkout</a></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>

    <script type="text/javascript">

        $(document).ready(function() {
            
        });

        function ubahQty(ProductId) {
            const Qty = $(".qty"+ProductId).val();
            $.ajax({
                type: "POST",
                url: "/chart/change_qty",
                data: {
                    ProductId: ProductId,
                    Qty: Qty,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil di rubah',
                        showConfirmButton: false,
                        type: 'success',
                        timer: 3500
                    });
                    location.reload();
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

        function konfirmasiHapus(ProductId) {
            var konfirmasi = confirm("Apakah Anda yakin ingin menghapus barang ini?");

            if (konfirmasi) {
                hapus(ProductId);
            }
        }

        function hapus(ProductId) {
            
            $.ajax({
                type: "DELETE",
                url: "/chart/"+ProductId,
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil di hapus',
                        showConfirmButton: false,
                        type: 'success',
                        timer: 3500
                    });
                    location.reload();
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

        function konfirmasiCheckout(ProductId) {
            var konfirmasi = confirm("Apakah Anda yakin ingin checkout ?");

            if (konfirmasi) {
                checkout(ProductId);
            }
        }    
        
        function checkout(ProductId) {
            $.ajax({
                type: "POST",
                url: "/checkout",
                data: {
                    ProductId: ProductId,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil checkout silahkan check di Laporan belanja atau Laporan keseluruhan',
                        showConfirmButton: false,
                        type: 'success',
                        timer: 50000
                    });
                    location.href="/product";
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