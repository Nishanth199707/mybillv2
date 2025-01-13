<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubUser;
use Yajra\DataTables\DataTables;

class SubUserController extends Controller
{
    public function create()
    {
        return view('subUsers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:sub_users,email',
            'password' => 'required|string|min:8',
            'permissions' => 'nullable|array',
        ]);

        $subUser = SubUser::create([
            'user_id' => $request->session()->get('user_id'),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'permissions' => json_encode($validated['permissions']),
        ]);

        return response()->json([
            'message' => 'Sub-user created successfully',
            'sub_user' => $subUser,
        ]);
    }

    public function edit($id)
    {
        $subUser = SubUser::findOrFail($id);
        return view('subUsers.edit', compact('subUser'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'permissions' => 'required|array',
        ]);

        $subUser = SubUser::findOrFail($id);
        $subUser->permissions = json_encode($validated['permissions']);
        $subUser->save();

        return response()->json([
            'message' => 'Permissions updated successfully',
            'sub_user' => $subUser,
        ]);
    }

    public function destroy($id)
    {
        $subUser = SubUser::findOrFail($id);
        $subUser->delete();

        return response()->json([
            'message' => 'Sub-user deleted successfully.',
        ]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubUser::with('parentUser')->select('id', 'name', 'email', 'permissions', 'user_id')->where('user_id', $request->session()->get('user_id'))->get();
            return Datatables::of($data)
                ->addColumn('parent_user', function ($row) {
                    return $row->parentUser ? $row->parentUser->name : 'N/A';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('subusers.edit', $row->id);
                    $deleteUrl = route('subusers.destroy', $row->id);
                    return '
                        <a href="' . $editUrl . '" class="btn btn-sm btn-info">Edit</a>
                        <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('subUsers.view');
    }
}
