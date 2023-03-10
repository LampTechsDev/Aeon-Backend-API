<?php

namespace Database\Seeders;

use App\Models\VendorCertificate;
use Illuminate\Database\Seeder;

class VendorCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorCertificate::create([
            "vendor_id"               => 1,
            "global_certificate_id"   => 1,
            "certificate_name"        => "ISO",
            "score"                   => 8,
            "remarks"                 => "this is vendor certificate comment part",
            "status"                  => "Active"
        ]);
    }
}
