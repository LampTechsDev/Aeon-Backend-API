<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            "name"                => "VENDOR",
            "address"             => "DHAKA",
            "email"               => "vendor@gmail.com",
            "contact_number"      =>01234566666,
            "remarks"             => "this is vendor comment part",
            "status"              => "Active"
        ]);
    }
}
