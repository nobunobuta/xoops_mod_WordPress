<?php //* Brazilian Portuguese Translation by Marcelo Yuji Himoro <www.yuji.eu.org> *//
$blog_charset = 'iso-8859-1';

if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */


/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */

/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>O WordPress ME ainda n�o est� instalado. Clique <a href=\'wp-admin/install.php\'>aqui</a> para come�ar a instala��o.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>O arquivo <code>wp-config.php</code> n�o existe. Ele � necess�rio na instala��o do WordPress ME. Precisa de ajuda? Clique <a href="http://wordpress.org/docs/faq/#wp-config">aqui</a>. Voc� pode <a href="wp-admin/install-config.php">criar um arquivo <code>wp-config.php</code></a> na interface web. Para isso, � preciso dar as permiss�es de escrita corretamente (707~777), mas ela pode n�o funcionar em todos os servidores. O jeito mais seguro � cri�-lo manualmente.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>O arquivo \'wp-config.php\' j� existe. Se voc� deseja zerar alguma configura��o neste arquivo, por favor apague-o primeiro.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Lamento, � preciso de um arquivo wp-config-sample.php para continuar. Por favor, fa�a o upload deste arquivo da sua instala��o do WordPress novamente.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Lamento, n�o � poss�vel escrever no diret�rio. Por favor, d� as permiss�es de escrita ao diret�rio do WordPress ou crie seu wp-config.php manualmente usando o arquivo wp-config-sample.php como refer�ncia.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Bem-vindo ao WordPress. Antes de come�ar, ser�o necess�rias algumas informa��es sobre o banco de dados. Voc� ter� que ter em m�os os seguintes dados antes de prosseguir:');
define('_LANG_WA_CONFIG_DATABASE','Nome do banco de dados');
define('_LANG_WA_CONFIG_USERNAME','Usu�rio');
define('_LANG_WA_CONFIG_PASSWORD','Senha');
define('_LANG_WA_CONFIG_LOCALHOST','Hostname');
define('_LANG_WA_CONFIG_PREFIX','Prefixo da tabela');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Se por alguma raz�o a cria��o autom�tica de arquivos n�o funcionar, n�o se preocupe, pois tudo o que � feito � transferir os dados para um arquivo de configura��o. Voc� tamb�m pode simplesmente abrir o arquivo <code>wp-config-sample.php</code> em um editor de textos, alterar as configura��es, e salv�-lo como <code>wp-config.php</code>. </strong></p><p>Provavelmente, esses dados foram fornecidos � voc� pelo seu host. Se voc� n�o tiv�-los, precisar� contat�-los antes de continuar. Caso voc� esteja pronto, clique <a href="install-config.php?step=1">aqui</a>.');
define('_LANG_WA_CONFIG_GUIDE6','Digite abaixo os dados da sua conex�o ao banco de dados. Se voc� n�o tiver certeza sobre eles, contate seu host.');
define('_LANG_WA_CONFIG_GUIDE7','<small>O nome do banco de dados onde o WordPress ME ser� instalado. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Nome de usu�rio do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>Senha do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>Em 99% dos casos, voc� n�o ter� que mudar isto.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Se voc� for rodar v�rias instala��es do WordPress ME em um �nico banco de dados, mude isto.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Pronto! As informa��es necess�rias est�o corretas. WordPress ME estabeleceu uma conex�o com seu banco de dados corretamente. Se estiver pronto, clique <a href="install.php">aqui</a> para instalar.');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>N�o foi poss�vel estabelecer uma conex�o com o banco de dados.</strong>Isso significa que as informa��es da conex�o no seu arquivo <code>wp-config.php</code> podem estar incorretas. Cheque-as e tente novamente.');
define('_LANG_WA_WPDB_GUIDE2','Tem certeza de que o nome de usu�rio/senha est�o corretos?');
define('_LANG_WA_WPDB_GUIDE3','Tem certeza de que voc� o hostname est� correto?');
define('_LANG_WA_WPDB_GUIDE4','Tem certeza de que o servidor do banco de dados est� rodando?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Editar formato da hora');
define('_LANG_F_NEW_COMMENT','Tem um coment�rio novo no seu post.');
define('_LANG_F_ALL_COMMENTS','Os coment�rios deste post podem ser vistos aqui:');
define('_LANG_F_NEW_TRACKBACK','Tem uma nova trackback no seu post.');
define('_LANG_F_ALL_TRACKBACKS','As trackbacks deste post podem ser vistas aqui:');
define('_LANG_F_NEW_PINGBACK','Tem um novo pingback no seu post.');
define('_LANG_F_ALL_PINGBACKS','Os pingbacks deste post podem ser vistos aqui:');
define('_LANG_F_COMMENT_POST','Tem um novo coment�rio no post');
define('_LANG_F_WAITING_APPROVAL','est� esperando por sua aprova��o.');
define('_LANG_F_APPROVAL_VISIT','Para aprovar este coment�rio:');
define('_LANG_F_DELETE_VISIT','Para apagar este coment�rio:');
define('_LANG_F_PLEASE_VISIT','No momento, existem coment�rios pendentes de aprova��o. V� para o Painel de Modera��o:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERRO</strong>: escolha um nome de usu�rio.');
define('_LANG_R_PASS_TWICE','<strong>ERRO</strong>: repita sua senha.');
define('_LANG_R_SAME_PASS','<strong>ERRO</strong>: repita a mesma senha nos dois campos.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERRO</strong>: digite seu endere�o de e-mail.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERRO</strong>: o endere�o de e-mail � inv�lido.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERRO</strong>: este nome de usu�rio j� existe. Escolha outro e tente novamente.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERRO</strong>: n�o foi poss�vel realizar o cadastro. Contate o administrador.');
define('_LANG_R_USER_REGISTRATION','Novo usu�rio no seu blog');
define('_LANG_R_MAIL_REGISTRATION','Novo cadastro de usu�rio');
define('_LANG_R_R_COMPLETE','Cadastro completado.');
define('_LANG_R_R_DISABLED','Cadastro desativado.');
define('_LANG_R_R_CLOSED','No momento, n�o s�o aceitos novos cadastros.');
define('_LANG_R_R_REGISTRATION','Cadastro');
define('_LANG_R_USER_LOGIN','Usu�rio:');
define('_LANG_R_USER_PASSWORD','Senha:');
define('_LANG_R_TWICE_PASSWORD','Repetir senha:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','Preencha o campo <b>Usu�rio</b>.');
define('_LANG_L_PASS_EMPTY','Preencha o campo <b>Senha</b>.');
define('_LANG_L_WRONG_LOGPASS','O nome de usu�rio ou senha s�o inv�lidos.');
define('_LANG_L_RECEIVE_PASSWORD','Basta preencher os dados e te enviaremos uma nova senha.');
define('_LANG_L_EXIST_SORRY','Este usu�rio n�o existe. Clique <a href="wp-login.php?action=lostpassword">aqui</a> para receber sua senha por e-mail.');
define('_LANG_L_YOUR_LOGPASS','Usu�rio/senha do WordPress');
define('_LANG_L_NOT_SENT','O e-mail n�o p�de ser enviado.');
define('_LANG_L_DISABLED_FUNC','Poss�vel raz�o: seu servidor pode ter desativado a fun��o mail().');

define('_LANG_L_SUCCESS_SEND',': o e-mail foi enviado com sucesso.');
define('_LANG_L_CLICK_ENTER','Clique aqui para se identificar!');
define('_LANG_L_WRONG_SESSION','Erro: usu�rio/senha inv�lidos.');
define('_LANG_L_BACK_BLOG','Voltar ao blog');
define('_LANG_L_WP_RESIST','Cadastrar-se agora!');
define('_LANG_L_WPLOST_YOURPASS','Esqueceu sua senha?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Como voc� � um novato, ter� que esperar at� que um administrador aumente seu n�vel para 1 para poder postar.<br />Voc� pode enviar um e-mail ao administrador pedindo uma promo��o.<br />Quando voc� for promovido, basta atualizar esta p�gina e poder� postar.');
define('_LANG_P_DATARIGHT_EDIT',', voc� n�o tem permiss�o para editar posts.');
define('_LANG_P_DATARIGHT_DELETE',', voc� n�o tem permiss�o para apagar posts.');
define('_LANG_P_DATARIGHT_ERROR','Erro ao apagar. Contate o administrador.');
define('_LANG_P_OOPS_IDCOM','N�o existem coment�rios com este n� ID.');
define('_LANG_P_OOPS_IDPOS','N�o existem posts com este n� ID.');
define('_LANG_P_ABOUT_FOLLOW','Voc� est� prestes a apagar o seguinte coment�rio:');
define('_LANG_P_SURE_THAT','Tem certeza de que deseja continuar?');
define('_LANG_P_NICKNAME_DELETE','Voc� n�o tem permiss�o para apagar coment�rios.');
define('_LANG_P_COMHAS_APPR','O coment�rio foi aprovado.');
define('_LANG_P_YOUR_DRAFTS','Seus rascunhos:');
define('_LANG_P_WP_BOOKMARKLET','Voc� pode arrastar o link seguinte para sua barra de links ou adicion�-lo ao seus Favoritos. Quando voc� clicar sobre ele, se abrir� uma janela popup com informa��es e um link para a p�gina que voc� est� visualizando agora, permitindo que voc� fa�a um post rapidamente.');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','N�o � poss�vel apagar esta categoria pois ela � a padr�o.');
define('_LANG_C_EDIT_TITLECAT','Editar categoria');
define('_LANG_C_NAME_SUBCAT','Nome da categoria:');
define('_LANG_C_NAME_SUBDESC','Descri��o:');
define('_LANG_C_RIGHT_EDITCAT','Voc� n�o tem permiss�o para alterar as categorias deste blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_C_NAME_CURRCAT','Categorias existentes');
define('_LANG_C_NAME_CATNAME','Nome');
define('_LANG_C_NAME_CATDESC','Descri��o');
define('_LANG_C_NAME_CATPOSTS','N� de posts');
define('_LANG_C_NAME_CATACTION','A��o');
define('_LANG_C_ADD_NEWCAT','Adicionar uma nova categoria');
define('_LANG_C_NOTE_CATEGORY','Apagar uma categoria n�o exclui os posts existentes nela, apenas move-os � categoria padr�o.');
define('_LANG_C_NAME_EDIT','EDITAR');
define('_LANG_C_NAME_DELETE','APAGAR');
define('_LANG_C_NAME_ADDBTN','Adicionar');
define('_LANG_C_NAME_EDITBTN','Enviar');
define('_LANG_C_NAME_PARENT','Categoria padr�o:');
define('_LANG_C_MESS_ADD','Categoria added.');
define('_LANG_C_MESS_DELE','Categoria deleted.');
define('_LANG_C_MESS_UP','Categoria updated.');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','�ltimos posts');
define('_LANG_E_LATEST_COMMENTS','�ltimos coment�rios');
define('_LANG_E_AWAIT_MODER','Coment�rios pendentes de aprova��o');
define('_LANG_E_SHOW_POSTS','Mostrar posts:');
define('_LANG_E_TITLE_COMMENTS','Coment�rios');
define('_LANG_E_FILL_REQUIRED','ERRO: preencha os campos obrigat�rios. (nome e coment�rio)');
define('_LANG_E_TITLE_LEAVECOM','Comentar');
define('_LANG_E_RESULTS_FOUND','Nenhum resultado foi encontrado.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Mostrar coment�rio:');
define('_LANG_EC_EDIT_COM','Editar coment�rio');
define('_LANG_EC_DELETE_COM','Apagar coment�rio');
define('_LANG_EC_EDIT_POST','Editar post &#8220;');
define('_LANG_EC_VIEW_POST','Ver post');
define('_LANG_EC_SEARCH_MODE','Realiza pesquisas dentro dos coment�rios, e-mail, URL e endere�o IP.');
define('_LANG_EC_VIEW_MODE','Modo de visualiza��o');
define('_LANG_EC_EDIT_MODE','Modo de edi��o em massa');
define('_LANG_EC_CHECK_INVERT','Inverter caixa de sele��o');
define('_LANG_EC_CHECK_DELETE','Apagar os coment�rios selecionados');
define('_LANG_EC_LINK_VIEW','Ver');
define('_LANG_EC_LINK_EDIT','Editar');
define('_LANG_EC_LINK_DELETE','Apagar');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback">Fazer <strong>pingback</strong> nas <acronym title="Uniform Resource Locators">URL</acronym>s dos posts</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Ajuda com pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Ajuda com trackbacks">Fazer <strong>trackback</strong> numa <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Separar m�ltiplas <acronym title="Uniform Resource Locator">URL</acronym>s por espa�os.)<br />');
define('_LANG_EF_AD_POSTTITLE','T�tulo');
define('_LANG_EF_AD_CATETITLE','Categorias');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Salvar como rascunho');
define('_LANG_EF_AD_PRIVATE','Salvar como particular');
define('_LANG_EF_AD_PUBLISH','Publicar');
define('_LANG_EF_AD_EDITING','Edi��o avan�ada &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Estado do post');
define('_LANG_EFA_AD_COMMENTS','Coment�rios');
define('_LANG_EFA_AD_PINGS','Pings');
define('_LANG_EFA_POST_PASSWORD','Senha do post');
define('_LANG_EFA_POST_EXCERPT','Excerto');
define('_LANG_EFA_POST_LATITUDE','Latitude:');
define('_LANG_EFA_POST_LONGITUDE','Longitude:');
define('_LANG_EFA_POST_GEOINFO','Clique aqui para informa��es geogr�ficas');
define('_LANG_EFA_DEL_THISPOST','Apagar este post');
define('_LANG_EFA_SAVE_CONTINUE','Salvar e continuar editando');
define('_LANG_EFA_STATUS_OPEN','Aberto');
define('_LANG_EFA_STATUS_CLOSE','Fechado');
define('_LANG_EFA_STATUS_UPLOAD','Fazer o upload de um arquivo ou imagem');
define('_LANG_EFA_STATUS_DISCUSS','Discuss�o');
define('_LANG_EFA_STATUS_ALLOWC','Permitir coment�rios');
define('_LANG_EFA_STATUS_ALLOWP','Permitir pings');
define('_LANG_EFA_STATUS_SLUG','Separador de post');
define('_LANG_EFA_STATUS_POST','Postar');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Enviar');
define('_LANG_EFC_COM_NAME','Nome:');
define('_LANG_EFC_COM_MAIL','E-mail:');
define('_LANG_EFC_COM_URI','Site:');
define('_LANG_EFC_COM_COMMENT','Coment�rio:');

/* File Name wp-admin/link-add.php */
define('_LANG_WLA_MANAGE_LINK','Gerenciar links');
define('_LANG_WLA_ADD_LINK','Adicionar link');
define('_LANG_WLA_LINK_CATE','Categorias de links');
define('_LANG_WLA_IMPORT_BLOG','Importar blogroll');
define('_LANG_WLA_LINK_TITLE','Adicionar um<strong>link</strong>:');
define('_LANG_WLA_SUB_URI','URL:');
define('_LANG_WLA_SUB_NAME','Nome do link:');
define('_LANG_WLA_SUB_IMAGE','Imagem:');
define('_LANG_WLA_SUB_RSS','RSS URL:');
define('_LANG_WLA_SUB_DESC','Descri��o:');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN:');
define('_LANG_WLA_SUB_NOTE','Notas:');
define('_LANG_WLA_SUB_RATE','Classifica��o:');
define('_LANG_WLA_SUB_TARGET','P�blico');
define('_LANG_WLA_SUB_VISIBLE','Vis�vel:');
define('_LANG_WLA_SUB_CAT','Categoria:');
define('_LANG_WLA_SUB_FRIEND','Amizades:');
define('_LANG_WLA_SUB_PHYSICAL','Fisica:');
define('_LANG_WLA_SUB_PROFESSIONAL','Profissional:');
define('_LANG_WLA_SUB_GEOGRAPH','Geogr�fica:');
define('_LANG_WLA_SUB_FAMILY','Familiar:');
define('_LANG_WLA_SUB_ROMANTIC','Rom�ntica:');
define('_LANG_WLA_CHECK_ACQUA','Conhecidos');
define('_LANG_WLA_CHECK_FRIE','Amigos');
define('_LANG_WLA_CHECK_NONE','Nenhum');
define('_LANG_WLA_CHECK_MET','Encontros');
define('_LANG_WLA_CHECK_WORKER','S�cios');
define('_LANG_WLA_CHECK_COLL','Colegas');
define('_LANG_WLA_CHECK_RESI','Colegas de quarto');
define('_LANG_WLA_CHECK_NEIG','Vizinhos');
define('_LANG_WLA_CHECK_CHILD','Filhos');
define('_LANG_WLA_CHECK_PARENT','Pais');
define('_LANG_WLA_CHECK_SIBLING','Irm�os');
define('_LANG_WLA_CHECK_SPOUSE','Esposa');
define('_LANG_WLA_CHECK_MUSE','Musa');
define('_LANG_WLA_CHECK_CRUSH','Paix�o');
define('_LANG_WLA_CHECK_DATE','Encontros');
define('_LANG_WLA_CHECK_HEART','Namoros');
define('_LANG_WLA_CHECK_ZERO','Deixe em 0 para nenhuma classifica��o.');
define('_LANG_WLA_CHECK_STRICT','NOTA: o atributo <code>target</code> � ilegal em XHTML 1.1 e restrito � 1.0.');
define('_LANG_WLA_TEXT_TOOLBAR','Voc� pode arrastar "Link This" para sua barra de tarefas. Ao clic�-la, uma janela pop-up permitir� � voc� adicionar qualquer site em que voc� estiver aos seus links. (No momento, funciona apenas no Mozilla ou Netscape)');
define('_LANG_WLA_BUTTON_TEXTNAME','Adicionar link');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','N�o � poss�vel apagar esta categoria de link pois ela � a padr�o.');
define('_LANG_WLC_TITLE_TEXT','Editar categorias de link &#8220;');
define('_LANG_WLC_EPAGE_TITLE','Editar uma categoria de link:');
define('_LANG_WLC_ADD_TITLE','Adicionar uma categoria de link:');
define('_LANG_WLC_SUBEDIT_NAME','Nome:');
define('_LANG_WLC_SUBEDIT_TOGGLE','Auto-toggle');
define('_LANG_WLC_SUBEDIT_SHOW','Mostrar:');
define('_LANG_WLC_SUBEDIT_ORDER','Mostrar por:');
define('_LANG_WLC_SUBEDIT_IMAGES','Imagens');
define('_LANG_WLC_SUBEDIT_DESC','Descri��o');
define('_LANG_WLC_SUBEDIT_RATE','Classifica��o');
define('_LANG_WLC_SUBEDIT_UPDATE','Atualiza��o');
define('_LANG_WLC_SUBEDIT_SORT','Ordenar por:');
define('_LANG_WLC_SUBEDIT_DESCEND','Origem');
define('_LANG_WLC_SUBEDIT_BEFORE','Antes:');
define('_LANG_WLC_SUBEDIT_BETWEEN','Entre:');
define('_LANG_WLC_SUBEDIT_AFTER','Depois:');
define('_LANG_WLC_SUBEDIT_LIMIT','Limite:');
define('_LANG_WLC_ADDBUTTON_TEXT','Enviar');
define('_LANG_WLC_SAVEBUTTON_TEXT','Salvar');
define('_LANG_WLC_CANCELBUTTON_TEXT','Cancelar');
define('_LANG_WLC_SUBCATE_NAME','Nome');
define('_LANG_WLC_SUBCATE_ATT','Auto-Toggle');
define('_LANG_WLC_SUBCATE_SHOW','Mostrar:');
define('_LANG_WLC_SUBCATE_SORT','Ordenar por');
define('_LANG_WLC_SUBCATE_DESC','Descrecente');
define('_LANG_WLC_SUBCATE_LIMIT','Limite:');
define('_LANG_WLC_SUBCATE_IMAGES','Imagens:');
define('_LANG_WLC_SUBCATE_MINIDESC','Origem');
define('_LANG_WLC_SUBCATE_RATE','Classifica��o');
define('_LANG_WLC_SUBCATE_UPDATE','Atualiza��o');
define('_LANG_WLC_SUBCATE_BEFORE','Antes');
define('_LANG_WLC_SUBCATE_BETWEEN','Entre');
define('_LANG_WLC_SUBCATE_AFTER','Depois');
define('_LANG_WLC_SUBCATE_EDIT','Editar');
define('_LANG_WLC_SUBCATE_DELETE','Apagar');
define('_LANG_WLC_SUBEDIT_EMPTY','Quantos de links devem ser mostrados. Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_EMPTY','Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_NOTE','Apagar uma categoria de links n�o remove os links contidos nela, apenas move-os � categoria padr�o: ');
define('_LANG_WLC_RIGHT_PROM','Voc� n�o tem permiss�o para editar as categorias de links deste blog.<br>Pe�a uma promo��o ao administrador do blog.');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Importar blogroll');
define('_LANG_WLI_ROLL_DESC','Importar sua blogroll de outro sistema ');
define('_LANG_WLI_ROLL_OPMLCODE','V� em Blogrolling.com e identifique-se. Clique em <strong>Get Code</strong>, e procure pelo <strong>c�digo <abbr title="Outline Processor Markup Language">OPML</abbr></strong>.');
define('_LANG_WLI_ROLL_OPMLLINK','V� em Blo.gs e identifique-se. Na caixa &#8217;Welcome Back&#8217; da direita, clique em <strong>share</strong>, e procure pelo <strong>link <abbr title="Outline Processor Markup Language">OPML</abbr></strong> (favorites.opml).');
define('_LANG_WLI_ROLL_BELOW','Copie o texto e cole-o aqui.');
define('_LANG_WLI_ROLL_YOURURL','Sua URL OPML:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>Ou</strong> fa�a o upload do arquivo OPML:');
define('_LANG_WLI_ROLL_THISFILE','Fazer upload do arquivo:');
define('_LANG_WLI_ROLL_CATEGORY','Agora, escolha a categoria onde voc� deseja inserir estes links.<br />Categoria:');
define('_LANG_WLI_ROLL_BUTTONTEXT','Importar');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Gerenciar links');
define('_LANG_WLM_LEVEL_ERROR','Voc� n�o tem permiss�o para editar os links para este blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WLM_SHOW_LINKS','<strong>Mostrar links por categorias:</strong>');
define('_LANG_WLM_ORDER_BY','<strong>Ordenar por:</strong>');
define('_LANG_WLM_SHOW_BUTTONTEXT','Enviar');
define('_LANG_WLM_SHOW_ACTIONTEXT','A��o');
define('_LANG_WLM_MULTI_LINK','Gerenciar links m�ltiplos');
define('_LANG_WLM_CHECK_CHOOSE','Use as caixas de sele��o da direita para selecionar v�rios links e escolha uma a��o abaixo.');
define('_LANG_WLM_ASSIGN_TEXT','Assignar');
define('_LANG_WLM_OWNER_SHIP','Pertence a:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibilidade');
define('_LANG_WLM_MOVE_TEXT','Mover');
define('_LANG_WLM_TO_CATEGORY',' para categoria');
define('_LANG_WLM_TOGGLE_BOXES','Selecionar tudo');
define('_LANG_WLM_EDIT_LINK','Editar um link:');
define('_LANG_WLM_SAVE_CHANGES','Salvar altera��es');
define('_LANG_WLM_EDIT_CANCEL','Cancelar');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Voc� n�o tem permiss�o para moderar coment�rios. Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Coment�rios');
define('_LANG_WPM_AWIT_MODERATION','Pendentes de modera��o');
define('_LANG_WPM_COM_APPROV',' coment�rio aprovado com sucesso.');
define('_LANG_WPM_COMS_APPROVS',' coment�rios aprovados com sucesso.');
define('_LANG_WPM_COM_DEL',' coment�rio apagado com sucesso.');
define('_LANG_WPM_COMS_DELS',' coment�rios apagados com sucesso.');
define('_LANG_WPM_COM_UNCHANGE',' coment�rio inalterado.');
define('_LANG_WPM_COMS_UNCHANGES',' coment�rios inalterados.');
define('_LANG_WPM_WAIT_APPROVAL','Os seguintes coment�rios est�o pendentes de aprova��o:');
define('_LANG_WPM_CURR_COMAPP','No momento, n�o existem coment�rios a serem aprovados.');
define('_LANG_WPM_DEL_LATER','<p>Para cada coment�rio, voc� deve escolher entre <em>aprovar</em>, <em>apagar</em> ou <em>deixar para depois</em>.</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>Aprovar</em>: aprova o coment�rio, ent�o ele ser� vis�vel publicamente.');
define('_LANG_WPM_AUTHOR_NOTIFIED','O autor do post ser� notificado sobre o novo coment�rio em seu post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>Apagar</em>: remove o conte�do do blog (NOTA: voc� n�o ser� consultado novamente, portanto tenha a certeza de que deseja realmente remover o coment�rio - uma vez apagados, eles n�o poder�o ser recuperados!)</p><p><em>Deixar para depois</em>: n�o muda o estado dos coment�rios.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderar coment�rios');
define('_LANG_WPM_DO_NOTHING','Deixar para depois');
define('_LANG_WPM_DO_DELETE','Apagar');
define('_LANG_WPM_DO_APPROVE','Aprovar');
define('_LANG_WPM_DO_ACTION','A��o:');
define('_LANG_WPM_JUST_THIS','Apagar apenas este coment�rio');
define('_LANG_WPM_JUST_EDIT','Editar');
define('_LANG_WPM_COMPOST_NAME','Nome:');
define('_LANG_WPM_COMPOST_MAIL','E-mail:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Voc� n�o tem permiss�o para editar as op��es deste blog.<br />Pe�a uma promo��o ao administrador do blog.');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Configura��es de links permanentes');
define('_LANG_WOP_NO_HELPS',' N�o existem t�picos de ajuda para este grupo de op��es.');
define('_LANG_WOP_SUBMIT_TEXT','Enviar');
define('_LANG_WOP_SETTING_SAVED',' Configura��es salvas com sucesso.');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_UPDATED','Estrutura de permalinks atualizada.');
define('_LANG_WPL_EDIT_STRUCT','Editar estrutura dos permalink');
define('_LANG_WPL_CREATE_CUSTOM','WordPress oferece � voc� a possibilidade de criar uma estrutura URL para os seus permalinks e arquivos. As seguintes &#8220;tags&#8221; est�o dispon�veis:');
define('_LANG_WPL_CODE_YEAR','Ano, com 4 digitos. Ex.: <code>2004</code>.');
define('_LANG_WPL_CODE_MONTH','M�s, com 2 digitos. Ex.: <code>05</code>.');
define('_LANG_WPL_CODE_DAY','Dia, com 2 digitos. Ex.: <code>28</code>.');
define('_LANG_WPL_CODE_HOUR','Hora, com 2 d�gitos. Ex.: <code>15</code>');
define('_LANG_WPL_CODE_MINUTE','Minutos, com 2 d�gitos. Ex.: <code>43</code>');
define('_LANG_WPL_CODE_SECOND','Segundos, com 2 d�gitos. Ex.: <code>33</code>');
define('_LANG_WPL_CODE_POSTNAME','Uma vers�o limpa do t�tulo do post. Ex.: "This Is A Great Post!" seria "this-is-a-great-post" no URL.');
define('_LANG_WPL_CODE_POSTID','O n� ID do post. Ex.: <code>423</code>.');
define('_LANG_WPL_USE_EXAMPLE','Um valor como <code>/archives/%year%/%monthnum%/%day%/%postname%/</code> daria um permalink como <code>/archives/2003/05/23/my-cheese-sandwich/</code>. Para que isso funcione, voc� dever� ter o mod_rewrite instalado em seu servidor para a cria��o das regras. Futuramente, poder�o haver mais op��es.');
define('_LANG_WPL_USE_TEMPTEXT','Use as tags de templates acima.');
define('_LANG_WPL_USE_BLANK','Se voc� quiser, voc� pode digitar um prefixo personalizado para a sua categoria de URIs aqui. Ex.: <code>/taxonomy/categorias</code> faria seus links de categoria ficarem como <code>http://examplo.org/taxonomy/categorias/general/</code>. Se voc� deixar isto em branco, as configura��es padr�es ser�o usadas.');
define('_LANG_WPL_USE_HTACCESS','No momento existem <code>%s</code> usando o valor da estrutura do permalink. Estas s�o as regras do mod_rewrite que voc� deve ter no seu <code>.htaccess</code>. Clique no campo e aperte <kbd>CTRL + A</kbd> para selecionar tudo.');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>Se o seu arquivo <code>.htaccess</code> tiver permiss�o de escrita pelo WordPress, voc� pode <a href="%s">edit�-lo na tela de edi��o de templates</a>.</p>');
define('_LANG_WPL_MOD_REWRITE','No momento, voc� n�o esta usando permalinks personalizados. Nenhuma regra especifica do mod_rewrite � necess�ria.');
define('_LANG_WPL_SUBMIT_UPDATE','Enviar');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERRO</strong>: digite seu nick (pode ser o mesmo que o seu nome de usu�rio).');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERRO</strong>: seu ICQ UIN deve conter apenas n�meros, letras n�o s�o permitidas.');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERRO</strong>: digite seu e-mail.');
define('_LANG_WPF_ERR_CORRECT','<strong>ERRO</strong>: o endere�o de e-mail � inv�lido.');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERRO</strong>: voc� digitou sua senha apenas uma vez. Volte e digite-a novamente.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERRO</strong>: voc� digitou duas senhas diferentes. Volte e corrija-a.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERRO</strong>: n�o foi poss�vel atualizar seu perfil. Contate o administrador.');
define('_LANG_WPF_SUBT_VIEW','Ver perfil');
define('_LANG_WPF_SUBT_FIRST','Nome:');
define('_LANG_WPF_SUBT_LAST','Sobrenome:');
define('_LANG_WPF_SUBT_NICK','Nick:');
define('_LANG_WPF_SUBT_MAIL','E-mail:');
define('_LANG_WPF_SUBT_URL','Site:');
define('_LANG_WPF_SUBT_ICQ','ICQ:');
define('_LANG_WPF_SUBT_AIM','AIM:');
define('_LANG_WPF_SUBT_MSN','MSN IM:');
define('_LANG_WPF_SUBT_YAHOO','Yahoo IM:');
define('_LANG_WPF_SUBT_ONE','IE one-click bookmarklet');
define('_LANG_WPF_SUBT_COPY','Para ter um one-click bookmarklet, basta copiar e colar isso em um arquivo de texto:');
define('_LANG_WPF_SUBT_BOOK','Salve-o como wordpress.reg, e clique duas vezes nele numa janela do Explorer.<br />Responda \"Sim\" a pergunta, e reinicie o Internet Explorer.<br /><br />Assim, voc� pode clicar com o bot�o direito numa janela do Internet Explorer<br />e selecionar "Postar no WP".');
define('_LANG_WPF_SUBT_CLOSE','Fechar esta janela');
define('_LANG_WPF_SUBT_UPDATED','Perfil atualizado com sucesso.');
define('_LANG_WPF_SUBT_EDIT','Editar seu perfil');
define('_LANG_WPF_SUBT_USERID','ID:');
define('_LANG_WPF_SUBT_LEVEL','N�vel:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Usu�rio:');
define('_LANG_WPF_SUBT_DESC','Perfil:');
define('_LANG_WPF_SUBT_IDENTITY','Nome de exibi��o:');
define('_LANG_WPF_SUBT_NEWPASS','Nova <strong>senha</strong> (deixe em branco para manter a mesma.)');
define('_LANG_WPF_SUBT_MOZILLA','Nenhuma sidebar encontrada. Voc� deve ter Mozilla 0.9.4 ou superior.');
define('_LANG_WPF_SUBT_SIDEBAR','Sidebar');
define('_LANG_WPF_SUBT_FAVORITES','Adicionar este link aos Favoritos:');
define('_LANG_WPF_SUBT_UPDATE','Atualizar');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Post realizado com sucesso.');
define('_LANG_WAS_SIDE_AGAIN','Clique <a href="sidebar.php">aqui</a> para postar novamente.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>Voc� n�o tem permiss�o para editar o template deste blog.<br />Pe�a uma promo��o ao administrador do blog.</p>');
define('_LANG_WAT_SORRY_EDIT','Lamento, n�o � poss�vel editar arquivos com ".." no nome. Se voc� estiver tentando editar um arquivo no diretorio raiz do seu WordPress, voc� deve digitar apenas o seu nome.');
define('_LANG_WAT_SORRY_PATH','Lamento, n�o � poss�vel chamar arquivos pelo seu caminho real.');
define('_LANG_WAT_EDITED_SUCCESS','<em>Arquivo editado com sucesso.</em>');
define('_LANG_WAT_FILE_CHMOD','Voc� n�o pode editar este arquivo/template. Ele deve ter permiss�o de escrita. Ex.: CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Arquivo n�o encontrado! Cheque-o e tente novamente.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Nome do arquivo: (Voc� pode editar qualquer arquivo com permiss�o de escrita. Ex.: CHMOD 766.)</p>');
define('_LANG_WAT_TYPE_HERE','Nome do arquivo:');
define('_LANG_WAT_FTP_CLIENT','Nota: � claro, voc� pode editar os arquivos/templates em seu editor de textos favorito e fazer o upload. Este editor on-line s� deve ser usado caso voc� n�o tem um editor de textos ou cliente de FTP.');
define('_LANG_WAT_UPTEXT_TEMP','Enviar');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','Esta op��o foi desativada pelo administrador.');
define('_LANG_WAU_FILE_UPLOAD','Fazer upload de um arquivo');
define('_LANG_WAU_CAN_TYPE','Extens�es permitidas:');
define('_LANG_WAU_MAX_SIZE','Tamanho m�ximo:');
define('_LANG_WAU_FILE_DESC','Descri��o:');
define('_LANG_WAU_BUTTON_TEXT','Enviar');
define('_LANG_WAU_ATTACH_ICON','Apenas o �cone do arquivo anexado');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','N�o � poss�vel alterar o n�vel de um usu�rio cujo n�vel � maior que o seu.');
define('_LANG_WUS_WHOSE_DELETE','N�o � poss�vel apagar um usu�rio cujo n�vel � maior que o seu.');
define('_LANG_WUS_CANNOT_DELU','N�o � poss�vel apagar este usu�rio.');
define('_LANG_WUS_CANNOT_DELUPOST','N�o � poss�vel apagar os posts desse usu�rio');
define('_LANG_WUS_AU_THOR','Autores');
define('_LANG_WUS_AU_NICK','Nick');
define('_LANG_WUS_AU_NAME','Nome');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','N�vel');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','Usu�rios');
define('_LANG_WUS_AU_WARNING','Para apagar um usu�rio, mude seu n�vel para 0, e ent�o clique no X vermelho.<br /><strong>ATEN��O:</strong> apagar um usu�rio remove tamb�m todos os posts feitos por ele.');
define('_LANG_WUS_ADD_USER','Adicionar usu�rio');
define('_LANG_WUS_ADD_THEMSELVES','Os usu�rios podem registrar-se por si mesmos ou voc� pode cri�-los manualmente por aqui.');
define('_LANG_WUS_ADD_FIRST','Nome');
define('_LANG_WUS_ADD_LAST','Sobrenome');
define('_LANG_WUS_ADD_TWICE','Senha (duas vezes)');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Acesso negado.');
define('_LANG_WPCM_ENTER_PASS','<p>Digite sua senha para ver os coment�rios.<p>');
define('_LANG_WPCM_COM_TITLE','Coment�rios');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> feed dos coment�rios');
define('_LANG_WPCM_COM_TRACK','<acronym title="Uniform Resource Identifier">URL</acronym> da TrackBack:');
define('_LANG_WPCM_COM_YET','Ainda n�o existem coment�rios.');
define('_LANG_WPCM_COM_LEAVE','Comentar');
define('_LANG_WPCM_HTML_ALLOWED','Par�grafos e quebra-linhas autom�ticos; site substitui o e-mail; <acronym title="Hypertext Markup Language">HTML</acronym> permitido.');
define('_LANG_WPCM_COM_YOUR','Seu coment�rio:');
define('_LANG_WPCM_PLEASE_NOTE','<strong>NOTA:</strong> a modera��o de coment�rios est� ativada, portanto pode haver algum atraso entre quando voc� enviar seu coment�rio e quando ele aparecer. N�o h� necessidade de envi�-lo novamente, seja paciente.');
define('_LANG_WPCM_COM_SAYIT','Enviar');
define('_LANG_WPCM_THIS_TIME','Lamento, no momento os coment�rios est�o fechados.');
define('_LANG_WPCM_GO_BACK','Voltar');
define('_LANG_WPCM_COM_NAME','Nome');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Desculpe, os coment�rios est�o fechados para este item.');
define('_LANG_WPCP_ERR_FILL','ERRO: preencha os campos obrigat�rios (nome e e-mail).');
define('_LANG_WPCP_ERR_TYPE','ERRO: escreva um coment�rio.');
define('_LANG_WPCP_SORRY_SECONDS','Lamento, voc� s� pode fazer um novo coment�rio ap�s 10 segundos.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','Esta op��o foi desativada pelo administrador.');
define('_LANG_WAU_UPLOAD_DIRECTORY','Voc� n�o pode fazer o upload de arquivos pois o diretorio especificado n�o tem permiss�o de escrita pelo WordPress. Cheque as permiss�es dos diret�rios ou erros.');
define('_LANG_WAU_UPLOAD_EXTENSION','Voc� pode fazer o upload de arquivos do tipo ');
define('_LANG_WAU_UPLOAD_BYTES','desde que eles n�o ultrapassem ');
define('_LANG_WAU_UPLOAD_OPTIONS','Se voc� � um administrador, esses valores podem ser alterados em <a href="options.php?option_group_id=4">Op��es</a>.');
define('_LANG_WAU_UPLOAD_FILE','Arquivo:');
define('_LANG_WAU_UPLOAD_ALT','Descri��o:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Criar miniatura?');
define('_LANG_WAU_UPLOAD_NO','N�o');
define('_LANG_WAU_UPLOAD_SMALL','Pequena (larg. m�x 200px)');
define('_LANG_WAU_UPLOAD_LARGE','Grande (larg. m�x. 400px)');
define('_LANG_WAU_UPLOAD_CUSTOM','Tamanho personalizado');
define('_LANG_WAU_UPLOAD_PX','px (larg. m�x.)');
define('_LANG_WAU_UPLOAD_BTN','Enviar arquivo');
define('_LANG_WAU_UPLOAD_SUCCESS','Seu arquivo foi enviado com sucesso: ');
define('_LANG_WAU_UPLOAD_CODE','Aqui est� o c�digo para mostr�-lo:');
define('_LANG_WAU_UPLOAD_START','Enviar');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplicar arquivo?');
define('_LANG_WAU_UPLOAD_EXISTS','Esse arquivo j� existe: ');
define('_LANG_WAU_UPLOAD_RENAME','Confirmar ou renomear:');
define('_LANG_WAU_UPLOAD_ALTER','Nome alternativo:');
define('_LANG_WAU_UPLOAD_REBTN','Renomear');
define('_LANG_WAU_UPLOAD_CODEIN','Inserir c�digo no formul�rio');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Associate');
define('_LANG_WAU_ATTACH_ICON','Apenas �cones anexos');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Voc� n�o tem permiss�o suficiente para editar as op��es para este blog.');
define('_LANG_WAO_GENERAL_WPTITLE','T�tulo do weblog:');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Endere�o do site (URL):');
define('_LANG_WAO_GENERAL_MAIL','Endere�o de e-mail:');
define('_LANG_WAO_GENERAL_MEMBER','Usu�rio:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">Fuso hor�rio</acronym>:');
define('_LANG_WAO_GENERAL_DIFFER','Diferen�a de horas:');
define('_LANG_WAO_GENERAL_EXPLIAIN','Fa�a uma breve descri��o do blog.');
define('_LANG_WAO_GENERAL_ADMIN','Este endere�o � usado apenas para quest�es administrativas.');
define('_LANG_WAO_GENERAL_REGISTER','Ativar cadastros');
define('_LANG_WAO_GENERAL_ARTICLES','Permitir a qualquer usu�rio cadastrado postar artigos.');
define('_LANG_WAO_GENERAL_UPDATE','Enviar');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Voc� n�o tem permiss�o para editar as op��es para este blog.');
define('_LANG_WAO_WRITING_TITLE','Op��es de escrita');
define('_LANG_WAO_WRITING_SIMPLE','Op��es b�sicas');
define('_LANG_WAO_WRITING_ADVANCED','Op��es avan�adas');
define('_LANG_WAO_WRITING_LINES','linhas');
define('_LANG_WAO_WRITING_DISPLAY','Transformar smilies como :-) e :-P em gr�ficos');
define('_LANG_WAO_WRITING_XHTML','Detectar codigos XHTML inv�lidos automaticamente');
define('_LANG_WAO_WRITING_CHARACTER','Codifica��o (UTF-8 recomendado)');
define('_LANG_WAO_WRITING_STYLE','Quando come�ar um post, mostrar:');
define('_LANG_WAO_WRITING_BOX','Tamanho da caixa de texto:');
define('_LANG_WAO_WRITING_FORMAT','Formata��o:');
define('_LANG_WAO_WRITING_ENCODE','Codifica��o:');
define('_LANG_WAO_WRITING_SERVICES','Atualizar servi�os');
define('_LANG_WAO_WRITING_SOMETHING','Digite os sites que voc� gostaria de avisar quando publicar um novo texto. Para uma lista de sites recomendados a fazer ping, por favor veja [LINK TO SOMETHING]. Separar URLs m�ltiplos por quebra-linhas.');
define('_LANG_WAO_WRITING_UPDATE','Enviar');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Op��es de discuss�o');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Configura��es padr�o para um artigo: <em>(estas configura��es podem ser sobrepostas por artigos individuais.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Tentar avisar alguns weblogs linkados sobre o artigo. (deixa os posts mais lentos.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Aceitar aviso de outros weblogs. (pingbacks e trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Permitir que coment�rios sejam enviados nos artigos');
define('_LANG_WAO_DISCUSS_EMAIL','Contatar-me quando:');
define('_LANG_WAO_DISCUSS_ANYONE','Um coment�rio for postado');
define('_LANG_WAO_DISCUSS_DECLINED','Um coment�rio for aceito ou rejeitado');
define('_LANG_WAO_DISCUSS_APPEARS','Antes que um coment�rio apare�a:');
define('_LANG_WAO_DISCUSS_ADMIN','Um administrador deve aprovar o coment�rio (independente de qualquer op��o acima)');
define('_LANG_WAO_DISCUSS_MODERATION','Quando um coment�rio tiver alguma destas palavras em seu conte�do, nome, URL, ou e-mail, coloc�-lo na fila de modera��o: (separar novas palavras por quebra-linha.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Op��es de leitura');
define('_LANG_WAO_READING_FRONT','Pagina frontal');
define('_LANG_WAO_READING_RECENT','Mostrar os mais recentes:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','Para cada artigo, mostrar:');
define('_LANG_WAO_READING_ENCODE','Codifica��o para paginas e feeds:');
define('_LANG_WAO_READING_CHARACTER','A codifica��o usada no seu blog (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 recomendado</a>)');
define('_LANG_WAO_READING_GZIP','Permitir que o WordPress comprima os artigos em gzip caso os visitantes pe�am por eles');
define('_LANG_WAO_READING_BTNTXT','Enviar');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','Voc� n�o tem permiss�o para realizar esta opera��o.');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','<p>O arquivo <code>wp-config.php</code> n�o existe. Ele � necess�rio na instala��o do WordPress ME. Precisa de ajuda? Clique <a href="http://wordpress.org/docs/faq/#wp-config">aqui</a>. Voc� pode <a href="wp-admin/install-config.php">criar um arquivo <code>wp-config.php</code></a> na interface web. Para isso, � preciso dar as permiss�es de escrita corretamente (707~777), mas ela pode n�o funcionar em todos os servidores. O jeito mais seguro � cri�-lo manualmente.</p>');
define('_LANG_INST_GUIDE_INSTALLED','<p>O WordPress j� est� instalado. Se voc� quiser reinstal�-lo, apague as informa��es antigas.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Bem-vindo ao WordPress. Voc� ter� que passar por algumas etapas antes de ter rodando a �ltima em plataformas de publica��o pessoal. Antes de come�ar, lembre-se de que � necess�ria pelo menos a vers�o 4.0.6 do PHP.');
define('_LANG_INST_GUIDE_COM','Voc� tamb�m deve determinar as configura��es do banco de dados no <code>wp-config.php</code>. Voc� deve alterar a permiss�o do arquivo weblogs.com.changes.cache para 666.<br />Veja o leia-me <a href="../wp-readme/">aqui</a>.</p> Se voc� estiver pronto, clique <a href="install.php?step=1">aqui</a>.');
define('_LANG_INST_STEP1_FIRST','<p>O banco de dados de links ser� configurado. Isso te permitir� hospedar seu pr�prio blogroll completo, com atualiza��es do Weblogs.com.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Instalando WP-Links.</p><p>Checando as tabelas...</p>');
define('_LANG_INST_STEP1_ALLDONE','Perfeito! Voc� est� pronto para o <a href="install.php?step=2">2� passo</a>.');
define('_LANG_INST_STEP2_INFO','As tabelas necess�rias para o blog ser�o criadas no banco de dados.');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','URL do blog (sem a barra invertida).');
define('_LANG_INST_BASE_VALUE2','Nome do arquivo padr�o do blog.');
define('_LANG_INST_BASE_VALUE3','Nome do blog.');
define('_LANG_INST_BASE_VALUE4','Descri��o do seu blog.');
define('_LANG_INST_BASE_VALUE7','Permitir que novos usu�rios possam postar depois de cadastrados.');
define('_LANG_INST_BASE_VALUE8','Permitir que os visitantes se cadastrem no seu blog.');
define('_LANG_INST_BASE_VALUE54','E-mail do administrador.');
// general blog setup
define('_LANG_INST_BASE_VALUE9','O dia em que a semana come�a.');
define('_LANG_INST_BASE_VALUE11','Usar BBCode. Ex.: [b]negrito[/b].');
define('_LANG_INST_BASE_VALUE12','Usar GreyMatter-styles. Ex.: **negrito** \\\\it�lico\\\\ __sublinhado__.');
define('_LANG_INST_BASE_VALUE13','Ativar bot�es de HTML tags. (ainda n�o funcionam no IE do Mac)');
define('_LANG_INST_BASE_VALUE14','ATEN��O: desative isto caso esteja usando Chin�s, Japon�s, Coreano, ou outro idioma multi-byte.');
define('_LANG_INST_BASE_VALUE15','Isto deve ajudar a equilibrar o c�digo HTML. Caso d� maus resultados, basta desativ�-lo.');
define('_LANG_INST_BASE_VALUE16','Ativar a transforma��o de smilies nos seus posts. (NOTA: ela � feita em TODOS os posts)');
define('_LANG_INST_BASE_VALUE17','Diret�rio de smilies. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE18','Ative isto para fazer de e-mail and nome campos obrigat�rios.');
define('_LANG_INST_BASE_VALUE20','Ativar aviso de novos coment�rios aos autores dos posts.');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','N�mero de �ltimos posts a sindicar.');
define('_LANG_INST_BASE_VALUE22','Idioma do blog (veja <a href="http://backend.userland.com/stories/storyReader$16" target="_blank">http://backend.userland.com/stories/storyReader$16</a>)');
define('_LANG_INST_BASE_VALUE23','Permitir HTML codificado na tag &lt;description> do b2rss.php.');
define('_LANG_INST_BASE_VALUE24','Tamanho dos excertos no RSS feed? (0=ilimitado) NOTA: no b2rss.php, ele ser� desativado se voc� usa HTML codificado');
define('_LANG_INST_BASE_VALUE25','Usar o campo excerto para RSS feed.');
define('_LANG_INST_BASE_VALUE26','Listar em http://weblogs.com quando um novo post for feito.');
define('_LANG_INST_BASE_VALUE27','Listar em http://blo.gs quando um novo post for feito.');
define('_LANG_INST_BASE_VALUE28','Voc� n�o deve precisar mudar isto.');
define('_LANG_INST_BASE_VALUE29','Permitir trackbacks. Se desativado, o envio de trackbacks tamb�m ser� desligado.');
define('_LANG_INST_BASE_VALUE30','Permitir pingbacks. Se desativado, o envio de pingbacks tamb�m ser� desligado.');
define('_LANG_INST_BASE_VALUE31','Permitir o upload de arquivos');
define('_LANG_INST_BASE_VALUE32','Digite o caminho real do diret�rio onde as imagens ser�o armazenadas. Se n�o tiver certeza do que � isto, por favor contate seu host. NOTA: o diret�rio deve ter permiss�o de escrita pelo servidor (CHMOD 766).');
define('_LANG_INST_BASE_VALUE33','Digite a URL do diret�rio. Ela ser� usada para gerar os links das imagens.');
define('_LANG_INST_BASE_VALUE34','Extens�es de arquivos permitidas, separadas por espa�o.');
define('_LANG_INST_BASE_VALUE35','Por padr�o, na maioria dos servidores o upload de arquivos � 2048 KB. Para determinar um valor menor, mude isto. (voc� n�o poder� determinar um valor maior do que o limite do seu servidor)');
define('_LANG_INST_BASE_VALUE36','Caso n�o queira permitir o upload de arquivos � todos os usu�rios, escolha um n�vel m�nimo,');
define('_LANG_INST_BASE_VALUE37','Ou voc� pode especificar apenas alguns usu�rios. Digite seus nomes de usu�rio, separados por espa�o. Se voc� deixar esta vari�vel em branco, todos os usu�rios com o n�vel m�nimo poder�o fazer o upload de arquivos.');
/* email settings */
define('_LANG_INST_BASE_VALUE38','Servidor de e-mail.');
define('_LANG_INST_BASE_VALUE39','Nome de usu�rio.');
define('_LANG_INST_BASE_VALUE40','Senha.');
define('_LANG_INST_BASE_VALUE41','Porta.');
define('_LANG_INST_BASE_VALUE42','Por padr�o, os posts ter�o esta categoria.');
define('_LANG_INST_BASE_VALUE43','Prefixo do assunto');
define('_LANG_INST_BASE_VALUE44','Body terminator string (a partir disto, tudo ser� ignorado)');
define('_LANG_INST_BASE_VALUE45','Ativa modo de teste.');
define('_LANG_INST_BASE_VALUE46','Ative isto caso seu servi�o de e-mail por celulares envie assunto e conte�do id�nticos na mesma linha.');
define('_LANG_INST_BASE_VALUE47','Se voc� ativou a op��o acima, quando redigir uma mensagem, voc� ter� que digitar o assunto, o string separador, usu�rio:senha, o string separador, e o conte�do.');
define('_LANG_INST_BASE_VALUE48','N�mero de posts mostrados na p�gina principal.');
define('_LANG_INST_BASE_VALUE49','Posts, dias, ou posts arquivados.');
define('_LANG_INST_BASE_VALUE50','Tipo de arquivo.');
define('_LANG_INST_BASE_VALUE51','Diferen�a entre o seu fuso hor�rio e o do seu servidor.');
define('_LANG_INST_BASE_VALUE52','Ver <a href="http://www.php.net/manual/pt_BR/function.date.php" target="_blank">ajuda</a> para formato de data.');
define('_LANG_INST_BASE_VALUE53','Ver <a href="http://www.php.net/manual/pt_BR/function.date.php" target="_blank">ajuda</a> para formato de hora.');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Outras configura��es');
define('_LANG_INST_BASE_HELP2','Configura��es gerais do blog');
define('_LANG_INST_BASE_HELP3','Configura��es de RSS/RDF feeds e track/ping-backs');
define('_LANG_INST_BASE_HELP4','Configura��es de upload de arquivos');
define('_LANG_INST_BASE_HELP5','Configura��es de postagem via e-mail');
define('_LANG_INST_BASE_HELP6','Configura��es b�sicas');
define('_LANG_INST_BASE_HELP7','Configura��es padr�o de postagem');
define('_LANG_INST_BASE_HELP8','Configura��es de links');
define('_LANG_INST_BASE_HELP9','Configura��es geogr�ficas');
define('_LANG_INST_BASE_VALUE55','O estado padr�o dos novos posts.');
define('_LANG_INST_BASE_VALUE56','O estado padr�o dos coment�rios dos novos posts.');
define('_LANG_INST_BASE_VALUE57','O estado padr�o do ping dos novos posts.');
define('_LANG_INST_BASE_VALUE58','Ativar \'Fazer pingback as URLs neste post\' por padr�o.');
define('_LANG_INST_BASE_VALUE59','A categoria padr�o dos novos posts.');
define('_LANG_INST_BASE_VALUE83','O n�mero de linhas no formul�rio de edi��o. (m�n. 3, m�x. 100)');
define('_LANG_INST_BASE_VALUE60','N�vel m�nimo para editar os links.');
define('_LANG_INST_BASE_VALUE61','Desative isto para ter os links vis�veis e edit�veis por todos no gerenciador de links.');
define('_LANG_INST_BASE_VALUE62','Escolha qual o tipo de avalia��o a utilizar.');
define('_LANG_INST_BASE_VALUE63','Se caracter, qual usar?');
define('_LANG_INST_BASE_VALUE64','Ative para ignorar valores "0", ou desative para process�-lo normalmente. (N�mero/Imagem)');
define('_LANG_INST_BASE_VALUE65','Usar a mesma imagem para cada ponto de avalia��o?');
define('_LANG_INST_BASE_VALUE66','Imagem 0 para avalia��o.');
define('_LANG_INST_BASE_VALUE67','Imagem 1 para avalia��o.');
define('_LANG_INST_BASE_VALUE68','Imagem 2 para avalia��o.');
define('_LANG_INST_BASE_VALUE69','Imagem 3 para avalia��o.');
define('_LANG_INST_BASE_VALUE70','Imagem 4 para avalia��o.');
define('_LANG_INST_BASE_VALUE71','Imagem 5 para avalia��o.');
define('_LANG_INST_BASE_VALUE72','Imagem 6 para avalia��o.');
define('_LANG_INST_BASE_VALUE73','Imagem 7 para avalia��o.');
define('_LANG_INST_BASE_VALUE74','Imagem 8 para avalia��o.');
define('_LANG_INST_BASE_VALUE75','Imagem 9 para avalia��o.');
define('_LANG_INST_BASE_VALUE76','O caminho para o cache deve ter permiss�o de escrita pelo servidor.');
define('_LANG_INST_BASE_VALUE77','Receber arquivos de weblogs.com.');
define('_LANG_INST_BASE_VALUE78','Tempo de cache em minutos.');
define('_LANG_INST_BASE_VALUE79','Formato de data e hora.');
define('_LANG_INST_BASE_VALUE80','Texto anexado � um link recente. (Pr�ximo)');
define('_LANG_INST_BASE_VALUE81','Texto anexado � um link recente. (Anterior)');
define('_LANG_INST_BASE_VALUE82','Tempo em minutos para considerar um link recentemente atualizado.');
define('_LANG_INST_BASE_VALUE84','Ativar GeoURL no WordPress.');
define('_LANG_INST_BASE_VALUE85','Ativar localiza��o GeoURL ICBM padr�o quando nenhuma for especificada.');
define('_LANG_INST_BASE_VALUE86','O valor padr�o da latitude ICBM - Veja <a href="http://www.geourl.org/resources.html" target="_blank">aqui</a>.');
define('_LANG_INST_BASE_VALUE87','O valor-padr�o da longitude ICBM');
/* Last Question */
define('_LANG_INST_STEP2_LAST','H� apenas algumas coisas que precisam ser informadas:');
define('_LANG_INST_STEP2_URL','Usu�rio criado com sucesso.');
define('_LANG_INST_STEP3_SET','<p>Agora voc� pode se <a href="../wp-login.php">identificar</a> com o <strong>usu�rio</strong> "admin" e <strong>senha</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Anote a senha</em></strong> com cuidado! � uma senha <em>randon�mica</em> gerada especialmente para voc�. Se voc� perd�-la, ter� que apagar as tabelas do banco de dados e reinstalar o WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Instala��o completada com sucesso!');
define('_LANG_INST_CAUTIONS','<ul><li>Diret�rio : [755]</li><li>wp-config.php : [604~644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','Parece que o arquivo wp-config.php n�o existe. Verifique se voc� atualizou o wp-config.sample.php com as informa��es corretas do banco de dados e renomeou-o para wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>Este arquivo atualiza seu WordPress para a �ltima vers�o. Seja paciente, pode levar alguns instantes. </p><p>Se voc� estiver pronto, clique <a href="upgrade.php?step=1">aqui</a>.</p>');
define('_LANG_UPG_STEP_INFO3','<p>� uma �nica etapa, portanto se voc� est� vendo isso, � porque a atualiza��o foi conclu�da. <a href="../">Divirta-se</a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','Mostrar coment�rios apenas ap�s serem aprovados.');
define('_LANG_INST_BASE_VALUE89','Avisar sobre novos coment�rios pendentes de aprova��o.');
define('_LANG_INST_BASE_VALUE90','Como os permalinks para o seu site s�o feitos. Veja <a href=\"options-permalink.php\">Configura��es de permalinks</a> para as regras mod_rewrite necess�rias e maiores informa��es.');
define('_LANG_INST_BASE_VALUE91','Se o arquivo de destino deve ser Gzip ou n�o. Ative-o se voc� n�o tiver mod_gzip rodando ainda.');
define('_LANG_INST_BASE_VALUE92','Altere este valor para verdadeiro se voc� planeja usar arquivos hackeados. Aqui voc� poder� guardar c�digos hackeados que n�o ser�o sobreescritos quando voc� atualizar. O arquivo deve estar na pasta raiz do wordpress e se chamar <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','Diferen�a em horas entre o fuso hor�rio do servidor e o seu.');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','Para instalar um plug-in, � necess�rio ter pelo menos n�vel 8.');
define('_LANG_PG_ACTIVATED_OK','Plug-ins <strong>ativados</strong>');
define('_LANG_PG_DEACTIVATED_OK','Plug-ins <strong>desativados</strong>');
define('_LANG_PG_PAGE_TITLE','Gerenciamento de plug-ins');
define('_LANG_PG_NEED_PUT','Plug-ins s�o arquivos especiais que servem para adicionar novas op��es no WordPress. Para instalar um plug-in, basta colocar os arquivos no diret�rio <code>wp-content/plugins</code>. Caso queira instalar um plug-in temporariamente, � poss�vel ativ�-lo e desativ�-lo nesta p�gina.');
define('_LANG_PG_OPEN_ERROR','N�o � poss�vel acessar o diret�rio "plugins" ou n�o existem plug-ins a serem instalados.');
define('_LANG_PG_SUB_PLUGIN','Plug-in');
define('_LANG_PG_SUB_VERSION','Vers�o');
define('_LANG_PG_SUB_AUTHOR','Autor');
define('_LANG_PG_SUB_DESCR','Descri��o');
define('_LANG_PG_SUB_ACTION','A��o');
define('_LANG_PG_SUB_DEACTIVATE','Desativar');
define('_LANG_PG_SUB_ACTIVATE','Ativar');
define('_LANG_PG_GOOGLE_HILITE','Quando algu�m � indicado por um site de busca como Google e Yahoo, ou a pesquisa interna do WordPress, os termos pesquisados s�o marcados com este plug-in. Pacote por <a href="http://photomatt.net/">Matt</a>.');
define('_LANG_PG_MARK_DOWN','Markdown � um conversor de texto para HTML para programadores. A <a href="http://daringfireball.net/projects/markdown/syntax">s�ntaxe Markdown</a> permite � voc� escrever em formato texto e convert�-lo em um XHTML estruturalmente v�lido. Este plug-in ativa <strong>Markdown</strong> em seus posts e coment�rios. Escrito por <a href="http://daringfireball.net/">John Gruber</a> em Perl, portado para PHP por <a href="http://www.michelf.com/">Michel Fortin</a>, e transformado em plug-in WP por <a href="http://photomatt.net/">Matt</a>. Se voc� ativar este plug-in, voc� deve desativar o Textile 1 e 2 por causa do conflito de s�ntaxe.');
define('_LANG_PG_TEXTILE_2','Este � um wrapper simples para o Humane Web Text Generator de <a href="http://textism.com/?wp">Dean Allen</a>, tamb�m conhecido como <a href="http://www.textism.com/tools/textile/">Textile</a>. A vers�o 2 d� muita flexibilidade, o que faz dele quase um HTML meta-linguagem, por�m � mais lento. Se voc� ativar este plug-in, deve desativar o Textile 1 e Markdown, pois eles n�o funcionam bem juntos.');
define('_LANG_PG_HELLO_DOLLY','Este n�o � apenas um plug-in, ele simboliza a esperan�a e o entusiasmo de uma gera��o inteira somada em 2 palavras cantadas por Louis Armstrong. Este � o primeiro plug-in oficial do WordPress no mundo inteiro. Quando ativado, ele mostra randonomicamente uma frase de <cite>Hello, Dolly</cite> em todas as p�ginas da Administra��o, exceto nas configura��es de plug-ins.');
define('_LANG_PG_TEXTILE_1','Este � um wrapper simples para o Humane Web Text Generator de <a href="http://textism.com/?wp">Dean Allen</a>, tamb�m conhecido como <a href="http://www.textism.com/tools/textile/">Textile</a>. Se voc� ativar este plug-in, deve desativar o Textile 2 e Markdown, pois eles n�o funcionam muito bem juntos.');
}
?>