# TaskFlow

Um gerenciador de tarefas moderno, combinando a robustez do Laravel com a reatividade do Vue.js.

## Apresentação

Este projeto foi montado para simplificar o gerenciamento de projetos e tarefas cotidianas. Unindo a eficiência de um ecossistema completo, a aplicação oferece uma experiência fluida para a criação, organização e acompanhamento de tarefas. O seu grande diferencial é sua arquitetura back-end e front-end.



## 🎯 Detalhes do projeto

### ⚙️ Ferramentas Utilizadas

O ecossistema foi construído integrando tecnologias consolidadas para garantir uma aplicação robusta no servidor e reativa na interface:

*   **Linguagem backend:** [PHP](https://www.php.net/)
*   **Linguagem frontend:** [typeScript](https://www.typescriptlang.org/)
*   **Backend Framework:** [Laravel](https://laravel.com/)
*   **Authentication:** [jwt-auth](https://github.com/tymondesigns/jwt-auth/)
*   **Frontend Framework:** [Vue.js](https://vuejs.org/)
*   **Estilização & UI:** [Tailwind CSS](https://tailwindcss.com/)
*   **Banco de Dados:** [MySQL 8](https://www.mysql.com/)
*   **Infraestrutura:** [Laravel Sail](https://laravel.com/framework/docs/12.x/sail#main-content)


### 🧠 Decisões Técnicas & Novas Ideias

#### 💡 Decisões implementadas

*   [x] **Clean Architecture no Backend:** 
    Implementação estruturada em camadas independentes (`Applications`, `Domain`, `Infrastructure`, `Http`). Essa divisão isola as regras de negócio puras (como validações de domínio) do framework, garantindo baixo acoplamento. Isso facilita a criação de testes unitários e permite escalar novas features (como envios de e-mails) através de *Use Cases*, sem inchar os Controllers.

*   [x] **Separação de Responsabilidades (Smart vs. Dumb Components):** 
    Divisão estrita no Vue.js entre componentes visuais (que recebem via `Props` e emitem eventos) e componentes inteligentes/Views (que se comunicam com o Pinia e as APIs).

*   [x] **Gerenciamento de Estado Isolado (Pinia):** 
    As Stores atuam apenas como "gerentes" do estado global da aplicação. Toda a formatação de dados e chamadas externas (HTTP) ocorrem em uma camada de serviços intermediária, mantendo a Store limpa e agnóstica em relação ao Axios.

*   [x] **Rotas Seguras e Prevenção de Loops (Vue Router):** 
    Implementação de *Navigation Guards* para controle de acesso (Auth) validados na camada do cliente, com tratamento adequado de redirecionamentos para evitar falhas

*   [x] **Infraestrutura Conteinerizada (Docker/Sail):** 
    Ambiente de desenvolvimento 100% isolado, garantindo paridade entre máquinas e facilitando a execução de rotinas, *migrations* e *seeds* (como o `UserFactory` com UUIDs) diretamente no contêiner através do ecossistema do Laravel Sail.
    
#### 📦 Ideias de Próximas Implementações (Roadmap)

+ [ ] **Gerenciamento de status dos projetos**
  - Permitir alterar o status entre **Ativo** e **Arquivado**.
  - Implementar exclusão de projetos.

*   [ ] **Modal para edição de campos como nome e descrição de projetos e tasks:** - assim não travando o usuário e o obrigando a criar um projeto e/ou tasks por falta de informação.

*   [ ] **Notificações de vencimento:**   - Enviar notificações por e-mail com uma lista de tarefas próximas do vencimento, evitando o envio excessivo de mensagens.


### 🗄️ Modelos e Base de Dados
*   [x] **Project** (`id`, `name`, `description`, `status: active/archived`, `timestamps`)
*   [x] **Task** (`id`, `project_id`, `title`, `description`, `status: todo/in_progress/done`, `priority: low/medium/high`, `due_date`, `timestamps`)


### 🏗️ Arquitetura do Projeto

🖥️ Backend (Laravel)
Estrutura principal responsável pelas regras de negócio, APIs e persistência de dados:

```text
├── 📁 app/                    # Núcleo da aplicação (Backend Laravel)
│   ├── 📁 Applications/       # Camada de Aplicação: Casos de uso (UseCases), DTOs e Exceções
│   ├── 📁 Domain/             # Regras de negócio isoladas (Entidades, Regras, Contratos e Enums)
│   ├── 📁 Infrastructure/     # Implementações de infraestrutura (bancos, repositórios, serviços)
│   ├── 📁 Http/               # Controladores (Controllers) e Requests da API
│   ├── 📁 Providers/          # Provedores de serviços do framework
│   └── 📁 Trait/              # Comportamentos reutilizáveis entre classes
├── 📁 config/                 # Arquivos de configuração global do sistema
├── 📁 database/               # Estrutura do banco de dados (Migrations, Factories e Seeders)
├── 📁 resources/              # Aplicação Frontend (Vue 3, Pinia, Vue Router, Tailwind)
└── 📁 routes/                 # Definições de endpoints da API (api.php) e rotas (web.php)
```

💻 Frontend (Vue.js)
Localizado dentro do diretório resources/, concentra toda a camada reativa e SPA (Single Page Application) do projeto:

```text
└── 📁 resources/              # Aplicação Frontend (Vue 3, Pinia, Vue Router, Tailwind)
   └── 📁 js/                 # Contém Components, Composables, Stores, Views e Types do TypeScript
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

## 🌐 API RESTful (JSON)

##### Auth
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/auth/login` | autenticação de login do usuário |
| `GET` | `/api/auth/logout` | remover token de acesso do usuário |
| `GET` | `/api/auth/refresh` | validar token expirado |

##### Users
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/users/register` | Criar usuário e gerar token |
| `GET` | `/api/users/me` | Mostrar dados do usuário |
| `GET` | `/api/users/me/statistic` | Listar estatisticas de projetos e tarefas |

##### Projetos 
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/projects` | Listar projetos com contagem de tarefas (com filtros) |
| `POST` | `/api/projects` | Criar projeto |

##### Tarefas
| Método | Endpoint | Descrição |
| :--- | :--- | :--- |
| `GET` | `/api/projects/{id}/tasks` | Listar tarefas do projeto (com filtros) |
| `POST` | `/api/projects/{id}/tasks` | Criar tarefa |
| `PATCH` | `/api/tasks/{id}` | Atualizar status/prioridade |
| `DELETE` | `/api/tasks/{id}` | Eliminar tarefa |


## 🚀 Configuração do Projeto

### 1. Pré-requisitos

* PHP ^8.4
*   [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado e rodando.
  *(O projeto utiliza o Laravel Sail, dispensando a necessidade de Node ou MySQL instalados localmente).*

### 2. Clone o repositório


```bash
git clone https://github.com/vitor-p-santos/taskFlow.git
cd taskFlow
```

### 3. Instalação das dependências (Backend)

Como o PHP já está instalado localmente, basta utilizar o Composer para baixar as dependências do projeto e gerar a pasta `vendor` (que contém os executáveis do Sail):

```bash
composer install
```
### 4. Configuração das Variáveis de Ambiente
Crie o arquivo de ambiente copiando o exemplo fornecido:

```bash
cp .env.example .env
```

### 5. Subindo os Containers (Laravel Sail)
Com a pasta vendor gerada, inicie a infraestrutura do projeto (Servidor e Banco de Dados) em segundo plano utilizando o Docker:
```bash
./vendor/bin/sail up -d
```

### 6. Preparando o Banco de Dados e a Aplicação
Gere a chave de segurança da aplicação e execute as migrações junto com as seeds para estruturar e popular o banco de dados inicial:

```bash
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

### 7. Configuração do Frontend (Vue.js + Vite)
Agora, instale as dependências do Node.js e inicie o servidor de desenvolvimento do Vite. Note que não é necessário ter o Node instalado na sua máquina, o Sail fará isso dentro do container:

```bash
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

### 8. Acessando a Aplicação
Tudo pronto! A aplicação já está rodando e pode ser acessada no seu navegador:

Aplicação Principal (Frontend): http://localhost

API (Backend): http://localhost/api

> [!NOTE]
> Quando quiser parar a execução do projeto e desligar os containers, basta rodar no terminal.

```bash
 ./vendor/bin/sail down
```
### 9. usuario criado com -seed gerado para teste

email: **teste@taskflow.com**
senha: **Dev@123@@**