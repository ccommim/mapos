<div class="row-fluid" style="margin-top:0">
    <style>
        .tecnicos-upper {
            text-transform: uppercase;
        }
    </style>
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title" style="margin: -20px 0 0">
                <span class="icon">
                    <i class="fas fa-id-card"></i>
                </span>
                <h5>Técnicos</h5>
                <div class="buttons">
                    <a href="<?php echo site_url('tecnicos/adicionar'); ?>" class="button btn btn-mini btn-success" style="max-width: 160px">
                        <span class="button__icon"><i class='bx bx-plus-circle'></i></span><span class="button__text2">Adicionar</span>
                    </a>
                </div>
            </div>
            <div class="widget-content nopadding tab-content tecnicos-upper">
                <?php if ($this->session->flashdata('success')) { ?>
                    <div class="alert alert-success" style="margin: 12px;"> <?= $this->session->flashdata('success'); ?> </div>
                <?php } ?>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="alert alert-danger" style="margin: 12px;"> <?= $this->session->flashdata('error'); ?> </div>
                <?php } ?>

                <div class="span12" style="padding: 12px; margin-left: 0; overflow-x: auto;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="70">ID</th>
                                <th>Nome</th>
                                <th width="120">Situação</th>
                                <th>Criado por</th>
                                <th width="150">Criado em</th>
                                <th>Alterado por</th>
                                <th width="150">Alterado em</th>
                                <th width="120">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($results) { ?>
                                <?php foreach ($results as $r) { ?>
                                    <tr>
                                        <td><?= $r->idTecnico ?></td>
                                        <td><?= $r->nome ?></td>
                                        <td>
                                            <?php $statusTecnico = isset($r->status) ? (int) $r->status : 1; ?>
                                            <?php if ($statusTecnico === 1) : ?>
                                                <span class="badge badge-success">HABILITADO</span>
                                            <?php else : ?>
                                                <span class="badge badge-important">DESABILITADO</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= $r->criado_por ?: '-' ?></td>
                                        <td><?= $r->criado_em ? date('d/m/Y H:i', strtotime($r->criado_em)) : '-' ?></td>
                                        <td><?= $r->alterado_por ?: '-' ?></td>
                                        <td><?= $r->alterado_em ? date('d/m/Y H:i', strtotime($r->alterado_em)) : '-' ?></td>
                                        <td>
                                            <a href="<?= site_url('tecnicos/editar/' . $r->idTecnico); ?>" class="btn btn-mini btn-info tip-top" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="<?= site_url('tecnicos/excluir/' . $r->idTecnico); ?>" onclick="return confirm('Deseja realmente excluir este técnico?');" class="btn btn-mini btn-danger tip-top" title="Excluir">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr>
                                    <td colspan="8" style="text-align:center;">Nenhum técnico cadastrado.</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="span12" style="margin-left:0; padding: 0 12px 12px;">
                    <?= $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
