<div class="row-fluid" style="margin-top:0">
    <style>
        #formTecnico {
            max-width: 980px;
            margin: 0 auto;
            padding: 12px 0;
        }

        #formTecnico .control-label {
            width: 140px;
        }

        #formTecnico .controls {
            margin-left: 160px;
            margin-right: 12px;
        }

        #formTecnico input[type="text"],
        #formTecnico select {
            text-transform: uppercase;
            box-sizing: border-box;
            width: 100%;
            margin-bottom: 0;
        }

        #formTecnico .audit-field {
            background: #f5f5f5;
        }

        #formTecnico .form-actions {
            padding-left: 0;
            padding-right: 0;
        }

        #formTecnico .form-actions .span6.offset3 {
            float: none;
            width: 100%;
            margin: 0;
        }

        @media (max-width: 767px) {
            #formTecnico {
                padding: 8px 10px;
            }

            #formTecnico .control-label {
                width: auto;
            }

            #formTecnico .controls {
                margin-left: 0;
                margin-right: 0;
            }
        }
    </style>
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-id-card"></i>
                </span>
                <h5>Editar Técnico</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php if ($custom_error != '') { echo $custom_error; } ?>
                <form action="<?= current_url(); ?>" method="post" id="formTecnico" class="form-horizontal">
                    <?= form_hidden('idTecnico', $result->idTecnico); ?>
                    <?php $statusAtual = isset($result->status) ? (string) $result->status : '1'; ?>

                    <div class="control-group">
                        <label for="nome" class="control-label">Nome<span class="required">*</span></label>
                        <div class="controls">
                            <input id="nome" class="span12" type="text" name="nome" value="<?= set_value('nome', $result->nome); ?>" oninput="this.value = this.value.toUpperCase();" />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="status" class="control-label">Situação</label>
                        <div class="controls">
                            <select id="status" name="status" class="span12">
                                <option value="1" <?= set_value('status', $statusAtual) === '1' ? 'selected' : ''; ?>>HABILITADO</option>
                                <option value="0" <?= set_value('status', $statusAtual) === '0' ? 'selected' : ''; ?>>DESABILITADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Criado por</label>
                        <div class="controls">
                            <input class="span12 audit-field" type="text" value="<?= $result->criado_por ?: '-'; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Criado em</label>
                        <div class="controls">
                            <input class="span12 audit-field" type="text" value="<?= $result->criado_em ? date('d/m/Y H:i', strtotime($result->criado_em)) : '-'; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Alterado por</label>
                        <div class="controls">
                            <input class="span12 audit-field" type="text" value="<?= $result->alterado_por ?: '-'; ?>" readonly />
                        </div>
                    </div>

                    <div class="control-group">
                        <label class="control-label">Alterado em</label>
                        <div class="controls">
                            <input class="span12 audit-field" type="text" value="<?= $result->alterado_em ? date('d/m/Y H:i', strtotime($result->alterado_em)) : '-'; ?>" readonly />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3" style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                                <button type="submit" class="button btn btn-primary" style="min-width: 160px;">
                                    <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Atualizar</span>
                                </button>
                                <a href="<?= site_url('tecnicos'); ?>" class="button btn btn-warning" style="min-width: 160px;">
                                    <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
