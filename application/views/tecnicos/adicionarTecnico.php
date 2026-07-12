<div class="row-fluid" style="margin-top:0">
    <style>
        #formTecnico {
            text-transform: uppercase;
        }

        #formTecnico input[type="text"] {
            text-transform: uppercase;
        }
    </style>
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-id-card"></i>
                </span>
                <h5>Cadastro de Técnico</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php if ($custom_error != '') { echo $custom_error; } ?>
                <form action="<?= current_url(); ?>" method="post" id="formTecnico" class="form-horizontal">
                    <div class="span12" style="padding: 12px; margin-left: 0;">
                        <div class="span8 offset2">
                            <label for="nome">Nome<span class="required">*</span></label>
                            <input id="nome" class="span12" type="text" name="nome" value="<?= set_value('nome'); ?>" oninput="this.value = this.value.toUpperCase();" />
                        </div>
                        <div class="span8 offset2" style="margin-top: 10px;">
                            <label for="status">Situação</label>
                            <select id="status" name="status" class="span12">
                                <option value="1" <?= set_value('status', '1') === '1' ? 'selected' : ''; ?>>HABILITADO</option>
                                <option value="0" <?= set_value('status') === '0' ? 'selected' : ''; ?>>DESABILITADO</option>
                            </select>
                        </div>
                    </div>

                    <div class="span12" style="padding: 0 12px 12px; margin-left: 0;">
                        <div class="span12" style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap;">
                            <button type="submit" class="button btn btn-success" style="min-width: 160px;">
                                <span class="button__icon"><i class='bx bx-save'></i></span><span class="button__text2">Salvar</span>
                            </button>
                            <a href="<?= site_url('tecnicos'); ?>" class="button btn btn-warning" style="min-width: 160px;">
                                <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
