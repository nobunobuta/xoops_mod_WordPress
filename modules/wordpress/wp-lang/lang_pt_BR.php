<?php
$blog_charset = 'iso-8859-1';
if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */
/* Brazilian Portuguese Translation: Marcelo Yuji Himoro <http://www.yuji.eu.org> */

/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */

/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>O WordPress ME ainda n�o est� instalado. Clique <a href=\'wp-admin/install.php\'>aqui</a> para iniciar a instala��o.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>O arquivo <code>wp-config.php</code> n�o existe. Ele � necess�rio para instalar o WordPress ME. Precisa de ajuda? Clique <a href=\'http://wordpress.org/docs/faq/#wp-config\'>aqui</a>. Voc� pode <a href=\'wp-admin/install-config.php\'>criar um arquivo <code>wp-config.php</code> na interface web</a>. Para isso, � necess�rio que as permiss�es de escrita estejam ativadas (707~777), mas ele pode n�o funcionar em todos os servidores. O jeito mais seguro � cri�-lo manualmente.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>O arquivo \'wp-config.php\' j� existe. Se voc� deseja zerar alguma configura��o neste arquivo, por favor delete-o primeiro.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Desculpe, � preciso de um arquivo wp-config-sample.php para continuar. Por favor, reenvie este arquivo da sua instala��o do WordPress.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Desculpe, n�o � poss�vel escrever no diret�rio. Por favor, d� as permiss�es de escrita ao diret�rio do WordPress ou crie seu wp-config.php manualmente usando o arquivo wp-config-sample.php como refer�ncia.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Bem-vindo ao WordPress. Antes de come�ar, ser�o necess�rias algumas informa��es sobre o banco de dados. Voc� ter� que ter os seguintes dados antes de prosseguir.');
define('_LANG_WA_CONFIG_DATABASE','Nome do banco de dados');
define('_LANG_WA_CONFIG_USERNAME','Usu�rio');
define('_LANG_WA_CONFIG_PASSWORD','Senha');
define('_LANG_WA_CONFIG_LOCALHOST','Hostname');
define('_LANG_WA_CONFIG_PREFIX','Prefixo da tabela');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Se por alguma raz�o a cria��o autom�tica de arquivos n�o funcionar, n�o se preocupe, pois tudo o que ele faz � transferir os dados para um arquivo de configura��o. Voc� tamb�m pode simplesmente abrir o arquivo <code>wp-config-sample.php</code> em um editor de textos, alterar as configura��es, e salv�-lo como <code>wp-config.php</code>. </strong></p><p>Provavelmente, esses dados foram fornecidos � voc� pelo seu provedor. Se voc� n�o tiv�-los, voc� precisar� contat�-los antes de continuar. Caso voc� esteja pronto, clique <a href="install-config.php?step=1">aqui</a>.');
define('_LANG_WA_CONFIG_GUIDE6','Digite abaixo os dados da sua conex�o do banco de dados. Se voc� n�o tiver certeza sobre eles, contate seu host.');
define('_LANG_WA_CONFIG_GUIDE7','<small>O nome do banco de dados onde o WordPress ME ser� instalado. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Nome de Usu�rio do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>Senha do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>Em 99% dos casos, voc� n�o ter� que mudar isso.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Se voc� for rodar v�rias instala��es do WordPress ME em um �nico banco de dados, mude isto.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Pronto! As informa��es necess�rias est�o corretas. WordPress ME estabeleceu uma conex�o com seu banco de dados corretamente. Se estiver pronto, clique <a href="install.php">aqui</a> para instalar.');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>N�o foi poss�vel estabelecer uma conex�o com o banco de dados.</strong>Isso significa que as informa��es da conex�o no seu arquivo <code>wp-config.php</code> podem estar incorretas. Cheque-as e tente novamente.');
define('_LANG_WA_WPDB_GUIDE2','Tem certeza de que o nome de usu�rio/senha est�o corretos?');
define('_LANG_WA_WPDB_GUIDE3','Tem certeza de que voc� o hostname est� correto?');
define('_LANG_WA_WPDB_GUIDE4','Tem certeza de que o servidor do banco de dados est� rodando?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Editar hora');
define('_LANG_F_NEW_COMMENT','Tem um coment�rio novo no seu post');
define('_LANG_F_ALL_COMMENTS','Voc� pode ver todos os coment�rios deste post aqui:');
define('_LANG_F_NEW_TRACKBACK','Tem uma nova trackback no seu post');
define('_LANG_F_ALL_TRACKBACKS','Voc� pode ver todas as trackbacks deste post aqui:');
define('_LANG_F_NEW_PINGBACK','Tem um novo pingback no seu post');
define('_LANG_F_ALL_PINGBACKS','Voc� pode ver todos os pingbacks deste post aqui:');
define('_LANG_F_COMMENT_POST','Tem um novo coment�rio no post');
define('_LANG_F_WAITING_APPROVAL','est� esperando pela sua aprova��o');
define('_LANG_F_APPROVAL_VISIT','Para aprovar este coment�rio:');
define('_LANG_F_DELETE_VISIT','Para deletar este coment�rio:');
define('_LANG_F_PLEASE_VISIT','No momento, existem coment�rios esperando pela sua aprova��o. Por favor, v� para o Painel de Modera��o:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERRO</strong>: Por favor, escolha um nome de usu�rio.');
define('_LANG_R_PASS_TWICE','<strong>ERRO</strong>: Por favor, repita sua senha.');
define('_LANG_R_SAME_PASS','<strong>ERRO</strong>: Por favor, repita a mesma senha nos dois campos.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERRO</strong>: Por favor, digite seu endere�o de e-mail.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERRO</strong>: O endere�o de e-mail � inv�lido.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERRO</strong>: Este nome de usu�rio j� existe. Por favor, escolha outro.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERRO</strong>: N�o foi poss�vel realizar o cadastro. Por favor, contate o administrador.');
define('_LANG_R_USER_REGISTRATION','Novo Usu�rio no seu Blog');
define('_LANG_R_MAIL_REGISTRATION','Novo Cadastro de Usu�rio');
define('_LANG_R_R_COMPLETE','Cadastro Completado');
define('_LANG_R_R_DISABLED','Cadastro Desativado');
define('_LANG_R_R_CLOSED','No momento, n�o s�o aceitos cadastros.');
define('_LANG_R_R_REGISTRATION','Cadastro');
define('_LANG_R_USER_LOGIN','Usu�rio:');
define('_LANG_R_USER_PASSWORD','Senha:');
define('_LANG_R_TWICE_PASSWORD','Repete Senha:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','Preencha o campo nome de usu�rio.');
define('_LANG_L_PASS_EMPTY','Preencha o campo senha.');
define('_LANG_L_WRONG_LOGPASS','O nome de usu�rio ou senha s�o inv�lidos.');
define('_LANG_L_RECEIVE_PASSWORD','Por favor, preencha seus dados e te enviaremos uma nova senha.');
define('_LANG_L_EXIST_SORRY','Este usu�rio n�o existe. Clique <a href="wp-login.php?action=lostpassword">aqui</a> para receber sua senha por e-mail.');
define('_LANG_L_YOUR_LOGPASS','Usu�rio/senha do WordPress');
define('_LANG_L_NOT_SENT','O e-mail n�o p�de ser enviado.');
define('_LANG_L_DISABLED_FUNC','Poss�vel raz�o: seu servidor pode ter desativado a fun��o mail().');

define('_LANG_L_SUCCESS_SEND',' : O e-mail foi enviado com sucesso.');
define('_LANG_L_CLICK_ENTER','Clique aqui para se conectar!');
define('_LANG_L_WRONG_SESSION','Erro: usu�rio/senha inv�lidos');
define('_LANG_L_BACK_BLOG','Voltar ao blog');
define('_LANG_L_WP_RESIST','Cadastrar-se');
define('_LANG_L_WPLOST_YOURPASS','Esqueceu sua senha?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Como voc� � um novato, voc� ter� que esperar at� que um administrador aumente seu n�vel para 1 para poder postar.<br />Voc� tambem pode enviar um e-mail ao administrador pedindo uma promo��o.<br />Quando voc� for promovido, basta atualizar esta p�gina e voc� poder� bloggar.');
define('_LANG_P_DATARIGHT_EDIT',', voc� n�o tem permiss�o para editar posts.');
define('_LANG_P_DATARIGHT_DELETE',', voc� n�o tem permiss�o para deletar posts.');
define('_LANG_P_DATARIGHT_ERROR','Erro ao deletar. Contate o administrador.');
define('_LANG_P_OOPS_IDCOM','N�o existem coment�rios com este ID.');
define('_LANG_P_OOPS_IDPOS','N�o existem posts com este ID.');
define('_LANG_P_ABOUT_FOLLOW','Voc� esta prestes a deletar o seguinte coment�rio:');
define('_LANG_P_SURE_THAT','Tem certeza de que deseja continuar?');
define('_LANG_P_NICKNAME_DELETE','Voc� n�o tem permiss�o para deletar coment�rios de posts.');
define('_LANG_P_COMHAS_APPR','O coment�rio foi aprovado.');
define('_LANG_P_YOUR_DRAFTS','Seus rascunhos:');
define('_LANG_P_WP_BOOKMARKLET','Voc� pode arrastar o link seguinte para sua barra de links ou adicion�-lo ao seus Favoritos. Quando voc� clicar sobre ele, se abrir� uma janela popup com informa��es e um link para o site que voc� esta visitando agora, permitindo que voc� faca um post rapido nele.');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','N�o � poss�vel deletar esta categoria pois ela � a padr�o.');
define('_LANG_C_EDIT_TITLECAT','Editar Categoria');
define('_LANG_C_NAME_SUBCAT','Nome da categoria:');
define('_LANG_C_NAME_SUBDESC','Descri��o:');
define('_LANG_C_RIGHT_EDITCAT','Voc� n�o tem permiss�o para alterar as categorias deste blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_C_NAME_CURRCAT','Categorias Existentes');
define('_LANG_C_NAME_CATNAME','Nome');
define('_LANG_C_NAME_CATDESC','Descri��o:');
define('_LANG_C_NAME_CATPOSTS','N� de Posts');
define('_LANG_C_NAME_CATACTION','A��o');
define('_LANG_C_ADD_NEWCAT','Adicionar Nova Categoria');
define('_LANG_C_NOTE_CATEGORY','<strong>Nota:</strong><br />Deletar uma categoria n�o exclui os posts existentes nela, apenas move-os � categoria-padr�o.');
define('_LANG_C_NAME_EDIT','EDITAR');
define('_LANG_C_NAME_DELETE','DELETAR');
define('_LANG_C_NAME_ADD','Adicionar');
define('_LANG_C_NAME_EDITBTN','Editar Categoria');
define('_LANG_C_NAME_PARENT','Categoria-padr�o:');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','�ltimos Posts');
define('_LANG_E_LATEST_COMMENTS','�ltimos Coment�rios');
define('_LANG_E_AWAIT_MODER','Coment�rios Esperando por Modera��o');
define('_LANG_E_SHOW_POSTS','Mostrar posts:');
define('_LANG_E_TITLE_COMMENTS','Coment�rios');
define('_LANG_E_FILL_REQUIRED','Erro: por favor, preencha os campos obrigat�rios (nome e coment�rio)');
define('_LANG_E_TITLE_LEAVECOM','Deixar Coment�rio');
define('_LANG_E_RESULTS_FOUND','Nenhum resultado foi encontrado.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Mostrar Coment�rio:');
define('_LANG_EC_EDIT_COM','Editar Coment�rio');
define('_LANG_EC_DELETE_COM','Deletar Coment�rio');
define('_LANG_EC_EDIT_POST','Editar Post &#8220;');
define('_LANG_EC_VIEW_POST','Ver Post');
define('_LANG_EC_SEARCH_MODE','Pesquisas dentro dos coment�rios, e-mail, URI e endere�o IP.');
define('_LANG_EC_VIEW_MODE','Modo de Vis�o');
define('_LANG_EC_EDIT_MODE','Modo de Edi��o em Massa');
define('_LANG_EC_CHECK_INVERT','Inverter Caixa de Sele��o');
define('_LANG_EC_CHECK_DELETE','Deletar os Coment�rios Selecionados');
define('_LANG_EC_LINK_VIEW','Ver');
define('_LANG_EC_LINK_EDIT','Editar');
define('_LANG_EC_LINK_DELETE','Deletar');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><strong>Fazer PingBack</strong> nas <acronym title="Uniform Resource Locators">URL</acronym>s dos posts</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Ajuda com Pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Ajuda com trackbacks"><strong>Fazer TrackBack</strong> numa <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Separar m�ltiplas <acronym title="Uniform Resource Locator">URL</acronym>s por espa�os.)<br />');
define('_LANG_EF_AD_POSTTITLE','T�tulo');
define('_LANG_EF_AD_CATETITLE','Categorias');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Salvar como Rascunho');
define('_LANG_EF_AD_PRIVATE','Salvar como Particular');
define('_LANG_EF_AD_PUBLISH','Publicar');
define('_LANG_EF_AD_EDITING','Edi��o Avan�ada &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Estado do Post');
define('_LANG_EFA_AD_COMMENTS','Coment�rios');
define('_LANG_EFA_AD_PINGS','Pings');
define('_LANG_EFA_POST_PASSWORD','Senha');
define('_LANG_EFA_POST_EXCERPT','Trecho');
define('_LANG_EFA_POST_LATITUDE','Latitude:');
define('_LANG_EFA_POST_LONGITUDE','Longitude:');
define('_LANG_EFA_POST_GEOINFO','Clique aqui para Geo Info');
define('_LANG_EFA_DEL_THISPOST','Deletar este post');
define('_LANG_EFA_SAVE_CONTINUE','Salvar e Continuar Editando');
define('_LANG_EFA_STATUS_OPEN','Aberto');
define('_LANG_EFA_STATUS_CLOSE','Fechado');
define('_LANG_EFA_STATUS_UPLOAD','Enviar um arquivo ou imagem');
define('_LANG_EFA_STATUS_DISCUSS','Discuss�o');
define('_LANG_EFA_STATUS_ALLOWC','Permitir Coment�rios');
define('_LANG_EFA_STATUS_ALLOWP','Permitir Pings');
define('_LANG_EFA_STATUS_SLUG','Separador de Post');
define('_LANG_EFA_STATUS_POST','Postar');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Enviar');
define('_LANG_EFC_COM_NAME','Nome:');
define('_LANG_EFC_COM_MAIL','E-Mail:');
define('_LANG_EFC_COM_URI','Website:');
define('_LANG_EFC_COM_COMMENT','Coment�rio:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','Gerenciar Links');
define('_LANG_WLA_ADD_LINK','Adicionar Link');
define('_LANG_WLA_LINK_CATE','Categorias de Links');
define('_LANG_WLA_IMPORT_BLOG','Importar Blogroll');
define('_LANG_WLA_LINK_TITLE','<strong>Adicionar</strong> um link:');
define('_LANG_WLA_SUB_URI','URL:');
define('_LANG_WLA_SUB_NAME','Nome do Link:');
define('_LANG_WLA_SUB_IMAGE','Imagem');
define('_LANG_WLA_SUB_RSS','RSS URL: ');
define('_LANG_WLA_SUB_DESC','Descri��o');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','Notas:');
define('_LANG_WLA_SUB_RATE','Classifica��o:');
define('_LANG_WLA_SUB_TARGET','P�blico');
define('_LANG_WLA_SUB_VISIBLE','Vis�vel:');
define('_LANG_WLA_SUB_CAT','Categoria:');
define('_LANG_WLA_SUB_FRIEND','amizades');
define('_LANG_WLA_SUB_PHYSICAL','fisica');
define('_LANG_WLA_SUB_PROFESSIONAL','profissional');
define('_LANG_WLA_SUB_GEOGRAPH','geogr�fica');
define('_LANG_WLA_SUB_FAMILY','familiar');
define('_LANG_WLA_SUB_ROMANTIC','rom�ntica');
define('_LANG_WLA_CHECK_ACQUA','conhecidos');
define('_LANG_WLA_CHECK_FRIE','amigos');
define('_LANG_WLA_CHECK_NONE','nenhum');
define('_LANG_WLA_CHECK_MET','encontros');
define('_LANG_WLA_CHECK_WORKER','s�cios');
define('_LANG_WLA_CHECK_COLL','colegas');
define('_LANG_WLA_CHECK_RESI','colegas de quarto');
define('_LANG_WLA_CHECK_NEIG','vizinhos');
define('_LANG_WLA_CHECK_CHILD','crian�as');
define('_LANG_WLA_CHECK_PARENT','pais');
define('_LANG_WLA_CHECK_SIBLING','irm�os');
define('_LANG_WLA_CHECK_SPOUSE','esposa');
define('_LANG_WLA_CHECK_MUSE','musa');
define('_LANG_WLA_CHECK_CRUSH','esmagamento');
define('_LANG_WLA_CHECK_DATE','encontro');
define('_LANG_WLA_CHECK_HEART','namorados');
define('_LANG_WLA_CHECK_ZERO','Deixe em 0 para nenhuma classifica��o.');
define('_LANG_WLA_CHECK_STRICT','Note que o c�digo do atributo <code>target</code> � ilegal em XHTML 1.1 e restrito � 1.0.');
define('_LANG_WLA_TEXT_TOOLBAR','Voc� pode arrastar "Link This" para sua barra de tarefas. Ao clic�-la, uma janela pop-up permitir� � voc� adicionar qualquer site em que voc� estiver aos seus links. (No momento, funciona apenas no Mozilla ou Netscape)');
define('_LANG_WLA_BUTTON_TEXTNAME','Adicionar Link');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','N�o � poss�vel deletar esta categoria de link pois ela � a padr�o.');
define('_LANG_WLC_TITLE_TEXT','Editar Categorias de Link &#8220;');
define('_LANG_WLC_EPAGE_TITLE','<strong>Editar</strong> uma categoria de link:');
define('_LANG_WLC_ADD_TITLE','Adicionar uma Categoria de Link:');
define('_LANG_WLC_SUBEDIT_NAME','Nome:');
define('_LANG_WLC_SUBEDIT_TOGGLE','Auto-toggle?');
define('_LANG_WLC_SUBEDIT_SHOW','Mostrar:');
define('_LANG_WLC_SUBEDIT_ORDER','Ordem de exibi��o:');
define('_LANG_WLC_SUBEDIT_IMAGES','imagens');
define('_LANG_WLC_SUBEDIT_DESC','descri��o');
define('_LANG_WLC_SUBEDIT_RATE','classifica��o');
define('_LANG_WLC_SUBEDIT_UPDATE','atualizado');
define('_LANG_WLC_SUBEDIT_SORT','Ordenar por:');
define('_LANG_WLC_SUBEDIT_DESCEND','Descende de?');
define('_LANG_WLC_SUBEDIT_BEFORE','Antes:');
define('_LANG_WLC_SUBEDIT_BETWEEN','Entre:');
define('_LANG_WLC_SUBEDIT_AFTER','Depois:');
define('_LANG_WLC_SUBEDIT_LIMIT','Limite:');
define('_LANG_WLC_ADDBUTTON_TEXT','Enviar');
define('_LANG_WLC_SAVEBUTTON_TEXT','Salvar');
define('_LANG_WLC_CANCELBUTTON_TEXT','Cancelar');
define('_LANG_WLC_SUBCATE_NAME','Nome');
define('_LANG_WLC_SUBCATE_ATT','Auto-Toggle?');
define('_LANG_WLC_SUBCATE_SHOW','Mostrar');
define('_LANG_WLC_SUBCATE_SORT','Ordem de Exibi��o ');
define('_LANG_WLC_SUBCATE_DESC','Descende de?');
define('_LANG_WLC_SUBCATE_LIMIT','Limite');
define('_LANG_WLC_SUBCATE_IMAGES','imagens?');
define('_LANG_WLC_SUBCATE_MINIDESC','descende de?');
define('_LANG_WLC_SUBCATE_RATE','classifica��o?');
define('_LANG_WLC_SUBCATE_UPDATE','atualiza��o?');
define('_LANG_WLC_SUBCATE_BEFORE','antes');
define('_LANG_WLC_SUBCATE_BETWEEN','entre');
define('_LANG_WLC_SUBCATE_AFTER','depois');
define('_LANG_WLC_SUBCATE_EDIT','Editar');
define('_LANG_WLC_SUBCATE_DELETE','Deletar');
define('_LANG_WLC_SUBEDIT_EMPTY','Quantos links ser�o mostrados. Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_EMPTY','Deixe em branco para ilimitados');
define('_LANG_WLC_EPAGE_NOTE','Deletar uma categoria de links n�o remove os links contidos nela, apenas move-os a categoria-padr�o:');
define('_LANG_WLC_RIGHT_PROM','Voc� n�o tem permiss�o para editar as categorias de links deste blog.<br>Pe�a uma promo��o ao administrador do blog.');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Importar Blogroll');
define('_LANG_WLI_ROLL_DESC','Importar sua blogroll de outro sistema ');
define('_LANG_WLI_ROLL_OPMLCODE','V� em Blogrolling.com e conecte-se. Depois, clique em <strong>Get Code</strong>, e procure pelo <strong>codigo <abbr title="Outline Processor Markup Language">OPML</abbr></strong>');
define('_LANG_WLI_ROLL_OPMLLINK','Ou v� em Blo.gs e conecte-se. Depois, na caixa &#8217;Welcome Back&#8217; da direita, clique em <strong>share</strong>, e ent�o procure pelo <strong>link <abbr title="Outline Processor Markup Language">OPML</abbr></strong> (favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','Selecione o texto e copie-o, ou copie o atalho para esta caixa abaixo.');
define('_LANG_WLI_ROLL_YOURURL','Sua URL OPML:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>ou</strong> voc� pode enviar seu arquivo OPML da sua �rea de Trabalho:');
define('_LANG_WLI_ROLL_THISFILE','Enviar arquivo: ');
define('_LANG_WLI_ROLL_CATEGORY','Agora, escolha a categoria onde voc� deseja inserir estes links.<br />Categoria: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','Enviar');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Gerenciar Links');
define('_LANG_WLM_LEVEL_ERROR','Voc� n�o tem permiss�o para editar os links para este blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WLM_SHOW_LINKS','<strong>Mostrar</strong> links por categorias:');
define('_LANG_WLM_ORDER_BY','<strong>Ordenar</strong> por:');
define('_LANG_WLM_SHOW_BUTTONTEXT','Mostrar');
define('_LANG_WLM_SHOW_ACTIONTEXT','A��o');
define('_LANG_WLM_MULTI_LINK','Gerenciar Links M�ltiplos:');
define('_LANG_WLM_CHECK_CHOOSE','Use as caixas de sele��o da direita para selecionar v�rios links e escolha uma a��o abaixo:');
define('_LANG_WLM_ASSIGN_TEXT','Assignar');
define('_LANG_WLM_OWNER_SHIP','pertence a:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibilidade');
define('_LANG_WLM_MOVE_TEXT','Mover');
define('_LANG_WLM_TO_CATEGORY',' para categoria');
define('_LANG_WLM_TOGGLE_BOXES','Caixas de Sele��o Toggle');
define('_LANG_WLM_EDIT_LINK','Editar um link:');
define('_LANG_WLM_SAVE_CHANGES','Enviar');
define('_LANG_WLM_EDIT_CANCEL','Cancelar');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Seu n�vel n�o � alto o suficiente para moderar coment�rios. Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Coment�rios');
define('_LANG_WPM_AWIT_MODERATION','Esperando por Modera��o');
define('_LANG_WPM_COM_APPROV',' coment�rio aprovado ');
define('_LANG_WPM_COMS_APPROVS',' coment�rios aprovados ');
define('_LANG_WPM_COM_DEL',' coment�rio deletado ');
define('_LANG_WPM_COMS_DELS',' coment�rios deletados ');
define('_LANG_WPM_COM_UNCHANGE',' coment�rio inalterado ');
define('_LANG_WPM_COMS_UNCHANGES',' coment�rios inalterados ');
define('_LANG_WPM_WAIT_APPROVAL','Os seguintes coment�rios est�o a espera de aprova��o:');
define('_LANG_WPM_CURR_COMAPP','No momento, n�o existem coment�rios a serem aprovados.');
define('_LANG_WPM_DEL_LATER','<p>Para cada coment�rio voc� deve escolher entre <em>aprovar</em>, <em>deletar</em> ou <em>deixar para depois</em>:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>aprovar</em>: aprova o coment�rio, ent�o ele ser� vis�vel publicamente.');
define('_LANG_WPM_AUTHOR_NOTIFIED','o autor do post ser� notificado sobre o novo coment�rio em seu post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>deletar</em>: remove o conte�do do blog (nota: voc� n�o ser� consultado novamente, ent�o voc� deve ter certeza de que deseja realmente remover o coment�rio - uma vez deletados, n�o poder�o ser recuperados!)</p><p><em>deiar para depois</em>: n�o muda o estado dos coment�rios.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderar Coment�rios');
define('_LANG_WPM_DO_NOTHING','N�o fazer nada');
define('_LANG_WPM_DO_DELETE','Deletar');
define('_LANG_WPM_DO_APPROVE','Aprovar');
define('_LANG_WPM_DO_ACTION','A��o:');
define('_LANG_WPM_JUST_THIS','Deletar apenas este coment�rio');
define('_LANG_WPM_JUST_EDIT','Editar');
define('_LANG_WPM_COMPOST_NAME','Nome:');
define('_LANG_WPM_COMPOST_MAIL','E-mail:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Voc� n�o tem permiss�o para editar as op��es deste blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Configura��es de Links Permanentes');
define('_LANG_WOP_NO_HELPS',' N�o existem t�picos de ajuda para este grupo de op��es.');
define('_LANG_WOP_SUBMIT_TEXT','Enviar');
define('_LANG_WOP_SETTING_SAVED',' Configura��es salvas com sucesso. ');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_STRUCT','Editar Estrutura dos Permalink');
define('_LANG_WPL_CREATE_CUSTOM','WordPress oferece � voc� a possibilidade de criar uma estrutura URI para os seus permalinks e arquivos. As seguintes &#8220;tags&#8221; est�o dispon�veis:');
define('_LANG_WPL_CODE_YEAR','O ano, com 4 digitos. Ex.: <code>2004</code>.');
define('_LANG_WPL_CODE_MONTH','O m�s do ano. Ex.: <code>05</code>.');
define('_LANG_WPL_CODE_DAY','O dia do m�s. Ex.: <code>28</code>.');
define('_LANG_WPL_CODE_POSTNAME','Uma vers�o limpa do t�tulo do post. Ex.: "This Is A Great Post!" vira "this-is-a-great-post" no URI.');
define('_LANG_WPL_CODE_POSTID','O N� ID �nico do post. Ex.: <code>423</code>.');
define('_LANG_WPL_USE_EXAMPLE','Um valor como <code>/archives/%year%/%monthnum%/%day%/%postname%/</code> daria um permalink como <code>/archives/2003/05/23/my-cheese-sandwich/</code>. Para que isso funcione, voc� dever� ter o mod_rewrite instalado em seu servidor para a cria��o de regras funcionar abaixo. No futuro, poder�o haver mais op��es.');
define('_LANG_WPL_USE_TEMPTEXT','Use as tags de templates acima:');
define('_LANG_WPL_BEFORE_HTACCESS','Usando o valor da estrutura do permalink, no momento voc� tem, ');
define('_LANG_WPL_AFTER_HTACCESS',' estas s�o as regras do mod_rewrite que voc� deve ter em seu arquivo <code>.htaccess</code>.');
define('_LANG_WPL_MOD_REWRITE','No momento, voc� n�o esta usando permalinks personalizados. Nenhuma regra especifica do mod_rewrite � necess�ria.');
define('_LANG_WPL_SUBMIT_UPDATE','Enviar');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERRO</strong>: por favor, digite seu nick (pode ser o mesmo que o seu nome de usu�rio).');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERRO</strong>: seu ICQ UIN deve conter apenas n�meros, letras n�o s�o permitidas.');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERRO</strong>: por favor, digite seu e-mail.');
define('_LANG_WPF_ERR_CORRECT','<strong>ERRO</strong>: o endere�o de e-mail � inv�lido.');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERRO</strong>: voc� digitou sua senha apenas uma vez. Volte e digite-a novamente.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERRO</strong>: voc� digitou duas senhas diferentes. Volte e corrija-a.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERRO</strong>: n�o foi poss�vel atualizar seu perfil. Por favor, contate o administrador.');
define('_LANG_WPF_SUBT_VIEW','Ver Perfil');
define('_LANG_WPF_SUBT_FIRST','Nome:');
define('_LANG_WPF_SUBT_LAST','Sobrenome:');
define('_LANG_WPF_SUBT_NICK','Nick:');
define('_LANG_WPF_SUBT_MAIL','E-mail:');
define('_LANG_WPF_SUBT_URL','Website:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','IE one-click bookmarklet');
define('_LANG_WPF_SUBT_COPY','Para ter um one-click bookmarklet, basta copiar e<br />colar isso em um arquivo de texto:');
define('_LANG_WPF_SUBT_BOOK','Salve-o como wordpress.reg, e clique duas vezes nele numa janela do Explorer.<br />Responda Sim a pergunta, e reinicie o Internet Explorer.<br /><br />Assim, voc� pode clicar com o bot�o direito numa janela do Internet Explorer<br />e selecionar "Postar no WP".');
define('_LANG_WPF_SUBT_CLOSE','Fechar esta janela');
define('_LANG_WPF_SUBT_UPDATED','Perfil atualizado com sucesso.');
define('_LANG_WPF_SUBT_EDIT','Editar Seu Perfil');
define('_LANG_WPF_SUBT_USERID','ID:');
define('_LANG_WPF_SUBT_LEVEL','N�vel:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Usu�rio:');
define('_LANG_WPF_SUBT_DESC','Perfil:');
define('_LANG_WPF_SUBT_IDENTITY','Identidade no blog: ');
define('_LANG_WPF_SUBT_NEWPASS','Nova <strong>Senha</strong> (Deixe em branco para manter a mesma.)');
define('_LANG_WPF_SUBT_MOZILLA','Nenhuma SideBar encontrada. Voc� deve ter Mozilla 0.9.4 ou superior.');
define('_LANG_WPF_SUBT_SIDEBAR','SideBar');
define('_LANG_WPF_SUBT_FAVORITES','Adicionar este link aos Favoritos:');
define('_LANG_WPF_SUBT_UPDATE','Atualizar');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Post enviado com sucesso.');
define('_LANG_WAS_SIDE_AGAIN','Clique <a href="sidebar.php">aqui</a> para postar novamente.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>Voc� n�o tem permiss�o para editar o template deste blog.<br />Pe�a uma promo��o ao administrador do blog.</p>');
define('_LANG_WAT_SORRY_EDIT','Desculpe, n�o � poss�vel editar arquivos com ".." no nome. Se voc� estiver tentando editar um arquivo no diretorio raiz do seu WordPress, voc� deve digitar apenas o nome dele.');
define('_LANG_WAT_SORRY_PATH','Desculpe, n�o e poss�vel chamar arquivos pelo seu caminho real.');
define('_LANG_WAT_EDITED_SUCCESS','<em>Arquivo editado com sucesso.</em>');
define('_LANG_WAT_FILE_CHMOD','Voc� n�o pode editar esse arquivo/template. Ele ter permiss�o de escrita. Ex.: CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Esse arquivo n�o existe! Por favor, cheque-o e tente novamente.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Para editar um arquivo, digite seu nome aqui. Voc� pode editar qualquer arquivo com permiss�o de escrita. Ex.: CHMOD 766.</p>');
define('_LANG_WAT_TYPE_HERE','Para editar um arquivo, digite seu nome aqui.');
define('_LANG_WAT_FTP_CLIENT','Nota: � claro, voc� pode editar os arquivos/templates no editor de textos de sua escolha e envi�-los. Este editor on-line s� deve ser usado caso voc� n�o tem um editor de textos ou cliente de FTP.');
define('_LANG_WAT_UPTEXT_TEMP','Enviar');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','Esta op��o foi desativada pelo administrador.');
define('_LANG_WAU_FILE_UPLOAD','Enviar Arquivo');
define('_LANG_WAU_CAN_TYPE','Extens�es Permitidas:');
define('_LANG_WAU_MAX_SIZE','Tamanho M�ximo:');
define('_LANG_WAU_FILE_DESC','Descri��o da Imagem:');
define('_LANG_WAU_BUTTON_TEXT','Enviar');
define('_LANG_WAU_ATTACH_ICON','File attachment ICON only');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','N�o � poss�vel alterar o n�vel de um usu�rio cujo n�vel � maior que o seu.');
define('_LANG_WUS_WHOSE_DELETE','N�o � poss�vel deletar um usu�rio cujo n�vel � maior que o seu.');
define('_LANG_WUS_CANNOT_DELU','N�o � poss�vel deletar esse usu�rio');
define('_LANG_WUS_CANNOT_DELUPOST','N�o � poss�vel deletar os posts desse usu�rio');
define('_LANG_WUS_AU_THOR','Autores');
define('_LANG_WUS_AU_NICK','Nick');
define('_LANG_WUS_AU_NAME','Nome');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','N�vel');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','Usu�rios');
define('_LANG_WUS_AU_WARNING','Para deletar um usu�rio, mude seu n�vel para 0, e ent�o clique no X vermelho.<br /><strong>Aten��o:</strong> deletar um usu�rio tamb�m remove todos os posts feitos por ele.');
define('_LANG_WUS_ADD_USER','Adicionar Usu�rio');
define('_LANG_WUS_ADD_THEMSELVES','Os usu�rios podem se registrar por si mesmos ou voc� pode criar usu�rios manualmente por aqui.');
define('_LANG_WUS_ADD_FIRST','Nome');
define('_LANG_WUS_ADD_LAST','Sobrenome');
define('_LANG_WUS_ADD_TWICE','Senha (duas vezes)');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Por favor, n�o acesse esta pagina diretamente. Obrigado!');
define('_LANG_WPCM_ENTER_PASS','<p>Digite sua senha para ver os coment�rios.<p>');
define('_LANG_WPCM_COM_TITLE','Coment�rios');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> feed dos coment�rios');
define('_LANG_WPCM_COM_TRACK','<acronym title="Uniform Resource Identifier">URL</acronym> da TrackBack:');
define('_LANG_WPCM_COM_YET','Ainda n�o existem coment�rios.');
define('_LANG_WPCM_COM_LEAVE','Deixar um Coment�rio');
define('_LANG_WPCM_HTML_ALLOWED','Par�grafos e quebra-linhas autom�ticos; websites substituem e-mails; <acronym title="Hypertext Markup Language">HTML</acronym> permitido.');
define('_LANG_WPCM_COM_YOUR','Seu Coment�rio');
define('_LANG_WPCM_PLEASE_NOTE','<strong>Por favor, note:</strong> A modera��o de coment�rios est� ativada, portanto pode haver algum atraso entre quando voc� enviar seu coment�rio e quando ele aparecer. Paci�ncia � uma virtude, n�o h� necessidade de re-envi�-lo.');
define('_LANG_WPCM_COM_SAYIT','Enviar');
define('_LANG_WPCM_THIS_TIME','Desculpe, mas os coment�rios est�o fechados no momento.');
define('_LANG_WPCM_GO_BACK','Voltar');
define('_LANG_WPCM_COM_NAME','Nome');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Desculpe, os coment�rios est�o fechados para este �tem.');
define('_LANG_WPCP_ERR_FILL','Erro: por favor, preencha os campos obrigat�rios (nome e e-mail).');
define('_LANG_WPCP_ERR_TYPE','Erro: por favor, escreva um coment�rio.');
define('_LANG_WPCP_SORRY_SECONDS','Desculpe, voc� so pode fazer um novo coment�rio ap�s 10 segundos.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','Esta op��o foi desativada pelo administrador.');
define('_LANG_WAU_UPLOAD_DIRECTORY','Voc� n�o pode enviar arquivos pois o diretorio que voc� especificou n�o tem permiss�o de escrita pelo WordPress. Cheque as permiss�es dos diret�rios ou erros.');
define('_LANG_WAU_UPLOAD_EXTENSION','Voc� pode enviar arquivos com as extens�es: ');
define('_LANG_WAU_UPLOAD_BYTES','Desde que n�o sejam maiores que <abbr title="Kilobytes">KB</abbr>: ');
define('_LANG_WAU_UPLOAD_OPTIONS','Se voc� for um administrador, pode configurar esses valores em <a href="options.php?option_group_id=4">op��es</a>.');
define('_LANG_WAU_UPLOAD_FILE','Arquivo:');
define('_LANG_WAU_UPLOAD_ALT','Descri��o:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Criar miniatura?');
define('_LANG_WAU_UPLOAD_NO','N�o');
define('_LANG_WAU_UPLOAD_SMALL','Pequena (200px larg. m�x.)');
define('_LANG_WAU_UPLOAD_LARGE','Grande (400px larg. m�x.)');
define('_LANG_WAU_UPLOAD_CUSTOM','Tamanho personalizado');
define('_LANG_WAU_UPLOAD_PX','px (larg. m�x.)');
define('_LANG_WAU_UPLOAD_BTN','Enviar Arquivo');
define('_LANG_WAU_UPLOAD_SUCCESS','Seu arquivo foi enviado com sucesso: ');
define('_LANG_WAU_UPLOAD_CODE','Aqui est� o c�digo para mostr�-lo:');
define('_LANG_WAU_UPLOAD_START','Enviar');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplicar Arquivo?');
define('_LANG_WAU_UPLOAD_EXISTS','Esse arquivo j� existe: ');
define('_LANG_WAU_UPLOAD_RENAME','Confirmar ou renomear:');
define('_LANG_WAU_UPLOAD_ALTER','Nome alternativo:');
define('_LANG_WAU_UPLOAD_REBTN','Renomear');
define('_LANG_WAU_UPLOAD_CODEIN','Inserir c�digo no formul�rio');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Associate');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Voc� n�o tem permiss�o o suficiente para editar as op��es para este blog.');
define('_LANG_WAO_GENERAL_WPTITLE','T�tulo do Weblog:');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Endere�o do Site (URL):');
define('_LANG_WAO_GENERAL_MAIL','Endere�o de E-mail:');
define('_LANG_WAO_GENERAL_MEMBER','Usu�rio:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">Fuso hor�rio</acronym>:');
define('_LANG_WAO_GENERAL_DIFFER','Diferen�a de horas:');
define('_LANG_WAO_GENERAL_EXPLIAIN','Descreva o blog em poucas palavras.');
define('_LANG_WAO_GENERAL_ADMIN','Este endere�o � usado apenas para quest�es administrativas.');
define('_LANG_WAO_GENERAL_REGISTER','Algu�m pode registrar');
define('_LANG_WAO_GENERAL_ARTICLES','Permitir a qualquer usu�rio cadastrado postar artigos');
define('_LANG_WAO_GENERAL_UPDATE','Enviar');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Voc� n�o tem permiss�o para editar as op��es para este blog.');
define('_LANG_WAO_WRITING_TITLE','Op��es de Escrita');
define('_LANG_WAO_WRITING_SIMPLE','Controles simples');
define('_LANG_WAO_WRITING_ADVANCED','Controles avan�ados');
define('_LANG_WAO_WRITING_LINES','linhas');
define('_LANG_WAO_WRITING_DISPLAY','Converter emoticons como :-) e :-P em gr�ficos');
define('_LANG_WAO_WRITING_XHTML','Detectar codigos XHTML inv�lidos automaticamente');
define('_LANG_WAO_WRITING_CHARACTER','Codifica��o (UTF-8 recomendado)');
define('_LANG_WAO_WRITING_STYLE','Quando come�ar um post, mostrar:');
define('_LANG_WAO_WRITING_BOX','Tamanho da caixa de texto:');
define('_LANG_WAO_WRITING_FORMAT','Formata��o:');
define('_LANG_WAO_WRITING_ENCODE','Codifica��o:');
define('_LANG_WAO_WRITING_SERVICES','Atualizar Servi�os');
define('_LANG_WAO_WRITING_SOMETHING','Digite os sites que voc� gost�ria de notificar quando publicar um novo texto. Para uma lista de sites recomendados a pingar, por favor veja [LINK TO SOMETHING]. Separar URIs m�ltiplos por quebra-linhas.');
define('_LANG_WAO_WRITING_UPDATE','Enviar');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Op��es de Discuss�o');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Configura��es-padr�o para um artigo: <em>(Essas configura��es podem ser sobrepostas por artigos individuais.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Tentar notificar algum Weblogs linkado sobre o artigo. (Deixa os posts mais lentos.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Aceitar notifica��o de outros Weblogs. (Pingbacks e trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Permitir que coment�rios sejam enviados nos artigos');
define('_LANG_WAO_DISCUSS_EMAIL','Contatar-me quando:');
define('_LANG_WAO_DISCUSS_ANYONE','Algu�m postar um coment�rio');
define('_LANG_WAO_DISCUSS_DECLINED','Um coment�rio for aceito ou rejeitado');
define('_LANG_WAO_DISCUSS_APPEARS','Antes que um coment�rio apare�a:');
define('_LANG_WAO_DISCUSS_ADMIN','Um administrador deve aprovar o coment�rio (independente de qualquer op��o acima)');
define('_LANG_WAO_DISCUSS_MODERATION','Quando um coment�rio tiver alguma dessas palavras em seu conte�do, nome, URI, ou e-mail, coloc�-lo na fila de modera��o: (Separar novas palavras por quebra-linha.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Op��es de Leitura');
define('_LANG_WAO_READING_FRONT','Pagina Frontal');
define('_LANG_WAO_READING_RECENT','Mostrar os mais recentes:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','Para cada artigo, mostrar:');
define('_LANG_WAO_READING_ENCODE','Codifica��o para paginas e feeds:');
define('_LANG_WAO_READING_CHARACTER','A codifica��o usada no seu blog (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 recomendado</a>)');
define('_LANG_WAO_READING_GZIP','WordPress deve comprimir os artigos (gzip) caso os visitantes pe�am por eles');
define('_LANG_WAO_READING_BTNTXT','Enviar');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','Voc� n�o tem permiss�o para realizar esta opera��o.');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','O arquivo wp-config.php n�o existe. Ele � necess�rio para instalar o WordPress ME. Precisa de ajuda? Clique <a href=\'http://wordpress.org/docs/faq/#wp-config\'>aqui</a>. Voc� pode <a href=\'wp-admin/install-config.php\'>criar um arquivo <code>wp-config.php</code> na interface web</a>. Para isso, � necess�rio que as permiss�es de escrita estejam ativadas (707~777), mas ele pode n�o funcionar em todos os servidores. O jeito mais seguro � cri�-lo manualmente.');
define('_LANG_INST_GUIDE_INSTALLED','<p>O WordPress j� est� instalado. Se voc� quiser reinstal�-lo, por favor apague as informa��es antigas.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Bem-vindo ao WordPress. Voc� ter� que passar por algumas etapas antes de ter rodando a �ltima em plataformas de publica��o pessoal. Antes de come�armos, lembre-se de que � necess�ria pelo menos a vers�o 4.0.6 do PHP.');
define('_LANG_INST_GUIDE_COM','Voc� tamb�m deve setar as configura��es do banco de dados no <code>wp-config.php</code>. Voc� deve alterar a permiss�o do arquivo weblogs.com.changes.cache para 666.<br />Veja o leia-me <a href="../wp-readme/">aqui</a>.</p> Se voc� estiver pronto, clique <a href="install.php?step=1">aqui</a>! ');
define('_LANG_INST_STEP1_FIRST','<p>Certo, primeiro vamos configurar o banco de dados de links. Isso te permitir� hospedar seu pr�prio blogroll completo, com atualiza��es do Weblogs.com.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Instalando WP-Links.</p><p>Checando as tabelas...</p>');
define('_LANG_INST_STEP1_ALLDONE','Perfeito! Voc� est� pronto para o <a href="install.php?step=2">2� Passo</a>.');
define('_LANG_INST_STEP2_INFO','Primeiro, iremos criar as tabelas necess�rias para o blog no banco de dados...');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','siteurl � a URL do seu blog. Ex.: \'http://exemplo.com.br/wordpress\'. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE2','blogfilename � o nome do arquivo-padr�o para o seu blog.');
define('_LANG_INST_BASE_VALUE3','blogname � o nome do seu blog.');
define('_LANG_INST_BASE_VALUE4','blogdescription � a descri��o do seu blog.');
define('_LANG_INST_BASE_VALUE7','Voc� deseja que novos usu�rios possam postar depois de cadastrados?');
define('_LANG_INST_BASE_VALUE8','Voc� deseja que os visitantes possam se cadastrar no seu blog?');
define('_LANG_INST_BASE_VALUE54','Seu e-mail');
// general blog setup
define('_LANG_INST_BASE_VALUE9','O dia em que a semana come�a.');
define('_LANG_INST_BASE_VALUE11','Usar BBCode. Ex.: [b]negrito[/b].');
define('_LANG_INST_BASE_VALUE12','Usar GreyMatter-styles. Ex.: **negrito** \\\\it�lico\\\\ __sublinhado__.');
define('_LANG_INST_BASE_VALUE13','Ativar bot�es para HTML tags. (Ainda n�o funcionam no IE do Mac)');
define('_LANG_INST_BASE_VALUE14','IMPORTANTE: ative isso caso esteja usando Chin�s, Japan�s, Coreano, ou outras l�nguas multi-bytes.');
define('_LANG_INST_BASE_VALUE15','Isso deve ajudar a equilibrar o c�digo HTML. Se ele der maus resultados, desative-o.');
define('_LANG_INST_BASE_VALUE16','Ative isso para ligar a convers�o de smiley nos seus posts (NOTA: ela � feita em TODOS os posts)');
define('_LANG_INST_BASE_VALUE17','O diret�rio onde os smileys est�o. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE18','Ative isso para fazer de e-mail and nome campos obrigat�rios, ou desative para permitir coment�rios sem eles.');
define('_LANG_INST_BASE_VALUE20','Ative isso para que cada autor seja notificado de novos coment�rios em seus posts.');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','N�mero de �ltimos posts para sindicar.');
define('_LANG_INST_BASE_VALUE22','O idioma do seu blog ( veja http://backend.userland.com/stories/storyReader$16 )');
define('_LANG_INST_BASE_VALUE23','Permitir HTML codificado na tag &lt;description> do b2rss.php?');
define('_LANG_INST_BASE_VALUE24','Tamanho dos excerpts no RSS feed? (0=ilimitado) NOTA: no b2rss.php, ele ser� desativado caso voc� use HTML codificado');
define('_LANG_INST_BASE_VALUE25','Usar o campo excerpt para RSS feed.');
define('_LANG_INST_BASE_VALUE26','Ative isso caso voc� queira que seu blog seja listado em http://weblogs.com quando voc� fizer um novo post.');
define('_LANG_INST_BASE_VALUE27','Ative isso caso voc� queira que seu site seja listado em http://blo.gs quando voc� fizer um novo post');
define('_LANG_INST_BASE_VALUE28','Voc� n�o deve precisar mudar isso.');
define('_LANG_INST_BASE_VALUE29','Ative isso para permitir trackbacks nos seus posts. Desativando-o, o envio de trackbacks tamb�m � desligado.');
define('_LANG_INST_BASE_VALUE30','Ative isso para permitir pingbacks nos seus posts. NOTA: Desativando-o, o envio de pingbacks tamb�m � desligado.');
define('_LANG_INST_BASE_VALUE31','Ative isso para ligar o envio de arquivos.');
define('_LANG_INST_BASE_VALUE32','Digite o caminho real do diret�rio onde as imagens ser�o enviadas. Se n�o tiver certeza do que � isso, por favor contate seu hosting. NOTA: o diret�rio deve ter permiss�o de escrita pelo servidor (chmod 766). Para usu�rios de servidores Windows: use a barra normal ao inv�s da invertida');
define('_LANG_INST_BASE_VALUE33','Digite a URL do diret�rio. Ela ser� usada para gerar os links para as imagens enviadas.');
define('_LANG_INST_BASE_VALUE34','Extens�es de arquivos permitidas, separadas por espa�o. Ex.: \'jpg gif png\'');
define('_LANG_INST_BASE_VALUE35','Por padr�o, a maioria dos servidores o envio de arquivos � 2048 KB. Se quiser colocar um valor menor, mude isso. (Voc� n�o poder� colocar um valor maior do que o limite do seu servidor)');
define('_LANG_INST_BASE_VALUE36','Caso n�o queira permitir todos os usu�rios a enviar arquivos, escolha um n�vel m�nimo,');
define('_LANG_INST_BASE_VALUE37','Ou voc� pode permitir apenas alguns usu�rios. Digite seus nomes de usu�rio, separados por espa�o. Ex.: \'barbara anne george\'. Se voc� deixar esta vari�vel em branco, todos os usu�rios com o n�vel m�nimo poder�o enviar arquivos.');
/* email settings */
define('_LANG_INST_BASE_VALUE38','Configura��es do Servidor de Correio');
define('_LANG_INST_BASE_VALUE39','Configura��es do Servidor de Correio');
define('_LANG_INST_BASE_VALUE40','Configura��es do Servidor de Correio');
define('_LANG_INST_BASE_VALUE41','Configura��es do Servidor de Correio');
define('_LANG_INST_BASE_VALUE42','Por padr�o, os posts ter�o esta categoria.');
define('_LANG_INST_BASE_VALUE43','Prefixo do Assunto');
define('_LANG_INST_BASE_VALUE44','Body Terminator String (a partir disso, tudo ser� ignorado, inclusive o string)');
define('_LANG_INST_BASE_VALUE45','Ative isso para rodar em modo de teste.');
define('_LANG_INST_BASE_VALUE46','Alguns servi�os de mensagens celulares mandam assunto e conte�do ind�nticos na mesma linha. Se voc� usa esses servi�os, ative o use_phoneemail, e indique o string separador.');
define('_LANG_INST_BASE_VALUE47','Quando voc� redigir uma mensagem, voc� ter� que digitar o assunto, o string separador, seu usu�rio:senha, o string separador, e o conte�do.');
define('_LANG_INST_BASE_VALUE48','Posts/dias a serem mostrados na p�gina principal.');
define('_LANG_INST_BASE_VALUE49','Posts, dias, ou posts arquivados.');
define('_LANG_INST_BASE_VALUE50','Formato do arquivo.');
define('_LANG_INST_BASE_VALUE51','Caso voc� n�o esteja no mesmo fuso do seu servidor.');
define('_LANG_INST_BASE_VALUE52','Ver nota para formato dos caract�res.');
define('_LANG_INST_BASE_VALUE53','Ver nota para formato dos caract�res.');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Configura��es Principais');
define('_LANG_INST_BASE_HELP2','Configura��es Gerais');
define('_LANG_INST_BASE_HELP3','Configura��es de RSS/RDF Feeds e Track/ping-backs');
define('_LANG_INST_BASE_HELP4','Configura��es de Envio de Arquivos.');
define('_LANG_INST_BASE_HELP5','Configura��es de Posts por E-mail');
define('_LANG_INST_BASE_HELP6','Configura��es B�sicas');
define('_LANG_INST_BASE_HELP7','Configura��es-Padr�o');
define('_LANG_INST_BASE_HELP8','Configura��es Variadas');
define('_LANG_INST_BASE_HELP9','Configura��es de Postagem e Geogr�ficas');
define('_LANG_INST_BASE_VALUE55','O estado padr�o de cada novo post.');
define('_LANG_INST_BASE_VALUE56','O estado padr�o dos coment�rios para cada post.');
define('_LANG_INST_BASE_VALUE57','O estado padr�o do ping para cada post.');
define('_LANG_INST_BASE_VALUE58','Se \'PingBackear as URLs neste post\' deve estar selecionado por padr�o.');
define('_LANG_INST_BASE_VALUE59','A categoria-padr�o para cada post.');
define('_LANG_INST_BASE_VALUE83','O n�mero de linhas no formul�rio de edi��o. (m�n. 3, m�x. 100)');
define('_LANG_INST_BASE_VALUE60','O n�vel m�nimo de administrador para editar os links.');
define('_LANG_INST_BASE_VALUE61','Desative isso para ter todos os links vis�veis e edit�veis por todos no gerenciador de links.');
define('_LANG_INST_BASE_VALUE62','Mude isso para o tipo de avalia��o que voc� deseja usar.');
define('_LANG_INST_BASE_VALUE63','Se ativado, qual char usar.');
define('_LANG_INST_BASE_VALUE64','O que fazer com um valor 0. Ative para ignor�-lo, ou desative para process�-lo normalmente. (n�mero/imagem)');
define('_LANG_INST_BASE_VALUE65','Usar a mesma imagem para cada ponto de avalia��o? (Use links_rating_image[0])');
define('_LANG_INST_BASE_VALUE66','Imagem para avalia��o 0');
define('_LANG_INST_BASE_VALUE67','Imagem para avalia��o 1');
define('_LANG_INST_BASE_VALUE68','Imagem para avalia��o 2');
define('_LANG_INST_BASE_VALUE69','Imagem para avalia��o 3');
define('_LANG_INST_BASE_VALUE70','Imagem para avalia��o 4');
define('_LANG_INST_BASE_VALUE71','Imagem para avalia��o 5');
define('_LANG_INST_BASE_VALUE72','Imagem para avalia��o 6');
define('_LANG_INST_BASE_VALUE73','Imagem para avalia��o 7');
define('_LANG_INST_BASE_VALUE74','Imagem para avalia��o 8');
define('_LANG_INST_BASE_VALUE75','Imagem para avalia��o 9');
define('_LANG_INST_BASE_VALUE76','caminho/para/o/cache deve ter permiss�o de escrita pelo servidor.');
define('_LANG_INST_BASE_VALUE77','Receber arquivos de weblogs.com');
define('_LANG_INST_BASE_VALUE78','Tempo de cache em minutos.');
define('_LANG_INST_BASE_VALUE79','O formato da data para a tooltip atualizada.');
define('_LANG_INST_BASE_VALUE80','Texto anexado � um link recente (Pr�ximo)');
define('_LANG_INST_BASE_VALUE81','Texto anexado � um link recente (Anterior)');
define('_LANG_INST_BASE_VALUE82','Tempo em minutos para considerar um link recentemente atualizado.');
define('_LANG_INST_BASE_VALUE84','Liga as op��es de GeoURL no WordPress');
define('_LANG_INST_BASE_VALUE85','enables placement of defa�lt GeoURL ICBM location even when no other specified');
define('_LANG_INST_BASE_VALUE86','O valor-padr�o da Latitude ICBM - Veja <a href="http://www.geourl.org/resources.html" target="_blank">aqui</a>');
define('_LANG_INST_BASE_VALUE87','O valor-padr�o da Longitude ICBM');
/* Last Question */
define('_LANG_INST_STEP2_LAST','OK. J� estamos quase l�. H� apenas algumas coisas que precisamos saber:');
define('_LANG_INST_STEP2_URL','Usu�rio criado com sucesso.');
define('_LANG_INST_STEP3_SET','<p>Agora voc� pode se <a href="../wp-login.php">conectar</a> com o <strong>usu�rio</strong> "admin" e <strong>senha</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Anote a senha</em></strong> com cuidado! � uma senha <em>randon�mica</em> gerada especialmente para voc�. Se voc� a perder, ter� que apagar as tabelas do banco de dados e reinstalar o WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Voc� achou que ia ser mais longo? Sinto desapont�-lo, j� est� tudo pronto!');
define('_LANG_INST_CAUTIONS','<ul><li>Diret�rio : [755]</li><li>wp-config.php : [604~644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','Parece que o arquivo wp-config.php n�o existe. Verifique se voc� atualizou o wp-config.sample.php com as informa��es corretas do banco de dados e renomeou-o para wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>Este arquivo atualiza seu WordPress para a �ltima vers�o. Seja paciente, pode levar alguns instantes. </p><p>Se voc� estiver pronto, clique <a href="upgrade.php?step=1">aqui</a>! </p>');
define('_LANG_UPG_STEP_INFO3','<p>H� apenas uma �nica etapa. Ent�o, se voc� est� vendo isso, � porque ela foi conclu�da. <a href="../">Divirta-se</a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','Se ativado, os coment�rios ser�o mostrados apenas ap�s serem aprovados.');
define('_LANG_INST_BASE_VALUE89','Ative isso se quiser ser notificado de novos coment�rios esperando por aprova��o.');
define('_LANG_INST_BASE_VALUE90','Como os permalinks para o seu site s�o feitos. Veja <a href=\"options-permalink.php\">permalink options page</a> para as regras mod_rewrite necess�rias e maiores informa��es.');
define('_LANG_INST_BASE_VALUE91','Se o seu arquivo de destino deve ser Gzip ou n�o. Ative-o se voc� n�o tiver mod_gzip rodando ainda.');
define('_LANG_INST_BASE_VALUE92','Altere este valor para verdadeiro se voc� planeja usar arquivos hackeados. Aqui voc� poder� guardar c�digos hackeados que n�o ser�o sobreescritos quando voc� atualizar. O arquivo deve estar na pasta raiz do wordpress e se chamar <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','Diferen�a em horas entre o fuso hor�rio do servidor e o seu.');
}
?>
