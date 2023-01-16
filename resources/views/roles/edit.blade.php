@extends('layouts.app')
@section('content')
    <h2 class="m-0 mt-2">
        @if ($disabled)
            {{ __('app.role.role') }}
        @else
            {{ __('app.role.edit') }}
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

    @if (isset($superadmin) && $superadmin)
        <div class="alert alert-warning mt-2">
            <ul class="m-0">
                {{ __('app.role.superadmin') }}
            </ul>
        </div>
    @endif

    {!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'PATCH']) !!}

    <div class="form-group mt-2">
        <strong>{{ __('app.role.name') }}:</strong>
        {!! Form::text('name', null, [
            'placeholder' => __('app.role.name'),
            'class' => 'form-control',
            $disabled ? 'disabled' : null,
        ]) !!}
    </div>
    <div class="form-group mt-2">
        <strong>{{ __('app.role.permissions') }}</strong>
        <br />
        @foreach ($permission as $k => $value)
            <label>{{ Form::checkbox('permission[]', $value->id, old('roles.' . $k, in_array($value->id, $rolePermissions)), ['class' => 'name', $disabled ? 'disabled' : null]) }}
                {{ $value->name }}</label>
            <br />
        @endforeach
    </div>
    <div class="row mt-2">
        <div class="col text-start"><a class="btn btn-secondary" href="{{ route('roles.index') }}"> {{ __('app.back') }}</a>
        </div>
        @if (!$disabled)
        <div class="col text-end"><button type="submit" class="btn btn-primary">{{ __('app.save') }}</button></div>
        @endif
    </div>

    {!! Form::close() !!}
@endsection
