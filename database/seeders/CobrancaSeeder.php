<?php

namespace Database\Seeders;

use App\Models\Cobranca;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CobrancaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vendedor = User::first();

        if (!$vendedor) {
            $this->command->warn('Nenhum vendedor encontrado. Execute o DatabaseSeeder primeiro.');
            return;
        }

        $cobrancas = [
            [
                'vendedor_id' => $vendedor->id,
                'cliente_id' => 1,
                'descricao' => 'Serviço de Consultoria - Janeiro 2024',
                'valor' => 2500.00,
                'data_vencimento' => now()->addDays(5),
                'status' => 'pendente',
            ],
            [
                'vendedor_id' => $vendedor->id,
                'cliente_id' => 2,
                'descricao' => 'Produto XYZ - Quantidade 10',
                'valor' => 1500.00,
                'data_vencimento' => now()->addDays(10),
                'status' => 'pendente',
            ],
            [
                'vendedor_id' => $vendedor->id,
                'cliente_id' => 3,
                'descricao' => 'Serviço de Desenvolvimento',
                'valor' => 5000.00,
                'data_vencimento' => now()->addDays(15),
                'status' => 'pendente',
            ],
            [
                'vendedor_id' => $vendedor->id,
                'cliente_id' => 4,
                'descricao' => 'Manutenção Mensal',
                'valor' => 800.00,
                'data_vencimento' => now()->subDays(2),
                'status' => 'atrasada',
            ],
            [
                'vendedor_id' => $vendedor->id,
                'cliente_id' => 5,
                'descricao' => 'Licença de Software',
                'valor' => 1200.00,
                'data_vencimento' => now()->addDays(7),
                'status' => 'pendente',
            ],
        ];

        foreach ($cobrancas as $cobranca) {
            Cobranca::create($cobranca);
        }
    }
}
