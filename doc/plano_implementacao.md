# Plano de Implementação de Novas Funcionalidades (GymPro)

Este documento detalha o plano de ação, a arquitetura e as etapas necessárias para implementar os novos requisitos solicitados. As funções de check-in, limite de frequência semanal e a visualização dos treinos completos no app já foram implementadas. Abaixo constam os próximos passos:

## 1. Tela do Treinador - Lista de Alunos Presentes
- **Objetivo**: Substituir o dropdown e listar diretamente os alunos que estão fisicamente na academia no momento, agilizando o acesso às fichas.
- **Backend (Laravel)**:
  - Ajustar o método que carrega a view do treinador para buscar os atletas que possuem um registro de entrada (na tabela `alunos_freq`) no dia corrente.
- **Frontend (Painel do Treinador)**:
  - Remover o comportamento de dropdown na opção "Meus Alunos".
  - Criar uma lista visual rápida (cards ou lista simples) mostrando os alunos com check-in válido nas últimas horas.
- **Pendência/Decisão**: Definir o tempo de validade para o aluno ser considerado "presente" (ex: visível na lista até 3 ou 4 horas após o check-in ou simplesmente todos que deram check-in no dia).

## 2. Tipos de Mensalidade e Formas de Pagamento
- **Objetivo**: Expandir as opções de mensalidade e cadastro de formas de pagamento.
- **Estrutura de Banco de Dados**:
  - *Sugestão de escalabilidade*: Criar as tabelas dinâmicas `planos` (id, nome_plano, valor, limite_dias) e `formas_pagamento` (id, nome).
  - Atualizar a tabela `atletas` retirando as colunas em formato ENUM para usar relacionamento com chave estrangeira.
- **Backend/Frontend**:
  - Criar interface no painel administrativo para cadastrar/excluir esses planos e formas.
- **Pendência/Decisão**: Caso a gerência dinâmica no painel não seja necessária, podemos simplesmente incluir mais opções fixas no ENUM atual no banco. Precisamos validar a preferência.

## 3. Adicionais e Vínculos (Spining, Zumba, Natação)
- **Objetivo**: Gerenciar turmas e alunos inscritos em aulas extras com horários pré-definidos e professores designados.
- **Estrutura de Banco de Dados**:
  - Tabela `modalidades_extras` (id, nome).
  - Tabela `turmas` (id, modalidade_id, treinador_id, dia_semana, hora_inicio, hora_fim).
  - Tabela `atleta_turma` (id, atleta_id, turma_id) - Para as matrículas.
- **Backend/Frontend**:
  - Telas no Admin para criar a Modalidade, criar a Turma (vinculando horário e professor) e registrar a matrícula do aluno.

## 4. Horário de Funcionamento da Academia
- **Objetivo**: Tornar dinâmico o cadastro e exibição do horário da academia.
- **Estrutura de Banco de Dados**:
  - Criar uma tabela de `configuracoes` com colunas de chave e valor (ex: chave="horario_funcionamento", valor="Seg-Sex 06h às 22h, Sáb 08h às 14h").
- **Backend/Frontend**:
  - Exibir a configuração esteticamente no Dashboard inicial do aluno e criar formulário básico no Admin para alteração.

## 5. Financeiro: Exibição Padrão nos Primeiros Dias
- **Objetivo**: Não mostrar uma tela "vazia" quando o admin abrir o painel financeiro no dia 01 ou 02 do mês.
- **Backend (Laravel)**:
  - Localização: `FinanceiroController@index`.
  - Ajuste: Alterar a condição de fall-back do filtro de datas. No lugar de pegar por padrão o `startOfMonth()` (dia 01), a lógica aplicará `now()->subDays(15)` como data inicial padrão.

## 6. Loja da Academia
- **Objetivo**: Sistema para venda de produtos no balcão/app.
- **Arquitetura Base**:
  - Requer um módulo completo com as tabelas: `produtos` (nome, preco, quantidade_estoque), `categorias_produtos`, `vendas_loja` (data, total, atleta_id_opcional), `itens_venda`.
- **Pendência/Decisão**: Alinhar como os produtos serão pagos (se vai pendurar na conta do aluno ou se é pagamento à vista direto no caixa) e como será feito o controle de estoque inicial.
