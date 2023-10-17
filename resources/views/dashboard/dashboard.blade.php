@extends('dashboard.layout.app', [
    'title' => 'Dashboard',
])
@section('content')
    <div class="container">
        @if (session('status'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('status') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body text-center">
                        {{ Auth::user()->name }}
                        {{ __(', You are logged in! As') }}
                        {{ Auth::user()->role->name }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
