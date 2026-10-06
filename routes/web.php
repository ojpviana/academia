<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AlunoController;
use App\Http\Controllers\Admin\FinanceiroController;
use App\Http\Controllers\Admin\TreinadorController;
use App\Http\Controllers\Treinador\ExercicioController;
use App\Http\Controllers\Treinador\TemplateController;

use App\Http\Controllers\Admin\ConfiguracaoController;
use App\Http\Controllers\Admin\ModalidadeController;
use App\Http\Controllers\Admin\LojaController;

// ==========================================
// 🔓 ROTAS PÚBLICAS
// ==========================================
Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/setup-admin', function () {
    \App\Models\User::updateOrCreate(
        ['email' => 'admin@gympro.com'],
        [
            'name' => 'Administrador Geral',
            'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            'role' => 'admin'
        ]
    );
    return "Usuário Admin criado com sucesso!";
});

// ==========================================
// 🔒 ROTAS PROTEGIDAS (Exigem Login)
// ==========================================
Route::middleware(['auth'])->group(function () {

    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/perfil/trocar-senha', [AuthController::class, 'updatePassword']);

    // ---------------------------------------------------
    // 🔴 ADMINISTRADOR
    // ---------------------------------------------------
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'index']);
        Route::get('/admin/radar', [DashboardController::class, 'radar'])->name('admin.radar');

        // Alunos e Treinadores
        Route::post('/admin/alunos', [AlunoController::class, 'store']);
        Route::put('/admin/alunos/{id}', [AlunoController::class, 'update']);
        Route::delete('/admin/alunos/{id}', [AlunoController::class, 'destroy']);
        Route::put('/admin/alunos/{id}/restaurar', [AlunoController::class, 'restaurar']);
        Route::post('/admin/treinadores', [AlunoController::class, 'salvarTreinador']);
        // Rota para Salvar a Edição do Treinador (UPDATE)
        Route::put('/admin/treinadores/{id}', [\App\Http\Controllers\Admin\TreinadorController::class, 'update']);

// Rota para Excluir o Treinador (DELETE)
        Route::delete('/admin/treinadores/{id}', [\App\Http\Controllers\Admin\TreinadorController::class, 'destroy']);
        Route::get('/admin/treinadores/{id}/remuneracao', [\App\Http\Controllers\Admin\TreinadorController::class, 'getRemuneracao']);
        Route::post('/admin/treinadores/{id}/remuneracao', [\App\Http\Controllers\Admin\TreinadorController::class, 'storeRemuneracao']);

        // Financeiro
        Route::get('/admin/financeiro', [FinanceiroController::class, 'index']);
        // Planos e Formas (Financeiro)
        Route::post('/admin/financeiro/planos', [\App\Http\Controllers\Admin\FinanceiroController::class, 'storePlano']);
        Route::post('/admin/financeiro/formas-pagamento', [\App\Http\Controllers\Admin\FinanceiroController::class, 'storeFormaPagamento']);
        Route::put('/admin/financeiro/planos/{id}', [\App\Http\Controllers\Admin\FinanceiroController::class, 'updatePlano']);
        Route::delete('/admin/financeiro/planos/{id}', [\App\Http\Controllers\Admin\FinanceiroController::class, 'destroyPlano']);
        Route::put('/admin/financeiro/formas-pagamento/{id}', [\App\Http\Controllers\Admin\FinanceiroController::class, 'updateFormaPagamento']);
        Route::delete('/admin/financeiro/formas-pagamento/{id}', [\App\Http\Controllers\Admin\FinanceiroController::class, 'destroyFormaPagamento']);
        Route::post('/admin/despesas', [FinanceiroController::class, 'storeDespesa']);
        Route::post('/admin/recebimentos', [FinanceiroController::class, 'storeRecebimento']); // Correção aqui!
        Route::post('/admin/pagamentos', [AlunoController::class, 'registrarPagamento']);
        Route::get('/admin/financeiro/exportar-caixa', [FinanceiroController::class, 'exportarPdfCaixa']);

        // Configurações (Planos e Formas de Pagamento)
        Route::get('/admin/configuracoes', [ConfiguracaoController::class, 'index']);
        Route::post('/admin/configuracoes/planos', [ConfiguracaoController::class, 'storePlano']);
        Route::put('/admin/configuracoes/planos/{id}', [ConfiguracaoController::class, 'updatePlano']);
        Route::delete('/admin/configuracoes/planos/{id}', [ConfiguracaoController::class, 'destroyPlano']);
        Route::post('/admin/configuracoes/formas-pagamento', [ConfiguracaoController::class, 'storeFormaPagamento']);
        Route::put('/admin/configuracoes/formas-pagamento/{id}', [ConfiguracaoController::class, 'updateFormaPagamento']);
        Route::delete('/admin/configuracoes/formas-pagamento/{id}', [ConfiguracaoController::class, 'destroyFormaPagamento']);
        
        // Configurações Gerais
        Route::post('/admin/configuracoes/horario', [ConfiguracaoController::class, 'salvarHorario']);
        // Turnos
        Route::post('/admin/configuracoes/turnos', [\App\Http\Controllers\Admin\ConfiguracaoController::class, 'storeTurno']);
        Route::delete('/admin/configuracoes/turnos/{id}', [\App\Http\Controllers\Admin\ConfiguracaoController::class, 'destroyTurno']);

        // Modalidades Extras e Turmas
        Route::get('/admin/modalidades', [ModalidadeController::class, 'index']);
        Route::post('/admin/modalidades', [ModalidadeController::class, 'storeModalidade']);
        Route::delete('/admin/modalidades/{id}', [ModalidadeController::class, 'destroyModalidade']);
        Route::post('/admin/turmas', [ModalidadeController::class, 'storeTurma']);
        Route::delete('/admin/turmas/{id}', [ModalidadeController::class, 'destroyTurma']);
        Route::post('/admin/turmas/{idTurma}/matricular', [ModalidadeController::class, 'matricularAluno']);
        Route::delete('/admin/turmas/{idTurma}/matricular/{idAtleta}', [ModalidadeController::class, 'removerMatricula']);

        // Vitrine Virtual (Loja)
        Route::get('/admin/loja', [LojaController::class, 'index']);
        Route::post('/admin/loja', [LojaController::class, 'store']);
        Route::put('/admin/loja/{id}', [LojaController::class, 'update']);
        Route::delete('/admin/loja/{id}', [LojaController::class, 'destroy']);
    });

    // ---------------------------------------------------
    // 🟢 TREINADOR
    // ---------------------------------------------------
    Route::middleware(['role:treinador'])->group(function () {
        Route::get('/treinador', [TreinadorController::class, 'index']);
        Route::get('/treinador/alunos', [TreinadorController::class, 'listarTodosAlunos']);
        Route::post('/treinador/salvar', [TreinadorController::class, 'salvarTreino']);
        Route::get('/treinador/listar-treinos/{id}', [TreinadorController::class, 'listarTreinosPorAtleta']);
        Route::delete('/treinador/remover-treino/{id}', [TreinadorController::class, 'removerTreino']);

        // A rota certa do histórico, na área certa!
        Route::get('/treinador/historico/{atletaId}', [TreinadorController::class, 'listarHistorico']);

        // Avaliação Física
        Route::get('/treinador/avaliacoes/{atletaId}', [TreinadorController::class, 'listarAvaliacoes']);
        Route::post('/treinador/avaliacoes/{atletaId}', [TreinadorController::class, 'salvarAvaliacao']);

        // Templates de Treino (Meus Templates)
        Route::get('/treinador/templates', [TemplateController::class, 'index']);
        Route::post('/treinador/templates', [TemplateController::class, 'store']);
        Route::post('/treinador/templates/importar', [TemplateController::class, 'importar']);
        Route::get('/treinador/templates/{id}', [TemplateController::class, 'show'])->whereNumber('id');
        Route::put('/treinador/templates/{id}', [TemplateController::class, 'update'])->whereNumber('id');
        Route::delete('/treinador/templates/{id}', [TemplateController::class, 'destroy'])->whereNumber('id');
        Route::post('/treinador/templates/{id}/exercicios', [TemplateController::class, 'adicionarExercicio'])->whereNumber('id');
        Route::delete('/treinador/templates/{id}/exercicios/{exercicioId}', [TemplateController::class, 'removerExercicio'])->whereNumber(['id', 'exercicioId']);

        // Exercícios (Catálogo)
        Route::get('/treinador/exercicios', [ExercicioController::class, 'index']);
        Route::post('/treinador/exercicios', [ExercicioController::class, 'store']);
        Route::put('/treinador/exercicios/{id}', [ExercicioController::class, 'update']);
        Route::delete('/treinador/exercicios/{id}', [ExercicioController::class, 'destroy']);
    });

    // ---------------------------------------------------
    // 🟠 ATLETA (APP)
    // ---------------------------------------------------
    Route::middleware(['role:atleta'])->group(function () {
        Route::get('/app', [AppController::class, 'index']);
        Route::post('/app/checkin', [AppController::class, 'checkin']);
        Route::post('/app/registrar-historico', [AlunoController::class, 'registrarHistorico']);
        Route::post('/app/exercicio-concluido', [AppController::class, 'registrarExercicioConcluido']);
        Route::post('/app/treino/meta', [AppController::class, 'salvarMetaCarga']);
    });
});
