<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubUser;
use App\Models\User;
use App\Models\Business;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;


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
            'user_type' => 'required|in:manager,staff', // Validate user_type
        ]);


        $user_id = $request->session()->get('user_id');

        $business = Business::where('user_id', '=', $user_id)->select('state', 'company_name', 'gstavailable','business_category')->first();

        $permissions = [
            'party' => false,
        'product' => false,
        'purchase' => false,
        'sale' => false,
        'quotation' => false,
        'payment' => false,
        'expense' => false,
        'cash_bank' => false,
        'report' => false,
        'setting' => false,
        'finance' => false,
        ];
    
        if ($request->has('permissions')) {
            foreach ($request->input('permissions') as $key => $value) {
                $permissions[$key] = $value === 'true'; 
            }
        }

        $subUser = SubUser::create([
            'user_id' => $request->session()->get('user_id'),
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'permissions' => json_encode($permissions),
            'usertype' => $validated['user_type'], 
        ]);

        $userArr = [
            'name' =>$business->company_name,
            'email' =>$validated['email'],
            'password' => Hash::make($validated['password']),
            'usertype' => $validated['user_type'],
            'parent_id' => $user_id,
        ];

        // dd($userArr);

        User::create($userArr);

        return redirect()->route('subuser.index')->with('success', 'User added successfully.');
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
            'user_type' => 'required|in:manager,staff', // Validate user_type
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

        // Save the updated data to the database
        $subUser->permissions = json_encode($permissions);
        $subUser->usertype = $validated['user_type']; // Update user_type
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
            $userId = $request->session()->get('user_id');
    
            // Fetch data
            $data = SubUser::select('id', 'name', 'email', 'permissions')
                ->where('user_id', $userId)
                ->get();
    
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
                ->editColumn('permissions', function ($row) {
                    try {
                        // Decode JSON safely
                        $permissions = json_decode($row->permissions, true);
                
                        // Handle null or invalid JSON
                        if (!$permissions || !is_array($permissions)) {
                            return json_encode([]); // Return an empty JSON array for invalid or null permissions
                        }
                
                        // Filter permissions
                        $filteredPermissions = array_filter($permissions, fn($val) => $val === true || $val === "true");
                
                        // Return JSON-encoded filtered keys
                        return json_encode(array_keys($filteredPermissions));
                    } catch (\Exception $e) {
                        \Log::error('Error decoding permissions: ' . $e->getMessage());
                        return json_encode([]); // Return an empty JSON array on error
                    }
                })
                
                ->rawColumns(['action', 'permissions']) // Allow HTML in these columns
                ->make(true);
        }
    
        return view('subUsers.view');
    }
    
    
    
}
