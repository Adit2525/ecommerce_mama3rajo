<?php

namespace Database\Seeders;

use App\Models\Pengeluaran;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengeluaranSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('Admin user not found. Run UserSeeder first.');
            return;
        }

        $categories = ['supplier', 'shipping', 'marketing', 'utilities', 'rent', 'salaries', 'other'];

        // Create 25 sample expense records spread over the last 90 days
        for ($i = 0; $i < 25; $i++) {
            Pengeluaran::create([
                'category' => $categories[array_rand($categories)],
                'reference' => 'EXP-' . strtoupper(uniqid()),
                'amount' => rand(100, 1000) + (rand(0, 99) / 100),
                'recorded_by' => $admin->id,
                'note' => 'Sample expense entry ' . ($i + 1),
                'created_at' => now()->subDays(rand(0, 90)),
            ]);
        }

        $this->command->info('Pengeluaran seeder completed with 25 sample expense records.');
    }
}
