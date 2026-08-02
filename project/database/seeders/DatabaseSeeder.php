<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database com cenários reais.
     */
    public function run(): void
    {
        // -------------------------------------------------------------
        // PROJETO 1: Redesign do Website Institucional (Ativo)
        // -------------------------------------------------------------
        $project1 = Project::factory()->create([
            'name' => 'Redesign do Portal Institucional',
            'description' => 'Modernização da interface pública da empresa, focando em responsividade, SEO e acessibilidade (WCAG).',
            'status' => 'active'
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Mapear arquitetura de informação',
            'description' => 'Analisar o sitemap atual e desenhar a nova estrutura de navegação e taxonomia das páginas.',
            'status' => 'done',
            'priority' => 'high',
            'due_date' => Carbon::now()->subDays(2)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Desenvolver protótipos de alta fidelidade',
            'description' => 'Criar as telas principais no Figma seguindo o novo guia de estilos da marca.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => Carbon::now()->addDays(7)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Revisão de Textos (Copywriting)',
            'description' => 'Adequar a linguagem institucional para técnicas de SEO e tom de voz unificado.',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => Carbon::now()->addDays(15)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Homologação e testes de acessibilidade',
            'description' => 'Validar o comportamento do site com leitores de tela (NVDA/JAWS) e contraste de cores.',
            'status' => 'todo',
            'priority' => 'low',
            'due_date' => Carbon::now()->addDays(30)->format('Y-m-d')
        ]);


        // -------------------------------------------------------------
        // PROJETO 2: Módulo de Cobrança Recorrente (Em Espera / Planejamento)
        // -------------------------------------------------------------
        $project2 = Project::factory()->create([
            'name' => 'Integração de Assinaturas (Stripe)',
            'description' => 'Implementação de planos recorrentes (mensal/anual) e tratamento de falhas de pagamento via Webhooks.',
            'status' => 'active' // Ajustado para condizer com o andamento das tarefas
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Desenhar fluxo de checkout',
            'description' => 'Criar diagramas de sequência detalhando a comunicação entre o frontend, backend e a API do Stripe.',
            'status' => 'done',
            'priority' => 'high',
            'due_date' => Carbon::now()->subDays(5)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Modelagem das tabelas de assinaturas',
            'description' => 'Criar migrations e models para gerenciar planos, itens de inscrição e histórico de faturas.',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => Carbon::now()->addDays(4)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Configurar Webhooks locais (Stripe CLI)',
            'description' => 'Preparar o ambiente de desenvolvimento para escutar os eventos `invoice.paid` e `customer.subscription.deleted`.',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => Carbon::now()->addDays(10)->format('Y-m-d')
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Implementar tela de "Minha Assinatura"',
            'description' => 'Criar o portal do cliente onde o usuário pode atualizar o cartão de crédito ou cancelar o plano.',
            'status' => 'todo',
            'priority' => 'medium',
            'due_date' => Carbon::now()->addDays(18)->format('Y-m-d')
        ]);


        // -------------------------------------------------------------
        // PROJETO 3: Legado / Arquivado (Histórico)
        // -------------------------------------------------------------
        $project3 = Project::factory()->create([
            'name' => 'Migração de Servidor Físico para AWS (2025)',
            'description' => 'Desativação do data center local e migração de toda a infraestrutura para instâncias EC2 e RDS.',
            'status' => 'archived'
        ]);

        Task::factory()->create([
            'project_id' => $project3->id,
            'title' => 'Backup e extração do banco MySQL',
            'description' => 'Gerar dumps compactados e transferir de forma segura via SFTP para o bucket S3 de transição.',
            'status' => 'done',
            'priority' => 'high',
            'due_date' => '2025-11-20'
        ]);

        Task::factory()->create([
            'project_id' => $project3->id,
            'title' => 'Virada de DNS (GoDaddy para Route 53)',
            'description' => 'Alteração das zonas de DNS apontando os domínios para o Application Load Balancer da AWS.',
            'status' => 'done',
            'priority' => 'high',
            'due_date' => '2025-12-01'
        ]);
    }
}