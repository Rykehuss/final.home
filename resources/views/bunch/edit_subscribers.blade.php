@extends('layouts.panel')

@section('panel')
<div class="panel-heading container-fluid">
    <div class="form-group">
        <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2" href="{{route('bunch.index')}}">
            <i class="fa fa-backward" aria-hidden="true"></i> Back
        </a>
        <div class="centered-child col-md-9 col-sm-7 col-xs-6">Edit bunch subscribers: <b>{{$bunch->name}}</b></div>
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
    {{--Current subscribers--}}
    <table class="table table-bordered table-responsive table-condensed table-hover">
        <caption><b>Subscribers:</b></caption>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Surname</th>
            <th>E-mail</th>
            <th width="25%">Action</th>
        </tr>
        <tr>
            <td colspan="5">
                {{ link_to_route('subscriber.create', 'Create New', [$bunch->id], ['class' => 'btn btn-success btn-block']) }}
            </td>
        </tr>
        <tr>
            <td colspan="5">
                {!! Form::open(['class' => 'confirm-add', 'route' => ['bunch.addSubscriber', $bunch], 'method' => 'POST']) !!}
                <table class="table-simple table-responsive table-condensed">
                    <tr>
                        <td width="20%"><strong>Add existent:</strong></td>
                        <td width="55%">
                                {!!Form::select('subscriber_id', \App\Models\Subscriber::getAsListFiltered($bunch), null, ['class' => 'form-control']) !!}
                        </td>
                        <td width="25%">
                                {!! Form::button('Add', ['type' => 'submit', 'class' => 'btn btn-primary btn-block']) !!}
                        </td>
                    </tr>
                </table>
                {!! Form::close() !!}
            </td>
        </tr>
        @foreach ($bunch->subscribers as $subscriber)
        <tr link="{{"subscriber/{$subscriber->id}"}}" class="clickable_row as-link">
            <td>{{$subscriber->id}}</td>
            <td>{{$subscriber->name}}</td>
            <td>{{$subscriber->surname}}</td>
            <td>{{$subscriber->email}}</td>
            <td>
                {{Form::open(['class' => 'subscriber-delete', 'route' => ['subscriber.destroy', $bunch->id, $subscriber], 'method' => 'DELETE'])}}
                {{ link_to_route('bunch.removeSubscriber', 'Remove', [$bunch->id, $subscriber], ['class' => 'btn btn-danger btn-xs']) }}
                {{ link_to_route('subscriber.show', 'Info', [$bunch->id, $subscriber], ['class' => 'btn btn-info btn-xs']) }}
                {{ link_to_route('subscriber.edit', 'Edit', [$bunch->id, $subscriber], ['class' => 'btn btn-success btn-xs']) }}
                {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                {{Form::close()}}
            </td>
        </tr>
        @endforeach
    </table>

</div>

@include('layouts.validation_errors')

@endsection