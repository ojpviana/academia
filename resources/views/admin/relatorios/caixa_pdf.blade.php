<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Caixa - GymPro</title>
    <style>
        /* CSS Clássico para o DomPDF entender perfeitamente */
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #334155;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #f97316; /* Laranja GymPro */
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #0f172a;
            font-size: 28px;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .text-right {
            text-align: right;
        }
        .status {
            color: #16a34a;
            font-weight: bold;
            font-size: 12px;
        }
        .footer {
            text-align: right;
            font-size: 20px;
            color: #0f172a;
            font-weight: bold;
            border-top: 2px solid #e2e8f0;
            padding-top: 20px;
        }
        .valor-total {
            color: #f97316;
        }
        .assinatura {
            margin-top: 80px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>GymPro</h1>
        <h2>Relatório de Recebimentos</h2>
        <p>Período de Análise: {{ $periodo }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Atleta</th>
                <th>Status</th>
                <th class="text-right">Valor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pagamentos as $pagamento)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($pagamento->data_pagamento)->format('d/m/Y') }}</td>
                    <td>{{ $pagamento->atleta->nome ?? 'Atleta Desvinculado/Excluído' }}</td>
                    <td class="status">{{ strtoupper($pagamento->status) }}</td>
                    <td class="text-right">R$ {{ number_format($pagamento->valor, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        TOTAL ARRECADADO: <span class="valor-total">R$ {{ number_format($total, 2, ',', '.') }}</span>
    </div>

    <div class="assinatura">
        Documento gerado pelo sistema GymPro em {{ now()->format('d/m/Y, H:i') }}
    </div>

</body>
</html>
