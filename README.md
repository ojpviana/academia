# GymPro SaaS - Documentação do Projeto

## 📌 Visão Geral
Sistema web de gestão para academias (SaaS) projetado para automatizar processos internos e melhorar a experiência de treino dos alunos. O sistema possui três painéis distintos com diferentes níveis de acesso: **Administrador**, **Treinador** e **Atleta (App)**.

## 🏗 Estrutura do Projeto e Tecnologias
- **Backend:** Laravel 12.0 / PHP 8.2+
- **Frontend:** Blade Templates com **Tailwind CSS 4** (utilizando Vite para compilação). Desenvolvido com foco na abordagem *Mobile-First* para os alunos.
- **Mídia:** Sistema *Zero Upload* — não armazena vídeos ou mídias pesadas no servidor, utilizando embeds/iframes do YouTube ou Giphy.
- **Relatórios:** Pacote `barryvdh/laravel-dompdf` para geração e exportação de PDFs financeiros.

## 👥 Atores e Fluxos de Autenticação
O sistema utiliza o `AuthController` padrão juntamente com um único model de `User`, validando a coluna `role` (`admin`, `treinador`, `atleta`) por meio de middlewares de rotas (`routes/web.php`).

1. **Admin (`/admin/*`)**: Gestor dono da academia.
2. **Treinador (`/treinador/*`)**: Professores que prescrevem treinos e avaliam os alunos.
3. **Atleta (`/app/*`)**: Alunos que utilizam o sistema no celular pelo navegador para consumir fichas de treino.

---

## 🎯 O que funciona (Status Atual)

### Módulo do Administrador
- **Dashboard Resumo**: Tela inicial com indicadores.
- **Gestão de Usuários**: Cadastro, edição, exclusão e restauração (SoftDelete/lógica local) de Alunos e Treinadores via `AlunoController` e `TreinadorController`.
- **Módulo Financeiro Básico**: Lançamento de despesas e exportação de PDF do livro caixa (`FinanceiroController`).

### Módulo do Treinador
- **Listagem de Alunos**: O treinador vê e seleciona os alunos que estão sob sua supervisão.
- **Prescrição de Treinos**: Envio de fichas de treino distribuídas por dia da semana (`TreinadorController`).
- **Avaliação Física**: Cadastro rico da evolução corporal do aluno (Peso, Altura, % Massa Magra, % Massa Gorda e observações textuais). Histórico completo de avaliações fica disponível no painel.

### App do Atleta (Frontend Mobile)
- **Ficha Dinâmica**: Navegação em formato de abas (A, B, C) responsiva e adaptada para uso via smartphone (`app/dashboard.blade.php`).
- **Vídeos Interativos**: Clique no exercício abre um *Modal* com Iframe do vídeo do YouTube/GIF + orientações, tudo sem recarregar a tela.
- **Acompanhamento de Evolução**: A última Avaliação Corporal cadastrada pelo Treinador é exibida automaticamente no topo do dashboard com as datas.
- **Troca/Motivo de Ficha**: Lógica em que o aluno avisa o sistema/treinador o motivo caso decida trocar o dia do treino (aparelhos lotados, dor, etc.).
- **Autoatendimento**: Alteração da própria senha no menu do perfil.

---

## 🛠 O que tem que corrigir (Bugs Conhecidos e Pendências)

1. **Dívida Técnica no Financeiro**
   - Na linha de rotas (`web.php`), há uma anotação manual pendente apontando um problema/correção necessária na rota de recebimentos:
     `Route::post('/admin/recebimentos', [FinanceiroController::class, 'storeRecebimento']); // Correção aqui!`

---

## 🚀 Próximos Passos (Roadmap Recomendado)

1. **Módulo Financeiro / Planos de Assinatura (Fase 2):** 
   - Implementar os Models de `Plano` e `Assinatura`.
   - Ligar a Assinatura ao `Atleta`.
   - Adicionar uma Job diária para checar vencimentos.
   - **Bloqueio Automático:** Se a assinatura vencer, exibir aviso no login e bloquear a listagem do treino no App do Atleta.
2. **Dashboards Gerenciais:** 
   - Substituir números fixos por lógicas de contagem real no painel admin (taxa de inadimplência, lucro do mês atual, alunos ativos x inativos).
