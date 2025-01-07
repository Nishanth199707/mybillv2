<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Sale;
use App\Models\SaleDetail;
class InvoiceController extends Controller
{
    //
    public function index($id)
    {
        $sale_invoice = Sale::find($id);
        $sale_invoice_details = SaleDetail::find($id);

        // $invoice_no = $this->invoice_num ('1', $pad_len = 7, $prefix = 'INV');
        // return view('invoice.invoicebill',compact('sale_invoice','sale_invoice_details'));

        $data = [
            [
                'quantity' => 2,
                'description' => 'Gold',
                'price' => '$500.00'
            ],
            [
                'quantity' => 3,
                'description' => 'Silver',
                'price' => '$300.00'
            ],
            [
                'quantity' => 5,
                'description' => 'Platinum',
                'price' => '$200.00'
            ]
        ];

        $pdf = Pdf::loadView('invoice', ['data' => $data]);

        return $pdf->download();
    }
}
