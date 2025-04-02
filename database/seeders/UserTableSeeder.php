<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Timezone;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timezoneIds = Timezone::pluck('id')->all();

        User::factory()->create([
            'name' => 'Alice Example',
            'email' => 'alice@example.com',
            'password' => bcrypt('password123'),
            'timezone_id' => $this->getRandomTimezoneId($timezoneIds),
        ]);

        User::factory()->create([
            'name' => 'Bob Example',
            'email' => 'bob@example.com',
            'password' => bcrypt('password123'),
            'timezone_id' => $this->getRandomTimezoneId($timezoneIds),
        ]);

        User::factory()->create([
            'name' => 'Charlie Example',
            'email' => 'charlie@example.com',
            'password' => bcrypt('password123'),
            'timezone_id' => $this->getRandomTimezoneId($timezoneIds),
        ]);

        User::factory()->create([
            'name' => 'David Example',
            'email' => 'david@example.com',
            'password' => bcrypt('password123'),
            'timezone_id' => $this->getRandomTimezoneId($timezoneIds),
        ]);

        User::factory()->create([
            'name' => 'Eve Example',
            'email' => 'eve@example.com',
            'password' => bcrypt('password123'),
            'timezone_id' => $this->getRandomTimezoneId($timezoneIds),
        ]);

    }

    private function getRandomTimezoneId(array $timezoneIds): int
    {
        return $timezoneIds[array_rand($timezoneIds)];
    }
}
