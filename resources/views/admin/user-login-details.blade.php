@extends('admin.layout.layout')
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Login Details</h3>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>User email</th>
                                <th>Role</th>
                                <th>Login Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loginDetails as $loginDetail)
                            <tr>
                                <td>{{ $loginDetail['email'] }}</td>
                                <td>{{ $loginDetail['role'] }}</td>
                                <td>{{ $loginDetail['login_time'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
