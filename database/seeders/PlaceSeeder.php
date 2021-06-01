<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('places')->truncate();
        $place=new \App\Models\Place();
        $place->name="سوق غزة";
        $place->image="1.jpg";
        $place->category_id=3;
        $place->overview="جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل";
        $place->address="غزة";
        $place->user_id=1;
        $place->latitude=21.39245;
        $place->longitude=39.39245;
        $place->view_count=3;
        $place->save();

        $place=new \App\Models\Place();
        $place->name="سوق رفح";
        $place->image="2.jpg";
        $place->category_id=2;
        $place->overview="جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل";
        $place->address="رفح";
        $place->user_id=1;
        $place->latitude=21.39245;
        $place->longitude=39.39245;
        $place->view_count=3;
        $place->save();

        $place=new \App\Models\Place();
        $place->name="سوق جباليا";
        $place->image="3.jpg";
        $place->category_id=4;
        $place->overview="جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل";
        $place->address="جباليا";
        $place->user_id=1;
        $place->latitude=21.39245;
        $place->longitude=39.39245;
        $place->view_count=3;
        $place->save();
        
        $place=new \App\Models\Place();
        $place->name="سوق الشجاعية";
        $place->image="4.jpg";
        $place->category_id=5;
        $place->overview="جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل جدا جميل";
        $place->address="الشجاعية";
        $place->user_id=1;
        $place->latitude=21.39245;
        $place->longitude=39.39245;
        $place->view_count=3;
        $place->save();
    }
}
