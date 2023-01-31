<?php

namespace Database\Seeders;

use App\Models\CustomerDepartment;
use Illuminate\Database\Seeder;

class CustomerDepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerDepartment::create([
            "customer_id"             => 1,
            "department_name"         => "128 BOYS",
            "contact_number"          => 0123333334,
            "address"                 => "Dhaka",
            "email"                   => "customer@gmail.com",
            "remarks"                 => "this is customer comment part",
            "status"                  => "Active"
        ]);
    }
}
