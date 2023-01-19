@extends('frontend.layout.app')
@section('title','Kasir Restaurant')
@section('content')
    <div class="container">
        <div class="card mt-5" style="background-color:#414141;height:250px;">
            <div class="card-body mx-auto">
                <div class="mx-4">
                    <a href="/start_order" class="btn btn-secondary {{ $meja->where('status_meja','kosong')->count() <= 0 ? 'disabled' : '' }}">Start New Order</a>
                    <a href="/list_order" class="btn btn-secondary">View List Order</a>
                </div>
                <span>
                    <h3 class="mt-5 text-light">Total meja yang tersedia : {{ $meja->where('status_meja','kosong')->count() }}</h3>
                </span>
            </div>
        </div>
    </div>
@endsection
