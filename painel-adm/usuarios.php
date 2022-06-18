<?php
$pag = 'usuarios';
require_once('../conexao.php');
?>


<a href="index.php?pagina=<?php echo $pag ?>&funcao=novo" type="button" class="btn btn-secondary mt-2">Novo Usuário</a>

<div class="mt-4" style="margin-right: 25px;">
  
    <?php
      //BUSCAR
    $query = $pdo->query("SELECT * FROM usuarios ORDER BY id DESC");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
    ?>
        <small>
            <table id="example" class="table table-hover my-4">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>CPF</th>
                        <th>Email</th>
                        <th>Senha</th>
                        <th>Nível</th>
                        <th>Ação</th>

                    </tr>
                </thead>
                <tbody>
                    <?php
                    //For para percorrer dados na tabela do banco
                    for ($i = 0; $i < $total_reg; $i++) {
                        foreach ($res[$i] as $key => $value) {
                        }

                    ?>
                        <tr>
                            <td><?php echo $res[$i]['nome'] ?></td>
                            <td><?php echo $res[$i]['cpf'] ?></td>
                            <td><?php echo $res[$i]['email'] ?></td>
                            <td><?php echo $res[$i]['senha'] ?></td>
                            <td><?php echo $res[$i]['nivel'] ?></td>
                            <td>

                                <a href="index.php?pagina=<?php echo $pag ?>&funcao=editar&id=<?php echo $res[$i]['id'] ?>" title="Editar Registro">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>

                                <i class="bi bi-archive text-danger"></i>

                            </td>
                        </tr>

                    <?php  } ?>
                </tbody>

            </table>
        </small>
    <?php } else {
        echo '<p>Não existem dados para serem exibidos</p>';
    } ?>
</div>

<?php
//EDITAR
if (@$_GET['funcao'] == 'editar') {
    $tipo_modal = 'Editar Registro';

    $query = $pdo->query("SELECT * FROM usuarios WHERE id = '$_GET[id]'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    $total_reg = @count($res);
    if ($total_reg > 0) {
        $nome = $res[0]['nome'];
        $cpf = $res[0]['cpf'];
        $senha = $res[0]['senha'];
        $email = $res[0]['email'];
        $nivel = $res[0]['nivel'];
        $id = $res[0]['id'];
    }
} else {
    $tipo_modal = 'Inserir Registro';
}
?>
<div class="modal" tabindex="-1" id="modalCadastrar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo $tipo_modal ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" id="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome" required="" value="<?php echo @$nome ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="exampleFormControlInput1" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="cpf" name="cpf" placeholder="CPF" required="" value="<?php echo @$cpf ?>">
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?php echo @$email ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Senha</label>
                        <input type="text" class="form-control" id="senha" name="senha" placeholder="Senha" value="<?php echo @$senha ?>">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nível</label>
                        <select class="form-select mt-1" aria-label="Default select example" name="nivel">

                            <option <?php if (@$nivel == 'Operador') { ?> selected <?php } ?> value="Operador">Operador</option>
                            <option <?php if (@$nivel == 'Administrador') { ?> selected <?php } ?> value="Administrador">Administrador</option>
                            <option <?php if (@$nivel == 'Tesoureiro') { ?> selected <?php } ?> value="Tesoureiro">Tesoureiro</option>
                        </select>
                    </div>
                    <small class="mt-1">
                        <div align="center" id="mensagem">

                        </div>
                    </small>
                </div>
                <div class="modal-footer">
					<button type="button" id="btn-fechar" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
					<button name="btn-salvar" id="btn-salvar" type="submit" class="btn btn-primary">Salvar</button>

					<input name="id" type="hidden" value="<?php echo @$_GET['id'] ?>">

					<input name="cpf_antigo" type="hidden" value="<?php echo @$cpf ?>">
					<input name="email_antigo" type="hidden" value="<?php echo @$email ?>">

				</div>
            </form>
        </div>
    </div>
</div>


<?php
if (@$_GET['funcao'] == "novo") { ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        })
        myModal.show();
    </script>
<?php } ?>

<?php
if (@$_GET['funcao'] == "editar") { ?>
    <script type="text/javascript">
        var myModal = new bootstrap.Modal(document.getElementById('modalCadastrar'), {
            backdrop: 'static'
        })
        myModal.show();
    </script>
<?php } ?>

<!--AJAX PARA INSERÇÃO E EDIÇÃO DOS DADOS COM IMAGEM -->
<script type="text/javascript">
    $("#form").submit(function() {
        var pag = "<?= $pag ?>";
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: pag + "/inserir.php",
            type: 'POST',
            data: formData,

            success: function(mensagem) {

                $('#mensagem').removeClass()

                if (mensagem.trim() == "Salvo com Sucesso!") {

                    //$('#nome').val('');
                    //$('#cpf').val('');
                    $('#btn-fechar').click();
                    window.location = "index.php?pagina=" + pag;

                } else {

                    $('#mensagem').addClass('text-danger')
                }

                $('#mensagem').text(mensagem)

            },

            cache: false,
            contentType: false,
            processData: false,
            xhr: function() { // Custom XMLHttpRequest
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) { // Avalia se tem suporte a propriedade upload
                    myXhr.upload.addEventListener('progress', function() {
                        /* faz alguma coisa durante o progresso do upload */
                    }, false);
                }
                return myXhr;
            }
        });
    });
</script>


<script type="text/javascript">
    $('#example').dataTable({
        "ordering": false
    })
</script>