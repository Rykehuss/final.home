<div class="form-group">
    {!!Form::label('name', 'Name') !!}
    {!!Form::text('name', null, ['class' => 'form-control']) !!}
    {!!Form::label('description', 'Description') !!}
    {!!Form::text('description', null, ['class' => 'form-control']) !!}

    {!!Form::label('bunch', 'Bunch') !!}
    {!!Form::select('bunch_id', \App\Models\Bunch::getAsList(), isset($campaign) ? $campaign->bunch_id : null, ['class' => 'form-control']) !!}
    {!!Form::label('template', 'Template') !!}
    {!!Form::select('template_id', \App\Models\Template::getAsList(), isset($campaign) ? $campaign->template_id : null, ['class' => 'form-control']) !!}
</div>

