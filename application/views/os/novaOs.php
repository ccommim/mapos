<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/smoothness/jquery-ui-1.9.2.custom.css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-ui/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.validate.js"></script>

<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-diagnoses"></i>
                </span>
                <h5>Nova Ordem de Serviço</h5>
            </div>
            <div class="widget-content nopadding tab-content">
                <?php if ($custom_error != '') {
                    echo $custom_error;
                } ?>
                <form action="<?php echo current_url(); ?>" method="post" id="formNovaOs" class="form-horizontal" style="padding: 12px;">
                    <div class="control-group">
                        <label for="cliente" class="control-label">Cliente<span class="required">*</span></label>
                        <div class="controls">
                            <input id="cliente" class="span6" type="text" name="cliente" value="" />
                            <input id="clientes_id" type="hidden" name="clientes_id" value="" />
                            <span class="help-block">Selecione o cliente para criar a OS e abrir a tela completa de edição.</span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="button btn btn-success">
                            <span class="button__icon"><i class='bx bx-file'></i></span><span class="button__text2">Criar OS</span>
                        </button>
                        <a href="<?php echo base_url(); ?>index.php/os" class="button btn btn-mini btn-warning">
                            <span class="button__icon"><i class="bx bx-undo"></i></span><span class="button__text2">Voltar</span>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#cliente").autocomplete({
            source: "<?php echo base_url(); ?>index.php/os/autoCompleteCliente",
            minLength: 1,
            select: function(event, ui) {
                $("#clientes_id").val(ui.item.id);
            }
        });

        $("#formNovaOs").validate({
            rules: {
                cliente: {
                    required: true
                }
            },
            messages: {
                cliente: {
                    required: 'Campo Requerido.'
                }
            },
            errorClass: "help-inline",
            errorElement: "span",
            highlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
        });
    });
</script>
