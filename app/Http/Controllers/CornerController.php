<?php

namespace App\Http\Controllers;

use App\Models\Corner;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CornerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(Corner::all());

        return view('corners.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('/corners/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
        ]);

        $handle = strtolower($request->name);

        $iconname = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
        $request->file('icon')->storeAs('icons', $iconname, 'public');

        $bannername = Str::uuid() . '.' . $request->file('banner')->getClientOriginalExtension();
        $request->file('banner')->storeAs('banners', $bannername, 'public');

        $user = User::where('id', Auth::user()->id)->first();
        $corner = $user->corners()->create([
            'name' => $request->name,
            'handle' => $handle,
            'description' => $request->description,
            'icon_url' => $iconname,
            'banner_url' => $bannername,
        ]);

        return redirect("/corners/{$corner->handle}");
    }

    /**
     * Display the specified resource.
     */
    public function show(Corner $corner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Corner $corner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Corner $corner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Corner $corner)
    {
        //
    }
}
