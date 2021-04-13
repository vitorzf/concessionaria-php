<?php
   session_start();
   foreach (glob("./classes/*.php") as $nome_arquivo) {
       require $nome_arquivo;
   }
?>
<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    

    <title>Registro de venda</title>

    <!-- Principal CSS do Bootstrap -->
    <link href="css/bootstrap.css" rel="stylesheet">

  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-5 text-center">
        <h2>Formulário de registro</h2>
      </div>

        <div class="col-md-8 order-md-1">
          <h4 class="mb-3">Registro de venda</h4>
          <form class="needs-validation" novalidate>
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="primeiroNome">Nome completo do cliente</label>
                <input type="text" class="form-control" id="primeiroNome" placeholder="" value="" required>
                <div class="invalid-feedback">
                  É obrigatório inserir um nome válido.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label>CPF</label>
                <input type="text" class="form-control" placeholder="" value="" required>
                <div class="invalid-feedback">
                  É obrigatório inserir um CPF válido.
                  <div class="mb-3">
              <label>CNH</label>
              <input type="text" class="form-control"  placeholder="">
            </div>
                </div>
              </div>
            </div>
            

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Opcional)</span></label>
              <input type="email" class="form-control" id="email" placeholder="fulano@exemplo.com">
              <div class="invalid-feedback">
                Por favor, insira um endereço de e-mail válido, para atualizações de entrega.
              </div>
            </div>

            <div class="mb-3">
              <label for="endereco">Endereço</label>
              <input type="text" class="form-control" id="endereco" placeholder="Rua..., nº 0" required>
            </div>
            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="pais">País</label>
                <select class="custom-select d-block w-100" id="pais" required>
                  <option value="">Escolha...</option>
                  <option>Brasil</option>
                </select>
                <div class="invalid-feedback">
                  Por favor, escolha um país válido.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="estado">Estado</label>
                <select class="custom-select d-block w-100" id="estado" required>
                  <option value="">Escolha...</option>
                  <option>Acre (AC)
                          Alagoas (AL)
                          Amapá (AP)
                          Amazonas (AM)
                          Bahia (BA)
                          Ceará (CE)
                          Distrito Federal (DF)
                          Espírito Santo (ES)
                          Goiás (GO)
                          Maranhão (MA)
                          Mato Grosso (MT)
                          Mato Grosso do Sul (MS)
                          Minas Gerais (MG)
                          Pará (PA)
                          Paraíba (PB)
                          Paraná (PR)
                          Pernambuco (PE)
                          Piauí (PI)
                          Rio de Janeiro (RJ)
                          Rio Grande do Norte (RN)
                          Rio Grande do Sul (RS)
                          Rondônia (RO)
                          Roraima (RR)
                          Santa Catarina (SC)
                          São Paulo (SP)
                          Sergipe (SE)
                          Tocantins (TO)</option>
                </select>
                <div class="invalid-feedback">
                  Por favor, insira um estado válido.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="cep">CEP</label>
                <input type="text" class="form-control" id="cep" placeholder="" required>
                <div class="invalid-feedback">
                  É obrigatório inserir um CEP.
                </div>
              </div>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" class="custom-control-input" id="salvar-info">
              <label class="custom-control-label" for="salvar-info">Lembrar desta informação, na próxima vez.</label>
            </div>
            <hr class="mb-4">
            
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" type="submit">Finalizar</button>
          </form>
        </div>
      </div>

    

    <!-- Principal JavaScript do Bootstrap
    ================================================== -->
    <!-- Foi colocado no final para a página carregar mais rápido -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../../assets/js/vendor/popper.min.js"></script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <script>
      // Exemplo de JavaScript para desativar o envio do formulário, se tiver algum campo inválido.
      (function() {
        'use strict';

        window.addEventListener('load', function() {
          // Selecione todos os campos que nós queremos aplicar estilos Bootstrap de validação customizados.
          var forms = document.getElementsByClassName('needs-validation');

          // Faz um loop neles e previne envio
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();
    </script>
  </body>
</html>
