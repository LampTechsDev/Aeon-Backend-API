<?php

namespace Database\Seeders;

use App\Models\VendorProfile;
use Illuminate\Database\Seeder;

class VendorProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VendorProfile::create([
            
            "vendor_id"           => "1",
            "factory_profile_name"=> "DSL GROUP",
            "contact_number"      => 01233333333,
            "email"               => "vendorprofile@gmail.com",
            "address"             =>"DHAKA",
            "business_segments"   =>"Business Segment",
            "manufacturing_unit"  =>"Manufacturing Unit",
            "buying_partners"     =>"Buying Partners",
            "social_platform_link"=>"www.socialmedia.com",
            "video_link"          =>"https://www.youtube.com/watch?v=I7sVDcJ8YF4&ab_channel=OsmanGroup",
            "social_platform_link"=>"www.socialmedia.com",
            "remarks"             => "this is vendor comment part",
            "status"              => "Active"
        ]);
    }
}
