<?php
   if (!$session->logado()){
      echo "É necessário estar logado para acessar esta área.";
      exit;
   }  
?>


    <div class="container">
      <div class="py-3 text-center">
        <h2>Bem vindo ao painel inicial!</h2>
      </div>

      <div class="py-3 text-center">
          <h4 class="mb-3">O que você deseja realizar?</h4>
          </div>

          <div class="l-estilo l-estilo1 l-antes"></div>

          <div class="container-fluid container-conteudo">
              <div class="row">
          <div class="col-md-3">

          <div class="panel-group" id="accordion-menu" role="tablist" aria-multiselectable="true">
          <div class="panel">
                    <div class="panel-heading" role="tab" id="menu_categoria_1">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-menu"  href="#categoria_1" aria-expanded="true" aria-controls="categoria_1">
                                <i class="fa fa-caret-down"></i>                                ESTOQUE                            </a>
                        </div>
                    </div>
                    <div id="categoria_1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_categoria_1">

                        <div class="panel-group" id="accordion-menu_" role="tablist" aria-multiselectable="true">

                                                    <div class="panel">
                                <div class="panel-heading" role="tab" id="menu_grupo_4">
                                    <div class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion-menu_"  href="#grupo_4" aria-expanded="true" aria-controls="grupo_4">
                                            <i class="fa fa-caret-down"></i>                                            Editar estoque                                        </a>
                                    </div>
                                </div>
                                <div id="grupo_4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_4">
                                                                    <div class="panel-item active" id_categoria="1" id_grupo="4" id_documentacao="privacidade" >
                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Cadastrar carro                                     </a>
                                  
                                    </div>
                                                                    </div>

                                <div id="grupo_4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_4">
                                                                    <div class="panel-item active" id_categoria="1" id_grupo="4" id_documentacao="privacidade" >
                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Atualizar informações do carro                                      </a>
                                  
                                    </div>
                                                                    </div>
                            </div>
                                                        
                    </div>
                </div>
                        </div>
    </div>
    
    <div class="panel-group" id="accordion-menu" role="tablist" aria-multiselectable="true">
          <div class="panel">
                    <div class="panel-heading" role="tab" id="menu_categoria_2">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-menu"  href="#categoria_2" aria-expanded="true" aria-controls="categoria_2">
                                <i class="fa fa-caret-down"></i>                                CLIENTE                            </a>
                        </div>
                    </div>
                    <div id="categoria_2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_categoria_2">

                        <div class="panel-group" id="accordion-menu_" role="tablist" aria-multiselectable="true">

                                                    <div class="panel">
                                <div class="panel-heading" role="tab" id="menu_grupo_5">
                                    <div class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion-menu_"  href="#grupo_5" aria-expanded="true" aria-controls="grupo_5">
                                            <i class="fa fa-caret-down"></i>                                            Editar  cadastro                                        </a>
                                    </div>
                                </div>
                                <div id="grupo_5" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_5">
                                                                    <div class="panel-item active" id_categoria="2" id_grupo="5" id_documentacao="Editar cadastro" >
                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Atualizar dados do cliente                                     </a>
                                            </div>
                                                                    </div>

                                <div id="grupo_5" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_5">
                                                                    <div class="panel-item active" id_categoria="2" id_grupo="5" id_documentacao="Editar cadastro" >

                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Cadastrar cliente                                     </a>
                                  
                                    </div>
                                                                    </div>
                            </div>
                                                        
                    </div>
                </div>
                        </div>
    </div>
    <div class="panel-group" id="accordion-menu" role="tablist" aria-multiselectable="true">
          <div class="panel">
                    <div class="panel-heading" role="tab" id="menu_categoria_3">
                        <div class="panel-title">
                            <a role="button" data-toggle="collapse" data-parent="#accordion-menu"  href="#categoria_3" aria-expanded="true" aria-controls="categoria_3">
                                <i class="fa fa-caret-down"></i>                                FUNCIONÁRIO                            </a>
                        </div>
                    </div>
                    <div id="categoria_3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_categoria_3">

                        <div class="panel-group" id="accordion-menu_" role="tablist" aria-multiselectable="true">

                                                    <div class="panel">
                                <div class="panel-heading" role="tab" id="menu_grupo_6">
                                    <div class="panel-title">
                                        <a role="button" data-toggle="collapse" data-parent="#accordion-menu_"  href="#grupo_6" aria-expanded="true" aria-controls="grupo_6">
                                            <i class="fa fa-caret-down"></i>                                            Editar cadastro funcionário                                       </a>
                                    </div>
                                </div>
                                <div id="grupo_6" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_6">
                                                                    <div class="panel-item active" id_categoria="3" id_grupo="6" id_documentacao="Editar cadastro funcionário" >
                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Cadastrar funcionário                                    </a>
                                            </div>
                                </div>

                                <div id="grupo_6" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="menu_grupo_6">
                                                                    <div class="panel-item active" id_categoria="3" id_grupo="6" id_documentacao="Editar cadastro funcionário" >
                                        <a href="">
                                            <i class="fa fa-caret-right"></i>Atualizar dados do funcionário                                    </a>
                                  
                                    </div>
                                                                    </div>
                            </div>
                                                        
                    </div>
                </div>
                        </div>
    </div>
          <!-- <form class="needs-validation" novalidate>
            
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
          </form> -->
        </div>
      </div>