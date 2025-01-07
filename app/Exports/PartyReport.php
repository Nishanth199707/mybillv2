<?php

namespace App\Exports;

use App\Models\Party;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PartyReport implements FromCollection, WithHeadings
{
    /**
     * Fetch the collection of data for the export.
     *
     * @return \Illuminate\Support\Collection
     */

    protected $filter;
 
    public function __construct($filter)
    {

        $this->filter = $filter;
    }
    public function collection()
    {
        // Query the Party model with necessary fields
        $query = Party::join('users', 'users.id', '=', 'parties.user_id')
            ->select(
                'parties.id',
                'parties.name',
                'parties.email',
                'parties.phone_no',
                'parties.transaction_type',

            )
            ->where('parties.user_id', Auth::user()->id); // Filter by the logged-in user's ID
        if ($this->filter !== '' && $this->filter) {
            $query
                ->where('parties.transaction_type', $this->filter);
        } else {
            $query->get();
        }

        return $query->get();
    }

    /**
     * Set the headings for the Excel export.
     *
     * @return array
     */




    /**
     * Set the headings for the Excel export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
           
            "Name",
            "Email",
            "Phone No",
            "Transaction Type",
            
        ];
    }
}
