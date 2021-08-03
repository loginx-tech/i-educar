adicionaMaisUmaLinhaNaTabela();
ajustaTabelaDePessoasUnificadas();

$j('#btn_add_tab_add_1').click(function(){
  ajustaTabelaDePessoasUnificadas();
});

var $quantidadeDeVinculosComAlunos = 0;
var $quantidadeDeVinculosComServidores = 0;

function adicionaMaisUmaLinhaNaTabela() {
  tab_add_1.addRow();
}

function ajustaTabelaDePessoasUnificadas() {
  $j('a[id^="link_remove["').empty().text('EXCLUIR');
  $j('input[id^="pessoa_duplicada["').attr("placeholder", "Informe nome, código, CPF ou RG da pessoa");
}

function carregaDadosPessoas() {
  let pessoas_duplicadas = [];

  $j('input[id^="pessoa_duplicada["').each(function(id, input) {
    pessoas_duplicadas.push(input.value.split(' ')[0]);
  });

  var url = getResourceUrlBuilder.buildUrl(
    '/module/Api/Pessoa',
    'dadosUnificacaoPessoa',
    {
      pessoas_ids : pessoas_duplicadas
    }
  );

  var options = {
    url      : url,
    dataType : 'json',
    success  : function(response) {
      if (!exiteMaisDeUmaPessoa()) {
        modalInformeMaisPessoas();
        return;
      }

      if (exitemPessoasDuplicadas()) {
        modalAjustePessoasUnificadas();
        return;
      }

      $j('#adicionar_linha').hide();
      listaDadosPessoasUnificadas(response);
    }
  };

  getResources(options);
}

function recarregaListaDePessoas() {
  let pessoas_duplicadas = [];

  $j('input[id^="pessoa_duplicada["').each(function(id, input) {
    pessoas_duplicadas.push(input.value.split(' ')[0]);
  });

  var url = getResourceUrlBuilder.buildUrl(
    '/module/Api/Pessoa',
    'dadosUnificacaoPessoa',
    {
      pessoas_ids : pessoas_duplicadas
    }
  );

  var options = {
    url      : url,
    dataType : 'json',
    success  : function(response) {
      montaTabela(response);
      apresentaObservacoes(response.pessoas);
      uniqueCheck();
      $j('#check_confirma_dados_unificacao').prop('checked', false);
    }
  };

  getResources(options);
}

function exiteMaisDeUmaPessoa() {
  let pessoas = [];

  $j('input[id^="pessoa_duplicada["').each(function(id, input) {
    idpes = input.value.split(' ')[0];
    if (idpes) {
      pessoas.push(idpes);
    }
  });

  return pessoas.length > 1;
}

function modalInformeMaisPessoas() {
  makeDialog({
    content: 'Informe pelo menos duas pessoas para unificar.',
    title: 'Atenção!',
    maxWidth: 400,
    width: 400,
    close: function () {
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Ok',
      click: function () {
        $j('#dialog-container').dialog('destroy');
      }
    },]
  });
}

function exitemPessoasDuplicadas() {
  let pessoas = [];

  $j('input[id^="pessoa_duplicada["').each(function(id, input) {
    pessoas.push(input.value.split(' ')[0]);
  });

  let pessoasSemDuplicidade = [...new Set(pessoas)];

  return pessoas.length != pessoasSemDuplicidade.length;
}

function modalAjustePessoasUnificadas() {
  makeDialog({
    content: 'Selecione pessoas diferentes.',
    title: 'Atenção!',
    maxWidth: 400,
    width: 400,
    close: function () {
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Ok',
      click: function () {
        $j('#dialog-container').dialog('destroy');
      }
    },]
  });
}

function listaDadosPessoasUnificadas(response) {
  modalAvisoComplementaDadosPessoa();
  removeExclusaoDePessoas();
  disabilitaSearchInputs();
  montaTabela(response);
  adicionaSeparador();
  apresentaObservacoes(response.pessoas);
  adicionaCheckboxConfirmacao();
  adicionaBotoes();
  uniqueCheck();
  desabilitaBotaoUnificar();
}

function removeExclusaoDePessoas() {
  $j('.tr_tabela_pessoas td a').each(function(id, input) {
    input.remove();
  });
}

function disabilitaSearchInputs() {
  $j('input[id^="pessoa_duplicada["').prop('disabled', true);
}

function confirmaAnalise() {
  let checked = $j('#check_confirma_dados_unificacao').is(':checked');

  if (existePessoaPrincipal() && checked) {
    if ($quantidadeDeVinculosComAlunos <= 1) {
      habilitaBotaoUnificar();
    }

    return;
  }

  if (checked) {
    desabilitaBotaoUnificar();
    modalExigePessoaPrincipal();
    return;
  }

  desabilitaBotaoUnificar();
}

function habilitaBotaoUnificar() {
  $j('#unifica_pessoa').prop('disabled', false);
  $j('#unifica_pessoa').addClass('btn-green');
  $j('#unifica_pessoa').removeClass('btn-disabled');
}

function desabilitaBotaoUnificar() {
  $j('#unifica_pessoa').prop('disabled', true);
  $j('#unifica_pessoa').removeClass('btn-green');
  $j('#unifica_pessoa').addClass('btn-disabled');
}

function existePessoaPrincipal() {
  let existePessoaPrincipal = false;
  const checkbox = document.querySelectorAll('input.check_principal')
  checkbox.forEach(element => {
    if (element.checked == true) {
      existePessoaPrincipal = true;
    }
  });

  return existePessoaPrincipal;
}

function modalExigePessoaPrincipal() {
  makeDialog({
    content: 'Você precisa definir uma pessoa como principal.',
    title: 'Atenção!',
    maxWidth: 860,
    width: 860,
    close: function () {
      $j('#check_confirma_dados_unificacao').prop('checked', false);
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Ok',
      click: function () {
        $j('#check_confirma_dados_unificacao').prop('checked', false);
        $j('#dialog-container').dialog('destroy');
      }
    },]
  });
}

function modalAvisoComplementaDadosPessoa() {
  makeDialog({
    content: `Para complementar os dados da pessoa que selecionou como principal,
    é necessário fazê-lo manualmente editando os dados da pessoa física antes da Unificação de Pessoas.
    <b>Caso não faça essa complementação, os dados das pessoas físicas não selecionadas como principal serão perdidos.</b>`,
    title: 'Atenção!',
    maxWidth: 860,
    width: 860,
    close: function () {
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Ok',
      click: function () {
        $j('#dialog-container').dialog('destroy');
      }
    },]
  });
}

function adicionaBotoes() {
  let htmlBotao = '<input type="button" class="botaolistagem" onclick="voltar();" value="Voltar" autocomplete="off">';
  htmlBotao += '<input id="unifica_pessoa" type="button" class="botaolistagem" onclick="showConfirmationMessage();" value="Unificar pessoas da lista" autocomplete="off">';
  $j('.linhaBotoes td').html(htmlBotao);
}

function adicionaSeparador() {
  $j('<tr class="lista_pessoas_unificadas_hr"><td class="tableDetalheLinhaSeparador" colspan="2"></td></tr>').insertAfter($j('#lista_dados_pessoas_unificadas'));
}

function adicionaCheckboxConfirmacao() {
  $j('<tr id="tr_confirma_dados_unificacao"></tr>').insertBefore($j('.linhaBotoes'));

  let htmlCheckbox = '<td colspan="2">'
  htmlCheckbox += '<input onchange="confirmaAnalise()" id="check_confirma_dados_unificacao" type="checkbox" />';
  htmlCheckbox += '<label for="check_confirma_dados_unificacao">Confirmo a análise de que são a mesma pessoa, levando <br> em conta a possibilidade de gêmeos cadastrados.</label>';
  htmlCheckbox += '</td>';

  $j('#tr_confirma_dados_unificacao').html(htmlCheckbox);
}

function montaTabela(response) {
  $j('tr#lista_dados_pessoas_unificadas').remove().animate({});
  $j('tr#unifica_pessoa_titulo').remove().animate({});

  $j('<tr id="lista_dados_pessoas_unificadas"></tr>').insertAfter($j('.tableDetalheLinhaSeparador').first().closest('tr')).hide().show('slow');
  $j(`
    <tr id="unifica_pessoa_titulo">
      <td colspan="2">
        <h2 class="unifica_pessoa_h2">
          Seleciona a pessoa que tenha preferencialmente vínculo(s) e com dados relavantes mais completos.
        </h2>
      </td>
    </tr>
  `).insertAfter($j('.tableDetalheLinhaSeparador').first().closest('tr')).hide().show('slow');

  let html = `
    <td colspan="2">
    <table id="tabela_pessoas_unificadas">
      <tr class="tr_title">
        <td>Principal</td>
        <td>Vinculo</td>
        <td>Nome</td>
        <td>Nascimento</td>
        <td>Sexo</td>
        <td>CPF</td>
        <td>RG</td>
        <td>Pessoa Mãe</td>
        <td>Ação</td>
      </tr>
  `;

  response.pessoas.each(function(value, id) {
    html += '<tr id="' + value.idpes + '" class="linha_listagem">';
    html += '<td><input onclick="validaCheckPessoaPrincipal(this)" type="checkbox" class="check_principal" id="check_principal_' + value.idpes + '"</td>';
    html += '<td id="vinculo_'+ value.idpes +'">'+ value.vinculo +'</td>';
    html += '<td><a target="_new" href="/intranet/atendidos_det.php?cod_pessoa=' + value.idpes + '">'+ value.nome +'</a></td>';
    html += '<td>'+ value.data_nascimento +'</td>';
    html += '<td>'+ value.sexo +'</td>';
    html += '<td>'+ addMascara(value.cpf) +'</td>';
    html += '<td>'+ value.rg +'</td>';
    html += '<td>'+ value.pessoa_mae +'</td>';
    html += '<td><a class="link_remove" onclick="removePessoa(' + value.idpes + ')"><b><u>EXCLUIR</u></b></a></td>';
    html += '</tr>';
  });

  html += '</table></td>';

  $j('#lista_dados_pessoas_unificadas').html(html);
}

function addMascara(value) {
  if (value === 'Não consta') {
    return value
  }

  if (value.length === 10) { // Quando o CPF tem 0 na frente o i-educar remove.
    value = '0' + value;
  }

  return value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
}

function uniqueCheck() {
  const checkbox = document.querySelectorAll('input.check_principal')
  checkbox.forEach(element => {
    element.addEventListener('click', handleClick.bind(event,checkbox));
  });
}

function validaCheckPessoaPrincipal(element) {
  let idpes = element.id.replace(/[^\d]/g, '');

  if (! $j('#' + element.id).is(':checked')) {
    return;
  }

  if ($j('#vinculo_' + idpes).text() != 'Sem vínculo') {
    return;
  }

  if ($quantidadeDeVinculosComAlunos > 0 || $quantidadeDeVinculosComServidores > 0) {
    modalInformePessoaPrincipalComVinculo(element.id);
    return;
  }
}

function modalInformePessoaPrincipalComVinculo(checkId) {
  makeDialog({
    content: 'Seleciona uma pessoa com vínculo como principal.',
    title: 'Atenção!',
    maxWidth: 400,
    width: 400,
    close: function () {
      $j('#'+checkId).prop('checked', false);
      desabilitaBotaoUnificar();
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Ok',
      click: function () {
        $j('#'+checkId).prop('checked', false);
        desabilitaBotaoUnificar();
        $j('#dialog-container').dialog('destroy');
      }
    },]
  });
}


function handleClick(checkbox, event) {
  checkbox.forEach(element => {
    confirmaAnalise();
    if (event.currentTarget.id !== element.id) {
      element.checked = false;
    }
  });
}

function removePessoa(idpes) {
  if ($j('#tabela_pessoas_unificadas tr').length === 3) {
    confirmaRemocaoPessoaUnificacao();
    return;
  }
  removeTr(idpes);
}

function removeTr(idpes) {
  let trClose = $j('#' + idpes);
  trClose.fadeOut(400, function() {
    trClose.remove();
  });
}

function confirmaRemocaoPessoaUnificacao() {
  makeDialog({
    content: 'É necessário ao menos 2 pessoas para a unificação, ao confirmar o processo vai ser reiniciado, Deseja prosseguir?',
    title: 'Atenção!',
    maxWidth: 860,
    width: 860,
    close: function () {
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Confirmar',
      click: function () {
        voltar();
        $j('#dialog-container').dialog('destroy');
      }
    }, {
      text: 'Cancelar',
      click: function () {
        $j('#dialog-container').dialog('destroy');
      }
    }]
  });
}

function contabilizaVinculos(pessoas) {
  let alunos = 0;
  let servidores = 0;

  pessoas.each(function(value, id) {
    let vinculos = value.vinculo.split(', ');

    if ($j.inArray('Aluno',vinculos) != -1) {
      alunos++;
    }

    if ($j.inArray('Servidor',vinculos) != -1) {
      servidores++;
    }
  });

  $quantidadeDeVinculosComAlunos = alunos;
  $quantidadeDeVinculosComServidores = servidores;
}

function apresentaObservacoes(pessoas) {
  $j('#tr_observacoes').remove();

  contabilizaVinculos(pessoas);

  if ($quantidadeDeVinculosComAlunos > 1) {
    $j('<tr id="tr_observacoes"></tr>').insertAfter($j('.lista_pessoas_unificadas_hr'));
    htmlApresentaObservacoes();
    return;
  }
}

function htmlApresentaObservacoes() {
  html = `
    <td colspan="2">
      <div>
        Consta mais de um vínculo de aluno na lista de pessoas a serem unificadas,
        <a href="/intranet/educar_unifica_aluno.php" target="_new"><b>clique aqui</b></a> para fazer a Unificação de alunos antes de unificar as pessoas físicas.
        Após a unificação clique no botão abaixo para recarregar a listagem de pessoas. <br>
        <a id="recarregar_lista" onclick="recarregaListaDePessoas()"><b>Recarregar lista</br></a>
      </div>
    </td>
  `;

  $j('#tr_observacoes').html(html);
}

function voltar() {
  document.location.reload(true);
}

var handleSelect = function(event, ui){
  $j(event.target).val(ui.item.label);
  return false;
};

  var search = function(request, response) {
  var searchPath = '/module/Api/Pessoa?oper=get&resource=pessoa-search';
  var params     = { query : request.term };

  $j.get(searchPath, params, function(dataResponse) {
  simpleSearch.handleSearch(dataResponse, response);
});
};

  function setAutoComplete() {
  $j.each($j('input[id^="pessoa_duplicada"]'), function(index, field) {

    $j(field).autocomplete({
      source    : search,
      select    : handleSelect,
      minLength : 1,
      autoFocus : true
    });

  });
}

  setAutoComplete();

  // bind events

  var $addPontosButton = $j('#btn_add_tab_add_1');

  $addPontosButton.click(function(){
  setAutoComplete();
});

  $j('#btn_enviar').val('Carregar dados');

  function showConfirmationMessage() {
  makeDialog({
    content: 'O processo de unificação de pessoas não poderá ser desfeito. Deseja continuar?',
    title: 'Atenção!',
    maxWidth: 860,
    width: 860,
    close: function () {
      $j('#dialog-container').dialog('destroy');
    },
    buttons: [{
      text: 'Confirmar',
      click: function () {
        enviaDados();
        $j('#dialog-container').dialog('destroy');
      }
    }, {
      text: 'Cancelar',
      click: function () {
        $j('#dialog-container').dialog('destroy');
      }
    }]
  });
}

  function  enviaDados() {

    let dados = [];
    const formData = document.createElement('form');
    formData.method = 'post';
    formData.action = 'educar_unifica_pessoa.php';

    $j('#tabela_pessoas_unificadas .linha_listagem').each(function(id, input) {
      let isChecked = $j('#check_principal_'+ input.id).is(':checked');
      let pessoaParaUnificar = {};
      pessoaParaUnificar.idpes = input.id;
      pessoaParaUnificar.pessoa_principal = isChecked;
      dados.push(pessoaParaUnificar);
    });

    const acao = document.createElement('input');
    acao.type = 'hidden';
    acao.name = 'tipoacao';
    acao.value = 'Novo';
    formData.appendChild(acao);

    const hiddenField = document.createElement('input');
    hiddenField.type = 'hidden';
    hiddenField.name = 'pessoas';
    hiddenField.value = JSON.stringify(dados);
    formData.appendChild(hiddenField);

    document.body.appendChild(formData);
    formData.submit();
  }

  function makeDialog(params) {
  var container = $j('#dialog-container');

  if (container.length < 1) {
  $j('body').append('<div id="dialog-container" style="width: 500px;"></div>');
  container = $j('#dialog-container');
}

  if (container.hasClass('ui-dialog-content')) {
  container.dialog('destroy');
}

  container.empty();
  container.html(params.content);

  delete params['content'];

  container.dialog(params);
}

