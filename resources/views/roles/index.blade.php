@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('app.role.roles') }}</h2>
        </div>
        <div class="pull-right">
        @can('role-create')
            <a class="btn btn-success" href="{{ route('roles.create') }}"> {{ __('app.role.create') }} </a>
        @endcan
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
@endif
<table class="table table-striped mt-2">
    <tr>
        <th>{{ __('app.role.number') }}</th>
        <th>{{ __('app.role.name') }}</th>
        <th>{{ __('app.actions') }}</th>
    </tr>
    
    @foreach ($roles as $key => $role)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $role->name }}</td>
        <td>
            <a class="btn btn-info" href="{{ route('roles.show',$role->id) }}" title="{{ __('app.view') }}"><i class="fa-solid fa-eye"></i></a>
            @can('role-edit')
            <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}" title="{{ __('app.edit') }}"><i class="fas fa-edit"></i></a>
            @endcan
            @can('role-delete')
            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
            {!! Form::button('<i class="fa-solid fa-trash"></i>', ['class' => 'btn btn-danger', 'title' => __('app.delete')]) !!}
        {!! Form::close() !!}
            @endcan
        </td>
    </tr>
    @endforeach
</table>
{!! $roles->render() !!}
@endsection