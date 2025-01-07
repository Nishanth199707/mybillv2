<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Exception;
use Yajra\DataTables\DataTables;


class PlanController extends Controller
{
    public function index(Request $request)
    {
        try {

                if ($request->ajax()) {
                    $plans = Plan::all(); 
                    return DataTables::of($plans)
                        ->addIndexColumn() 
                        ->addColumn('actions', function ($plan) {
                            return '<a class="btn btn-primary btn-sm"  href="' . url('wp-admin/plans/' . $plan->id . '/edit') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
';
                        })
                        ->rawColumns([ 'actions']) // Render HTML for buttons
                        ->make(true);
                }
        
            
          
            return view('saadmin.plans.index');
        } catch (Exception $e) {
            \Log::error("Error fetching plans: " . $e->getMessage());
            return redirect()->route('plans.index')->with('error', 'An error occurred while fetching plans.');
        }
    }

    public function create()
    {
        return view('saadmin.plans.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'offer_price' => 'nullable',
                'sale_price' => 'required',
                'no_of_days' => 'required',
            ]);

            Plan::create($request->all());

            return redirect()->route('plans.index')->with('success', 'Plan created successfully');
        } catch (Exception $e) {
                      \Log::error("Error creating plan: " . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the plan. Please try again.');
        }
    }

    public function edit(Plan $plan)
    {
        return view('saadmin.plans.edit', compact('plan'));
    }

    public function update(Request $request, Plan $plan)
    {
        try {
            $request->validate([
                'name' => 'required|string',
                'description' => 'required',
                'offer_price' => 'nullable',
                'sale_price' => 'required',
                'no_of_days' => 'required',
            ]);

            $plan->update($request->all());

            return redirect()->route('plans.index')->with('success', 'Plan updated successfully');
        } catch (Exception $e) {
                      \Log::error("Error updating plan: " . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the plan. Please try again.');
        }
    }

    public function destroy(Plan $plan)
    {
        try {
            $plan->delete();

            return redirect()->route('plans.index')->with('success', 'Plan deleted successfully');
        } catch (Exception $e) {
                      \Log::error("Error deleting plan: " . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the plan. Please try again.');
        }
    }
}
