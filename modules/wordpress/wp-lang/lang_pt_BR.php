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
define('_LANG_WA_SETTING_GUIDE','<p>O WordPress ME ainda não está instalado. Clique <a href=\'wp-admin/install.php\'>aqui</a> para iniciar a instalação.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>O arquivo <code>wp-config.php</code> não existe. Ele é necessário para instalar o WordPress ME. Precisa de ajuda? Clique <a href=\'http://wordpress.org/docs/faq/#wp-config\'>aqui</a>. Você pode <a href=\'wp-admin/install-config.php\'>criar um arquivo <code>wp-config.php</code> na interface web</a>. Para isso, é necessário que as permissões de escrita estejam ativadas (707~777), mas ele pode não funcionar em todos os servidores. O jeito mais seguro é criá-lo manualmente.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>O arquivo \'wp-config.php\' já existe. Se você deseja zerar alguma configuração neste arquivo, por favor delete-o primeiro.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Desculpe, é preciso de um arquivo wp-config-sample.php para continuar. Por favor, reenvie este arquivo da sua instalação do WordPress.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Desculpe, não é possível escrever no diretório. Por favor, dê as permissões de escrita ao diretório do WordPress ou crie seu wp-config.php manualmente usando o arquivo wp-config-sample.php como referência.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Bem-vindo ao WordPress. Antes de começar, serão necessárias algumas informações sobre o banco de dados. Você terá que ter os seguintes dados antes de prosseguir.');
define('_LANG_WA_CONFIG_DATABASE','Nome do banco de dados');
define('_LANG_WA_CONFIG_USERNAME','Usuário');
define('_LANG_WA_CONFIG_PASSWORD','Senha');
define('_LANG_WA_CONFIG_LOCALHOST','Hostname');
define('_LANG_WA_CONFIG_PREFIX','Prefixo da tabela');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Se por alguma razão a criação automática de arquivos não funcionar, não se preocupe, pois tudo o que ele faz é transferir os dados para um arquivo de configuração. Você também pode simplesmente abrir o arquivo <code>wp-config-sample.php</code> em um editor de textos, alterar as configurações, e salvá-lo como <code>wp-config.php</code>. </strong></p><p>Provavelmente, esses dados foram fornecidos à você pelo seu provedor. Se você não tivé-los, você precisará contatá-los antes de continuar. Caso você esteja pronto, clique <a href="install-config.php?step=1">aqui</a>.');
define('_LANG_WA_CONFIG_GUIDE6','Digite abaixo os dados da sua conexão do banco de dados. Se você não tiver certeza sobre eles, contate seu host.');
define('_LANG_WA_CONFIG_GUIDE7','<small>O nome do banco de dados onde o WordPress ME será instalado. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Nome de Usuário do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>Senha do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>Em 99% dos casos, você não terá que mudar isso.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Se você for rodar várias instalações do WordPress ME em um único banco de dados, mude isto.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Pronto! As informações necessárias estão corretas. WordPress ME estabeleceu uma conexão com seu banco de dados corretamente. Se estiver pronto, clique <a href="install.php">aqui</a> para instalar.');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>Não foi possível estabelecer uma conexão com o banco de dados.</strong>Isso significa que as informações da conexão no seu arquivo <code>wp-config.php</code> podem estar incorretas. Cheque-as e tente novamente.');
define('_LANG_WA_WPDB_GUIDE2','Tem certeza de que o nome de usuário/senha estão corretos?');
define('_LANG_WA_WPDB_GUIDE3','Tem certeza de que você o hostname está correto?');
define('_LANG_WA_WPDB_GUIDE4','Tem certeza de que o servidor do banco de dados está rodando?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Editar hora');
define('_LANG_F_NEW_COMMENT','Tem um comentário novo no seu post');
define('_LANG_F_ALL_COMMENTS','Você pode ver todos os comentários deste post aqui:');
define('_LANG_F_NEW_TRACKBACK','Tem uma nova trackback no seu post');
define('_LANG_F_ALL_TRACKBACKS','Você pode ver todas as trackbacks deste post aqui:');
define('_LANG_F_NEW_PINGBACK','Tem um novo pingback no seu post');
define('_LANG_F_ALL_PINGBACKS','Você pode ver todos os pingbacks deste post aqui:');
define('_LANG_F_COMMENT_POST','Tem um novo comentário no post');
define('_LANG_F_WAITING_APPROVAL','está esperando pela sua aprovação');
define('_LANG_F_APPROVAL_VISIT','Para aprovar este comentário:');
define('_LANG_F_DELETE_VISIT','Para deletar este comentário:');
define('_LANG_F_PLEASE_VISIT','No momento, existem comentários esperando pela sua aprovação. Por favor, vá para o Painel de Moderação:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERRO</strong>: Por favor, escolha um nome de usuário.');
define('_LANG_R_PASS_TWICE','<strong>ERRO</strong>: Por favor, repita sua senha.');
define('_LANG_R_SAME_PASS','<strong>ERRO</strong>: Por favor, repita a mesma senha nos dois campos.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERRO</strong>: Por favor, digite seu endereço de e-mail.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERRO</strong>: O endereço de e-mail é inválido.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERRO</strong>: Este nome de usuário já existe. Por favor, escolha outro.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERRO</strong>: Não foi possível realizar o cadastro. Por favor, contate o administrador.');
define('_LANG_R_USER_REGISTRATION','Novo Usuário no seu Blog');
define('_LANG_R_MAIL_REGISTRATION','Novo Cadastro de Usuário');
define('_LANG_R_R_COMPLETE','Cadastro Completado');
define('_LANG_R_R_DISABLED','Cadastro Desativado');
define('_LANG_R_R_CLOSED','No momento, não são aceitos cadastros.');
define('_LANG_R_R_REGISTRATION','Cadastro');
define('_LANG_R_USER_LOGIN','Usuário:');
define('_LANG_R_USER_PASSWORD','Senha:');
define('_LANG_R_TWICE_PASSWORD','Repete Senha:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','Preencha o campo nome de usuário.');
define('_LANG_L_PASS_EMPTY','Preencha o campo senha.');
define('_LANG_L_WRONG_LOGPASS','O nome de usuário ou senha são inválidos.');
define('_LANG_L_RECEIVE_PASSWORD','Por favor, preencha seus dados e te enviaremos uma nova senha.');
define('_LANG_L_EXIST_SORRY','Este usuário não existe. Clique <a href="wp-login.php?action=lostpassword">aqui</a> para receber sua senha por e-mail.');
define('_LANG_L_YOUR_LOGPASS','Usuário/senha do WordPress');
define('_LANG_L_NOT_SENT','O e-mail não pôde ser enviado.');
define('_LANG_L_DISABLED_FUNC','Possível razão: seu servidor pode ter desativado a função mail().');

define('_LANG_L_SUCCESS_SEND',' : O e-mail foi enviado com sucesso.');
define('_LANG_L_CLICK_ENTER','Clique aqui para se conectar!');
define('_LANG_L_WRONG_SESSION','Erro: usuário/senha inválidos');
define('_LANG_L_BACK_BLOG','Voltar ao blog');
define('_LANG_L_WP_RESIST','Cadastrar-se');
define('_LANG_L_WPLOST_YOURPASS','Esqueceu sua senha?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Como você é um novato, você terá que esperar até que um administrador aumente seu nível para 1 para poder postar.<br />Você tambem pode enviar um e-mail ao administrador pedindo uma promoção.<br />Quando você for promovido, basta atualizar esta página e você poderá bloggar.');
define('_LANG_P_DATARIGHT_EDIT',', você não tem permissão para editar posts.');
define('_LANG_P_DATARIGHT_DELETE',', você não tem permissão para deletar posts.');
define('_LANG_P_DATARIGHT_ERROR','Erro ao deletar. Contate o administrador.');
define('_LANG_P_OOPS_IDCOM','Não existem comentários com este ID.');
define('_LANG_P_OOPS_IDPOS','Não existem posts com este ID.');
define('_LANG_P_ABOUT_FOLLOW','Você esta prestes a deletar o seguinte comentário:');
define('_LANG_P_SURE_THAT','Tem certeza de que deseja continuar?');
define('_LANG_P_NICKNAME_DELETE','Você não tem permissão para deletar comentários de posts.');
define('_LANG_P_COMHAS_APPR','O comentário foi aprovado.');
define('_LANG_P_YOUR_DRAFTS','Seus rascunhos:');
define('_LANG_P_WP_BOOKMARKLET','Você pode arrastar o link seguinte para sua barra de links ou adicioná-lo ao seus Favoritos. Quando você clicar sobre ele, se abrirá uma janela popup com informações e um link para o site que você esta visitando agora, permitindo que você faca um post rapido nele.');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','Não é possível deletar esta categoria pois ela é a padrão.');
define('_LANG_C_EDIT_TITLECAT','Editar Categoria');
define('_LANG_C_NAME_SUBCAT','Nome da categoria:');
define('_LANG_C_NAME_SUBDESC','Descrição:');
define('_LANG_C_RIGHT_EDITCAT','Você não tem permissão para alterar as categorias deste blog.<br />Peça uma promoção ao administrador do blog.');
define('_LANG_C_NAME_CURRCAT','Categorias Existentes');
define('_LANG_C_NAME_CATNAME','Nome');
define('_LANG_C_NAME_CATDESC','Descrição:');
define('_LANG_C_NAME_CATPOSTS','Nº de Posts');
define('_LANG_C_NAME_CATACTION','Ação');
define('_LANG_C_ADD_NEWCAT','Adicionar Nova Categoria');
define('_LANG_C_NOTE_CATEGORY','<strong>Nota:</strong><br />Deletar uma categoria não exclui os posts existentes nela, apenas move-os à categoria-padrão.');
define('_LANG_C_NAME_EDIT','EDITAR');
define('_LANG_C_NAME_DELETE','DELETAR');
define('_LANG_C_NAME_ADD','Adicionar');
define('_LANG_C_NAME_EDITBTN','Editar Categoria');
define('_LANG_C_NAME_PARENT','Categoria-padrão:');

/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','Últimos Posts');
define('_LANG_E_LATEST_COMMENTS','Últimos Comentários');
define('_LANG_E_AWAIT_MODER','Comentários Esperando por Moderação');
define('_LANG_E_SHOW_POSTS','Mostrar posts:');
define('_LANG_E_TITLE_COMMENTS','Comentários');
define('_LANG_E_FILL_REQUIRED','Erro: por favor, preencha os campos obrigatórios (nome e comentário)');
define('_LANG_E_TITLE_LEAVECOM','Deixar Comentário');
define('_LANG_E_RESULTS_FOUND','Nenhum resultado foi encontrado.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Mostrar Comentário:');
define('_LANG_EC_EDIT_COM','Editar Comentário');
define('_LANG_EC_DELETE_COM','Deletar Comentário');
define('_LANG_EC_EDIT_POST','Editar Post &#8220;');
define('_LANG_EC_VIEW_POST','Ver Post');
define('_LANG_EC_SEARCH_MODE','Pesquisas dentro dos comentários, e-mail, URI e endereço IP.');
define('_LANG_EC_VIEW_MODE','Modo de Visão');
define('_LANG_EC_EDIT_MODE','Modo de Edição em Massa');
define('_LANG_EC_CHECK_INVERT','Inverter Caixa de Seleção');
define('_LANG_EC_CHECK_DELETE','Deletar os Comentários Selecionados');
define('_LANG_EC_LINK_VIEW','Ver');
define('_LANG_EC_LINK_EDIT','Editar');
define('_LANG_EC_LINK_DELETE','Deletar');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback"><strong>Fazer PingBack</strong> nas <acronym title="Uniform Resource Locators">URL</acronym>s dos posts</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Ajuda com Pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Ajuda com trackbacks"><strong>Fazer TrackBack</strong> numa <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Separar múltiplas <acronym title="Uniform Resource Locator">URL</acronym>s por espaços.)<br />');
define('_LANG_EF_AD_POSTTITLE','Título');
define('_LANG_EF_AD_CATETITLE','Categorias');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Salvar como Rascunho');
define('_LANG_EF_AD_PRIVATE','Salvar como Particular');
define('_LANG_EF_AD_PUBLISH','Publicar');
define('_LANG_EF_AD_EDITING','Edição Avançada &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Estado do Post');
define('_LANG_EFA_AD_COMMENTS','Comentários');
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
define('_LANG_EFA_STATUS_DISCUSS','Discussão');
define('_LANG_EFA_STATUS_ALLOWC','Permitir Comentários');
define('_LANG_EFA_STATUS_ALLOWP','Permitir Pings');
define('_LANG_EFA_STATUS_SLUG','Separador de Post');
define('_LANG_EFA_STATUS_POST','Postar');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Enviar');
define('_LANG_EFC_COM_NAME','Nome:');
define('_LANG_EFC_COM_MAIL','E-Mail:');
define('_LANG_EFC_COM_URI','Website:');
define('_LANG_EFC_COM_COMMENT','Comentário:');

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
define('_LANG_WLA_SUB_DESC','Descrição');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN');
define('_LANG_WLA_SUB_NOTE','Notas:');
define('_LANG_WLA_SUB_RATE','Classificação:');
define('_LANG_WLA_SUB_TARGET','Público');
define('_LANG_WLA_SUB_VISIBLE','Visível:');
define('_LANG_WLA_SUB_CAT','Categoria:');
define('_LANG_WLA_SUB_FRIEND','amizades');
define('_LANG_WLA_SUB_PHYSICAL','fisica');
define('_LANG_WLA_SUB_PROFESSIONAL','profissional');
define('_LANG_WLA_SUB_GEOGRAPH','geográfica');
define('_LANG_WLA_SUB_FAMILY','familiar');
define('_LANG_WLA_SUB_ROMANTIC','romântica');
define('_LANG_WLA_CHECK_ACQUA','conhecidos');
define('_LANG_WLA_CHECK_FRIE','amigos');
define('_LANG_WLA_CHECK_NONE','nenhum');
define('_LANG_WLA_CHECK_MET','encontros');
define('_LANG_WLA_CHECK_WORKER','sócios');
define('_LANG_WLA_CHECK_COLL','colegas');
define('_LANG_WLA_CHECK_RESI','colegas de quarto');
define('_LANG_WLA_CHECK_NEIG','vizinhos');
define('_LANG_WLA_CHECK_CHILD','crianças');
define('_LANG_WLA_CHECK_PARENT','pais');
define('_LANG_WLA_CHECK_SIBLING','irmãos');
define('_LANG_WLA_CHECK_SPOUSE','esposa');
define('_LANG_WLA_CHECK_MUSE','musa');
define('_LANG_WLA_CHECK_CRUSH','esmagamento');
define('_LANG_WLA_CHECK_DATE','encontro');
define('_LANG_WLA_CHECK_HEART','namorados');
define('_LANG_WLA_CHECK_ZERO','Deixe em 0 para nenhuma classificação.');
define('_LANG_WLA_CHECK_STRICT','Note que o código do atributo <code>target</code> é ilegal em XHTML 1.1 e restrito à 1.0.');
define('_LANG_WLA_TEXT_TOOLBAR','Você pode arrastar "Link This" para sua barra de tarefas. Ao clicá-la, uma janela pop-up permitirá à você adicionar qualquer site em que você estiver aos seus links. (No momento, funciona apenas no Mozilla ou Netscape)');
define('_LANG_WLA_BUTTON_TEXTNAME','Adicionar Link');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Não é possível deletar esta categoria de link pois ela é a padrão.');
define('_LANG_WLC_TITLE_TEXT','Editar Categorias de Link &#8220;');
define('_LANG_WLC_EPAGE_TITLE','<strong>Editar</strong> uma categoria de link:');
define('_LANG_WLC_ADD_TITLE','Adicionar uma Categoria de Link:');
define('_LANG_WLC_SUBEDIT_NAME','Nome:');
define('_LANG_WLC_SUBEDIT_TOGGLE','Auto-toggle?');
define('_LANG_WLC_SUBEDIT_SHOW','Mostrar:');
define('_LANG_WLC_SUBEDIT_ORDER','Ordem de exibição:');
define('_LANG_WLC_SUBEDIT_IMAGES','imagens');
define('_LANG_WLC_SUBEDIT_DESC','descrição');
define('_LANG_WLC_SUBEDIT_RATE','classificação');
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
define('_LANG_WLC_SUBCATE_SORT','Ordem de Exibição ');
define('_LANG_WLC_SUBCATE_DESC','Descende de?');
define('_LANG_WLC_SUBCATE_LIMIT','Limite');
define('_LANG_WLC_SUBCATE_IMAGES','imagens?');
define('_LANG_WLC_SUBCATE_MINIDESC','descende de?');
define('_LANG_WLC_SUBCATE_RATE','classificação?');
define('_LANG_WLC_SUBCATE_UPDATE','atualização?');
define('_LANG_WLC_SUBCATE_BEFORE','antes');
define('_LANG_WLC_SUBCATE_BETWEEN','entre');
define('_LANG_WLC_SUBCATE_AFTER','depois');
define('_LANG_WLC_SUBCATE_EDIT','Editar');
define('_LANG_WLC_SUBCATE_DELETE','Deletar');
define('_LANG_WLC_SUBEDIT_EMPTY','Quantos links serão mostrados. Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_EMPTY','Deixe em branco para ilimitados');
define('_LANG_WLC_EPAGE_NOTE','Deletar uma categoria de links não remove os links contidos nela, apenas move-os a categoria-padrão:');
define('_LANG_WLC_RIGHT_PROM','Você não tem permissão para editar as categorias de links deste blog.<br>Peça uma promoção ao administrador do blog.');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Importar Blogroll');
define('_LANG_WLI_ROLL_DESC','Importar sua blogroll de outro sistema ');
define('_LANG_WLI_ROLL_OPMLCODE','Vá em Blogrolling.com e conecte-se. Depois, clique em <strong>Get Code</strong>, e procure pelo <strong>codigo <abbr title="Outline Processor Markup Language">OPML</abbr></strong>');
define('_LANG_WLI_ROLL_OPMLLINK','Ou vá em Blo.gs e conecte-se. Depois, na caixa &#8217;Welcome Back&#8217; da direita, clique em <strong>share</strong>, e então procure pelo <strong>link <abbr title="Outline Processor Markup Language">OPML</abbr></strong> (favorites.opml)');
define('_LANG_WLI_ROLL_BELOW','Selecione o texto e copie-o, ou copie o atalho para esta caixa abaixo.');
define('_LANG_WLI_ROLL_YOURURL','Sua URL OPML:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>ou</strong> você pode enviar seu arquivo OPML da sua Área de Trabalho:');
define('_LANG_WLI_ROLL_THISFILE','Enviar arquivo: ');
define('_LANG_WLI_ROLL_CATEGORY','Agora, escolha a categoria onde você deseja inserir estes links.<br />Categoria: ');
define('_LANG_WLI_ROLL_BUTTONTEXT','Enviar');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Gerenciar Links');
define('_LANG_WLM_LEVEL_ERROR','Você não tem permissão para editar os links para este blog.<br />Peça uma promoção ao administrador do blog.');
define('_LANG_WLM_SHOW_LINKS','<strong>Mostrar</strong> links por categorias:');
define('_LANG_WLM_ORDER_BY','<strong>Ordenar</strong> por:');
define('_LANG_WLM_SHOW_BUTTONTEXT','Mostrar');
define('_LANG_WLM_SHOW_ACTIONTEXT','Ação');
define('_LANG_WLM_MULTI_LINK','Gerenciar Links Múltiplos:');
define('_LANG_WLM_CHECK_CHOOSE','Use as caixas de seleção da direita para selecionar vários links e escolha uma ação abaixo:');
define('_LANG_WLM_ASSIGN_TEXT','Assignar');
define('_LANG_WLM_OWNER_SHIP','pertence a:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibilidade');
define('_LANG_WLM_MOVE_TEXT','Mover');
define('_LANG_WLM_TO_CATEGORY',' para categoria');
define('_LANG_WLM_TOGGLE_BOXES','Caixas de Seleção Toggle');
define('_LANG_WLM_EDIT_LINK','Editar um link:');
define('_LANG_WLM_SAVE_CHANGES','Enviar');
define('_LANG_WLM_EDIT_CANCEL','Cancelar');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Seu nível não é alto o suficiente para moderar comentários. Peça uma promoção ao administrador do blog.');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Comentários');
define('_LANG_WPM_AWIT_MODERATION','Esperando por Moderação');
define('_LANG_WPM_COM_APPROV',' comentário aprovado ');
define('_LANG_WPM_COMS_APPROVS',' comentários aprovados ');
define('_LANG_WPM_COM_DEL',' comentário deletado ');
define('_LANG_WPM_COMS_DELS',' comentários deletados ');
define('_LANG_WPM_COM_UNCHANGE',' comentário inalterado ');
define('_LANG_WPM_COMS_UNCHANGES',' comentários inalterados ');
define('_LANG_WPM_WAIT_APPROVAL','Os seguintes comentários estão a espera de aprovação:');
define('_LANG_WPM_CURR_COMAPP','No momento, não existem comentários a serem aprovados.');
define('_LANG_WPM_DEL_LATER','<p>Para cada comentário você deve escolher entre <em>aprovar</em>, <em>deletar</em> ou <em>deixar para depois</em>:</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>aprovar</em>: aprova o comentário, então ele será visível publicamente.');
define('_LANG_WPM_AUTHOR_NOTIFIED','o autor do post será notificado sobre o novo comentário em seu post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>deletar</em>: remove o conteúdo do blog (nota: você não será consultado novamente, então você deve ter certeza de que deseja realmente remover o comentário - uma vez deletados, não poderão ser recuperados!)</p><p><em>deiar para depois</em>: não muda o estado dos comentários.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderar Comentários');
define('_LANG_WPM_DO_NOTHING','Não fazer nada');
define('_LANG_WPM_DO_DELETE','Deletar');
define('_LANG_WPM_DO_APPROVE','Aprovar');
define('_LANG_WPM_DO_ACTION','Ação:');
define('_LANG_WPM_JUST_THIS','Deletar apenas este comentário');
define('_LANG_WPM_JUST_EDIT','Editar');
define('_LANG_WPM_COMPOST_NAME','Nome:');
define('_LANG_WPM_COMPOST_MAIL','E-mail:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Você não tem permissão para editar as opções deste blog.<br />Peça uma promoção ao administrador do blog.');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Configurações de Links Permanentes');
define('_LANG_WOP_NO_HELPS',' Não existem tópicos de ajuda para este grupo de opções.');
define('_LANG_WOP_SUBMIT_TEXT','Enviar');
define('_LANG_WOP_SETTING_SAVED',' Configurações salvas com sucesso. ');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_STRUCT','Editar Estrutura dos Permalink');
define('_LANG_WPL_CREATE_CUSTOM','WordPress oferece à você a possibilidade de criar uma estrutura URI para os seus permalinks e arquivos. As seguintes &#8220;tags&#8221; estão disponíveis:');
define('_LANG_WPL_CODE_YEAR','O ano, com 4 digitos. Ex.: <code>2004</code>.');
define('_LANG_WPL_CODE_MONTH','O mês do ano. Ex.: <code>05</code>.');
define('_LANG_WPL_CODE_DAY','O dia do mês. Ex.: <code>28</code>.');
define('_LANG_WPL_CODE_POSTNAME','Uma versão limpa do título do post. Ex.: "This Is A Great Post!" vira "this-is-a-great-post" no URI.');
define('_LANG_WPL_CODE_POSTID','O Nº ID único do post. Ex.: <code>423</code>.');
define('_LANG_WPL_USE_EXAMPLE','Um valor como <code>/archives/%year%/%monthnum%/%day%/%postname%/</code> daria um permalink como <code>/archives/2003/05/23/my-cheese-sandwich/</code>. Para que isso funcione, você deverá ter o mod_rewrite instalado em seu servidor para a criação de regras funcionar abaixo. No futuro, poderão haver mais opções.');
define('_LANG_WPL_USE_TEMPTEXT','Use as tags de templates acima:');
define('_LANG_WPL_BEFORE_HTACCESS','Usando o valor da estrutura do permalink, no momento você tem, ');
define('_LANG_WPL_AFTER_HTACCESS',' estas são as regras do mod_rewrite que você deve ter em seu arquivo <code>.htaccess</code>.');
define('_LANG_WPL_MOD_REWRITE','No momento, você não esta usando permalinks personalizados. Nenhuma regra especifica do mod_rewrite é necessária.');
define('_LANG_WPL_SUBMIT_UPDATE','Enviar');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERRO</strong>: por favor, digite seu nick (pode ser o mesmo que o seu nome de usuário).');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERRO</strong>: seu ICQ UIN deve conter apenas números, letras não são permitidas.');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERRO</strong>: por favor, digite seu e-mail.');
define('_LANG_WPF_ERR_CORRECT','<strong>ERRO</strong>: o endereço de e-mail é inválido.');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERRO</strong>: você digitou sua senha apenas uma vez. Volte e digite-a novamente.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERRO</strong>: você digitou duas senhas diferentes. Volte e corrija-a.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERRO</strong>: não foi possível atualizar seu perfil. Por favor, contate o administrador.');
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
define('_LANG_WPF_SUBT_BOOK','Salve-o como wordpress.reg, e clique duas vezes nele numa janela do Explorer.<br />Responda Sim a pergunta, e reinicie o Internet Explorer.<br /><br />Assim, você pode clicar com o botão direito numa janela do Internet Explorer<br />e selecionar "Postar no WP".');
define('_LANG_WPF_SUBT_CLOSE','Fechar esta janela');
define('_LANG_WPF_SUBT_UPDATED','Perfil atualizado com sucesso.');
define('_LANG_WPF_SUBT_EDIT','Editar Seu Perfil');
define('_LANG_WPF_SUBT_USERID','ID:');
define('_LANG_WPF_SUBT_LEVEL','Nível:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Usuário:');
define('_LANG_WPF_SUBT_DESC','Perfil:');
define('_LANG_WPF_SUBT_IDENTITY','Identidade no blog: ');
define('_LANG_WPF_SUBT_NEWPASS','Nova <strong>Senha</strong> (Deixe em branco para manter a mesma.)');
define('_LANG_WPF_SUBT_MOZILLA','Nenhuma SideBar encontrada. Você deve ter Mozilla 0.9.4 ou superior.');
define('_LANG_WPF_SUBT_SIDEBAR','SideBar');
define('_LANG_WPF_SUBT_FAVORITES','Adicionar este link aos Favoritos:');
define('_LANG_WPF_SUBT_UPDATE','Atualizar');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Post enviado com sucesso.');
define('_LANG_WAS_SIDE_AGAIN','Clique <a href="sidebar.php">aqui</a> para postar novamente.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>Você não tem permissão para editar o template deste blog.<br />Peça uma promoção ao administrador do blog.</p>');
define('_LANG_WAT_SORRY_EDIT','Desculpe, não é possível editar arquivos com ".." no nome. Se você estiver tentando editar um arquivo no diretorio raiz do seu WordPress, você deve digitar apenas o nome dele.');
define('_LANG_WAT_SORRY_PATH','Desculpe, não e possível chamar arquivos pelo seu caminho real.');
define('_LANG_WAT_EDITED_SUCCESS','<em>Arquivo editado com sucesso.</em>');
define('_LANG_WAT_FILE_CHMOD','Você não pode editar esse arquivo/template. Ele ter permissão de escrita. Ex.: CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Esse arquivo não existe! Por favor, cheque-o e tente novamente.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Para editar um arquivo, digite seu nome aqui. Você pode editar qualquer arquivo com permissão de escrita. Ex.: CHMOD 766.</p>');
define('_LANG_WAT_TYPE_HERE','Para editar um arquivo, digite seu nome aqui.');
define('_LANG_WAT_FTP_CLIENT','Nota: É claro, você pode editar os arquivos/templates no editor de textos de sua escolha e enviá-los. Este editor on-line só deve ser usado caso você não tem um editor de textos ou cliente de FTP.');
define('_LANG_WAT_UPTEXT_TEMP','Enviar');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','Esta opção foi desativada pelo administrador.');
define('_LANG_WAU_FILE_UPLOAD','Enviar Arquivo');
define('_LANG_WAU_CAN_TYPE','Extensões Permitidas:');
define('_LANG_WAU_MAX_SIZE','Tamanho Máximo:');
define('_LANG_WAU_FILE_DESC','Descrição da Imagem:');
define('_LANG_WAU_BUTTON_TEXT','Enviar');
define('_LANG_WAU_ATTACH_ICON','File attachment ICON only');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','Não é possível alterar o nível de um usuário cujo nível é maior que o seu.');
define('_LANG_WUS_WHOSE_DELETE','Não é possível deletar um usuário cujo nível é maior que o seu.');
define('_LANG_WUS_CANNOT_DELU','Não é possível deletar esse usuário');
define('_LANG_WUS_CANNOT_DELUPOST','Não é possível deletar os posts desse usuário');
define('_LANG_WUS_AU_THOR','Autores');
define('_LANG_WUS_AU_NICK','Nick');
define('_LANG_WUS_AU_NAME','Nome');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','Nível');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','Usuários');
define('_LANG_WUS_AU_WARNING','Para deletar um usuário, mude seu nível para 0, e então clique no X vermelho.<br /><strong>Atenção:</strong> deletar um usuário também remove todos os posts feitos por ele.');
define('_LANG_WUS_ADD_USER','Adicionar Usuário');
define('_LANG_WUS_ADD_THEMSELVES','Os usuários podem se registrar por si mesmos ou você pode criar usuários manualmente por aqui.');
define('_LANG_WUS_ADD_FIRST','Nome');
define('_LANG_WUS_ADD_LAST','Sobrenome');
define('_LANG_WUS_ADD_TWICE','Senha (duas vezes)');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Por favor, não acesse esta pagina diretamente. Obrigado!');
define('_LANG_WPCM_ENTER_PASS','<p>Digite sua senha para ver os comentários.<p>');
define('_LANG_WPCM_COM_TITLE','Comentários');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> feed dos comentários');
define('_LANG_WPCM_COM_TRACK','<acronym title="Uniform Resource Identifier">URL</acronym> da TrackBack:');
define('_LANG_WPCM_COM_YET','Ainda não existem comentários.');
define('_LANG_WPCM_COM_LEAVE','Deixar um Comentário');
define('_LANG_WPCM_HTML_ALLOWED','Parágrafos e quebra-linhas automáticos; websites substituem e-mails; <acronym title="Hypertext Markup Language">HTML</acronym> permitido.');
define('_LANG_WPCM_COM_YOUR','Seu Comentário');
define('_LANG_WPCM_PLEASE_NOTE','<strong>Por favor, note:</strong> A moderação de comentários está ativada, portanto pode haver algum atraso entre quando você enviar seu comentário e quando ele aparecer. Paciência é uma virtude, não há necessidade de re-enviá-lo.');
define('_LANG_WPCM_COM_SAYIT','Enviar');
define('_LANG_WPCM_THIS_TIME','Desculpe, mas os comentários estão fechados no momento.');
define('_LANG_WPCM_GO_BACK','Voltar');
define('_LANG_WPCM_COM_NAME','Nome');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Desculpe, os comentários estão fechados para este ítem.');
define('_LANG_WPCP_ERR_FILL','Erro: por favor, preencha os campos obrigatórios (nome e e-mail).');
define('_LANG_WPCP_ERR_TYPE','Erro: por favor, escreva um comentário.');
define('_LANG_WPCP_SORRY_SECONDS','Desculpe, você so pode fazer um novo comentário após 10 segundos.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','Esta opção foi desativada pelo administrador.');
define('_LANG_WAU_UPLOAD_DIRECTORY','Você não pode enviar arquivos pois o diretorio que você especificou não tem permissão de escrita pelo WordPress. Cheque as permissões dos diretórios ou erros.');
define('_LANG_WAU_UPLOAD_EXTENSION','Você pode enviar arquivos com as extensões: ');
define('_LANG_WAU_UPLOAD_BYTES','Desde que não sejam maiores que <abbr title="Kilobytes">KB</abbr>: ');
define('_LANG_WAU_UPLOAD_OPTIONS','Se você for um administrador, pode configurar esses valores em <a href="options.php?option_group_id=4">opções</a>.');
define('_LANG_WAU_UPLOAD_FILE','Arquivo:');
define('_LANG_WAU_UPLOAD_ALT','Descrição:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Criar miniatura?');
define('_LANG_WAU_UPLOAD_NO','Não');
define('_LANG_WAU_UPLOAD_SMALL','Pequena (200px larg. máx.)');
define('_LANG_WAU_UPLOAD_LARGE','Grande (400px larg. máx.)');
define('_LANG_WAU_UPLOAD_CUSTOM','Tamanho personalizado');
define('_LANG_WAU_UPLOAD_PX','px (larg. máx.)');
define('_LANG_WAU_UPLOAD_BTN','Enviar Arquivo');
define('_LANG_WAU_UPLOAD_SUCCESS','Seu arquivo foi enviado com sucesso: ');
define('_LANG_WAU_UPLOAD_CODE','Aqui está o código para mostrá-lo:');
define('_LANG_WAU_UPLOAD_START','Enviar');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplicar Arquivo?');
define('_LANG_WAU_UPLOAD_EXISTS','Esse arquivo já existe: ');
define('_LANG_WAU_UPLOAD_RENAME','Confirmar ou renomear:');
define('_LANG_WAU_UPLOAD_ALTER','Nome alternativo:');
define('_LANG_WAU_UPLOAD_REBTN','Renomear');
define('_LANG_WAU_UPLOAD_CODEIN','Inserir código no formulário');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Associate');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Você não tem permissão o suficiente para editar as opções para este blog.');
define('_LANG_WAO_GENERAL_WPTITLE','Título do Weblog:');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Endereço do Site (URL):');
define('_LANG_WAO_GENERAL_MAIL','Endereço de E-mail:');
define('_LANG_WAO_GENERAL_MEMBER','Usuário:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">Fuso horário</acronym>:');
define('_LANG_WAO_GENERAL_DIFFER','Diferença de horas:');
define('_LANG_WAO_GENERAL_EXPLIAIN','Descreva o blog em poucas palavras.');
define('_LANG_WAO_GENERAL_ADMIN','Este endereço é usado apenas para questões administrativas.');
define('_LANG_WAO_GENERAL_REGISTER','Alguém pode registrar');
define('_LANG_WAO_GENERAL_ARTICLES','Permitir a qualquer usuário cadastrado postar artigos');
define('_LANG_WAO_GENERAL_UPDATE','Enviar');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Você não tem permissão para editar as opções para este blog.');
define('_LANG_WAO_WRITING_TITLE','Opções de Escrita');
define('_LANG_WAO_WRITING_SIMPLE','Controles simples');
define('_LANG_WAO_WRITING_ADVANCED','Controles avançados');
define('_LANG_WAO_WRITING_LINES','linhas');
define('_LANG_WAO_WRITING_DISPLAY','Converter emoticons como :-) e :-P em gráficos');
define('_LANG_WAO_WRITING_XHTML','Detectar codigos XHTML inválidos automaticamente');
define('_LANG_WAO_WRITING_CHARACTER','Codificação (UTF-8 recomendado)');
define('_LANG_WAO_WRITING_STYLE','Quando começar um post, mostrar:');
define('_LANG_WAO_WRITING_BOX','Tamanho da caixa de texto:');
define('_LANG_WAO_WRITING_FORMAT','Formatação:');
define('_LANG_WAO_WRITING_ENCODE','Codificação:');
define('_LANG_WAO_WRITING_SERVICES','Atualizar Serviços');
define('_LANG_WAO_WRITING_SOMETHING','Digite os sites que você gostária de notificar quando publicar um novo texto. Para uma lista de sites recomendados a pingar, por favor veja [LINK TO SOMETHING]. Separar URIs múltiplos por quebra-linhas.');
define('_LANG_WAO_WRITING_UPDATE','Enviar');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Opções de Discussão');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Configurações-padrão para um artigo: <em>(Essas configurações podem ser sobrepostas por artigos individuais.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Tentar notificar algum Weblogs linkado sobre o artigo. (Deixa os posts mais lentos.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Aceitar notificação de outros Weblogs. (Pingbacks e trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Permitir que comentários sejam enviados nos artigos');
define('_LANG_WAO_DISCUSS_EMAIL','Contatar-me quando:');
define('_LANG_WAO_DISCUSS_ANYONE','Alguém postar um comentário');
define('_LANG_WAO_DISCUSS_DECLINED','Um comentário for aceito ou rejeitado');
define('_LANG_WAO_DISCUSS_APPEARS','Antes que um comentário apareça:');
define('_LANG_WAO_DISCUSS_ADMIN','Um administrador deve aprovar o comentário (independente de qualquer opção acima)');
define('_LANG_WAO_DISCUSS_MODERATION','Quando um comentário tiver alguma dessas palavras em seu conteúdo, nome, URI, ou e-mail, colocá-lo na fila de moderação: (Separar novas palavras por quebra-linha.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Opções de Leitura');
define('_LANG_WAO_READING_FRONT','Pagina Frontal');
define('_LANG_WAO_READING_RECENT','Mostrar os mais recentes:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','Para cada artigo, mostrar:');
define('_LANG_WAO_READING_ENCODE','Codificação para paginas e feeds:');
define('_LANG_WAO_READING_CHARACTER','A codificação usada no seu blog (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 recomendado</a>)');
define('_LANG_WAO_READING_GZIP','WordPress deve comprimir os artigos (gzip) caso os visitantes peçam por eles');
define('_LANG_WAO_READING_BTNTXT','Enviar');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','Você não tem permissão para realizar esta operação.');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','O arquivo wp-config.php não existe. Ele é necessário para instalar o WordPress ME. Precisa de ajuda? Clique <a href=\'http://wordpress.org/docs/faq/#wp-config\'>aqui</a>. Você pode <a href=\'wp-admin/install-config.php\'>criar um arquivo <code>wp-config.php</code> na interface web</a>. Para isso, é necessário que as permissões de escrita estejam ativadas (707~777), mas ele pode não funcionar em todos os servidores. O jeito mais seguro é criá-lo manualmente.');
define('_LANG_INST_GUIDE_INSTALLED','<p>O WordPress já está instalado. Se você quiser reinstalá-lo, por favor apague as informações antigas.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Bem-vindo ao WordPress. Você terá que passar por algumas etapas antes de ter rodando a última em plataformas de publicação pessoal. Antes de começarmos, lembre-se de que é necessária pelo menos a versão 4.0.6 do PHP.');
define('_LANG_INST_GUIDE_COM','Você também deve setar as configurações do banco de dados no <code>wp-config.php</code>. Você deve alterar a permissão do arquivo weblogs.com.changes.cache para 666.<br />Veja o leia-me <a href="../wp-readme/">aqui</a>.</p> Se você estiver pronto, clique <a href="install.php?step=1">aqui</a>! ');
define('_LANG_INST_STEP1_FIRST','<p>Certo, primeiro vamos configurar o banco de dados de links. Isso te permitirá hospedar seu próprio blogroll completo, com atualizações do Weblogs.com.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Instalando WP-Links.</p><p>Checando as tabelas...</p>');
define('_LANG_INST_STEP1_ALLDONE','Perfeito! Você está pronto para o <a href="install.php?step=2">2º Passo</a>.');
define('_LANG_INST_STEP2_INFO','Primeiro, iremos criar as tabelas necessárias para o blog no banco de dados...');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','siteurl é a URL do seu blog. Ex.: \'http://exemplo.com.br/wordpress\'. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE2','blogfilename é o nome do arquivo-padrão para o seu blog.');
define('_LANG_INST_BASE_VALUE3','blogname é o nome do seu blog.');
define('_LANG_INST_BASE_VALUE4','blogdescription é a descrição do seu blog.');
define('_LANG_INST_BASE_VALUE7','Você deseja que novos usuários possam postar depois de cadastrados?');
define('_LANG_INST_BASE_VALUE8','Você deseja que os visitantes possam se cadastrar no seu blog?');
define('_LANG_INST_BASE_VALUE54','Seu e-mail');
// general blog setup
define('_LANG_INST_BASE_VALUE9','O dia em que a semana começa.');
define('_LANG_INST_BASE_VALUE11','Usar BBCode. Ex.: [b]negrito[/b].');
define('_LANG_INST_BASE_VALUE12','Usar GreyMatter-styles. Ex.: **negrito** \\\\itálico\\\\ __sublinhado__.');
define('_LANG_INST_BASE_VALUE13','Ativar botões para HTML tags. (Ainda não funcionam no IE do Mac)');
define('_LANG_INST_BASE_VALUE14','IMPORTANTE: ative isso caso esteja usando Chinês, Japanês, Coreano, ou outras línguas multi-bytes.');
define('_LANG_INST_BASE_VALUE15','Isso deve ajudar a equilibrar o código HTML. Se ele der maus resultados, desative-o.');
define('_LANG_INST_BASE_VALUE16','Ative isso para ligar a conversão de smiley nos seus posts (NOTA: ela é feita em TODOS os posts)');
define('_LANG_INST_BASE_VALUE17','O diretório onde os smileys estão. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE18','Ative isso para fazer de e-mail and nome campos obrigatórios, ou desative para permitir comentários sem eles.');
define('_LANG_INST_BASE_VALUE20','Ative isso para que cada autor seja notificado de novos comentários em seus posts.');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','Número de últimos posts para sindicar.');
define('_LANG_INST_BASE_VALUE22','O idioma do seu blog ( veja http://backend.userland.com/stories/storyReader$16 )');
define('_LANG_INST_BASE_VALUE23','Permitir HTML codificado na tag &lt;description> do b2rss.php?');
define('_LANG_INST_BASE_VALUE24','Tamanho dos excerpts no RSS feed? (0=ilimitado) NOTA: no b2rss.php, ele será desativado caso você use HTML codificado');
define('_LANG_INST_BASE_VALUE25','Usar o campo excerpt para RSS feed.');
define('_LANG_INST_BASE_VALUE26','Ative isso caso você queira que seu blog seja listado em http://weblogs.com quando você fizer um novo post.');
define('_LANG_INST_BASE_VALUE27','Ative isso caso você queira que seu site seja listado em http://blo.gs quando você fizer um novo post');
define('_LANG_INST_BASE_VALUE28','Você não deve precisar mudar isso.');
define('_LANG_INST_BASE_VALUE29','Ative isso para permitir trackbacks nos seus posts. Desativando-o, o envio de trackbacks também é desligado.');
define('_LANG_INST_BASE_VALUE30','Ative isso para permitir pingbacks nos seus posts. NOTA: Desativando-o, o envio de pingbacks também é desligado.');
define('_LANG_INST_BASE_VALUE31','Ative isso para ligar o envio de arquivos.');
define('_LANG_INST_BASE_VALUE32','Digite o caminho real do diretório onde as imagens serão enviadas. Se não tiver certeza do que é isso, por favor contate seu hosting. NOTA: o diretório deve ter permissão de escrita pelo servidor (chmod 766). Para usuários de servidores Windows: use a barra normal ao invés da invertida');
define('_LANG_INST_BASE_VALUE33','Digite a URL do diretório. Ela será usada para gerar os links para as imagens enviadas.');
define('_LANG_INST_BASE_VALUE34','Extensões de arquivos permitidas, separadas por espaço. Ex.: \'jpg gif png\'');
define('_LANG_INST_BASE_VALUE35','Por padrão, a maioria dos servidores o envio de arquivos á 2048 KB. Se quiser colocar um valor menor, mude isso. (Você não poderá colocar um valor maior do que o limite do seu servidor)');
define('_LANG_INST_BASE_VALUE36','Caso não queira permitir todos os usuários a enviar arquivos, escolha um nível mínimo,');
define('_LANG_INST_BASE_VALUE37','Ou você pode permitir apenas alguns usuários. Digite seus nomes de usuário, separados por espaço. Ex.: \'barbara anne george\'. Se você deixar esta variável em branco, todos os usuários com o nível mínimo poderão enviar arquivos.');
/* email settings */
define('_LANG_INST_BASE_VALUE38','Configurações do Servidor de Correio');
define('_LANG_INST_BASE_VALUE39','Configurações do Servidor de Correio');
define('_LANG_INST_BASE_VALUE40','Configurações do Servidor de Correio');
define('_LANG_INST_BASE_VALUE41','Configurações do Servidor de Correio');
define('_LANG_INST_BASE_VALUE42','Por padrão, os posts terão esta categoria.');
define('_LANG_INST_BASE_VALUE43','Prefixo do Assunto');
define('_LANG_INST_BASE_VALUE44','Body Terminator String (a partir disso, tudo será ignorado, inclusive o string)');
define('_LANG_INST_BASE_VALUE45','Ative isso para rodar em modo de teste.');
define('_LANG_INST_BASE_VALUE46','Alguns serviços de mensagens celulares mandam assunto e conteúdo indênticos na mesma linha. Se você usa esses serviços, ative o use_phoneemail, e indique o string separador.');
define('_LANG_INST_BASE_VALUE47','Quando você redigir uma mensagem, você terá que digitar o assunto, o string separador, seu usuário:senha, o string separador, e o conteúdo.');
define('_LANG_INST_BASE_VALUE48','Posts/dias a serem mostrados na página principal.');
define('_LANG_INST_BASE_VALUE49','Posts, dias, ou posts arquivados.');
define('_LANG_INST_BASE_VALUE50','Formato do arquivo.');
define('_LANG_INST_BASE_VALUE51','Caso você não esteja no mesmo fuso do seu servidor.');
define('_LANG_INST_BASE_VALUE52','Ver nota para formato dos caractéres.');
define('_LANG_INST_BASE_VALUE53','Ver nota para formato dos caractéres.');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Configurações Principais');
define('_LANG_INST_BASE_HELP2','Configurações Gerais');
define('_LANG_INST_BASE_HELP3','Configurações de RSS/RDF Feeds e Track/ping-backs');
define('_LANG_INST_BASE_HELP4','Configurações de Envio de Arquivos.');
define('_LANG_INST_BASE_HELP5','Configurações de Posts por E-mail');
define('_LANG_INST_BASE_HELP6','Configurações Básicas');
define('_LANG_INST_BASE_HELP7','Configurações-Padrão');
define('_LANG_INST_BASE_HELP8','Configurações Variadas');
define('_LANG_INST_BASE_HELP9','Configurações de Postagem e Geográficas');
define('_LANG_INST_BASE_VALUE55','O estado padrão de cada novo post.');
define('_LANG_INST_BASE_VALUE56','O estado padrão dos comentários para cada post.');
define('_LANG_INST_BASE_VALUE57','O estado padrão do ping para cada post.');
define('_LANG_INST_BASE_VALUE58','Se \'PingBackear as URLs neste post\' deve estar selecionado por padrão.');
define('_LANG_INST_BASE_VALUE59','A categoria-padrão para cada post.');
define('_LANG_INST_BASE_VALUE83','O número de linhas no formulário de edição. (mín. 3, máx. 100)');
define('_LANG_INST_BASE_VALUE60','O nível mínimo de administrador para editar os links.');
define('_LANG_INST_BASE_VALUE61','Desative isso para ter todos os links visíveis e editáveis por todos no gerenciador de links.');
define('_LANG_INST_BASE_VALUE62','Mude isso para o tipo de avaliação que você deseja usar.');
define('_LANG_INST_BASE_VALUE63','Se ativado, qual char usar.');
define('_LANG_INST_BASE_VALUE64','O que fazer com um valor 0. Ative para ignorá-lo, ou desative para processá-lo normalmente. (número/imagem)');
define('_LANG_INST_BASE_VALUE65','Usar a mesma imagem para cada ponto de avaliação? (Use links_rating_image[0])');
define('_LANG_INST_BASE_VALUE66','Imagem para avaliação 0');
define('_LANG_INST_BASE_VALUE67','Imagem para avaliação 1');
define('_LANG_INST_BASE_VALUE68','Imagem para avaliação 2');
define('_LANG_INST_BASE_VALUE69','Imagem para avaliação 3');
define('_LANG_INST_BASE_VALUE70','Imagem para avaliação 4');
define('_LANG_INST_BASE_VALUE71','Imagem para avaliação 5');
define('_LANG_INST_BASE_VALUE72','Imagem para avaliação 6');
define('_LANG_INST_BASE_VALUE73','Imagem para avaliação 7');
define('_LANG_INST_BASE_VALUE74','Imagem para avaliação 8');
define('_LANG_INST_BASE_VALUE75','Imagem para avaliação 9');
define('_LANG_INST_BASE_VALUE76','caminho/para/o/cache deve ter permissão de escrita pelo servidor.');
define('_LANG_INST_BASE_VALUE77','Receber arquivos de weblogs.com');
define('_LANG_INST_BASE_VALUE78','Tempo de cache em minutos.');
define('_LANG_INST_BASE_VALUE79','O formato da data para a tooltip atualizada.');
define('_LANG_INST_BASE_VALUE80','Texto anexado à um link recente (Próximo)');
define('_LANG_INST_BASE_VALUE81','Texto anexado à um link recente (Anterior)');
define('_LANG_INST_BASE_VALUE82','Tempo em minutos para considerar um link recentemente atualizado.');
define('_LANG_INST_BASE_VALUE84','Liga as opções de GeoURL no WordPress');
define('_LANG_INST_BASE_VALUE85','enables placement of defaúlt GeoURL ICBM location even when no other specified');
define('_LANG_INST_BASE_VALUE86','O valor-padrão da Latitude ICBM - Veja <a href="http://www.geourl.org/resources.html" target="_blank">aqui</a>');
define('_LANG_INST_BASE_VALUE87','O valor-padrão da Longitude ICBM');
/* Last Question */
define('_LANG_INST_STEP2_LAST','OK. Já estamos quase lá. Há apenas algumas coisas que precisamos saber:');
define('_LANG_INST_STEP2_URL','Usuário criado com sucesso.');
define('_LANG_INST_STEP3_SET','<p>Agora você pode se <a href="../wp-login.php">conectar</a> com o <strong>usuário</strong> "admin" e <strong>senha</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Anote a senha</em></strong> com cuidado! É uma senha <em>randonômica</em> gerada especialmente para você. Se você a perder, terá que apagar as tabelas do banco de dados e reinstalar o WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Você achou que ia ser mais longo? Sinto desapontá-lo, já está tudo pronto!');
define('_LANG_INST_CAUTIONS','<ul><li>Diretório : [755]</li><li>wp-config.php : [604~644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','Parece que o arquivo wp-config.php não existe. Verifique se você atualizou o wp-config.sample.php com as informações corretas do banco de dados e renomeou-o para wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>Este arquivo atualiza seu WordPress para a última versão. Seja paciente, pode levar alguns instantes. </p><p>Se você estiver pronto, clique <a href="upgrade.php?step=1">aqui</a>! </p>');
define('_LANG_UPG_STEP_INFO3','<p>Há apenas uma única etapa. Então, se você está vendo isso, é porque ela foi concluída. <a href="../">Divirta-se</a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','Se ativado, os comentários serão mostrados apenas após serem aprovados.');
define('_LANG_INST_BASE_VALUE89','Ative isso se quiser ser notificado de novos comentários esperando por aprovação.');
define('_LANG_INST_BASE_VALUE90','Como os permalinks para o seu site são feitos. Veja <a href=\"options-permalink.php\">permalink options page</a> para as regras mod_rewrite necessárias e maiores informações.');
define('_LANG_INST_BASE_VALUE91','Se o seu arquivo de destino deve ser Gzip ou não. Ative-o se você não tiver mod_gzip rodando ainda.');
define('_LANG_INST_BASE_VALUE92','Altere este valor para verdadeiro se você planeja usar arquivos hackeados. Aqui você poderá guardar códigos hackeados que não serão sobreescritos quando você atualizar. O arquivo deve estar na pasta raiz do wordpress e se chamar <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','Diferença em horas entre o fuso horário do servidor e o seu.');
}
?>
