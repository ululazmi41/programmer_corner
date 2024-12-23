<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Corner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

use function App\Helpers\addBookmarks;
use function App\Helpers\addCountsPosts;

class CornerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $corners = Corner::all();

        return view('corners.index', compact('corners'));
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

        $iconname = null;
        if ($request->file('icon')) {
            $iconname = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
            $request->file('icon')->storeAs('icons', $iconname, 'public');
        }

        $bannername = null;
        if ($request->file('banner')) {
            $bannername = Str::uuid() . '.' . $request->file('banner')->getClientOriginalExtension();
            $request->file('banner')->storeAs('banners', $bannername, 'public');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $corner = $user->createdCorners()->create([
            'name' => $request->name,
            'handle' => $handle,
            'description' => $request->description,
            'icon_url' => $iconname,
            'banner_url' => $bannername,
        ]);

        $user->corners()->attach($corner, ['role' => 'owner']);

        return redirect("/corners/{$corner->handle}");
    }

    /**
     * Display the specified resource.
     */
    public function show(String $handle)
    {
        $corner = Corner::where('handle', $handle)->firstOrFail();
        $unprocessed = Post::where('corner_id', $corner->id)->with('user', 'corner', 'comments', 'likes', 'views')->latest()->get();
        $counted = addCountsPosts($unprocessed);
        $bookmarks = addBookmarks($counted);
        $posts = $bookmarks;

        $role = 'guest';
        $joined = false;
        $c = null;
        if (Auth::check()) {
            $currentUser = User::where('id', Auth::user()->id)->first();
            $joined = $currentUser->corners->find($corner) != null;
            if ($joined) {
                $role = $currentUser->corners->find($corner)->pivot->role;
            }
        }

        return view("corners.show", compact('corner', 'joined', 'role', 'posts'));
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
    public function update(Request $request, String $id)
    {
        $validation = Validator::make($request->all(), [
            'value' => ['required'],
        ]);

        if (!$validation->fails()) {
            $corner = Corner::find($id);
            if ($request->type == "name") {
                $corner->name = $request->value;
            } else if ($request->type == "description") {
                $corner->description = $request->value;
            } else {
                return response()->json([
                    "type" => $request->type,
                    "error" => "Unknown request type: {$request['value']}",
                ], 422);
            }
            $corner->save();

            return response()->json([
                'status' => 'ok',
            ], 200);
        } else {
            return response()->json([
                'status' => 'failed',
                'type' => $request->type,
            ], 422);
        }
    }

    public function deleteIcon(String $id)
    {
        $corner = Corner::find($id);
        $filepath = 'icons/' . $corner->icon_url;

        if (Storage::disk('public')->exists($filepath)) {
            Storage::disk('public')->delete($filepath);

            $corner->icon_url = null;
            $corner->save();

            return response()->json([
                "status" => "ok",
            ], 200);
        } else {
            return response()->json([
                "status" => "no icon",
            ], 500);
        }
    }

    public function setIcon(Request $request, String $id)
    {
        $corner = Corner::find($id);
        $oldpath = 'icons/' . $corner->icon_url;

        if (Storage::disk('public')->exists($oldpath)) {
            Storage::disk('public')->delete($oldpath);
        }

        $filename = Str::uuid() . '.' . $request->file('icon')->getClientOriginalExtension();
        $filepath = $request->file('icon')->storeAs('icons', $filename, 'public');

        $corner->icon_url = $filename;
        $corner->save();

        return response()->json([
            "filename" => $filename,
            "filepath" => $filepath,
        ], 200);
    }

    public function deleteBanner(String $id)
    {
        $corner = Corner::find($id);
        $filepath = 'banners/' . $corner->banner_url;

        if (Storage::disk('public')->exists($filepath)) {
            Storage::disk('public')->delete($filepath);

            $corner->banner_url = null;
            $corner->save();

            return response()->json([
                "status" => "ok",
            ], 200);
        } else {
            return response()->json([
                "status" => "no icon",
            ], 500);
        }
    }

    public function setBanner(Request $request, String $id)
    {
        $corner = Corner::find($id);
        $oldpath = 'banners/' . $corner->banner_url;

        if (Storage::disk('public')->exists($oldpath)) {
            Storage::disk('public')->delete($oldpath);
        }

        $filename = Str::uuid() . '.' . $request->file('banner')->getClientOriginalExtension();
        $filepath = $request->file('banner')->storeAs('banners', $filename, 'public');

        $corner->banner_url = $filename;
        $corner->save();

        return response()->json([
            "filename" => $filename,
            "filepath" => $filepath,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Corner $corner)
    {
        $corner->delete();

        return redirect()->route('corners.index');
    }

    public function settings(String $handle)
    {
        $corner = Corner::where('handle', $handle)->withCount('members')->firstOrFail();
        return view('corners.settings', compact('corner'));
    }

    public function join(String $handle)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $corner = Corner::where('handle', $handle)->firstOrFail();
        
        if ($user->corners->contains($corner)) {
            return redirect()->route('corners.show', ['handle' => $handle]);
        }
        
        $user->corners()->attach($corner);

        return redirect()->route('corners.show', ['handle' => $handle]);
    }

    public function leave(String $handle)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $corner = Corner::where('handle', $handle)->firstOrFail();
        
        if (!$user->corners->contains($corner)) {
            return redirect()->route('corners.show', ['handle' => $handle]);
        }
        
        $user->corners()->detach($corner);

        return redirect()->route('corners.show', ['handle' => $handle]);
    }
}
