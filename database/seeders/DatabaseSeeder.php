<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria um vendedor padrão
        User::factory()->create([
            'name' => 'Felipe Vendedor',
            'email' => 'felipe@vendedor.com',
            'password' => bcrypt('password'),
        ]);

        // Popula clientes
        $this->call(ClienteSeeder::class);

        // Popula cobranças (depende de vendedor e clientes)
        $this->call(CobrancaSeeder::class);
    }
}
