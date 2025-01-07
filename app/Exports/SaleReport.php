<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class SaleReport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */


    protected $from_date;
    protected $to_date;
    protected $subcategory;
    protected $category;

    public function __construct($from_date, $to_date, $subcategory, $category)
    {
        $this->from_date = $from_date;
        $this->to_date = $to_date;
        $this->subcategory = $subcategory;
        $this->category = $category;
    }


    public function collection()
    {
        $query = Sale::join('businesses', 'businesses.id', '=', 'sales.business_id')
            ->join('sale_details', 'sale_details.sale_id', '=', 'sales.id')
            ->join('parties','parties.id', '=', 'sales.party_id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select(
                'sales.id',
                'sales.party',
                'parties.gstin',
                'users.name as billed_by',
                'sales.invoice_date',
                'sales.invoice_no',
                'productsub_categories.name as brand',
                'sale_details.item_description as product',
                'sales.totalAmountDisplay as total',
                'products.gst_rate',
                DB::raw('COALESCE(sales.tax_amount_18_igst, sales.tax_amount_28_igst, sales.tax_amount_12_igst, sales.tax_amount_5_igst) as igst'),
                DB::raw('COALESCE(sales.tax_amount_18_cgst, sales.tax_amount_28_cgst, sales.tax_amount_12_cgst, sales.tax_amount_5_cgst) as cgst'),
                DB::raw('COALESCE(sales.tax_amount_18_sgst, sales.tax_amount_28_sgst, sales.tax_amount_12_sgst, sales.tax_amount_5_sgst) as sgst'),
                'sales.tax_amount',
                'sales.net_amount',
                'sales.cash_type',
                'sales.created_at as created_at'
            )
            ->where('sales.user_id', Auth::user()->id);


        if ($this->from_date && $this->to_date  && $this->subcategory !== 'all' && $this->category !== 'all') {
            $query->whereBetween('sales.created_at', [
                $this->from_date . ' 00:00:00',
                $this->to_date . ' 23:59:59'
            ])
                ->where('products.sub_category_id', $this->subcategory)
                ->where('products.category', $this->category);
        } else if ($this->from_date && $this->to_date) {
            $query->whereBetween('sales.created_at', [
                $this->from_date . ' 00:00:00',
                $this->to_date . ' 23:59:59'
            ]);
        }else{
            $query->get();
        }

        return $query->get();
    }


    public function headings(): array
    {
        return [
            "ID",
            "PARTY",
            "GSTIN",
            "BILLED BY",
            "INVOICE DATE",
            "INVOICE NO",
            "BRAND",
            "PRODUCT",
            "TAXABLE AMOUNT",
            "RATE",
            "IGST",
            "CGST",
            "SGST",
            "TAX AMOUNT",
            "NET AMOUNT",
            "CASH TYPE",
            "CREATED AT"
        ];
    }
}
