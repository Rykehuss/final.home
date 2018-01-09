@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">BUNCHES</div>
                    <div class="panel-body">

                        @if(Session::has('error'))
                            <div class="alert alert-danger">
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        {{ link_to_route('bunch.create', 'Create', null, ['class' => 'btn btn-info btn-xs']) }}
                        <table class="table table-bordered table-responsive table-striped table-hover">
                            <tr>
                                <th width="5%">id</th>
                                <th width="20%">Name</th>
                                <th width="30%">Description</th>
                                <th width="10">Subscribers</th>
                                <th width="35%">Action</th>
                            </tr>
                            @foreach ($bunches as $model)
                                <tr link="{{"bunch/".$model->id}}" class="clickable_row as-link">
                                    <td>{{$model->id}}</td>
                                    <td>{{$model->name}}</td>
                                    <td>{{$model->description}}</td>
                                    <td>{{$model->subscribers->count()}}</td>
                                    <td>
                                        {{Form::open(['class' => 'confirm-delete', 'route' => ['bunch.destroy', $model],
                                        'method' => 'DELETE'])}}
                                        {{ link_to_route('bunch.show', 'Info', [$model], ['class' => 'btn btn-info btn-xs']) }}
                                        {{ link_to_route('bunch.edit', 'Edit', [$model], ['class' => 'btn btn-success btn-xs']) }}
                                        {{ link_to_route('bunch.editSubscribers', 'Subscribers', [$model], ['class' => 'btn btn-success btn-xs']) }}
                                        {{Form::button('Delete', ['class' => 'btn btn-danger btn-xs', 'type' => 'submit'])}}
                                        {{Form::close()}}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection