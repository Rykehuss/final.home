<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\Bunch;
use App\Http\Requests\SubscriberRequest;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscribers = Subscriber::orderBy('id', 'asc')->get();
        return view('subscriber.index', compact('subscribers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('subscriber.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\SubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriberRequest $request)
    {
        Subscriber::create($request->all());
        return redirect()->route('subscriber.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function show(Subscriber $subscriber)
    {
        return view('subscriber.show', compact('subscriber'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscriber $subscriber)
    {
        return view('subscriber.edit', compact('subscriber'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Subscriber $subscriber
     * @param  \App\Http\Requests\SubscriberRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Subscriber $subscriber, SubscriberRequest $request)
    {
        $subscriber->update($request->all());
        return redirect()->route('subscriber.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Subscriber $subscriber
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscriber $subscriber)
    {
        $subscriber->delete();
        return redirect()->route('subscriber.index');
    }

    /**
     * Remove subscriber from specified bunch.
     *
     * @param  Subscriber    $subscriber
     * @param  Bunch    $bunch
     * @return \Illuminate\Http\Response
     */
    public function removeFromBunch(Subscriber $subscriber, Bunch $bunch)
    {
        $subscriber->bunches()->detach($bunch->id);
        return view('subscriber.edit', compact('subscriber'));
    }

    /**
     * Add the specified subscriber to bunch.
     *
     * @param  Subscriber    $subscriber
     * @param  \Illuminate\Http\Request    $request
     * @return \Illuminate\Http\Response
     */
    public function addToBunch(Subscriber $subscriber, Request $request)
    {
        $subscriber->bunches()->attach($request->input('bunch_id'));
        return view('subscriber.edit', compact('subscriber'));
    }
}
