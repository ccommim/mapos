<?php
$totalServico  = 0;
$totalProdutos = 0;
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <title><?= $this->config->item('app_name') ?> - <?= numeroOS($result) ?> - <?= $result->nomeCliente ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap5.3.2.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/css/font-awesome.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/imprimir.css?v=<?= @filemtime(FCPATH . 'assets/css/imprimir.css') ?>">
</head>
<body>
    <div class="main-page <?= !empty($control_2vias_ativo) ? 'duas-vias' : '' ?>">
        <div class="sub-page">
            <header>
                <?php if ($emitente == null) : ?>
                    <div class="alert alert-danger" role="alert">
                        Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/mapos/emitente">Configurar</a>
                    </div>
                <?php else : ?>
                    <div class="imgLogo" class="align-middle">
                        <img src="<?= $emitente->url_logo ?>" class="img-fluid" style="width:120px;">
                    </div>
                    <div class="emitente">
                        <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                        <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                            <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                        <?php endif; ?>
                        <span class="align-middle">
                            <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?> - <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                        </span>
                        <span class="contato-item"><span class="contato-label">E-mail:</span> <?= $emitente->email ?></span>
                        <span class="contato-item"><span class="contato-label">Telefone:</span> <?= $emitente->telefone ?></span>
                    </div>
                <?php endif; ?>
            </header>
            <section>
                <div class="title">
                    <?php if (!empty($control_2vias_ativo)) : ?><span class="via">Via cliente</span><?php endif; ?>
                    <span class="ordem-servico">OS <span class="ordem-servico-numero">#<?= numeroOS($result) ?></span></span>
                    <span class="emissao">Data: <?= date('d/m/Y') ?></span>
                </div>

                <?php if ($result->dataInicial != null): ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <?php if ($result->garantia) : ?>
                                        <th class="text-center">GARANTIA</th>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <th class="text-center">VENC. GARANTIA</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <?php if ($result->garantia) : ?>
                                        <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                    <?php endif; ?>
                                    <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                        <td class="text-center"><?= dateInterval($result->dataFinal, $result->garantia) ?></td>
                                    <?php endif; ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <div class="subtitle">DADOS DO CLIENTE</div>
                <div class="dados dados-cliente">
                    <div class="cliente-nome">
                        <span><b><?= $result->nomeCliente ?></b></span>
                    </div>
                    <div class="cliente-detalhes-linha">
                    <div class="cliente-info">
                        <?php $documentoNumerico = preg_replace('/\D+/', '', (string) $result->documento); ?>
                        <?php $rotuloDocumento = strlen($documentoNumerico) === 11 ? 'CPF' : (strlen($documentoNumerico) === 14 ? 'CNPJ' : 'Documento'); ?>
                        <span><?= $rotuloDocumento ?>: <?= $result->documento ?></span><br />
                        <?php if (!empty($result->email)) : ?><span><i class="fas fa-envelope"></i> <?= $result->email ?></span><br /><?php endif; ?>
                        <?php if ($result->telefone || $result->celular) : ?><span><i class="fas fa-phone"></i> <?= $result->contato_cliente.' '.$result->telefone ?><?= $result->telefone && $result->celular ? ' / '.$result->celular : $result->celular ?></span><br /><?php endif; ?>
                    </div>
                    <div class="cliente-endereco">
                        <span><?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                        <span><?= $result->complemento ? $result->complemento.' - ' : '' ?><?= $result->cidade.' - '.$result->estado ?> | CEP: <?= $result->cep ?></span><br />
                    </div>
                    </div>
                </div>

                <?php if ($result->descricaoProduto) : ?>
                    <div class="subtitle">DESCRIÇÃO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->descricaoProduto) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->defeito) : ?>
                    <div class="subtitle">DEFEITO APRESENTADO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->defeito) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->observacoes) : ?>
                    <div class="subtitle">OBSERVAÇÕES</div>
                    <div class="dados">
                        <div style="text-align: justify;">
                            <?= printSafeHtml($result->observacoes) ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($result->laudoTecnico) : ?>
					<div class="subtitle">PARECER TÉCNICO</div>
                    <div class="dados">
                        <div style="text-align: justify;">
    						<?= printSafeHtml($result->laudoTecnico) ?>
						</div>
                    </div>
                <?php endif; ?>

                <?php if ($result->garantias_id) : ?>
                    <div class="subtitle">TERMO DE GARANTIA</div>
                    <div class="dados">
                        <div style="text-align: justify;"><?= printSafeHtml($result->textoGarantia) ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($produtos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th>PRODUTO(S)</th>
                                    <th class="text-center" width="10%">QTD</th>
                                    <th class="text-center" width="10%">UNT</th>
                                    <th class="text-end" width="15%" >SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($produtos as $p) :
                                    $totalProdutos = $totalProdutos + $p->subTotal;
                                    echo '<tr>';
                                    echo '  <td>' . $p->descricao . '</td>';
                                    echo '  <td class="text-center">' . $p->quantidade . '</td>';
                                    echo '  <td class="text-center">' . number_format($p->preco ?: $p->precoVenda, 2, ',', '.') . '</td>';
                                    echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                    echo '</tr>';
                                endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end"><b>TOTAL PRODUTOS:</b></td>
                                    <td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php if ($servicos) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="table-secondary">
                                    <th>SERVIÇO(S)</th>
                                    <th class="text-center" width="10%">QTD</th>
                                    <th class="text-center" width="10%">UNT</th>
                                    <th class="text-end" width="15%" >SUBTOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    setlocale(LC_MONETARY, 'en_US');
                    foreach ($servicos as $s) :
                        $preco = $s->preco ?: $s->precoVenda;
                        $subtotal = $preco * ($s->quantidade ?: 1);
                        $totalServico = $totalServico + $subtotal;
                        echo '<tr>';
                        echo '  <td>' . $s->nome . '</td>';
                        echo '  <td class="text-center">' . ($s->quantidade ?: 1) . '</td>';
                        echo '  <td class="text-center">' . number_format($preco, 2, ',', '.') . '</td>';
                        echo '  <td class="text-end">R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                        echo '</tr>';
                    endforeach; ?>
                                <tr>
                                    <td colspan="3" class="text-end"><b>TOTAL SERVIÇOS:</b></td>
                                    <td class="text-end"><b>R$ <?= number_format($totalServico, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

                <?php
                $subtotalGeral = (float) $totalProdutos + (float) $totalServico;
                $temDesconto = ((float) ($result->desconto ?? 0) > 0 && (float) ($result->valor_desconto ?? 0) > 0);
                $totalFinal = $temDesconto ? (float) $result->valor_desconto : $subtotalGeral;
                $valorAbatido = max(0, $subtotalGeral - $totalFinal);
                $tipoDesconto = (string) ($result->tipo_desconto ?? '');
                $descontoInfo = '';
                if ($temDesconto) {
                    $descontoInfo = $tipoDesconto === 'porcento'
                        ? number_format((float) $result->desconto, 2, ',', '.') . '%'
                        : 'R$ ' . number_format((float) $result->desconto, 2, ',', '.');
                }
                ?>
                <?php if ($subtotalGeral > 0 || $temDesconto) : ?>
                    <div class="tabela">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="text-end"><b>SUBTOTAL:</b></td>
                                    <td class="text-end" style="width: 180px;">R$ <?= number_format($subtotalGeral, 2, ',', '.') ?></td>
                                </tr>
                                <?php if ($temDesconto) : ?>
                                    <tr>
                                        <td class="text-end"><b>DESCONTO APLICADO<?= $descontoInfo ? ' (' . $descontoInfo . ')' : '' ?>:</b></td>
                                        <td class="text-end">- R$ <?= number_format($valorAbatido, 2, ',', '.') ?></td>
                                    </tr>
                                <?php endif; ?>
                                <tr>
                                    <td class="text-end"><b>TOTAL FINAL:</b></td>
                                    <td class="text-end"><b>R$ <?= number_format($totalFinal, 2, ',', '.') ?></b></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>

            </section>
            <footer>
                <?php if (($totalProdutos != 0 || $totalServico != 0) && !empty($this->data['configuration']['pix_key']) && !empty($qrCode)) : ?>
                    <div class="qrcode qrcode-pix qrcode-rodape">
                        <div class="qrcode-imgwrap"><img class="qrcode-img" src="<?= $qrCode ?>" alt="QR Code de Pagamento" /></div>
                        <div class="pix-conteudo">
                            <div class="pix-titulo">PAGUE COM PIX</div>
                            <div class="pix-logo-wrap">
                                <img class="pix-logo" src="<?= base_url() ?>assets/img/logo_pix.png" alt="Pix" />
                            </div>
                            <ol class="pix-passos">
                                <li>Abra o app do seu banco</li>
                                <li>Escolha pagar com QR Code</li>
                                <li>Aponte a camera para o codigo</li>
                            </ol>
                            <div class="chavePix">Chave Pix: <?= $chaveFormatada ?></div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="detalhes">
                </div>
                <div class="assinaturas">
                    <span>Assinatura do cliente</span>
                    <span>Assinatura do técnico</span>
                </div>
            </footer>
        </div>

        <?php if (!empty($control_2vias_ativo)) : ?>
            <div class="sub-page novaPagina">
                <header>
                    <?php if ($emitente == null) : ?>
                        <div class="alert alert-danger" role="alert">
                            Você precisa configurar os dados do emitente. >>> <a href="<?=base_url()?>index.php/mapos/emitente">Configurar</a>
                        </div>
                    <?php else : ?>
                        <div class="imgLogo" class="align-middle">
                            <img src="<?= $emitente->url_logo ?>" class="img-fluid" style="width:120px;">
                        </div>
                        <div class="emitente">
                            <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                            <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                                <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                            <?php endif; ?>
                            <span class="align-middle">
                                <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?> - <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                            </span>
                            <span class="contato-item"><span class="contato-label">E-mail:</span> <?= $emitente->email ?></span>
                            <span class="contato-item"><span class="contato-label">Telefone:</span> <?= $emitente->telefone ?></span>
                        </div>
                    <?php endif; ?>
                </header>
                <section>
                    <div class="title">
                        <!-- VIA EMPRESA  -->
                        <?php $totalServico = 0;
$totalProdutos = 0; ?>
                        <?php if (!empty($control_2vias_ativo)) : ?><span class="via">Via Empresa</span><?php endif; ?>
                        <span class="ordem-servico">OS <span class="ordem-servico-numero">#<?= numeroOS($result) ?></span></span>
                        <span class="emissao">Data: <?= date('d/m/Y') ?></span>
                    </div>

                    <?php if ($result->dataInicial != null): ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <?php if ($result->garantia) : ?>
                                            <th class="text-center">GARANTIA</th>
                                        <?php endif; ?>
                                        <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                            <th class="text-center">VENC. GARANTIA</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php if ($result->garantia) : ?>
                                            <td class="text-center"><?= $result->garantia . ' dia(s)' ?></td>
                                        <?php endif; ?>
                                        <?php if (in_array($result->status, ['Finalizado', 'Faturado'])) : ?>
                                            <td class="text-center"><?= dateInterval($result->dataFinal, $result->garantia) ?></td>
                                        <?php endif; ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <div class="subtitle">DADOS DO CLIENTE</div>
                    <div class="dados dados-cliente">
                        <div class="cliente-nome">
                            <span><b><?= $result->nomeCliente ?></b></span>
                        </div>
                        <div class="cliente-detalhes-linha">
                        <div class="cliente-info">
                            <?php $documentoNumerico = preg_replace('/\D+/', '', (string) $result->documento); ?>
                            <?php $rotuloDocumento = strlen($documentoNumerico) === 11 ? 'CPF' : (strlen($documentoNumerico) === 14 ? 'CNPJ' : 'Documento'); ?>
                            <span><?= $rotuloDocumento ?>: <?= $result->documento ?></span><br />
                            <?php if (!empty($result->email)) : ?><span><i class="fas fa-envelope"></i> <?= $result->email ?></span><br /><?php endif; ?>
                            <?php if ($result->telefone || $result->celular) : ?><span><i class="fas fa-phone"></i> <?= $result->contato_cliente.' '.$result->telefone ?><?= $result->telefone && $result->celular ? ' / '.$result->celular : $result->celular ?></span><br /><?php endif; ?>
                        </div>
                        <div class="cliente-endereco">
                            <span><?= $result->rua.', '.$result->numero.', '.$result->bairro ?></span><br />
                            <span><?= $result->complemento ? $result->complemento.' - ' : '' ?><?= $result->cidade.' - '.$result->estado ?> | CEP: <?= $result->cep ?></span><br />
                        </div>
                        </div>
                    </div>

                    <?php if ($result->descricaoProduto) : ?>
                        <div class="subtitle">DESCRIÇÃO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->descricaoProduto) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->defeito) : ?>
                        <div class="subtitle">DEFEITO APRESENTADO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->defeito) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->observacoes) : ?>
                        <div class="subtitle">OBSERVAÇÕES</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->observacoes) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->laudoTecnico) : ?>
                        <div class="subtitle">PARECER TÉCNICO</div>
                        <div class="dados">
                            <div>
                                <?= printSafeHtml($result->laudoTecnico) ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ($result->garantias_id) : ?>
                        <div class="subtitle">TERMO DE GARANTIA</div>
                        <div class="dados">
                            <div style="text-align: justify;"><?= printSafeHtml($result->textoGarantia) ?></div>
                        </div>
                    <?php endif; ?>

                    <?php if ($produtos) : ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>PRODUTO(S)</th>
                                        <th class="text-center" width="10%">QTD</th>
                                        <th class="text-center" width="10%">UNT</th>
                                        <th class="text-end" width="15%" >SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($produtos as $p) :
                                        $totalProdutos = $totalProdutos + $p->subTotal;
                                        echo '<tr>';
                                        echo '  <td>' . $p->descricao . '</td>';
                                        echo '  <td class="text-center">' . $p->quantidade . '</td>';
                                        echo '  <td class="text-center">' . number_format($p->preco ?: $p->precoVenda, 2, ',', '.') . '</td>';
                                        echo '  <td class="text-end">R$ ' . number_format($p->subTotal, 2, ',', '.') . '</td>';
                                        echo '</tr>';
                                    endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><b>TOTAL PRODUTOS:</b></td>
                                        <td class="text-end"><b>R$ <?= number_format($totalProdutos, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php if ($servicos) : ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="table-secondary">
                                        <th>SERVIÇO(S)</th>
                                        <th class="text-center" width="10%">QTD</th>
                                        <th class="text-center" width="10%">UNT</th>
                                        <th class="text-end" width="15%" >SUBTOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        setlocale(LC_MONETARY, 'en_US');
                        foreach ($servicos as $s) :
                            $preco = $s->preco ?: $s->precoVenda;
                            $subtotal = $preco * ($s->quantidade ?: 1);
                            $totalServico = $totalServico + $subtotal;
                            echo '<tr>';
                            echo '  <td>' . $s->nome . '</td>';
                            echo '  <td class="text-center">' . ($s->quantidade ?: 1) . '</td>';
                            echo '  <td class="text-center">' . number_format($preco, 2, ',', '.') . '</td>';
                            echo '  <td class="text-end">R$ ' . number_format($subtotal, 2, ',', '.') . '</td>';
                            echo '</tr>';
                        endforeach; ?>
                                    <tr>
                                        <td colspan="3" class="text-end"><b>TOTAL SERVIÇOS:</b></td>
                                        <td class="text-end"><b>R$ <?= number_format($totalServico, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>

                    <?php
                    $subtotalGeral = (float) $totalProdutos + (float) $totalServico;
                    $temDesconto = ((float) ($result->desconto ?? 0) > 0 && (float) ($result->valor_desconto ?? 0) > 0);
                    $totalFinal = $temDesconto ? (float) $result->valor_desconto : $subtotalGeral;
                    $valorAbatido = max(0, $subtotalGeral - $totalFinal);
                    $tipoDesconto = (string) ($result->tipo_desconto ?? '');
                    $descontoInfo = '';
                    if ($temDesconto) {
                        $descontoInfo = $tipoDesconto === 'porcento'
                            ? number_format((float) $result->desconto, 2, ',', '.') . '%'
                            : 'R$ ' . number_format((float) $result->desconto, 2, ',', '.');
                    }
                    ?>
                    <?php if ($subtotalGeral > 0 || $temDesconto) : ?>
                        <div class="tabela">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td class="text-end"><b>SUBTOTAL:</b></td>
                                        <td class="text-end" style="width: 180px;">R$ <?= number_format($subtotalGeral, 2, ',', '.') ?></td>
                                    </tr>
                                    <?php if ($temDesconto) : ?>
                                        <tr>
                                            <td class="text-end"><b>DESCONTO APLICADO<?= $descontoInfo ? ' (' . $descontoInfo . ')' : '' ?>:</b></td>
                                            <td class="text-end">- R$ <?= number_format($valorAbatido, 2, ',', '.') ?></td>
                                        </tr>
                                    <?php endif; ?>
                                    <tr>
                                        <td class="text-end"><b>TOTAL FINAL:</b></td>
                                        <td class="text-end"><b>R$ <?= number_format($totalFinal, 2, ',', '.') ?></b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </section>
                <footer>
                    <div class="detalhes">
                    </div>
                    <div class="assinaturas">
                        <span>Assinatura do cliente</span>
                        <span>Assinatura do técnico</span>
                    </div>
                </footer>
            </div>
        <?php endif; ?>

        <?php if ($anexos && $imprimirAnexo) : ?>
            <div class="sub-page" id="anexos">
                <header style="border: 1px solid #cdcdcd">
                    <?php if ($emitente == null) : ?>
                        <div class="alert alert-danger" role="alert">
                            Você precisa configurar os dados do emitente. >>> <a href="<?= base_url() ?>index.php/mapos/emitente">Configurar</a>
                        </div>
                    <?php else : ?>
                        <div id="imgLogo" class="align-middle">
                            <img src="<?= $emitente->url_logo ?>" class="img-fluid" style="width:120px;">
                        </div>
                        <div class="emitente">
                            <span style="font-size: 16px;"><b><?= $emitente->nome ?></b></span></br>
                            <?php if ($emitente->cnpj != "00.000.000/0000-00") : ?>
                                <span class="align-middle">CNPJ: <?= $emitente->cnpj ?></span></br>
                            <?php endif; ?>
                            <span class="align-middle">
                                <?= $emitente->rua.', '.$emitente->numero.', '.$emitente->bairro ?> - <?= $emitente->cidade.' - '.$emitente->uf.' - '.$emitente->cep ?>
                            </span>
                            <span class="contato-item"><span class="contato-label">E-mail:</span> <?= $emitente->email ?></span>
                            <span class="contato-item"><span class="contato-label">Telefone:</span> <?= $emitente->telefone ?></span>
                        </div>
                    <?php endif; ?>
                </header>
                <section>
                    <div class="title">
                        OS #<?= numeroOS($result) ?>
                        <span class="emissao">Emissão: <?= date('d/m/Y') ?></span>
                    </div>
                    <div class="subtitle">ANEXO(S)</div>
                    <div class="dados">
                        <div style="width: 100%; display: flex; justify-content: space-around; align-items: center; flex-wrap: wrap;">
                            <?php
                                $contaAnexos = 0;
foreach ($anexos as $a) :
    if ($a->thumb) :
        $thumb = $a->url.'/thumbs/'.$a->thumb;
        $link  = $a->url.'/'.$a->anexo;
        ?>
                                        <img src="<?= $link ?>" alt="">
                            <?php
    endif;
endforeach;
?>
                        </div>
                    </div>
                <section>
            </div>
        <?php endif; ?>
    </div>
    <?php if (empty($export_pdf)) : ?>
        <script type="text/javascript">
            window.print();
        </script>
    <?php endif; ?>
</body>
</html>
