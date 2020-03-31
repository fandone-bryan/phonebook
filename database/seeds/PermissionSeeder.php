<?php

use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'id' => 1,
                'name' => 'phone_list',
                'nickname' => 'Visualizar telefones',
            ],
            [
                'id' => 2,
                'name' => 'phone_handle',
                'nickname' => 'Editar / Excluir telefones',
            ],
            [
                'id' => 3,
                'name' => 'logs_all',
                'nickname' => 'Visualizar Log de atividades(todos os usuários)',
            ],

        ];

        DB::table('permissions')->insert($permissions);
    }
}
