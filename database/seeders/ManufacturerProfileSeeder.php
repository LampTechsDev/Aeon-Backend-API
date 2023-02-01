<?php

namespace Database\Seeders;

use App\Models\ManufacturerProfile;
use Illuminate\Database\Seeder;

class ManufacturerProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ManufacturerProfile::create([

            "vendor_id"           => "1",
            "factory_profile_name"=> "DPPL DENIM PROCESSING PLANT LTD.",
            "vendor_manufacturer_id"=> 1,
            "contact_number"      => 01233333333,
            "email"               => "menufacturerprofile@gmail.com",
            "address"             =>"DHAKA",
            "business_segments"   =>"Business Segment",
            "buying_partners"     =>"Buying Partners",
            "social_platform_link"=>"www.socialmedia.com",
            "video_link"          =>"https://www.youtube.com/watch?v=I7sVDcJ8YF4&ab_channel=OsmanGroup",
            "social_platform_link"=>"www.socialmedia.com",
            "remarks"             => "this is manufacturer comment part",
            "status"              => "Active"
        ]);
    }
}
