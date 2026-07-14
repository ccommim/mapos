<style>
    .cliente-view-layout.form-horizontal .control-group {
        border-bottom: 1px solid #ffffff;
        margin-bottom: 0;
        display: flex;
        align-items: center;
    }

    .cliente-view-layout.form-horizontal .controls {
        margin-left: 0;
        flex: 1;
        padding-bottom: 0;
    }

    .cliente-view-layout.form-horizontal .control-label {
        text-align: left;
        padding-top: 0;
        width: 220px;
        margin: 0;
        line-height: 20px;
    }

    .cliente-view-layout input[readonly],
    .cliente-view-layout textarea[readonly] {
        background: #fff;
        cursor: default;
        margin-bottom: 0;
    }

    .cliente-view-layout input[readonly] {
        width: 206px;
    }

    .cliente-view-layout .observacoes-full {
        clear: both;
        padding: 0 20px 20px 0;
        margin: 0;
        margin-top: -22px;
    }

    .cliente-view-layout .observacoes-full .control-group {
        border-bottom: 0;
        margin: 0;
        display: block;
    }

    .cliente-view-layout .observacoes-full .control-label {
        float: none;
        width: auto;
        margin-left: 0;
        padding-top: 12px;
        margin-bottom: 0;
        line-height: 18px;
    }

    .cliente-view-layout .observacoes-full .controls {
        margin-left: 0;
        margin-top: 0;
    }

    .cliente-view-layout .observacoes-full textarea {
        width: calc(100% - 20px);
        max-width: 100%;
        min-height: 160px;
        box-sizing: border-box;
        resize: vertical;
        margin-top: 0;
    }

    @media (max-width: 768px) {
        .cliente-view-layout.form-horizontal .control-group {
            display: block;
        }

        .cliente-view-layout.form-horizontal .control-label {
            width: auto;
            margin-bottom: 4px;
        }

        .cliente-view-layout.form-horizontal .controls {
            width: 100%;
        }

        .cliente-view-layout input[readonly] {
            width: 100%;
            box-sizing: border-box;
        }

        .cliente-view-layout .observacoes-full {
            margin-top: 0;
            padding-right: 0;
        }

        .cliente-view-layout .observacoes-full textarea {
            width: 100%;
        }
    }
</style>
<div class="widget-box">
    <div class="widget-title" style="margin: 0;font-size: 1.1em">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab1">Dados do Cliente</a></li>
            <li><a data-toggle="tab" href="#tab2">Ordens de Serviço</a></li>
            <li style="display: none;"><a data-toggle="tab" href="#tab3">Vendas</a></li>
        </ul>
    </div>
    <div class="widget-content tab-content">
        <div id="tab1" class="tab-pane active" style="min-height: 300px">
            <div class="cliente-view-layout form-horizontal">
                <div class="widget-content nopadding tab-content">
                    <div class="span6">
                    <div class="control-group">
                        <label class="control-label">CPF/CNPJ</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->documento, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Nome/Razão Social</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->nomeCliente, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Contato</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->contato, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Telefone</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->telefone, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Celular</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->celular, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Email</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->email, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Data de Cadastro</label>
                        <div class="controls">
                            <input type="text" value="<?php echo date('d/m/Y', strtotime($result->dataCadastro)); ?>" readonly>
                        </div>
                    </div>
                    </div>

                    <div class="span6">
                    <?php
                        $partesEnderecoMaps = array_filter([
                            trim((string) ($result->rua ?? '')),
                            trim((string) ($result->numero ?? '')),
                            trim((string) ($result->bairro ?? '')),
                            trim((string) ($result->cidade ?? '')),
                            trim((string) ($result->estado ?? '')),
                            trim((string) ($result->cep ?? '')),
                        ]);
                        $enderecoMaps = implode(', ', $partesEnderecoMaps);
                        $mapsUrl = $enderecoMaps !== ''
                            ? 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($enderecoMaps)
                            : '';
                    ?>
                    <div class="control-group">
                        <label class="control-label">CEP</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->cep, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Rua</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->rua, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Número</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->numero, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Complemento</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->complemento, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Bairro</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->bairro, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Cidade</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->cidade, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Estado</label>
                        <div class="controls">
                            <input type="text" value="<?php echo htmlspecialchars($result->estado, ENT_QUOTES, 'UTF-8'); ?>" readonly>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Mapa</label>
                        <div class="controls">
                            <?php if ($mapsUrl !== '') : ?>
                                <a href="<?php echo htmlspecialchars($mapsUrl, ENT_QUOTES, 'UTF-8'); ?>" target="_blank" rel="noopener noreferrer" class="btn btn-mini btn-info">
                                    Abrir no Google Maps
                                </a>
                            <?php else : ?>
                                <span class="text-muted">Endereço incompleto para abrir no mapa.</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    </div>

                    <div class="observacoes-full">
                        <div class="control-group">
                            <label class="control-label">Observações</label>
                            <div class="controls">
                                <textarea readonly><?php echo htmlspecialchars($result->cust_observacoes ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--Tab 2-->
        <div id="tab2" class="tab-pane" style="min-height: 300px">
            <?php if (!$results) { ?>
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>N° OS</th>
                        <th>Data da Execução</th>
                        <th>Nome do Serviço</th>
                        <th>Observação</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Valor Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="8">Nenhuma OS Cadastrada</td>
                    </tr>
                    </tbody>
                </table>
                <?php
            } else { ?>
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>N° OS</th>
                        <th>Data da Execução</th>
                        <th>Nome do Serviço</th>
                        <th>Observação</th>
                        <th>Quantidade</th>
                        <th>Valor</th>
                        <th>Valor Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($results as $r) {
                        $dataExecucao = !empty($r->dataExecucao) ? date(('d/m/Y'), strtotime($r->dataExecucao)) : '-';
                        $quantidade = $r->quantidade ?: 1;
                        $valor = $r->preco !== null ? (float) $r->preco : (float) $r->precoPadraoServico;
                        $valorTotal = $r->subTotal !== null ? (float) $r->subTotal : ($valor * $quantidade);
                        $nomeServico = $r->nomeServico ?: $r->servico;
                        $observacaoOs = trim(strip_tags((string) $r->observacoes));
                        echo '<tr>';
                        echo '<td>' . numeroOS($r) . '</td>';
                        echo '<td>' . $dataExecucao . '</td>';
                        echo '<td>' . htmlspecialchars($nomeServico ?: '-', ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars($observacaoOs !== '' ? $observacaoOs : '-', ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>' . htmlspecialchars((string) $quantidade, ENT_QUOTES, 'UTF-8') . '</td>';
                        echo '<td>R$ ' . number_format($valor, 2, ',', '.') . '</td>';
                        echo '<td>R$ ' . number_format($valorTotal, 2, ',', '.') . '</td>';

                        echo '<td>';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                            echo '<a href="' . base_url() . 'index.php/os/visualizar/' . $r->idOs . '" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="fas fa-eye"></i></a>';
                        }

                        echo  '</td>';
                        echo '</tr>';
                    } ?>
                    <tr>
                    </tr>
                    </tbody>
                </table>
                <?php
            } ?>
        </div>
        <!--Tab 3-->
        <div id="tab3" class="tab-pane" style="min-height: 300px; display: none;">
            <?php if (!$result_vendas) { ?>
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>N° Venda</th>
                        <th>Data</th>
                        <th>Faturado</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td colspan="6">Nenhuma OS Cadastrada</td>
                    </tr>
                    </tbody>
                </table>
                <?php
            } else { ?>
                <table class="table table-bordered ">
                    <thead>
                    <tr>
                        <th>N° Venda</th>
                        <th>Data</th>
                        <th>Faturado</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($result_vendas as $r) {
                        $dataVenda = date(('d/m/Y'), strtotime($r->dataVenda));
                        if ($r->faturado == 1) {
                            $faturado = 'Sim';
                        } else {
                            $faturado = 'Não';
                        }
                        echo '<tr>';
                        echo '<td>' . $r->idVendas . '</td>';
                        echo '<td>' . $dataVenda . '</td>';
                        echo '<td>' . $faturado . '</td>';
                        echo '<td>R$' . $r->valorTotal . '</td>';

                        echo '<td>';
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'vOs')) {
                            echo '<a href="' . base_url() . 'index.php/vendas/visualizar/' . $r->idVendas . '" style="margin-right: 1%" class="btn tip-top" title="Ver mais detalhes"><i class="fas fa-eye"></i></a>';
                        }
                        if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eOs')) {
                            echo '<a href="' . base_url() . 'index.php/vendas/editar/' . $r->idVendas . '" class="btn btn-info tip-top" title="Editar OS"><i class="fas fa-edit"></i></a>';
                        }
                        echo '</td>';
                        echo '</tr>';
                    } ?>
                    <tr>
                    </tr>
                    </tbody>
                </table>
                <?php
            } ?>
        </div>
    </div>
    <div class="modal-footer" style="display:flex;justify-content: center">
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'eCliente')) {
            echo '<a title="Icon Title" class="button btn btn-mini btn-info" style="min-width: 140px; top:10px" href="' . base_url() . 'index.php/clientes/editar/' . $result->idClientes . '">
<span class="button__icon"><i class="bx bx-edit"></i></span> <span class="button__text2"> Editar</span></a>';
        } ?>
        <a title="Voltar" class="button btn btn-mini btn-warning" style="min-width: 140px; top:10px" href="<?php echo site_url() ?>/clientes">
          <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span></a>
        <?php if ($this->permission->checkPermission($this->session->userdata('permissao'), 'aOs')) {
                        echo '<a title="Nova OS" class="button btn btn-mini btn-success" style="min-width: 140px; top:10px" href="' . base_url() . 'index.php/os/nova?cliente_id=' . $result->idClientes . '">
<span class="button__icon"><i class="bx bx-file"></i></span> <span class="button__text2"> Nova OS</span></a>';
        } ?>
    </div>
</div>
