<?php

namespace App\Http\Controllers;

use App\Models\AuditAccess;
use App\Models\Business;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\File;

class AuditAccessController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $loggedInUser = Business::where('user_id', $user_id)->first();

        if ($loggedInUser->business_category === 'Accounting & CA') {
            $auditAccesses = AuditAccess::where('auditor_id', $user_id)->with(['auditor', 'targetUser'])->orderBy('id', 'desc')->get();
        } else {
            $auditAccesses = AuditAccess::where('target_user_id', $user_id)->with(['auditor', 'targetUser'])->orderBy('id', 'desc')->get();
        }
        return view('auditaccess.view', compact('auditAccesses'));
    }

    public function searchAuditors(Request $request)
    {
        $searchTerm = $request->get('search');
    
        $auditors = Business::where('business_category', 'Accounting & CA')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('user_id', $searchTerm);
            })
            ->select('user_id', 'company_name')
            ->get();
    
        if ($auditors->isEmpty()) {
            return response()->json([
                'message' => 'No auditors found.',
                'auditors' => []
            ], 401);
        }
    
        return response()->json([
            'message' => 'Auditors retrieved successfully.',
            'auditors' => $auditors
        ], 200);
    }
    

    public function searchClients(Request $request)
    {
        $searchTerm = $request->get('search');
    
        $existingClient = AuditAccess::where('target_user_id', $searchTerm)
            ->where('status', 'approved')
            ->exists();
    
        if ($existingClient) {
            return response()->json([
                'message' => 'An auditor is already assigned to this client.',
                'clients' => []
            ], 401);
        }
    
        // Fetch clients based on search term or return all if not found
        $clients = Business::where('business_category', '!=', 'Accounting & CA')
            ->when($searchTerm, function ($query, $searchTerm) {
                return $query->where('user_id', $searchTerm);
            })
            ->select('user_id', 'company_name')
            ->get();
    
        return response()->json([
            'clients' => $clients
        ]);
    }
    

    public function create(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $loggedInUser = Business::where('user_id', $user_id)->first();

        if ($loggedInUser->business_category === 'Accounting & CA') {
            $auditors = Business::where('user_id', $user_id)->where('business_category', 'Accounting & CA')->select('user_id', 'company_name')->first();

            $existinguserIds = AuditAccess::where('status', '!=', 'approved')
                ->pluck('id')
                ->toArray();
            if (!$existinguserIds) {

                $users = Business::where('business_category', '!=', 'Accounting & CA')
                    ->whereNotIn('id', $existinguserIds)
                    ->get();
            } else {
                $users = Business::where('business_category', '!=', 'Accounting & CA')
                    ->where('user_id', $user_id)
                    ->get();
            }
            // $users = Business::where('business_category', '!=', 'Accounting & CA')->get();
        } else {

            $existingAuditorIds = AuditAccess::where('target_user_id', $user_id)
                ->where('status', 'approved')
                ->pluck('auditor_id')
                ->toArray();
            if (!$existingAuditorIds) {

                $auditors = Business::where('business_category', 'Accounting & CA')
                    ->whereNotIn('user_id', $existingAuditorIds)
                    ->get();
            } else {
                $auditors = Business::where('business_category', 'Accounting & CA')
                    ->where('user_id', $existingAuditorIds)
                    ->get();
            }

            $users = Business::where('user_id', $user_id)->select('user_id', 'company_name')->first();
        }
        // dd($auditors,$users);
        return view('auditaccess.add', compact('auditors', 'users', 'loggedInUser'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'auditor_id' => 'required|exists:users,id',
            'target_user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
        ]);

        $auditorId = $validatedData['auditor_id'];
        $targetUserId = $validatedData['target_user_id'];
        $reason = $validatedData['reason'];

        // dd($validatedData);
        $auditAccess = new AuditAccess();
        $auditAccess->auditor_id = $auditorId;
        $auditAccess->target_user_id = $targetUserId;
        $auditAccess->user_id = $request->session()->get('user_id');
        $auditAccess->reason = $reason;
        $auditAccess->status = 'pending';
        $auditAccess->save();

        return redirect()->route('audit-access.index')->with('success', 'Audit access request created successfully.');
    }


    public function edit(AuditAccess $auditAccess)
    {
        $auditors = User::where('usertype', 'auditor')->get();
        $users = User::all();
        return view('auditaccess.edit', compact('auditAccess', 'auditors', 'users'));
    }

    public function update(Request $request, AuditAccess $auditAccess)
    {
        $validatedData = $request->validate([
            'auditor_id' => 'required|exists:users,id',
            'target_user_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
        ]);

        $auditAccess->auditor_id = $validatedData['auditor_id'];
        $auditAccess->target_user_id = $validatedData['target_user_id'];
        $auditAccess->reason = $validatedData['reason'];
        $auditAccess->save();

        return redirect()->route('audit-access.index')->with('success', 'Audit access request updated successfully.');
    }



    public function destroy(AuditAccess $auditAccess)
    {
        $auditAccess->delete();
        return redirect()->route('audit-access.index')->with('success', 'Audit access request deleted successfully.');
    }
    public function changeStatus(AuditAccess $auditAccess, $status)
    {
        if (!in_array($status, ['approved', 'rejected', 'pending'])) {
            return back()->with('error', 'Invalid status.');
        }

        $auditAccess->update(['status' => $status]);

        return redirect()->route('audit-access.index')->with('success', 'Audit access status updated successfully.');
    }

    public function show(Request $request, $id)
    {
        $clients = AuditAccess::where('auditor_id', $request->session()->get('user_id'))
            ->where('status', 'approved')
            ->with('targetUser')
            ->get()
            ->pluck('targetUser');

        return view('auditaccess.myclient', compact('clients'));
    }


    public function downloadSaleReport(Request $request, $client)
    {
        $data = Sale::select(
            'sales.id',
            'sales.party',
            'sales.invoice_date',
            'products.item_name as name',
            'item_description',
            'sales.invoice_no',
            'net_amount'
        )
            ->join('sale_details', 'sale_details.sale_id', '=', 'sales.id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->where('sales.user_id', $client);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = $request->input('from_date') . ' 00:00:00';
            $toDate = $request->input('to_date') . ' 23:59:59';
            $data->whereBetween('sales.created_at', [$fromDate, $toDate]);
        }

        $data = $data->get();



        $filename = 'Sales_Report_Client_' . now()->format('Y-m-d') . '.csv';
        $filePath = storage_path("reports/{$filename}");
        $file = fopen($filePath, 'w');

        fputcsv($file, ['ID', 'Party', 'Invoice Date', 'Item Name', 'Description', 'Invoice No', 'Net Amount']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->id,
                $row->party,
                $row->invoice_date,
                $row->name,
                $row->item_description,
                $row->invoice_no,
                $row->net_amount,
            ]);
        }

        fclose($file);

        return response()->download($filePath)->deleteFileAfterSend();
    }

    public function downloadPurchaseReport(Request $request, $client)
    {
        $data = Purchase::select(
            'purchases.id',
            'businesses.company_name',
            'products.item_name as name',
            'purchases.created_at as purchase_date',
            'purchases.party',
            'purchases.purchase_no',
            'purchases.net_amount'
        )
            ->join('businesses', 'businesses.id', '=', 'purchases.business_id')
            ->join('purchase_details', 'purchase_details.purchase_id', '=', 'purchases.id')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->where('purchases.user_id', $client);

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $fromDate = $request->input('from_date') . ' 00:00:00';
            $toDate = $request->input('to_date') . ' 23:59:59';
            $data->whereBetween('purchases.created_at', [$fromDate, $toDate]);
        }

        $data = $data->get();

        $filename = 'Purchase_Report_Client_'  . now()->format('Y-m-d') . '.csv';
        $filePath = storage_path("reports/{$filename}");
        $file = fopen($filePath, 'w');

        fputcsv($file, ['ID', 'Company Name', 'Item Name', 'Purchase Date', 'Party', 'Purchase No', 'Net Amount']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->id,
                $row->company_name,
                $row->name,
                $row->purchase_date,
                $row->party,
                $row->purchase_no,
                $row->net_amount,
            ]);
        }

        fclose($file);

        return response()->download($filePath)->deleteFileAfterSend();
    }
}
