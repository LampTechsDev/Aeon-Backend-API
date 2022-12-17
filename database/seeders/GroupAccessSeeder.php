<?php

namespace Database\Seeders;

use App\Models\GroupAccess;
use Illuminate\Database\Seeder;

class GroupAccessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GroupAccess::where("group_id", 1)->delete();
        GroupAccess::create([
            "group_id"      => 1,
            "group_access"  => [
                "admin"         => ["admin_list", "admin_create", "admin_update", "admin_delete", "admin_restore"],
                "group"         => ["group_list", "group_create", "group_update", "group_delete"],
                "therapist"     => ["therapist_list", "therapist_create", "therapist_update", "therapist_delete"],
                "patient"       => ["patient_list", "patient_create", "patient_update", "patient_delete"],
            ]
        ]);
    }
}
