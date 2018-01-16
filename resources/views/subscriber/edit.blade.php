@extends('layouts.panel')

@section('panel')
    <div class="panel-heading container-fluid">
        <div class="form-group">
            <a class="btn btn-info btn-xs col-md-1 col-sm-2 col-xs-2"
               href="{{route('bunch.editSubscribers', compact('bunch_id'))}}">
                <i class="fa fa-backward" aria-hidden="true"></i> Back
            </a>
            <div class="centered-child col-md-9 col-sm-7 col-xs-6">Edit subscriber: <b>{{$subscriber->email}}</b></div>
            <div class="col-md-2 col-sm-3 col-xs-4">
                <div class="pull-right">
                    {{Form::open(['class' => 'confirm-delete', 'route' => ['subscriber.destroy', $bunch_id, $subscriber], 'method' => 'DELETE'])}}
                    {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">

        @if(Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif

        {!! Form::model($subscriber, ['route' => ['subscriber.update', $bunch_id, $subscriber], 'method' => 'PUT']) !!}

        @include('subscriber._form')

        <div class="form-group">
            {!! Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}

        {{--Current bunches--}}
        <table class="table table-bordered table-responsive table-condensed">
            <caption><b>Bunches:</b></caption>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Description</th>
                <th width="15%">Action</th>
            </tr>
            @foreach ($subscriber->bunches as $bunch)
                <tr>
                    <td>{{$bunch->id}}</td>
                    <td>{{$bunch->name}}</td>
                    <td>{{$bunch->description}}</td>
                    <td>
                        {{ link_to_route('subscriber.removeFromBunch', 'Remove', [$bunch_id, $subscriber, $bunch], ['class' => 'btn btn-danger btn-block']) }}
                    </td>
                </tr>
            @endforeach
        </table>

        {{--Add to new bunch--}}
        {!! Form::open(['class' => 'confirm-add', 'route' => ['subscriber.addToBunch', $bunch_id, $subscriber], 'method' => 'POST']) !!}
        <table class="table table-bordered table-responsive table-condensed">
            <caption><b>Add to bunch:</b></caption>
            <tr>
                <td>
                    <div class="form-group">
                        {!!Form::select('bunch_id', \App\Models\Bunch::getAsListFiltered($subscriber), null, ['class' => 'form-control']) !!}
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