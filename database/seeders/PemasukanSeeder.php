<?php

namespace Database\Seeders;

use App\Models\Pemasukan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PemasukanSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('Admin user not found. Run UserSeeder first.');
            return;
        }

        $sources = ['product_sales', 'service_fee', 'subscription', 'refund_reversal'];

        // Create 30 sample income records spread over the last 90 days
        for ($i = 0; $i < 30; $i++) {
            Pemasukan::create([
                'source' => $sources[array_rand($sources)],
                'reference_id' => 'REF-' . strtoupper(uniqid()),
                'amount' => rand(50, 500) + (rand(0, 99) / 100),
                'recorded_by' => $admin->id,
                'note' => 'Sample income entry ' . ($i + 1),
                'created_at' => now()->subDays(rand(0, 90)),
            ]);
        }

        $this->command->info('Pemasukan seeder completed with 30 sample income records.');
    }
}
