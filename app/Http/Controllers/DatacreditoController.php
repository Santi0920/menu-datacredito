<?php

namespace App\Http\Controllers;

use App\Models\Datacredito;
use Illuminate\Http\Request;

class DatacreditoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return view('datacredito');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('datacredito');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        Datacredito::create($request->all());
        return redirect()->route('datacredito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Datacredito $datacredito)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Datacredito $datacredito)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Datacredito $datacredito)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datacredito $datacredito)
    {
        //
    }
}
