@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>List</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('employes.create') }}"> Create New Employer</a>
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
            <th>First Name</th>
            <th>Last Name</th>
            <th>Company</th>
            <th>Email</th>
            <th>Phone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($employes as $i=>$employer)
        <tr>
            <td>{{ ++$i }}</td>
            <td>{{ $employer->first_name }}</td>
            <td>{{ $employer->last_name }}</td>
            <td>{{ $employer->companyName }}</td>
            <td>{{ $employer->email }}</td>
            <td>{{ $employer->phone }}</td>
            <td>
                <form action="{{ route('employes.destroy',$employer->id) }}" method="POST">

                    <a class="btn btn-info" href="{{ route('employes.show',$employer->id) }}">Show</a>

                    <a class="btn btn-primary" href="{{ route('employes.edit',$employer->id) }}">Edit</a>

                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $employes->links() !!}
</div>
@endsection