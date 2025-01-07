<?php

namespace App\Exports;

use App\Models\Repair;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RepairReport implements FromCollection, WithHeadings
{
    /**
     * Variable to store filter criteria.
     */
    protected $filter;

    /**
     * Constructor to accept filter.
     *
     * @param string $filter
     */
    public function __construct($filter)
    {
        $this->filter = $filter;
    }

    /**
     * Fetch the collection of data for the export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Query the Repair model
        $query = Repair::select(
            'service_no',
            'customer_name',
            'phone',
            'complaint_remark',
            'status'
        )
        ->where('user_id', Auth::user()->id);

        if (!empty($this->filter)) {
            $query->where('status', $this->filter);
        }

        $repairs = $query->get();

        return $repairs->map(function ($repair) {
            $repair->status = strtoupper($repair->status);
            return $repair;
        });
    }

    /**
     * Set the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            "Service No",
            "Customer Name",
            "Phone",
            "Complaint",
            "Status",
        ];
    }
}
