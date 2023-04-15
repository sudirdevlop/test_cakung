@extends('layouts.app')

@section('title', 'Products List')

@section('content')

    <div class="container">
    <div class="row">
      <div class="col-md-12">
        <table class="table">
          <thead>
            <tr>
              <th width="20%">Transction</th>
              <th width="20%">User Name</th>
              <th width="20%">Total</th>
              <th>Date</th>
              <th>Item</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($reports as $report)
                <tr>
                    <td>{{$report->TransactionNumber }}</td>
                    <td>{{ $report->name }} / {{ $report->email }}</td>
                    <td>{{ $report->TransactionDetail[0]->Currency }} {{ number_format($report->Total,0,',','.') }}</td>
                    <td>{{ $report->CreatedAt }}</td>
                    <td>{{ $report->TransactionDetail[0]->ProductName }}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>

@endsection