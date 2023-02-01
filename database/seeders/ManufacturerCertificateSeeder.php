<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ManufacturerCertificate;

class ManufacturerCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManufacturerCertificate::create([
            "vendor_id"               => 1,
            "global_certificate_id"   => 1,
            "vendor_manufacturer_id"  => 1,
            "score"                   => 8,
            "remarks"                 => "this is vendor comment part",
            "status"                  => "Active"
        ]);
    }
}
