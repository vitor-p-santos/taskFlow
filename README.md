# TaskFlow

Um gerenciador de tarefas moderno, combinando a robustez do Laravel com a reatividade do Vue.js.

## Apresentação

Este projeto foi montado para simplificar o gerenciamento de projetos e tarefas cotidianas. Unindo a eficiência de um ecossistema completo, a aplicação oferece uma experiência fluida para a criação, organização e acompanhamento de tarefas.

## 🎯 Escopo do Projeto & Requisitos realizados

### 🔌 Parte 1 - Backend com Laravel 12

#### 🗄️ Modelos e Base de Dados
*   [x] **Project** (`id`, `name`, `description`, `status: active/archived`, `timestamps`)
*   [x] **Task** (`id`, `project_id`, `title`, `description`, `status: todo/in_progress/done`, `priority: low/medium/high`, `due_date`, `timestamps`)

#### 🌐 API RESTful (JSON)
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/projects` | Listar projetos com contagem de tarefas |
| `POST` | `/api/projects` | Criar projeto |
| `GET` | `/api/projects/{id}/tasks` | Listar tarefas do projeto (com filtros) |
| `POST` | `/api/projects/{id}/tasks` | Criar tarefa |
| `PATCH` | `/api/tasks/{id}` | Atualizar status/prioridade |
| `DELETE` | `/api/tasks/{id}` | Eliminar tarefa |

#### 🛠️ Requisitos Obrigatórios
*   [x] Form Requests com validação completa em todos os endpoints de escrita
*   [x] API Resources para formatar as respostas (sem expor campos desnecessários)
*   [x] Filtros no GET de tarefas: `?status=todo&priority=high`
*   [x] Scope no modelo Task: `scopeOverdue()` para tarefas com `due_date` passada
*   [x] Um Seeder com dados realistas para testar
*   [x] Feature tests com PHPUnit para pelo menos 3 endpoints
*   [x] Paginação com cursor ou offset
*   [x] Rate limiting na API
*   [x] Soft deletes nas tarefas

---

### 💻 Parte 2 - Frontend com Vue 3 + Tailwind 4

#### 🏗️ Estrutura da Aplicação
*   [x] Vue 3 com Composition API (obrigatório, sem Options API)
*   [x] Vue Router com pelo menos 2 rotas: lista de projetos e detalhe do projeto
*   [x] Pinia para gestão de estado

#### 🖼️ Vistas Obrigatórias
*   [x] **Lista de Projetos:** Cards com nome, descrição, status e contagem de tarefas. Botão para criar novo projeto (modal ou inline).
*   [x] **Detalhe do Projeto:** Lista de tarefas com possibilidade de filtrar por status e prioridade. Criar nova tarefa. Mudar status de tarefa (drag-and-drop ou dropdown simples). Indicação visual de tarefas em atraso.

#### ⚡ Requisitos Técnicos
*   [x] Composable `useProjects()` e `useTask()` para encapsular lógica de API
*   [x] Componente reutilizável `TaskCard` com props tipadas (TypeScript ou JSDoc)
*   [x] Feedback visual em todas as ações: loading states, erros e sucesso
*   [x] Layout responsivo (mobile-first)
*   [x] Optimistic updates ao mudar status de tarefa
*   [x] Debounce no filtro de tarefas
*   [x] Transições/animações entre estados
*   [x] Testes com Vitest para um composable

## Ferramentas Utilizadas

O ecossistema foi construído integrando tecnologias consolidadas para garantir uma aplicação robusta no servidor e reativa na interface:

*   **Linguagem Principal:** [PHP](https://www.php.net/) – Linguagem server-side que dá vida a toda a lógica de negócios do backend.
*   **Backend Framework:** [Laravel](https://laravel.com/) – Framework PHP utilizado para a construção de uma API REST segura, estruturada e escalável.
*   **Frontend Framework:** [Vue.js](https://vuejs.org/) – Framework JavaScript progressivo e reativo responsável por entregar uma interface de usuário fluida e de alta performance.
*   **Estilização & UI:** [Tailwind CSS](https://tailwindcss.com/) – Framework CSS utilitário utilizado para o desenvolvimento de um design moderno, limpo e totalmente responsivo.
*   **Banco de Dados:** [MySQL 8](https://www.mysql.com/) – Banco de dados relacional robusto utilizado para a persistência ágil e segura de todas as informações.

## 🏗️ Arquitetura do Projeto

🖥️ Backend (Laravel)
Estrutura principal responsável pelas regras de negócio, APIs e persistência de dados:

```text
├── 📁 app/                 # Núcleo da aplicação
│   ├── 📁 Domain/         # Domínios e regras de negócio isoladas
│   ├── 📁 Exceptions/     # Tratamento customizado de erros e exceções
│   ├── 📁 Http/           # Controladores (Controllers) e Requests da API
│   ├── 📁 Interfaces/     # Contratos e assinaturas de repositórios/serviços
│   ├── 📁 Models/         # Representação e relacionamentos do banco de dados
│   ├── 📁 Providers/      # Provedores de serviços do framework
│   └── 📁 Trait/          # Comportamentos reutilizáveis entre classes
├── 📁 config/              # Arquivos de configuração global do sistema
├── 📁 database/            # Estrutura do banco de dados (Migrations e Seeders)
└── 📁 routes/              # Definições de endpoints da API (api.php) e rotas web
```

💻 Frontend (Vue.js)
Localizado dentro do diretório resources/, concentra toda a camada reativa e SPA (Single Page Application) do projeto:

```text
└── 📁 resources/           
    └── 📁 js/              # ⚡ Raiz do ecossistema Vue
        ├── 📁 components/  # Componentes visuais globais e reutilizáveis
        ├── 📁 composables/ # Lógicas reutilizáveis de estado (Composition API)
        ├── 📁 layouts/     # Estruturas de página (ex: Dashboard, Auth)
        ├── 📁 lib/         # Configurações de bibliotecas de terceiros (Axios, etc)
        ├── 📁 router/      # Gerenciamento e mapeamento de rotas do lado do cliente
        ├── 📁 stores/      # Gerenciamento de estado global (Pinia / Vuex)
        ├── 📁 types/       # Definições de tipos e interfaces do TypeScript
        ├── 📁 views/       # Páginas principais renderizadas pelas rotas
        ├── 📄 app.js       # Inicialização e registro das instâncias do Vue
        ├── 📄 App.vue      # Componente raiz da aplicação
        └── 📄 bootstrap.js # Configurações de plugins internos e dependências do front
```

## 🧠 Decisões Técnicas & Novas Ideias

### 💡 Por que essa arquitetura?
*   **Domain-Driven Architecture (Mentalidade):** A criação da pasta `app/Domain` foi pensada para isolar as regras de negócio puras da infraestrutura do Laravel. Isso evita que os *Controllers* fiquem inflados e centraliza a lógica de alteração de estados e validações complexas.
*   **Padrão Repository/Interfaces:** O uso de `app/Interfaces` garante o desacoplamento do banco de dados. Caso amanhã o projeto mude de MySQL para um banco NoSQL, a camada de controle/Visão não sofre impacto, bastando apenas criar uma nova implementação da interface.

### 🚀 Ideias de Próximas Implementações (Roadmap)
*   [ ] **Notificações em Tempo Real:** Implementar Laravel Reverb ou WebSockets para atualizar a lista de tarefas de outros membros do time sem necessidade de F5.
*   [ ] **Autenticação Multi-Tenant:** Separar os projetos por workspaces de empresas ou times específicos utilizando Laravel Sanctum.
*   [ ] **Gráficos de Produtividade:** Adicionar uma aba de *Analytics* no frontend com Vue para exibir gráficos de burndown e performance das tarefas concluídas.

## ⚙️ Instalação e Inicialização

### 📦 Pré-requisitos

Você pode rodar este projeto utilizando **Docker (Recomendado)** ou configurando o ambiente de forma **Nativa**. Escolha a abordagem que preferir:

#### Opção A: Via Docker (Simplificada)
*   [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e rodando.
*   *(O projeto utiliza o Laravel Sail, dispensando a necessidade de PHP, Node ou MySQL instalados localmente).*

#### Opção B: Via Ambiente Nativo
*   **PHP 8.2+** & [Composer](https://getcomposer.org/)
*   **Node.js 20+** & **npm**
*   Servidor **MySQL 8** ativo e configurado.

### 🚀 Passo a Passo para Configuração

**1. Clone o repositório e acesse a pasta:**

```bash
git clone https://github.com/vitor-p-santos/taskFlow.git
cd taskFlow
```