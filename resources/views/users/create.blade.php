@extends('layouts.app')
@section('content')
    <div class="d-flex align-content-start justify-center">
        <div>
            <a class="btn btn-secondary" href="{{ route('users.index') }}"> {{ __('app.back') }}</a>
        </div>
        <div>
                <h2 class="m-0 ms-2">{{ __('app.user.new') }}</h2>
        </div>
    </div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}

    <div class="form-group mt-2">
        <strong>{{ __('app.user.name') }}:</strong>
        {!! Form::text('name', null, ['placeholder' => __('app.user.name'), 'class' => 'form-control']) !!}
    </div>
    <div class="form-group mt-2">
        <strong>{{ __('app.user.email') }}:</strong>
        {!! Form::text('email', null, ['placeholder' => __('app.user.email'), 'class' => 'form-control']) !!}

    </div>

    <div class="form-group mt-2">
        <strong>{{ __('app.user.password') }}:</strong>
        {!! Form::password('password', ['placeholder' => __('app.user.password'), 'class' => 'form-control']) !!}

    </div>
    <div class="form-group mt-2">
        <strong>{{ __('app.user.confirm-password') }}:</strong>
        {!! Form::password(__('app.user.confirm-password'), [
            'placeholder' => __('app.user.confirm-password'),
            'class' => 'form-control',
        ]) !!}
    </div>

    <div class="form-group mt-2">
        <strong>{{ __('app.user.roles') }}:</strong>
        {!! Form::select('roles[]', $roles, [], ['class' => 'form-control', 'multiple']) !!}
    </div>

    <div class="mt-2">
        <button type="submit" class="btn btn-primary">{{ __('app.save') }}</button>
    </div>
    </div>
    {!! Form::close() !!}
@endsection
