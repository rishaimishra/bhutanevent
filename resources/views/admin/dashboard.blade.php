@extends('layouts.app')

@section('title', 'Admin Dashboard - Bhutan Echos')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>
                <div class="card-body">
                    <h1>Welcome to Admin Dashboard</h1>
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">User Management</div>
                                <div class="card-body">
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary">Manage Users</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 