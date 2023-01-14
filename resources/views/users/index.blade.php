@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>{{ __('app.user.users') }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ route('users.create') }}">{{ __('app.user.new') }}</a>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success mt-2">
    {{ $message }}
</div>
@endif
<table class="table table-striped mt-2">
    <tr>
        <th>{{ __('app.user.number') }}</th>
        <th>{{ __('app.user.name') }}</th>
        <th>{{ __('app.user.email') }}</th>
        <th>{{ __('app.user.roles') }}</th>
        <th>{{ __('app.actions') }}</th>
    </tr>
@foreach ($data as $key => $user)
    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>
            @if(!empty($user->getRoleNames()))
                @foreach($user->getRoleNames() as $v)
                    <span class="badge rounded-pill bg-dark">{{ $v }}</span>
                @endforeach
            @endif
        </td>
        <td>
            <a class="btn btn-info" href="{{ route('users.show',$user->id) }}" title="{{ __('app.view') }}"><i class="fa-solid fa-eye"></i></a>
            <a class="btn btn-primary" href="{{ route('users.edit',$user->id) }}" title="{{ __('app.edit') }}"><i class="fas fa-edit"></i></a>
                {!! Form::open(['method' => 'DELETE','route' => ['users.destroy', $user->id],'style'=>'display:inline']) !!}
                    {!! Form::button('<i class="fa-solid fa-trash"></i>', ['class' => 'btn btn-danger', 'title' => __('app.delete')]) !!}
                {!! Form::close() !!}
        </td>
    </tr>
@endforeach
</table>
@endsection