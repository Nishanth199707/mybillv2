<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\TaskManager;
use App\Models\Party;
use App\Models\Product;
use App\Models\Business;
use App\Models\Status;
use App\Models\SubUser;
use Yajra\DataTables\DataTables;

class TaskController extends Controller
{

    public function index(Request $request){
        $userId = $request->session()->get('user_id');

        if ($request->ajax()) {
            $data = TaskManager::select(
                'task_managers.id',
                'task_managers.status',
                'task_managers.updated_at',
                'task_managers.user_id',
                'products.item_name',
                'parties.name',
                'task_managers.description',
                 'sub_users.name as user_name'
            )
            ->leftJoin('products', 'products.id', '=', 'task_managers.product')
            ->leftJoin('parties', 'parties.id', '=', 'task_managers.party')
            ->leftJoin('sub_users', 'sub_users.id', '=', 'task_managers.sub_user') // Fixed LEFT JOIN
            ->where('task_managers.user_id', $request->session()->get('user_id'))
            ->where('task_managers.status','!=', 'complete')
            ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                if($row->user_name == NULL){
                    $user_name = "All User";
                }else{
                    $user_name = $row->user_name;
                }
                return $user_name;
            })
            ->addColumn('status', function ($row) {
                if($row->user_name == NULL){
                    $row->user_name = "All User";
                }
                $options = '';
                $status = Status::where('user_id', $row->user_id)->where('status','active')->get();
                // Generate the select options dynamically
                foreach ($status as $statuses) {
                    $selected = $row->status === $statuses->name ? 'selected' : ''; // Check if the current status matches
                    $options .= "<option value='{$statuses->name}' {$selected}>{$statuses->name}</option>"; // Add options
                }
                $selected1 = $row->status === 'complete' ? 'selected' : ''; // Check if the current status match
                $options .= "<option value='complete' {$selected1}>complete</option>"; // Add options

                // Return the select dropdown
                $selectBox = '<select class="status-select btn btn-secondary" data-id="' . $row->id . '">' . $options . '</select>';
                return $selectBox;
            })
            ->addColumn('action', function ($row) {
                $btn = '<form action="' . route('task.distroy') . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this?\')">
                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                            <input type="hidden" name="id" value="' . $row->id . '">
                            <a class="btn btn-primary btn-sm" href="' . url('/superadmin/taskedit/' . $row->id) . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                        </form>';
                return $btn;
            })
            ->rawColumns(['status', 'action']) // Specify which columns allow raw HTML
            ->make(true);
        }
        $status = Status::where('user_id', $userId)->where('status','active')->get();
        $parties = Party::where('user_id', $userId)->get();
        $products = Product::where('user_id', $userId)->get();
        $sub_user = SubUser::where('user_id', $userId)->get();
        $task='';
        return view('task.view',compact('parties', 'task','products','status','sub_user'));
    }

    public function copindex(Request $request){
        $userId = $request->session()->get('user_id');

        if ($request->ajax()) {
            $data = TaskManager::select(
                'task_managers.id',
                'task_managers.status',
                'task_managers.updated_at',
                'task_managers.user_id',
                'products.item_name',
                'parties.name',
                'task_managers.description',
                 'sub_users.name as user_name'
            )
            ->leftJoin('products', 'products.id', '=', 'task_managers.product')
            ->leftJoin('parties', 'parties.id', '=', 'task_managers.party')
            ->leftJoin('sub_users', 'sub_users.id', '=', 'task_managers.sub_user') // Fixed LEFT JOIN
            ->where('task_managers.user_id', $request->session()->get('user_id'))
            ->where('task_managers.status', 'complete')
            ->get();
            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                if($row->user_name == NULL){
                    $user_name = "All User";
                }else{
                    $user_name = $row->user_name;
                }
                return $user_name;
            })
            ->make(true);
        }
        return view('task.completedlist');
    }

    public function store(Request $request){

        $userId = $request->session()->get('user_id');
        $task = new TaskManager();
        $business = Business::where('user_id', $userId)->first();
        $method = $request->action_fun;
        if($method == 'add' ){
            $task->party = $request->party;
            $task->business_id = $business->id;
            $task->product = $request->product;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->sub_user = $request->user;
            $task->user_id = $userId;
            $task->save();
            return redirect()->route('task.index')
            ->with('success', 'Task Added successfully');
        }elseif($method == 'update'){
            $task = TaskManager::find($request->id);
            $task->party = $request->party;
            $task->business_id = $business->id;
            $task->product = $request->product;
            $task->description = $request->description;
            $task->status = $request->status;
            $task->sub_user = $request->user;
            $task->user_id = $userId;
            $task->save();
            return redirect()->route('task.index')->with('success', 'Task Updated successfully');
        }

    }

    public function distroy(Request $request)
    {
        //
        $id = $request->id;

        $task = TaskManager::find($id);
        $task->delete();


        return redirect()->route('task.index')
            ->with('success', 'Task deleted successfully');
    }
    public function updateStatus(Request $request, $id)
    {
        // dd($id);
        $task = TaskManager::findOrFail($id);
        $task->status = $request->status;
        $task->save();

        return response()->json(['message' => 'Status updated successfully.']);
    }

    public function edit(Request $request, $id)
    {
        $userId = $request->session()->get('user_id');
        $task = TaskManager::find($id);
        $parties = Party::where('user_id', $userId)->get();
        $products = Product::where('user_id', $userId)->get();
        $sub_user = SubUser::where('user_id', $userId)->get();
        $status = Status::where('user_id', $userId)->where('status','active')->get();
        return view('task.view',compact('parties', 'task','products','sub_user','status'));
    }

}
