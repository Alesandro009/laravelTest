@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('companies.create') }}"> Create New Company</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Email</th>
            <th>Logo</th>
            <th>Website</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($companies as $i=>$company)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->email }}</td>
            <td><img src="{{ $company->logo }}" width=100 height=100></td>
            <td>{{ $company->website }}</td>
            <td>
                <form action="{{ route('companies.destroy',$company->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('companies.show',$company->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $companies->links() !!}
</div>
@endsection