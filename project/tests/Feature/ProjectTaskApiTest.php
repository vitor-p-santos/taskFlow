<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskApiTest extends TestCase
{
    
    // use RefreshDatabase;
    use WithFaker;

    /**
     * Testa a criação de projetos e tarefas com dados realistas.
     */
    public function test_create_a_project_and_tasks(): void
    {
        $project = [
            'name' => 'Migração de E-commerce para Microsserviços',
            'description' => 'Projeto focado em modernizar a arquitetura monolítica do sistema de vendas, dividindo as responsabilidades em microsserviços.',
            'status' => 'active',
        ];

        $response = $this->postJson(route('storeProject'), $project);
        $response->assertStatus(201);

        $projectId = $response['data']['id'];

        $task_array = [
            [
                'title' => 'Configurar API Gateway',
                'description' => 'Implementar e configurar o API Gateway para gerenciar o roteamento das requisições externas para os serviços internos.',
                'status' => 'in_progress',
                'priority' => 'high',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Modelagem do banco do Catálogo',
                'description' => 'Criar as tabelas e migrações no PostgreSQL exclusivas para o serviço de catálogo de produtos.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(15)->format('Y-m-d H:i:s')
            ],
            [
                'title' => 'Configurar CI/CD no GitHub Actions',
                'description' => 'Criar pipelines automatizadas para rodar testes unitários e realizar o deploy no ambiente de staging.',
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

    /**
     * Testa a listagem de projetos.
     */
    public function test_list_projects(): void
    {
        $this->postJson(route('storeProject'), [
            'name' => 'App Mobile de Entregas (Logística)',
            'description' => 'Desenvolvimento de aplicativo mobile em React Native para rastreamento de entregadores em tempo real.',
            'status' => 'active'
        ]);

        $this->postJson(route('storeProject'), [
            'name' => 'Integração de Pagamento via PIX',
            'description' => 'Adicionar PIX como método de pagamento no checkout e processar os webhooks do banco.',
            'status' => 'on_hold'
        ]);

        $response = $this->getJson(route('getProject'));
        
        $response->assertStatus(200);
        
 
    }
}