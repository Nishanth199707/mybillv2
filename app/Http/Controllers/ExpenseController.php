<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Expensecategory;
use App\Models\Expensedetails;
use App\Models\Business;
use App\Models\Party;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PartyPayment;
use App\Models\Purchase;
use App\Models\Sale;


class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if ($request->ajax()) {
            $data = Expense::select('*')->where('user_id', $request->session()->get('user_id'))->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('dateofexpense', function ($row) {
                    return date('d-m-Y', strtotime($row->dateofexpense));
                })
                ->addColumn('action', function ($row) {
                    $btn = '<a class="btn btn-primary btn-sm" href="' . url('/expense/edit/' . $row->id . '') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a class="btn btn-primary btn-sm" href="' . url('/expense/view/' . $row->id . '') . '"><i class="fa-solid fa-eye"></i> View</a>
                            <a class="btn btn-primary btn-sm" href="' . url('/expense/delete/' . $row->id . '') . '"><i class="fa-solid fa-distroy"></i> Delete</a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('expense.index');

    }

    public function edit(Request $request, $id)
    {
        $userId = $request->session()->get('user_id');
        $categories = Expensecategory::where('user_id', $userId)->get();
        $parties = Party::where('user_id', $userId)->get();
        $business = Business::where('user_id', $userId)->first();
        $expense = Expense::find($id);
        $expensedetails = Expensedetails::where('expense_id', $id)->get();
        return view('expense.edit', compact('categories', 'parties', 'business', 'expense', 'expensedetails'));
    }

    public function view(Request $request, $id)
    {
        $userId = $request->session()->get('user_id');
        $categories = Expensecategory::where('user_id', $userId)->get();
        $parties = Party::where('user_id', $userId)->get();
        $business = Business::where('user_id', $userId)->first();
        $expense = Expense::find($id);
        $expensedetails = Expensedetails::join('expensecategories','expensecategories.id','=','expensedetails.expensecategory_id')->where('expense_id', $id)->get();
        $payment = PartyPayment::where('transaction_type', 'expense'.$id)->first();
        return view('expense.view', compact('categories', 'parties', 'business', 'expense', 'expensedetails', 'payment'));
    }


    public function update(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $expense = Expense::find($request->expense_id);
        $timestamp = strtotime($request->expense_date); // Convert string to timestamp
        $expense->dateofexpense = date('Y-m-d',$timestamp);
        $expense->expense_ref = $request->expense_no;
        $expense->amount = $request->net_amount;
        $expense->user_id = $userId;
        $expense->cash_type = $request->cash_type;
        $expense->save();
        $expenseId = $expense->id;

        $totQues = $request->totQues;
        Expensedetails::where('expense_id', $expenseId)->delete();
        for ($i = 0; $i < $totQues; $i++) {
            $expensedetail = new Expensedetails();
            $expensedetail->expense_id = $expenseId;
            $expensedetail->expensecategory_id = $request->input('expence_type' . ($i + 1));
            $expensedetail->expense_name =  $request->input('product_id' . ($i + 1));
            $expensedetail->price = $request->input('amount' . ($i + 1));
            $expensedetail->description = $request->input('description' . ($i + 1));
            $expensedetail->save();
        }
        if(!empty($expenseId)){
            // 'expense'.$expenseId;
            $expense_pay = PartyPayment::where('transaction_type', 'expense'.$expenseId)->first();
            if($expense_pay){

                $expense_pay->debit = $request->net_amount;
                $expense_pay->save();
            }else{
                $business_id = Business::where('user_id', '=', $userId)->select('id')->first();
                $invoice_id = PartyPayment::where('user_id', $userId)
                ->where('debit', '!=', '0.00')
                ->where('invoice_no', 'LIKE', "%PMT%") // Filter by prefix
                ->orderBy('invoice_no', 'DESC')
                ->first();

            if ($invoice_id) {
                    // Extract the numeric part from the last invoice number
                    $lastInvoiceNumber = (int)str_replace('PMT', '', $invoice_id->invoice_no);
                    $nextInvoiceNumber = $lastInvoiceNumber + 1;
                } else {
                    // Start from 1 if no previous invoice exists
                    $nextInvoiceNumber = 1;
                }

        // Generate the next invoice number with padding
        $invoice_no = $this->invoice_num($nextInvoiceNumber, 7, 'PMT');
                $partyPaymentArr = [
                    'user_id' => $userId,
                    'party_id' => 0,
                    'business_id' => $business_id->id,
                    'transaction_type' => 'expense'.$expenseId,
                    'invoice_no' => $invoice_no,
                    'paid_date' => $request->expense_date,
                    'debit' => $request->net_amount,
                    'payment_type' => 'debit',
                    'mode_of_payment' => $request->cash_type,
                    'opening_balance' => 0,
                    'closing_balance' => 0,
                ];

                PartyPayment::create($partyPaymentArr);
            }
        }
        return redirect()->route('expense.index')
        ->with('success', 'Expense Updated successfully.');
    }
    public function category(Request $request)
    {
        $userId = $request->session()->get('user_id');
        if ($request->ajax()) {
            $data = Expensecategory::select('*')->where('user_id', $request->session()->get('user_id'))->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('image', function ($row) {
                    $image = '<img src="' . asset('uploads/category/' . $row->image) . '" width="50" height="50">';
                    return $image;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<form action="' .  route('expensecategory.distroy')  . '" method="POST" onsubmit="return confirm(\'Are you sure you want to delete this Category?\')">
                                <input type="hidden" name="_token" value="' . csrf_token() . '">
                                <input type="hidden" name="id" value="' . $row->id . '">
                                <a class="btn btn-primary btn-sm" href="' . url('/expense/categoryedit/' . $row->id . '') . '"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i> Delete</button>
                                </form>';
                    return $btn;
                })

                ->rawColumns(['image', 'action'])
                ->make(true);
        }
        $categories = Expensecategory::where('user_id', $userId)->get();
        $category = '';

        return view('expense.expensecat_add', compact('category','categories'));
    }

    public function categorystore(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $category = new Expensecategory();

        $method = $request->action_fun;
        if($method == 'add'){
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->user_id = $userId;
            $category->save();
            return redirect()->route('expense.category')
            ->with('success', 'Product Category Added successfully');
        }elseif($method == 'update'){
            $category = Expensecategory::find($request->id);
            $category->name = $request->name;
            $category->description = $request->description;
            $category->status = $request->status;
            $category->user_id = $userId;
            $category->save();
            return redirect()->route('expense.category')->with('success', 'Product Category Updated successfully');
        }


        // return response()->json(['success' => 'Category added successfully']);

    }

    public function categoryedit(Request $request, $id)
    {
        $userId = $request->session()->get('user_id');
        $category = Expensecategory::find($id);
        $categories = Expensecategory::where('user_id', $userId)->get();
        return view('expense.expensecat_add', compact('category','categories'));
    }

    public function categorydestroy(Request $request)
    {
        //
        $id = $request->id;
        $Expensecategory = Expensecategory::find($id);

        $Expensecategory->delete();
        return redirect()->route('expense.category')
            ->with('success', 'Product Category deleted successfully');
    }

    public function create(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $categories = Expensecategory::where('user_id', $userId)->get();
        $parties = Party::where('user_id', $userId)->get();
        $business = Business::where('user_id', $userId)->first();
        $expense = new Expense();
        // $count_expens = Expense::where('user_id', $userId)->count();
        $lastid_expens = Expense::orderBy('id', 'desc')->first();
        if($lastid_expens == null){
            $lastid_expens = 0;
        }else{
            $lastid_expens = $lastid_expens->id;
        }
        $exp_id = "EXPN" . str_pad($lastid_expens + 1, 4, "0", STR_PAD_LEFT);
        return view('expense.add', compact('categories', 'parties', 'business','exp_id'));
    }

    public function store(Request $request)
    {
        $invoice_no = '';
        // print_r($request->totQues); die();
        $userId = $request->session()->get('user_id');
        $expense = new Expense();
        $timestamp = strtotime($request->expense_date); // Convert string to timestamp
        $expense->dateofexpense = date('Y-m-d',$timestamp);
        $expense->expense_ref = $request->expense_no;
        $expense->amount = $request->net_amount;
        $expense->user_id = $userId;
        $expense->cash_type = $request->cash_type;
        $expense->save();
        $expenseId = $expense->id;

        $totQues = $request->totQues;
        for ($i = 0; $i < $totQues; $i++) {

            $expensedetail = new Expensedetails();
            $expensedetail->expense_id = $expenseId;
            $expensedetail->expensecategory_id = $request->input('expence_type' . ($i + 1));
            $expensedetail->expense_name =  $request->input('product_id' . ($i + 1));
            $expensedetail->price = $request->input('amount' . ($i + 1));
            $expensedetail->description = $request->input('description' . ($i + 1));
            $expensedetail->save();
        }

        if(!empty($expenseId)){
            $business_id = Business::where('user_id', '=', $userId)->select('id')->first();
            $invoice_id = PartyPayment::where('user_id', $userId)
            ->where('debit', '!=', '0.00')
            ->where('invoice_no', 'LIKE', "%PMT%") // Filter by prefix
            ->orderBy('invoice_no', 'DESC')
            ->first();

        if ($invoice_id) {
                // Extract the numeric part from the last invoice number
                $lastInvoiceNumber = (int)str_replace('PMT', '', $invoice_id->invoice_no);
                $nextInvoiceNumber = $lastInvoiceNumber + 1;
            } else {
                // Start from 1 if no previous invoice exists
                $nextInvoiceNumber = 1;
            }

        $invoice_no = $this->invoice_num($nextInvoiceNumber, 4, 'PMT');
            $partyPaymentArr = [
                'user_id' => $userId,
                'party_id' => 0,
                'business_id' => $business_id->id,
                'transaction_type' => 'expense'.$expenseId,
                'invoice_no' => $invoice_no,
                'paid_date' => $request->expense_date,
                'debit' => $request->net_amount,
                'mode_of_payment' => $request->cash_type,
                'payment_type' => 'debit',
                'opening_balance' => 0,
                'closing_balance' => 0,
            ];

            PartyPayment::create($partyPaymentArr);
        }


        return redirect()->route('expense.index')
            ->with('success', 'Expense created successfully.');
    }

    public function invoice_num($input, $pad_len = 5, $prefix = 'INV')
    {
        if ($pad_len <= strlen($input))
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate invoice number', E_USER_ERROR);

        if (is_string($prefix))
            return sprintf("%s%s", $prefix, str_pad($input, $pad_len, "0", STR_PAD_LEFT));

        return str_pad($input, $pad_len, "0", STR_PAD_LEFT);
    }

    public function delete(Request $request, $id)
    {
        $expense_pay = PartyPayment::where('transaction_type', 'expense'.$id)->first();
        if($expense_pay){
            $expense_pay->delete();
        }
        $expense = Expense::find($id);
        $expense->delete();
        return redirect()->route('expense.index')
            ->with('success', 'Expense deleted successfully');
    }

    // public function profit_report(Request $request)
    // {
    //     $f_date = $request->f_date ?: date('d-m-Y', strtotime('-1 year'));
    //     $t_date = $request->t_date ?: date('d-m-Y');

    //     $userId = $request->session()->get('user_id');

    //     // Fetch expenses
    //     $expenses = Expense::join('expensedetails', 'expenses.id', '=', 'expensedetails.expense_id')
    //         ->select('expensedetails.*')
    //         ->where('expenses.user_id', $userId);

    //     if (!empty($f_date) && !empty($t_date)) {
    //         $expenses->where('dateofexpense', '>=', date('d-m-Y', strtotime($f_date)));
    //         $expenses->where('dateofexpense', '<=', date('d-m-Y', strtotime($t_date)));
    //     }

    //     $expenses = $expenses->groupBy('expensedetails.id')->get();

    //     // Fetch purchase details
    //     $purchase_details = Purchase::join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
    //         ->select('purchase_details.*')
    //         ->where('purchases.user_id', $userId);

    //     if (!empty($f_date) && !empty($t_date)) {
    //         $purchase_details->where('purchase_date', '>=', date('d-m-Y', strtotime($f_date)));
    //         $purchase_details->where('purchase_date', '<=', date('d-m-Y', strtotime($t_date)));
    //     }

    //     $purchase_details = $purchase_details->groupBy('purchase_details.id')->get();

    //         // Fetch purchase details for opening
    //         $purchase_open = Purchase::join('purchase_details', 'purchases.id', '=', 'purchase_details.purchase_id')
    //         ->select('purchase_details.*')
    //         ->where('purchases.user_id', $userId);

    //     if (!empty($f_date) && !empty($t_date)) {
    //         $purchase_open->where('purchase_date', '<', date('d-m-Y', strtotime($f_date)));
    //     }
    //     $purchase_openbl = $purchase_open->groupBy('purchase_details.id')->get();

    //     $sales_open = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
    //         ->select('sale_details.*')
    //         ->where('sales.user_id', $userId);

    //     if (!empty($f_date) && !empty($t_date)) {
    //         $sales_open->where('invoice_date', '>=', date('d-m-Y', strtotime($f_date)));
    //     }
    //     $sales_openbalance = $sales_open->groupBy('sale_details.id', 'sale_details.product_id')->get();

    //     $prod = array();






    //     // Fetch sales
    //     $sales = Sale::join('sale_details', 'sales.id', '=', 'sale_details.sale_id')
    //         ->select('sale_details.*')
    //         ->where('sales.user_id', $userId);

    //     if (!empty($f_date) && !empty($t_date)) {
    //         $sales->where('invoice_date', '>=', date('Y-m-d', strtotime($f_date)));
    //         $sales->where('invoice_date', '<=', date('Y-m-d', strtotime($t_date)));
    //     }

    //     $sales = $sales->groupBy('sale_details.id')->get();

    //     // Calculate totals
    //     $total_purchase = $purchase_details->sum('total_amount');
    //     $total_sales = $sales->sum('total_amount');

    //     return view('expense.profit', compact('expenses', 'total_purchase', 'total_sales'));
    // }



}
