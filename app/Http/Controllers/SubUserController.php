<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubUser;
use Yajra\DataTables\DataTables;

class SubUserController extends Controller
{
    public function create()
    {
        return view('subUsers.add');
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

        // return response()->json([
        //     'message' => 'Sub-user created successfully',
        //     'sub_user' => $subUser,
        // ]);
        return redirect()->route('subuser.index')->with('success', 'User Added successfully.');

    }

    public function edit($id)
    {
        $user = SubUser::findOrFail($id);
        $permissions = json_decode($user->permissions, true);

        return view('subUsers.edit', compact('user', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'permissions' => 'nullable|array',
        ]);
    
        $subUser = SubUser::findOrFail($id);
    
        // Ensure all permissions exist and default to "false"
        $permissionsList = ['service', 'cash_bank', 'payment', 'report'];
        $permissions = array_fill_keys($permissionsList, 'false');
    
        // Update the "true" permissions from the request
        foreach ($request->input('permissions', []) as $key => $value) {
            if (in_array($key, $permissionsList)) {
                $permissions[$key] = 'true';
            }
        }
    
        // Save the updated JSON to the database
        $subUser->permissions = json_encode($permissions);
        $subUser->save();
    
        return redirect()->route('subuser.index')->with('success', 'Sub-user updated successfully.');
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
            $data = SubUser::with('parentUser')->select('id', 'name', 'email', 'permissions')->where('user_id', $request->session()->get('user_id'))->get();
            return Datatables::of($data)
              
                ->addColumn('action', function ($row) {
                    $editUrl = route('subuser.edit', $row->id);
                    $deleteUrl = route('subuser.destroy', $row->id);
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
