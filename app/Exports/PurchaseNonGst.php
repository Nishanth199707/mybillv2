<?php

namespace App\Exports;

use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PurchaseNonGst  implements FromCollection, WithHeadings
{
    /**
     * The date range and filter category and subcategory
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

    /**
     * Get the collection of purchase data based on the filters.
     * 
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Purchase::join('businesses', 'businesses.id', '=', 'purchases.business_id')
            ->join('users', 'users.id', '=', 'purchases.user_id')
            ->join('purchase_details', 'purchase_details.purchase_id', '=', 'purchases.id')
            ->join('products', 'products.id', '=', 'purchase_details.product_id')
            ->join('productsub_categories', 'productsub_categories.id', '=', 'products.sub_category_id')
            ->select(
                'purchases.id',
                'purchases.party',
                'businesses.company_name',
                'users.name as billed_by',
                'purchases.purchase_date',
                'purchases.purchase_no',
                'products.item_name as product_name',
                'productsub_categories.name as brand',
                'purchases.net_amount',
                'purchases.cash_type',
                'purchases.created_at as created_at'
            )
            ->where('purchases.user_id', Auth::user()->id); 
    

            if ($this->from_date && $this->to_date  && $this->subcategory !== 'all' && $this->category !== 'all') {
                $query->whereBetween('purchases.created_at', [
                    $this->from_date . ' 00:00:00',
                    $this->to_date . ' 23:59:59'
                ])
                    ->where('products.sub_category_id', $this->subcategory)
                    ->where('products.category', $this->category);
            } else if ($this->from_date && $this->to_date) {
                $query->whereBetween('purchases.created_at', [
                    $this->from_date . ' 00:00:00',
                    $this->to_date . ' 23:59:59'
                ]);
            }else{
                $query->get();
            }
        return $query->get();
    }
    

    /**
     * Define the headings for the export.
     * 
     * @return array
     */
    public function headings(): array
    {
        return [
            "ID",
            "PARTY",
            "COMPANY NAME",
            "BILLED BY",
            "PURCHASE DATE",
            "PURCHASE NO",
            "PRODUCT NAME",
            "BRAND",
            "NET AMOUNT",
            "CASH TYPE",
            "CREATED AT"
        ];
    }
}
