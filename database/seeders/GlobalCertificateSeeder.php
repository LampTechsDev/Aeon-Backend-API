<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GlobalCertificate;

class GlobalCertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         GlobalCertificate::create([
            "name"                    => "Global Certificate",
            "details"                 => "this is certificate details part",
            "remarks"                 => "this is certificate comment part",
            "status"                  => "Active"
        ]);
    }
}
