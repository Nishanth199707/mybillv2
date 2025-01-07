<?php

namespace App\Exports;

use App\Models\Sale;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class SalenonGst implements FromCollection, WithHeadings
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
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
            ->join('users', 'users.id', '=', 'sales.user_id')
            ->select(
                'sales.id',
                'sales.party',
                'businesses.company_name',
                'users.name as billed_by',
                'sales.invoice_date',
                'sales.invoice_no',
                'productsub_categories.name as brand',
                'sale_details.item_description as product',
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
            "COMPANY NAME",
            "BILLED BY",
            "INVOICE DATE",
            "INVOICE NO",
            "BRAND",
            "PRODUCT",
            "NET AMOUNT",
            "CASH TYPE",
            "CREATED AT"
        ];
    }
}
