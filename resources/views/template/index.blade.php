@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">TEMPLATES</div>
                    <div class="panel-body">
                        {{ link_to_route('template.create', 'Create', null, ['class' => 'btn btn-info btn-xs']) }}
                        <table class="table table-bordered table-responsive table-striped">
                            <tr>
                                <th width="10%">id</th>
                                <th width="20%">Name</th>
                                <th width="50%">Content</th>
                                <th width="20%">action</th>
                            </tr>
                            @foreach ($templates as $model)
                                <tr onclick="document.location = '{{"template/".$model->id}}'">
                                    <td>{{$model->id}}</td>
                                    <td>{{$model->name}}</td>
                                    <td>{{$model->content}}</td>
                                    <td>
                                        {{Form::open(['class' => 'confirm-delete', 'route' => ['template.destroy', $model],
                                        'method' => 'DELETE'])}}
                                        {{ link_to_route('template.show', 'Info', [$model], ['class' => 'btn btn-info btn-xs']) }}
                                        {{ link_to_route('template.edit', 'Edit', [$model], ['class' => 'btn btn-success btn-xs']) }}
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