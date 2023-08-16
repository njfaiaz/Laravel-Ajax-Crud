<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        \App\Models\Company::create([
            'company_name' => 'RFL',
            'company_address' => 'Middle Badda',
            'company_official_email' => 'contact@rfl-bd.com',
            'company_number' => '09255447788',
            'company_web_addr' => 'www.rfl-bd.com'
        ]);
        \App\Models\Company::create([
            'company_name' => 'Beximco',
            'company_address' => 'Gulshan-1',
            'company_official_email' => 'info@beximco.net',
            'company_number' => '04485214456',
            'company_web_addr' => 'www.beximco.net'
        ]);
    }
}
