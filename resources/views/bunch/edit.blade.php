@extends('layouts.panel')

@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('bunch.index')}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Edit bunch: <b>{{$bunch->name}}</b></div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <div class="pull-right">
                    {{Form::open(['class' => 'confirm-delete', 'route' => ['bunch.destroy', $bunch], 'method' => 'DELETE'])}}
                    {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        {!! Form::model($bunch, ['route' => ['bunch.update', $bunch], 'method' => 'PUT']) !!}

        @include('bunch._form')

        <div class="form-group">
            {{ Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
        </div>
        {!! Form::close() !!}

        {{--Current subscribers--}}
        <table class="table table-bordered table-responsive table-condensed">
            <caption><b>Subscribers:</b></caption>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Surname</th>
                <th>E-mail</th>
                <th width="15%">Action</th>
            </tr>
            @foreach ($bunch->subscribers as $subscriber)
                <tr>
                    <td>{{$subscriber->id}}</td>
                    <td>{{$subscriber->name}}</td>
                    <td>{{$subscriber->surname}}</td>
                    <td>{{$subscriber->email}}</td>
                    <td>
                        {{ link_to_route('bunch.removeSubscriber', 'Remove', [$bunch, $subscriber], ['class' => 'btn btn-danger btn-block']) }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{--Add new subscriber--}}
        {!! Form::open(['class' => 'confirm-delete', 'route' => ['bunch.addSubscriber', $bunch], 'method' => 'POST']) !!}
        <table class="table table-bordered table-responsive table-condensed">
            <caption><b>Add new subscriber:</b></caption>
            <tr>
                <td>
                    <div class="form-group">
                        {!!Form::select('subscriber_id', \App\Models\Subscriber::getAsListFiltered($bunch), null, ['class' => 'form-control']) !!}
                    </div>
                </td>
                <td width="15%">
                    <div class="form-group">
                        {!! Form::button('Add', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) !!}
                    </div>
                </td>
            </tr>
        </table>
        {!! Form::close() !!}

    </div>

    @include('layouts.validation_errors')

@endsection