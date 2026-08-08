<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskApiTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_create_a_project_and_tasks(): void
    {
        $projectData = [
            'name' => 'Migração de E-commerce para Microsserviços',
            'description' => 'Reestruturação completa do sistema monolítico de e-commerce visando desacoplamento de serviços, alta disponibilidade e suporte a grandes picos de acesso.',
            'status' => 'active',
        ];

        $response = $this->postJson(route('storeProject'), $projectData);
        $response->assertStatus(201);

        $projectId = $response['data']['id'];

        $tasks = [
            [
                'title' => 'Configurar API Gateway (Kong)',
                'description' => 'Implementar e configurar o API Gateway para gerenciar roteamento, limitação de taxa (rate limiting) e autenticação de requisições externas.',
                'status' => 'in_progress', 
                'priority' => 'high',      
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(5)->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Modelagem do Banco de Dados do Catálogo',
                'description' => 'Criar schemas e migrações no PostgreSQL para isolamento de dados do microsserviço de produtos e categorias.',
                'status' => 'todo',
                'priority' => 'high',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(10)->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Implementação de Filas com RabbitMQ',
                'description' => 'Configurar mensageria para processamento assíncrono de notificações de pagamento e disparo de e-mails transacionais.',
                'status' => 'in_progress',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(8)->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Elaboração da Documentação OpenAPI/Swagger',
                'description' => 'Escrever a especificação formal de todos os endpoints públicos para integração de parceiros externos.',
                'status' => 'todo',
                'priority' => 'low',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(20)->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Análise de Viabilidade Técnica e Arquitetura',
                'description' => 'Estudo inicial de infraestrutura e definição dos padrões de comunicação interna gRPC entre serviços.',
                'status' => 'done',
                'priority' => 'high',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addHours(2)->format('Y-m-d H:i:s'), 
            ],
            [
                'title' => 'Configuração de Monitoramento e Logs com Grafana/Loki',
                'description' => 'Estruturar dashboards para métricas em tempo real de latência, taxa de erro HTTP e consumo de memória dos pods.',
                'status' => 'todo',
                'priority' => 'medium',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addDays(18)->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Ajuste de Variáveis de Ambiente no Pipeline CI/CD',
                'description' => 'Padronizar secrets no GitHub Actions para deploy automatizado nos ambientes de Staging e Produção.',
                'status' => 'done',
                'priority' => 'low',
                'project_id' => $projectId,
                'due_date' => Carbon::now()->addHours(4)->format('Y-m-d H:i:s'),
            ],
        ];

        foreach ($tasks as $task) {
            $taskResponse = $this->postJson(route('storeTask', ['id' => $projectId]), $task);
            $taskResponse->assertStatus(201);
        }
    }

    public function test_list_projects_and_batch_data(): void
    {
        $projects = [
            [
                'name' => 'App Mobile de Entregas (Logística)',
                'description' => 'Desenvolvimento do aplicativo móvel em React Native para rastreamento geolocalizado de entregadores e gestão de rotas.',
                'status' => 'active',
            ],
            [
                'name' => 'Integração de Pagamento via PIX e Webhooks',
                'description' => 'Adicionar suporte a pagamentos instantâneos via PIX no checkout da loja e tratar callbacks de reconciliação bancária.',
                'status' => 'archived',
            ],
            [
                'name' => 'Portal do Cliente & Autoatendimento v2',
                'description' => 'Redesign completo do painel web do cliente com suporte a temas dinâmicos, exportação de relatórios em PDF e chat em tempo real.',
                'status' => 'active',
            ],
            [
                'name' => 'Adequação LGPD e Conformidade de Dados',
                'description' => 'Implementação de rotinas para anonimização de dados pessoais, gestão de consentimento de cookies e auditoria de logs.',
                'status' => 'archived',
            ],
        ];

        foreach ($projects as $project) {
            $response = $this->postJson(route('storeProject'), $project);
            $response->assertStatus(201);
        }

        $response = $this->getJson(route('getProject'));
        $response->assertStatus(200);
    }
}