<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class StockReport implements FromCollection, WithHeadings
{
    protected $subcategory;
    protected $category;

    public function __construct($subcategory, $category)
    {
        $this->subcategory = $subcategory;
        $this->category = $category;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Product::join('businesses', 'businesses.id', '=', 'products.business_id')
            ->join('users', 'users.id', '=', 'products.user_id')
            ->leftJoin('purchase_custom_details', 'purchase_custom_details.product_id', '=', 'products.id') // Join with purchase_custom_details to get IMEI
            ->select(
               
                'products.item_name',
                'products.item_code_barcode',
                'products.sale_price',
                'products.purchase_price',
                'products.stock',
                'products.gst_rate',
                'products.hsn_code',
                'products.description',
                'purchase_custom_details.field_value as imei'
            )
            ->where('products.user_id', Auth::user()->id);

        // Filter based on category and subcategory
        if ($this->category !== 'all') {
            $query->where('products.category', $this->category);
        }
        if ($this->subcategory !== 'all') {
            $query->where('products.sub_category_id', $this->subcategory);
        }

        // Return the results
        return $query->get();
    }

    /**
     * Set the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
           
            "ITEM NAME",
            "ITEM CODE/BARCODE",
            "SALE PRICE",
            "PURCHASE PRICE",
            "STOCK",
            "GST RATE",
            "HSN CODE",
            "DESCRIPTION",
            "IMEI"
        ];
    }
}
