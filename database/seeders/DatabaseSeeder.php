<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Organization;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat 1 akun admin manual
        User::factory()->create([
            'role' => 'admin',
            'name' => 'Jabbar Ali Panggabean',
            'phone' => '628990980799',
            'email' => 'jabbarpanggabean@gmail.com',
            'password' => bcrypt('bism!LLAH99'),
        ]);

        // Buat dummy Organization
        // $organizations = Organization::factory(5)->create();

        // // Untuk setiap Organization, buat dummy Task
        // foreach ($organizations as $organization) {
        //     Task::factory(10)->create([
        //         'organization_id' => $organization->id,
        //     ]);
        // }

        // // Buat dummy peserta User (role = participant)
        // User::factory(50)->create([
        //     'role' => 'participant',
        // ]);
    }
}
