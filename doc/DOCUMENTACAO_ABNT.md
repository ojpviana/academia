<div align="center">
    
**INSTITUTO FEDERAL DE EDUCAÇÃO CIÊNCIA E TECNOLOGIA**

<br><br><br><br><br><br>

**AUTOR(ES) DO PROJETO**

<br><br><br><br><br><br>

**SISTEMA DE GERENCIAMENTO DE TREINOS: UMA PLATAFORMA INTEGRADA PARA ACADEMIAS**

<br><br><br><br><br><br><br><br><br><br><br><br>

**CIDADE - UF**
**2026**

</div>

---

<div align="center">
    
**AUTOR(ES) DO PROJETO**

<br><br><br>

**SISTEMA DE GERENCIAMENTO DE TREINOS: UMA PLATAFORMA INTEGRADA PARA ACADEMIAS**

</div>

<br><br>

<div align="right" style="margin-left: 50%;">
Trabalho de conclusão de curso/Projeto apresentado ao Instituto Federal como requisito parcial para aprovação na disciplina de Engenharia de Software.
<br><br>
Orientador: Nome do Professor
</div>

<br><br><br><br><br><br>

<div align="center">
**CIDADE - UF**
**2026**
</div>

---

<div align="center">
<b>RESUMO</b>
</div>

Este trabalho tem como objetivo propor e desenvolver um software de gestão para academias e centros de treinamento, com enfoque no gerenciamento de alunos, prescrição de treinos e acompanhamento financeiro. A solução busca atender plenamente às regras de negócio específicas desse segmento, integrando um painel administrativo, uma área técnica para treinadores e um aplicativo móvel-first para os atletas. Considerando a necessidade de agilidade, o sistema foi desenvolvido utilizando o padrão de arquitetura MVC com o framework Laravel (PHP) e Tailwind CSS para a interface. O objetivo é permitir que o estabelecimento tenha controle total sobre matrículas, vínculos empregatícios de professores e fluxo de caixa, enquanto proporciona ao aluno a visualização de treinos, o acompanhamento de evolução física e o envio de feedbacks diários.

**Palavras-chave:** Software, Academia, Gestão, MVC, Laravel.

---

<div align="center">
<b>ABSTRACT</b>
</div>

This study aims to propose and develop management software for gyms and training centers, focusing on student management, workout prescription, and financial tracking. The solution seeks to fully meet the specific business rules of this segment by integrating an administrative panel, a technical area for trainers, and a mobile-first application for athletes. Considering the need for agility, the system was developed using the MVC architecture pattern with the Laravel framework (PHP) and Tailwind CSS for the interface. The objective is to allow the establishment to have full control over enrollments, teacher employment ties, and cash flow, while providing the student with workout visualization, physical evolution tracking, and daily feedback submission.

**Keywords:** Software, Gym, Management, MVC, Laravel.

---

## 1 INTRODUÇÃO

O mercado de saúde e bem-estar, especificamente o setor de academias, tem apresentado um crescimento expressivo nos últimos anos. Com o aumento da conscientização sobre a importância da atividade física, os centros de treinamento precisam de ferramentas eficientes para gerir não apenas o seu faturamento, mas também o acompanhamento técnico e a satisfação de seus alunos.

Muitos sistemas atuais de gestão esportiva pecam pela complexidade ou por não integrarem a visão do administrador, do treinador e do aluno de forma fluida. O presente projeto consiste em uma plataforma integrada operando na web como um SaaS (Software as a Service), onde cada ator possui um painel dedicado e desenhado para as suas rotinas diárias.

---

## 2 FUNDAMENTAÇÃO TEÓRICA

Para o desenvolvimento deste projeto, foram utilizadas tecnologias modernas e metodologias que garantem a escalabilidade e a manutenibilidade do sistema.

### 2.1 Padrão MVC e Laravel
O sistema foi desenvolvido utilizando o padrão de projeto MVC (Model-View-Controller). A linguagem base utilizada é o PHP, operando sob o framework Laravel para roteamento seguro e comunicação com o banco de dados através do Eloquent ORM.

### 2.2 Interface Responsiva e Tailwind CSS
Para garantir que o aluno possa consumir o sistema 100% pelo celular durante o treino, adotou-se o Tailwind CSS. O Front-end foi construído com uma abordagem *Mobile-First*.

### 2.3 Banco de Dados
A persistência de dados é relacional, empregando o uso estrito de Chaves Estrangeiras (Foreign Keys) para garantir a integridade dos dados (por exemplo, impedindo a existência de treinos vinculados a alunos que já foram excluídos).

---

## 3 MAPEAMENTO DE REQUISITOS

Para formalizar o escopo da plataforma e orientar o desenvolvimento, as necessidades do projeto foram categorizadas em Requisitos Funcionais e Não Funcionais.

### 3.1 Requisitos Funcionais (RF)

| Identificador | Nome do Requisito | Descrição | Prioridade |
| :--- | :--- | :--- | :--- |
| **RF-01** | Autenticação e Perfis | O sistema deve permitir o login seguro, direcionando o usuário para painéis distintos com base em seu nível de acesso. | Alta |
| **RF-02** | Gestão de Alunos | O Administrador deve poder cadastrar, editar, visualizar e inativar alunos (dados de saúde e pessoais). | Alta |
| **RF-03** | Gestão de Equipe | Cadastrar treinadores, informando CREF, vínculo empregatício e dados bancários. | Alta |
| **RF-04** | Atribuição de Carteira | O sistema deve permitir vincular um aluno a um treinador específico. | Alta |
| **RF-05** | Módulo Financeiro | O Administrador deve poder registrar pagamentos, definir planos e datas de vencimento. | Alta |
| **RF-06** | Catálogo de Exercícios | O sistema deve possuir uma base de exercícios divididos por grupamentos musculares. | Média |
| **RF-07** | Prescrição de Fichas | O Treinador deve poder montar fichas de treino para seus alunos (séries, repetições, dia). | Alta |
| **RF-08** | Anexos de Saúde | O sistema deve permitir o upload de atestados médicos no perfil do aluno. | Alta |
| **RF-09** | Histórico e Feedback | O Atleta deve poder registrar observações sobre a execução dos treinos. | Baixa |
| **RF-10** | Painel de Indicadores | O sistema deve exibir dashboards com alunos ativos, inativos e receita gerada. | Média |

### 3.2 Requisitos Não Funcionais (RNF)

| Identificador | Nome do Requisito | Descrição | Categoria |
| :--- | :--- | :--- | :--- |
| **RNF-01** | Arquitetura | O sistema deve ser desenvolvido utilizando o padrão de projeto MVC. | Arquitetura |
| **RNF-02** | Framework Back-end| A linguagem base deve ser o PHP, operando sob o framework Laravel. | Tecnologia |
| **RNF-03** | Interface Responsiva| O Front-end deve ser estilizado via Tailwind CSS (*Mobile-first*). | Usabilidade |
| **RNF-04** | Segurança de Senhas | Senhas devem ser armazenadas com criptografia unidirecional (Bcrypt). | Segurança |
| **RNF-05** | Integridade de Dados| O banco de dados deve garantir Foreign Keys para evitar registros órfãos. | Banco de Dados |
| **RNF-06** | Storage de Arquivos | Atestados e mídias devem ser salvos de forma segura no Storage do Laravel. | Infraestrutura |

---

## 4 DICIONÁRIO DE DADOS

Para garantir a integridade referencial, o banco de dados foi estruturado em entidades lógicas. Abaixo estão descritas as principais entidades do domínio.

### 4.1 Tabela `users`
Responsável por centralizar o acesso e o nível de permissão (roles) de todos os atores do sistema.

| Campo | Tipo | Restrição | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | Integer | PK, Auto Inc | Identificador único do usuário. |
| `name` | Varchar(255) | Not Null | Nome de exibição na plataforma. |
| `email` | Varchar(255) | Not Null, Unique | Endereço de e-mail utilizado como login. |
| `password` | Varchar(255) | Not Null | Senha criptografada (Bcrypt). |
| `role` | Varchar(50) | Not Null | Nível de acesso ('admin', 'treinador', 'aluno'). |

### 4.2 Tabela `atletas`
Armazena a ficha completa do aluno, unificando dados cadastrais, informações de saúde e financeiras.

| Campo | Tipo | Restrição | Descrição |
| :--- | :--- | :--- | :--- |
| `idAtleta` | Integer | PK, Auto Inc | Identificador único da ficha do atleta. |
| `nome` | Varchar(255) | Not Null | Nome civil completo do aluno. |
| `idade` | Integer | Not Null | Idade atual do atleta. |
| `peso` | Decimal(5,2) | Not Null | Peso corporal em quilogramas (kg). |
| `plano_tipo` | Varchar(100) | Nullable | Tipo de assinatura (Mensal, Anual, etc). |
| `data_vencimento` | Date | Nullable | Dia base para cobrança recorrente. |
| `treinador_id` | Integer | FK, Nullable | ID do treinador responsável (tabela treinadores). |
| `status` | Varchar(50) | Default 'Ativo' | Situação cadastral do aluno no sistema. |

### 4.3 Tabela `treinadores`
Isola os dados empregatícios e contratuais dos professores.

| Campo | Tipo | Restrição | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | Integer | PK, Auto Inc | Identificador da ficha de RH do treinador. |
| `user_id` | Integer | FK, Not Null | Relacionamento com a credencial de login (users). |
| `cref` | Varchar(50) | Not Null, Unique| Registro profissional no conselho de classe. |
| `tipo_vinculo` | Varchar(50) | Default 'PJ' | Natureza do contrato (CLT, PJ, Autônomo). |

### 4.4 Tabela `treino_atletas` (Ficha de Exercícios)
Entidade associativa que vincula o catálogo de exercícios ao perfil do atleta.

| Campo | Tipo | Restrição | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | Integer | PK, Auto Inc | Identificador único da linha de treino. |
| `atleta_id` | Integer | FK, Not Null | Aluno que realizará o exercício. |
| `exercicio_id` | Integer | FK, Not Null | Exercício base selecionado do catálogo. |
| `series` | Varchar(50) | Not Null | Quantidade de blocos (Ex: '4'). |
| `repeticoes` | Varchar(50) | Not Null | Volume alvo (Ex: '10 a 12'). |
| `dia_semana` | Varchar(50) | Not Null | Divisão da periodização (Ex: 'Treino A'). |

### 4.5 Tabela `aluno_pagamentos` (Módulo Financeiro)
Registra todo o fluxo de caixa da operação.

| Campo | Tipo | Restrição | Descrição |
| :--- | :--- | :--- | :--- |
| `id` | Integer | PK, Auto Inc | Identificador único do recibo. |
| `atleta_id` | Integer | FK, Not Null | Aluno pagante. |
| `valor` | Decimal(10,2) | Not Null | Quantia integral transacionada na operação. |
| `data_pagamento` | Date | Not Null | Data em que o repasse foi compensado. |
| `status` | Varchar(50) | Default 'Pago' | Confirmação da transação no sistema. |

---

<div align="center">
<b>REFERÊNCIAS</b>
</div>

GABARDO, A. C. **Laravel para ninjas**. Novatec Editora, 2017.
MANZANO, José Augusto N. G. **Estudo dirigido de Microsoft Visual C# Community**. São Paulo: Érica, 2016.
BOOCH, Grady; RUMBAUGH, James; JACOBSON, Ivar. **UML: guia do usuário**. 2. ed. Rio de Janeiro: Elsevier, c2012.
