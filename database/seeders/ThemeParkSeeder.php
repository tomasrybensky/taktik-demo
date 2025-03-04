<?php

namespace Database\Seeders;

use App\Models\RollerCoaster;
use App\Models\ThemePark;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Manufacturer;

class ThemeParkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themePark1 = ThemePark::factory()->create([
            'name' => 'Europa-Park',
        ]);

        $themePark2 = ThemePark::factory()->create([
            'name' => 'Efteling',
        ]);

        $themePark3 = ThemePark::factory()->create([
            'name' => 'Tivoli Gardens',
        ]);

        $manufacturer1 = Manufacturer::factory()->create([
            'name' => 'Bolliger & Mabillard',
        ]);

        $manufacturer2 = Manufacturer::factory()->create([
            'name' => 'Intamin',
        ]);

        $manufacturer3 = Manufacturer::factory()->create([
            'name' => 'Vekoma',
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Silver Star',
            'description' => 'A steel roller coaster located at Europa-Park in Rust, Germany.',
            'speed' => 130,
            'height' => 73,
            'length' => 5_315,
            'inversions' => 0,
            'manufacturer_id' => $manufacturer1->id,
            'theme_park_id' => $themePark1->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Baron 1898',
            'description' => 'A steel Dive Coaster located at Efteling in Kaatsheuvel, Netherlands.',
            'speed' => 90,
            'height' => 98,
            'length' => 501,
            'inversions' => 0,
            'manufacturer_id' => $manufacturer2->id,
            'theme_park_id' => $themePark2->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Demon',
            'description' => 'A steel roller coaster located at Tivoli Gardens in Copenhagen, Denmark.',
            'speed' => 77,
            'height' => 28,
            'length' => 564,
            'inversions' => 1,
            'manufacturer_id' => $manufacturer3->id,
            'theme_park_id' => $themePark3->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Blue Fire',
            'description' => 'A steel launched roller coaster located at Europa-Park in Rust, Germany.',
            'speed' => 100,
            'height' => 38,
            'length' => 1_056,
            'inversions' => 4,
            'manufacturer_id' => $manufacturer1->id,
            'theme_park_id' => $themePark1->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Python',
            'description' => 'A steel roller coaster located at Efteling in Kaatsheuvel, Netherlands.',
            'speed' => 85,
            'height' => 29,
            'length' => 750,
            'inversions' => 0,
            'manufacturer_id' => $manufacturer2->id,
            'theme_park_id' => $themePark2->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Vilde Mus',
            'description' => 'A steel Wild Mouse roller coaster located at Tivoli Gardens in Copenhagen, Denmark.',
            'speed' => 31,
            'height' => 7,
            'length' => 361,
            'inversions' => 0,
            'manufacturer_id' => $manufacturer3->id,
            'theme_park_id' => $themePark3->id,
        ]);

        RollerCoaster::factory()->create([
            'name' => 'Wodan Timbur Coaster',
            'description' => 'A wooden roller coaster located at Europa-Park in Rust, Germany.',
            'speed' => 100,
            'height' => 40,
            'length' => 1_050,
            'inversions' => 0,
            'manufacturer_id' => $manufacturer1->id,
            'theme_park_id' => $themePark1->id,
        ]);
    }
}
