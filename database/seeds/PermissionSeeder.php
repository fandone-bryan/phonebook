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
                'name' => 'phone_create',
                'nickname' => 'Criar telefone',
            ],
            [
                'id' => 3,
                'name' => 'phone_edit',
                'nickname' => 'Editar telefone',
            ],
            [
                'id' => 4,
                'name' => 'phone_delete',
                'nickname' => 'Excluir telefone',
            ],
            [
                'id' => 5,
                'name' => 'logs_all',
                'nickname' => 'Visualizar Log de atividades(todos os usuários)',
            ],

        ];

        DB::table('permissions')->insert($permissions);
    }
}
