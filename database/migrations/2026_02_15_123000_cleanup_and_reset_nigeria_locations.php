<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class CleanupAndResetNigeriaLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Ensure Nigeria exists and is active
        $nigeria = Country::where('name', 'Nigeria')->first();
        if (!$nigeria) {
            $nigeria = Country::create(['name' => 'Nigeria', 'code' => 'NG', 'is_active' => 1]);
        } else {
            $nigeria->update(['is_active' => 1]);
        }

        // 2. Delete all other countries
        Country::where('id', '!=', $nigeria->id)->delete();

        // 3. Ensure Lagos exists and is active
        // Find existing Lagos linked to Nigeria, or any Lagos
        $lagos = State::where('name', 'Lagos')->where('country_id', $nigeria->id)->first();
        if (!$lagos) {
            $lagos = State::where('name', 'Lagos')->first();
            if ($lagos) {
                $lagos->update(['country_id' => $nigeria->id, 'is_active' => 1]);
            } else {
                $lagos = State::create(['name' => 'Lagos', 'country_id' => $nigeria->id, 'is_active' => 1]);
            }
        } else {
            $lagos->update(['is_active' => 1]);
        }

        // 4. Delete all other states
        State::where('id', '!=', $lagos->id)->delete();

        // 5. Reset Cities (Delete all, populate curated list)
        City::query()->delete();

        $areas = [
            'Agege', 'Ajeromi-Ifelodun', 'Alimosho', 'Amuwo-Odofin', 'Apapa', 
            'Badagry', 'Epe', 'Eti-Osa', 'Ibeju-Lekki', 'Ifako-Ijaiye', 
            'Ikeja', 'Ikorodu', 'Kosofe', 'Lagos Island', 'Lagos Mainland', 
            'Mushin', 'Ojo', 'Oshodi-Isolo', 'Shomolu', 'Surulere', 
            'Victoria Island', 'Lekki', 'Ikoyi', 'Yaba', 'Festac', 
            'Maryland', 'Gbagada', 'Ogudu', 'Magodo', 'Berger', 'Ajah', 'Sangotedo'
        ];

        foreach ($areas as $areaName) {
            City::create([
                'name' => $areaName,
                'state_id' => $lagos->id,
                'is_active' => 1
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // No simple rollback for data deletion, but that's acceptable for a strict cleanup/fix.
    }
}
