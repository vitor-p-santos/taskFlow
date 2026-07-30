<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Testa a criação de projetos e tarefas.
     */
    public function test_create_a_project_and_tasks(): void
    {
        $project = [
            'name' => 'gerenciador',
            'description' => 'projeto visando criar gerenciador de tarefas',
            'status' => 'active',
        ];


        $response = $this->postJson(route('storeProject'), $project);

        $response->assertStatus(201);

        $projectId = $response['data']['id'];

        $task_array = [
            [
                'title' => 'tela de login',
                'description' => 'gerar tela html de login',
                'status' => 'in_progress',
                'priority' => 'high',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'registrar no banco',
                'description' => 'criar backend com action para registro',
                'status' => 'todo',
                'priority' => 'low',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(25)->format('Y-m-d H:i:s')
            ],
        ];

        foreach ($task_array as $task) {
            $response = $this->postJson(route('storeTask', ['id' => $projectId]), $task);

            $response->assertStatus(201);
        }
    }

    public function test_list_projects(): void
    {
        $this->postJson(route('storeProject'), [
            'name' => 'Projeto Teste Listagem',
            'description' => 'Desc',
            'status' => 'active'
        ]);

        $response = $this->getJson(route('getProject'));
        $response->assertStatus(200);
    }
}
