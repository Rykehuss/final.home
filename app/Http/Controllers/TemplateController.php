<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Http\Requests\TemplateRequest;

class TemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $templates = Template::orderBy('id', 'asc')->owned()->get();
        return view('template.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('template.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TemplateRequest $request)
    {
        Template::create($request->all());
        return redirect()->route('template.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Template $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        return view('template.show', compact('template'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Template $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        return view('template.edit', compact('template'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Template $template
     * @param  \App\Http\Requests\TemplateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Template $template, TemplateRequest $request)
    {
        $template->update($request->all());
        return redirect()->route('template.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Template $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $template->delete();
        return redirect()->route('template.index');
    }
}
