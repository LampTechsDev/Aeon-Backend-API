<?php

namespace Database\Seeders;

use App\Models\VendorContactPeople;
use Illuminate\Database\Seeder;

class VendorContactPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorContactPeople::create([
            "vendor_id"               => 1,
            "employee_id"             => 1,
            "first_name"              => "Baximco",
            "last_name"               => "RMG",
            "designation"             => "Designation Section",
            "department"              => "Department Section",
            "category"                => "Category Section",
            "phone"                   => 0123456677,
            "email"                   => "vendorcontactpeople@gmail.com",
            "remarks"                 => "this is vendor comment part",
            "status"                  => "Active"
        ]);
    }
}
