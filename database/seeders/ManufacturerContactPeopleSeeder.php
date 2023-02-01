<?php

namespace Database\Seeders;

use App\Models\ManufacturerContactPeople;
use Illuminate\Database\Seeder;

class ManufacturerContactPeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManufacturerContactPeople::create([
            
            "vendor_id"               => 1,
            "vendor_manufacturer_id"  => 1,
            "employee_id"             => 1,
            "first_name"              => "Steave",
            "last_name"               => "Rogers",
            "designation"             => "Designation Section",
            "department"              => "Department Section",
            "category"                => "Category Section",
            "phone"                   => 0123456677,
            "email"                   => "manufacturercontactpeople@gmail.com",
            "remarks"                 => "this is manufacturer comment part",
            "status"                  => "Active"
        ]);
    }
}
