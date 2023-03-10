@extends('layouts.app')
@section('content')

<h2 class="m-2 ms-0">{{ __('app.role.new') }}</h2>

    @if (count($errors) > 0)
        <div class="alert alert-danger mt-2">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['route' => 'roles.store', 'method' => 'POST']) !!}

    <div class="form-group mt-2">
        <strong>{{ __('app.role.name') }}:</strong>
        {!! Form::text('name', null, ['placeholder' => __('app.role.name'), 'class' => 'form-control']) !!}
    </div>
    <div class="form-group mt-2">
    <strong>{{ __('app.role.permissions'); }}</strong>
    <br/>
    @foreach($permission as $k => $value)
        <label>{{ Form::checkbox('permission[]', $value->id, old('roles.'.$k) , array('class' => 'name')) }}
        {{ $value->name }}</label>
    <br/>
    @endforeach
</div>
    <div class="row mt-2">
        <div class="col text-start"><a class="btn btn-secondary" href="{{ route('roles.index') }}"> {{ __('app.back') }}</a></div>
        <div class="col text-end"><button type="submit" class="btn btn-primary">{{ __('app.save') }}</button></div>
    </div>
        

        

    </div>
    {!! Form::close() !!}
@endsection
