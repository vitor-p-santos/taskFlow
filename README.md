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

*   **Linguagem Principal:** [PHP](https://www.php.net/)
*   **Backend Framework:** [Laravel](https://laravel.com/)
*   **Frontend Framework:** [Vue.js](https://vuejs.org/)
*   **Estilização & UI:** [Tailwind CSS](https://tailwindcss.com/)
*   **Banco de Dados:** [MySQL 8](https://www.mysql.com/)
*   **Infraestrutura:** [Docker](https://www.docker.com/)

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

### 💡 Decisões implementadas
* Regra de negocio separada por dominio - Dentro da pasta /Domain está separado a regra de cada dominio [task, project] onde tem seus models, services, exceptions, formRequest, repository, Enum e actions assim evitando codigo bagunçado

* Uso de interfaces dentro de `app/Interfaces` sendo contratos para actions e repositories.

* Infraestrutura montada no `docker` - facilitando testes e instalação.

* adição do parametro 'due_date=true' na rota `GET` | `/api/projects/{id}/tasks`.

* Montagem de components e layouts reutilizaveis no frontend.

### 🚀 Ideias de Próximas Implementações (Roadmap)
*   [ ] **Alteração de status e Filtro de busca e exclusão de projetos:** - Possibilitando alterar entre ativo, arquivado, Sendo possivel excluir projeto e filtrar por status e/ou nome. 

*   [ ] **Modal para edição de campos como nome e descrição de projetos e tasks:** - assim não travando o usuário e o obrigando a criar o projeto com nome correto e tasks deletadas por falta de informação.

*   [ ] **Autenticação:** - criar telas de login/register usando tokens do laravel sanctum, tanto para uso web como para implementação de acesso mobile.

*   [ ] **Notificações de vencimento:** - Notificação por e-mail das tarefas que estão próximas do vencimento em um formato de lista evitando envio ecessivo de e-mails.

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

## 🚀 Configuração do Projeto

### 1. Clone o repositório

```bash
git clone https://github.com/vitor-p-santos/taskFlow.git
cd taskFlow
```

> [!NOTE]
> O projeto pode ser executado com **Docker** ou diretamente na sua máquina.


## 🐳 Executando com Docker

Dentro da pasta do projeto, execute:

```bash
docker compose up -d --build
```

Após a criação dos containers, execute os testes:

```bash
docker exec -it laravel_app php artisan migrate --seed
```

Para rodar teste

```bash
docker exec -it laravel_app php artisan test
```

## 💻 Executando sem Docker

Caso prefira executar o projeto localmente:

1. Abra **dois terminais**, ambos apontando para a pasta `project`:
   - Um para executar o **Laravel**;
   - Outro para executar o **Vite**.

2. Copie o arquivo `.env.example` para `.env` dentro da pasta `project`.

3. Configure as credenciais do banco de dados no arquivo `.env`.

4. Instale as dependências do projeto.

**Composer**

```bash
composer install
```

**Node.js**

```bash
npm install
```

5. Gere a chave da aplicação:

```bash
php artisan key:generate
```

6. Execute as migrations e os seeders:

```bash
php artisan migrate --seed
```

7. Inicie o servidor Laravel:

```bash
php artisan serve
```

8. No outro terminal, inicie o Vite:

```bash
npm run dev
```

9. Execute os testes da aplicação:

```bash
php artisan test
```