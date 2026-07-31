<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $project1 = Project::factory()->create([
            'name' => 'project 1',
            'description' => 'Teste de seed',
            'status' => 'active'
        ]);

        $project2 = Project::factory()->create([
            'name' => 'project 2',
            'description' => 'Montando novas ideias',
            'status' => 'active'
        ]);

        $project3 = Project::factory()->create([
            'name' => 'project 3',
            'description' => 'Sistema de gerenciamento',
            'status' => 'archived'
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Configurar ambiente',
            'description' => 'Instalar dependências iniciais',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Configurar ambiente',
            'description' => 'Instalar dependências iniciais',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Configurar ambiente',
            'description' => 'Instalar dependências iniciais',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);

        Task::factory()->create([
            'project_id' => $project1->id,
            'title' => 'Configurar ambiente',
            'description' => 'Instalar dependências iniciais',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);

        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'done',
            'priority' => 'low',
            'due_date' => '1999-05-12'
        ]);
        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'in_progress',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);
        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);
        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);
        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);
        Task::factory()->create([
            'project_id' => $project2->id,
            'title' => 'Esboçar wireframes',
            'description' => 'Criar telas iniciais do sistema',
            'status' => 'todo',
            'priority' => 'high',
            'due_date' => '1999-05-12'
        ]);
    }
}
