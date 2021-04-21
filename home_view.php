<div class="container-fluid">
    <div class="row">
        <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
            <div class="form-group">
                <input class="form-control" id="txtPesquisa" type="text" placeholder="Nome, Modelo, Marca, etc...">
            </div>
        </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <div class="form-group">
                <button class="btn btn-primary" onclick="listar_carros()" style='width:100%;'>
                    <i class="fa fa-search"></i> Pesquisar
                </button>
            </div>
        </div>
    </div>
    <div class="row" id="lista-carros">
    </div>
</div>

<div class="modal" tabindex="-1" id="modalDetalhesCarro">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalhes do carro</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="divDetalhesCarro"></div>
            </div>
        </div>
    </div>
</div>


<script>
    var model_carros = '<?= $conf->base_url(); ?>request/model/carros';

    $(document).ready(function() {
        listar_carros();

        $(document).on('keypress', "#txtPesquisa", function(e) {
            if (e.which == 13) {
                listar_carros();
            }
        });
    });

    function detalhes_carro(id) {
        $.post(`${model_carros}/detalhes_carro`, {
            id
        }, function(data) {

            if (data.erro) {
                if (typeof data.msg !== 'undefined') {
                    alert(data.msg);
                } else {
                    alert("Erro ao buscar dados do carro!");
                }
                return;
            } else {

                $('#divDetalhesCarro').html(data.html);

                $('#modalDetalhesCarro').modal('show');
            }

        }, 'json')
    }

    function listar_carros() {
        var pesquisa = $('#txtPesquisa').val();

        $.post(`${model_carros}/lista_carros_home`, {
            pesquisa
        }, function(data) {

            if (data.erro) {
                if (typeof data.msg !== 'undefined') {
                    alert(data.msg);
                } else {
                    alert("Erro ao listar carros!");
                }
                return;
            } else {

                $('#lista-carros').html(data.html);

            }

        }, 'json')
    }
</script>