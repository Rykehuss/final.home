<?php

namespace App\Http\Controllers;

use App\Models\Bunch;
use App\Http\Requests\BunchRequest;
use App\Models\Subscriber;

use Illuminate\Http\Request;

class BunchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bunches = Bunch::orderBy('id', 'asc')->get();
        return view('bunch.index', compact('bunches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bunch.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\BunchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BunchRequest $request)
    {
        Bunch::create($request->all());
        return redirect()->route('bunch.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Bunch    $bunch
     * @return \Illuminate\Http\Response
     */
    public function show(Bunch $bunch)
    {
        return view('bunch.show', compact('bunch'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Bunch    $bunch
     * @return \Illuminate\Http\Response
     */
    public function edit(Bunch $bunch)
    {
        return view('bunch.edit', compact('bunch'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Bunch    $bunch
     * @param  \App\Http\Requests\BunchRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Bunch $bunch, BunchRequest $request)
    {
        dd($request);
//        $bunch->update($request->all());
//        return redirect()->route('bunch.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Bunch    $bunch
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bunch $bunch)
    {
        $bunch->delete();
        return redirect()->route('bunch.index');
    }

    /**
     * Remove the specified subscriber from bunch.
     *
     * @param  Bunch    $bunch
     * @param  Subscriber    $subscriber
     * @return \Illuminate\Http\Response
     */
    public function removeSubscriber(Bunch $bunch, Subscriber $subscriber)
    {
        $bunch->subscribers()->detach($subscriber->id);
        return view('bunch.edit', compact('bunch'));
    }

    /**
     * Add the specified subscriber to bunch.
     *
     * @param  Bunch    $bunch
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function addSubscriber(Bunch $bunch, Request $request)
    {
        $bunch->subscribers()->attach($request->input('subscriber_id'));
        return view('bunch.edit', compact('bunch'));
    }
}
