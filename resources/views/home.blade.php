@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="message-container"></div>
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home"><i class="fa fa-home"></i> Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="deposit-tab" data-toggle="tab" href="#deposit"><i class="fa fa-send-o"></i> Deposit</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="withdraw-tab" data-toggle="tab" href="#withdraw"><i class="fa fa-get-pocket"></i> Withdraw</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="transfer-tab" data-toggle="tab" href="#transfer"><i class="fa fa-exchange"></i> Transfer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="statement-tab" data-toggle="tab" href="#statement"><i class="fa fa-tasks"></i> Statement</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
        <div class="tab-content">
            <br>
            <div class="tab-pane fade show active" id="home">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">Welcome {{ Auth::user()->name }}</div>
                                <div class="card-body">
                                    <p>YOUR ID: {{ Auth::user()->email }}</p>
                                    <p>YOUR BALANCE: $<span id="userBalance">{{ Auth::user()->balance }}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="deposit">
                @include('deposit')
            </div>
            <div class="tab-pane fade" id="withdraw">
                @include('withdraw')
            </div>
            <div class="tab-pane fade" id="transfer">
                @include('transfer')
            </div>
            <div class="tab-pane fade" id="statement">
                @include('statement')
            </div>
        </div>
    </div>
@endsection
