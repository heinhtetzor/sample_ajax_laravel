@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12 centered">
            <h3>Warehouses</h3>
        <a href="{{ route('warehouses.create') }}" class="btn btn-success">Add New Warehouse</a>
        </div>
    </div>
@endsection