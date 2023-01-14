@extends('layouts.app')
@section('content')

    <h2 class="m-0 mt-2">{{ __('app.user.new') }}</h2>

    @if (count($errors) > 0)
        <div class="alert alert-danger mt-2">
            <ul class="m-0">
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
        {!! Form::password('confirm-password', [
            'placeholder' => __('app.user.confirm-password'),
            'class' => 'form-control',
        ]) !!}
    </div>

    <div class="form-group mt-2">
        <strong>{{ __('app.user.roles') }}</strong>
        <br />
        @foreach ($roles as $k => $value)
            <label>{{ Form::checkbox('roles[]', $value->id, old('roles.' . $k), ['class' => 'name']) }}
                {{ $value->name }}</label>
            <br />
        @endforeach
    </div>

    <div class="row mt-2">
        <div class="col text-start"><a class="btn btn-secondary" href="{{ route('users.index') }}"> {{ __('app.back') }}</a>
        </div>
        <div class="col text-end"><button type="submit" class="btn btn-primary">{{ __('app.save') }}</button></div>
    </div>




    </div>
    {!! Form::close() !!}
@endsection
