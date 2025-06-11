<?php

namespace App\Http\Controllers;

use App\Models\TestRequest;
use App\Http\Requests\StoreTestRequestRequest;
use App\Http\Requests\UpdateTestRequestRequest;

class TestRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTestRequestRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TestRequest $testRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTestRequestRequest $request, TestRequest $testRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TestRequest $testRequest)
    {
        //
    }
}
