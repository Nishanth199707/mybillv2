<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;


class GstReport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return
            Sale::join('businesses', 'businesses.id', '=', 'sales.business_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select(
                'sales.id',
                'sales.party',
                'businesses.company_name',
                'users.name',
                'sales.invoice_date',
                'sales.invoice_no',
                'sales.totalAmountDisplay',
                'sales.tax_amount_18_cgst as tax_amount_18_cgst',
                'sales.tax_amount_18_sgst as tax_amount_18_sgst',
                'sales.tax_amount_12_cgst as tax_amount_12_cgst',
                'sales.tax_amount_12_sgst as tax_amount_12_sgst',
                'sales.tax_amount_5_cgst as tax_amount_5_cgst',
                'sales.tax_amount_5_sgst as tax_amount_5_sgst',
                'sales.tax_amount',
                'sales.net_amount',
                'sales.cash_type',
                'sales.created_at'
            )
            ->where('sales.user_id',  Auth::user()->id)
            ->get();
    }

    public function headings(): array
    {
        return ["ID", "PARTY", "COMPANYNAME", "BILLEDBY", "INVOICEDATE", "INVOICENO", "TOTAL", "CGST18", "SGST18", "CGST12", "SGST12", "CGST5", "SGST5", "TAXAMOUNT", "NETAMOUNT", "CASHTYPE", "CREATEDAT"];
    }
}
