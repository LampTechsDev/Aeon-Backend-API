<?php

namespace Database\Seeders;

use App\Models\ManufacturerProfile;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(GroupSeeder::class);
        $this->call(GroupAccessSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(VendorSeeder::class);
        $this->call(VendorProfileSeeder::class);
        $this->call(VendorContactPeopleSeeder::class);
        $this->call(VendorManufacturerSeeder::class);
        $this->call(VendorCertificateSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(CustomerDepartmentSeeder::class);
        $this->call(CustomerContactPeopleSeeder::class);
        $this->call(ManufacturerProfileSeeder::class);
        $this->call(ManufacturerContactPeopleSeeder::class);
        $this->call(ManufacturerCertificateSeeder::class);
        $this->call(GlobalCertificateSeeder::class);
    }
}
