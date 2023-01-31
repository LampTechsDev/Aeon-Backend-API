<?php

namespace Database\Seeders;

use App\Models\VendorManufacturer;
use Illuminate\Database\Seeder;

class VendorManufacturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorManufacturer::create([
            "vendor_id"               =>1,
            "name"                    => "DPPL DENIM PROCESSING PLANT LTD",
            "phone"                   => 0123456677,
            "email"                   => "vendorcontactpeople@gmail.com",
            "remarks"                 => "this is vendor comment part",
            "status"                  => "Active"
        ]);
    }
}
