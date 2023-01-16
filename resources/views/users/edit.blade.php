@extends('layouts.app')
@section('content')

                <h2 class="m-0 mt-2">
                @if ($disabled)
                {{ __('app.user.user') }}    
                @else
                {{ __('app.user.edit') }}
                @endif
                </h2>

    @if (count($errors) > 0)
        <div class="alert alert-danger mt-2">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (isset($superadmin))
        <div class="alert alert-warning mt-2">
            <ul class="m-0">
                {{ __('app.user.superadmin') }}
            </ul>
        </div>
    @endif


{!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}
<div class="form-group mt-2">
    <strong>{{ __('app.user.name') }}:</strong>
    {!! Form::text('name', null, ['placeholder' => __('app.user.name'), 'class' => 'form-control', $disabled ? 'disabled' : null]) !!}
</div>
<div class="form-group mt-2">
    <strong>{{ __('app.user.email') }}:</strong>
    {!! Form::text('email', null, ['placeholder' => __('app.user.email'), 'class' => 'form-control', $disabled ? 'disabled' : null]) !!}

</div>

<div class="form-group mt-2">
    <strong>{{ __('app.user.password') }}:</strong>
    {!! Form::password('password', ['placeholder' => __('app.user.password'), 'class' => 'form-control', $disabled ? 'disabled' : null]) !!}

</div>
<div class="form-group mt-2">
    <strong>{{ __('app.user.confirm-password') }}:</strong>
    {!! Form::password('confirm-password', [
        'placeholder' => __('app.user.confirm-password'),
        'class' => 'form-control'
        , $disabled ? 'disabled' : null
    ]) !!}
</div>

<div class="form-group mt-2">
    <strong>{{ __('app.user.roles'); }}</strong>
    <br/>
    @foreach($roles as $k => $value)
        <label>{{ Form::checkbox(
            'roles[]',
            $value->id,
            old('roles.'.$k, in_array($value->id, $userRoles)),
            ['class' => 'name', $disabled || isset($superadmin) ? 'disabled' : null])
         }}
        {{ $value->name }}</label>
    <br/>
    @endforeach
</div>

<div class="row mt-2">
    <div class="col text-start"><a class="btn btn-secondary" href="{{ route('users.index') }}"> {{ __('app.back') }}</a></div>
    @if (!$disabled)
    <div class="col text-end"><button type="submit" class="btn btn-primary">{{ __('app.save') }}</button></div>
    @endif
</div>
{!! Form::close() !!}
@endsection