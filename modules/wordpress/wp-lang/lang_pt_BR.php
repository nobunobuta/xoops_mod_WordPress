<?php //* Brazilian Portuguese Translation by Marcelo Yuji Himoro <www.yuji.eu.org> *//
global $blog_charset;
$blog_charset = 'iso-8859-1';

if (!defined('WP_LANGUAGE_FILE_READ')) {
define ('WP_LANGUAGE_FILE_READ','1');
/* This is Multilingual correspondence file */


/* Copylight 2004 -----------------------
Author : Otsukare
URL : http://wordpress.xwd.jp/
-------------------------------------- */

/* File Name wp-settings.php */
define('_LANG_WA_SETTING_GUIDE','<p>O WordPress ME ainda nôþ estôþinstalado. Clique <a href=\'wp-admin/install.php\'>aqui</a> para comeôþr a instalação.</p>');

/* File Name wp-blog-header.php */
define('_LANG_WA_HEADER_GUIDE1','<p>O arquivo <code>wp-config.php</code> nôþ existe. Ele ôþnecessôþio na instalação do WordPress ME. Precisa de ajuda? Clique <a href="http://wordpress.org/docs/faq/#wp-config">aqui</a>. Vocôþpode <a href="wp-admin/install-config.php">criar um arquivo <code>wp-config.php</code></a> na interface web. Para isso, ôþpreciso dar as permissôþs de escrita corretamente (707~777), mas ela pode nôþ funcionar em todos os servidores. O jeito mais seguro ôþcriôþlo manualmente.</p>');

/* File Name wp-admin/install-config.php */
define('_LANG_WA_CONFIG_GUIDE1','<p>O arquivo \'wp-config.php\' jôþexiste. Se vocôþdeseja zerar alguma configuração neste arquivo, por favor apague-o primeiro.</p>');
define('_LANG_WA_CONFIG_GUIDE2','<p>Lamento, ôþpreciso de um arquivo wp-config-sample.php para continuar. Por favor, faôþ o upload deste arquivo da sua instalação do WordPress novamente.<p>');
define('_LANG_WA_CONFIG_GUIDE3','<p>Lamento, nôþ ôþpossôþel escrever no diretôþio. Por favor, dôþas permissôþs de escrita ao diretôþio do WordPress ou crie seu wp-config.php manualmente usando o arquivo wp-config-sample.php como referôþcia.</p>');
define('_LANG_WA_CONFIG_GUIDE4','Bem-vindo ao WordPress. Antes de comeôþr, serôþ necessôþias algumas informações sobre o banco de dados. Vocôþterôþque ter em môþs os seguintes dados antes de prosseguir:');
define('_LANG_WA_CONFIG_DATABASE','Nome do banco de dados');
define('_LANG_WA_CONFIG_USERNAME','Usuôþio');
define('_LANG_WA_CONFIG_PASSWORD','Senha');
define('_LANG_WA_CONFIG_LOCALHOST','Hostname');
define('_LANG_WA_CONFIG_PREFIX','Prefixo da tabela');
define('_LANG_WA_CONFIG_GUIDE5','<strong>Se por alguma razôþ a criação automôþica de arquivos nôþ funcionar, nôþ se preocupe, pois tudo o que ôþfeito ôþtransferir os dados para um arquivo de configuração. Vocôþtambôþ pode simplesmente abrir o arquivo <code>wp-config-sample.php</code> em um editor de textos, alterar as configurações, e salvôþlo como <code>wp-config.php</code>. </strong></p><p>Provavelmente, esses dados foram fornecidos ôþvocôþpelo seu host. Se vocôþnôþ tivôþlos, precisarôþcontatôþlos antes de continuar. Caso vocôþesteja pronto, clique <a href="install-config.php?step=1">aqui</a>.');
define('_LANG_WA_CONFIG_GUIDE6','Digite abaixo os dados da sua conexôþ ao banco de dados. Se vocôþnôþ tiver certeza sobre eles, contate seu host.');
define('_LANG_WA_CONFIG_GUIDE7','<small>O nome do banco de dados onde o WordPress ME serôþinstalado. </small>');
define('_LANG_WA_CONFIG_GUIDE8','<small>Nome de usuôþio do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE9','<small>Senha do MySQL</small>');
define('_LANG_WA_CONFIG_GUIDE10','<small>Em 99% dos casos, vocôþnôþ terôþque mudar isto.</small>');
define('_LANG_WA_CONFIG_GUIDE11','<small>Se vocôþfor rodar vôþias instalações do WordPress ME em um ôþico banco de dados, mude isto.</small>');
define('_LANG_WA_CONFIG_GUIDE12','Pronto! As informações necessôþias estôþ corretas. WordPress ME estabeleceu uma conexôþ com seu banco de dados corretamente. Se estiver pronto, clique <a href="install.php">aqui</a> para instalar.');


/* File Name wp-include/wp-db.php */
define('_LANG_WA_WPDB_GUIDE1','<strong>Nôþ foi possôþel estabelecer uma conexôþ com o banco de dados.</strong>Isso significa que as informações da conexôþ no seu arquivo <code>wp-config.php</code> podem estar incorretas. Cheque-as e tente novamente.');
define('_LANG_WA_WPDB_GUIDE2','Tem certeza de que o nome de usuôþio/senha estôþ corretos?');
define('_LANG_WA_WPDB_GUIDE3','Tem certeza de que vocôþo hostname estôþcorreto?');
define('_LANG_WA_WPDB_GUIDE4','Tem certeza de que o servidor do banco de dados estôþrodando?');


/* File Name wp-include/functions.php */
define('_LANG_F_TIMESTAMP','Editar formato da hora');
define('_LANG_F_NEW_COMMENT','Tem um comentôþio novo no seu post.');
define('_LANG_F_ALL_COMMENTS','Os comentôþios deste post podem ser vistos aqui:');
define('_LANG_F_NEW_TRACKBACK','Tem uma nova trackback no seu post.');
define('_LANG_F_ALL_TRACKBACKS','As trackbacks deste post podem ser vistas aqui:');
define('_LANG_F_NEW_PINGBACK','Tem um novo pingback no seu post.');
define('_LANG_F_ALL_PINGBACKS','Os pingbacks deste post podem ser vistos aqui:');
define('_LANG_F_COMMENT_POST','Tem um novo comentôþio no post');
define('_LANG_F_WAITING_APPROVAL','estôþesperando por sua aprovação.');
define('_LANG_F_APPROVAL_VISIT','Para aprovar este comentôþio:');
define('_LANG_F_DELETE_VISIT','Para apagar este comentôþio:');
define('_LANG_F_PLEASE_VISIT','No momento, existem comentôþios pendentes de aprovação. Vôþpara o Painel de Moderação:');

/* File Name wp-register.php */
define('_LANG_R_ENTER_LOGIN','<strong>ERRO</strong>: escolha um nome de usuôþio.');
define('_LANG_R_PASS_TWICE','<strong>ERRO</strong>: repita sua senha.');
define('_LANG_R_SAME_PASS','<strong>ERRO</strong>: repita a mesma senha nos dois campos.');
define('_LANG_R_MAIL_ADDRESS','<strong>ERRO</strong>: digite seu endereôþ de e-mail.');
define('_LANG_R_ADDRESS_CORRECT','<strong>ERRO</strong>: o endereôþ de e-mail ôþinvôþido.');
define('_LANG_R_CHOOSE_ANOTHER','<strong>ERRO</strong>: este nome de usuôþio jôþexiste. Escolha outro e tente novamente.');
define('_LANG_R_REGISTER_CONTACT','<strong>ERRO</strong>: nôþ foi possôþel realizar o cadastro. Contate o administrador.');
define('_LANG_R_USER_REGISTRATION','Novo usuôþio no seu blog');
define('_LANG_R_MAIL_REGISTRATION','Novo cadastro de usuôþio');
define('_LANG_R_R_COMPLETE','Cadastro completado.');
define('_LANG_R_R_DISABLED','Cadastro desativado.');
define('_LANG_R_R_CLOSED','No momento, nôþ sôþ aceitos novos cadastros.');
define('_LANG_R_R_REGISTRATION','Cadastro');
define('_LANG_R_USER_LOGIN','Usuôþio:');
define('_LANG_R_USER_PASSWORD','Senha:');
define('_LANG_R_TWICE_PASSWORD','Repetir senha:');
define('_LANG_R_USER_EMAIL','E-mail');

/* File Name wp-login.php */
define('_LANG_L_LOGIN_EMPTY','Preencha o campo <b>Usuôþio</b>.');
define('_LANG_L_PASS_EMPTY','Preencha o campo <b>Senha</b>.');
define('_LANG_L_WRONG_LOGPASS','O nome de usuôþio ou senha sôþ invôþidos.');
define('_LANG_L_RECEIVE_PASSWORD','Basta preencher os dados e te enviaremos uma nova senha.');
define('_LANG_L_EXIST_SORRY','Este usuôþio nôþ existe. Clique <a href="wp-login.php?action=lostpassword">aqui</a> para receber sua senha por e-mail.');
define('_LANG_L_YOUR_LOGPASS','Usuôþio/senha do WordPress');
define('_LANG_L_NOT_SENT','O e-mail nôþ pôþe ser enviado.');
define('_LANG_L_DISABLED_FUNC','Possôþel razôþ: seu servidor pode ter desativado a função mail().');

define('_LANG_L_SUCCESS_SEND',': o e-mail foi enviado com sucesso.');
define('_LANG_L_CLICK_ENTER','Clique aqui para se identificar!');
define('_LANG_L_WRONG_SESSION','Erro: usuôþio/senha invôþidos.');
define('_LANG_L_BACK_BLOG','Voltar ao blog');
define('_LANG_L_WP_RESIST','Cadastrar-se agora!');
define('_LANG_L_WPLOST_YOURPASS','Esqueceu sua senha?');

/* File Name wp-admin/post.php */
define('_LANG_P_NEWCOMER_MESS','Como vocôþôþum novato, terôþque esperar atôþque um administrador aumente seu nôþel para 1 para poder postar.<br />Vocôþpode enviar um e-mail ao administrador pedindo uma promoção.<br />Quando vocôþfor promovido, basta atualizar esta pôþina e poderôþpostar.');
define('_LANG_P_DATARIGHT_EDIT',', vocôþnôþ tem permissôþ para editar posts.');
define('_LANG_P_DATARIGHT_DELETE',', vocôþnôþ tem permissôþ para apagar posts.');
define('_LANG_P_DATARIGHT_ERROR','Erro ao apagar. Contate o administrador.');
define('_LANG_P_OOPS_IDCOM','Nôþ existem comentôþios com este nôþID.');
define('_LANG_P_OOPS_IDPOS','Nôþ existem posts com este nôþID.');
define('_LANG_P_ABOUT_FOLLOW','Vocôþestôþprestes a apagar o seguinte comentôþio:');
define('_LANG_P_SURE_THAT','Tem certeza de que deseja continuar?');
define('_LANG_P_NICKNAME_DELETE','Vocôþnôþ tem permissôþ para apagar comentôþios.');
define('_LANG_P_COMHAS_APPR','O comentôþio foi aprovado.');
define('_LANG_P_YOUR_DRAFTS','Seus rascunhos:');
define('_LANG_P_WP_BOOKMARKLET','Vocôþpode arrastar o link seguinte para sua barra de links ou adicionôþlo ao seus Favoritos. Quando vocôþclicar sobre ele, se abrirôþuma janela popup com informações e um link para a pôþina que vocôþestôþvisualizando agora, permitindo que vocôþfaôþ um post rapidamente.');
define('_LANG_P_CONFIRM_DELETE', 'Are you sure you want to delete this?');

/* File Name wp-admin/categories.php */
define('_LANG_C_DEFAULT_CAT','Nôþ ôþpossôþel apagar esta categoria pois ela ôþa padrôþ.');
define('_LANG_C_EDIT_TITLECAT','Editar categoria');
define('_LANG_C_NAME_SUBCAT','Nome da categoria:');
define('_LANG_C_NAME_SUBDESC','Descrição:');
define('_LANG_C_RIGHT_EDITCAT','Vocôþnôþ tem permissôþ para alterar as categorias deste blog.<br />Peôþ uma promoção ao administrador do blog.');
define('_LANG_C_NAME_CURRCAT','Categorias existentes');
define('_LANG_C_NAME_CATNAME','Nome');
define('_LANG_C_NAME_CATDESC','Descrição');
define('_LANG_C_NAME_CATPOSTS','Nôþde posts');
define('_LANG_C_NAME_CATACTION','Ação');
define('_LANG_C_ADD_NEWCAT','Adicionar uma nova categoria');
define('_LANG_C_NOTE_CATEGORY','Apagar uma categoria nôþ exclui os posts existentes nela, apenas move-os ôþcategoria padrôþ.');
define('_LANG_C_NAME_EDIT','EDITAR');
define('_LANG_C_NAME_DELETE','APAGAR');
define('_LANG_C_NAME_ADDBTN','Adicionar');
define('_LANG_C_NAME_EDITBTN','Enviar');
define('_LANG_C_NAME_PARENT','Categoria padrôþ:');
define('_LANG_C_MESS_ADD','Categoria adicionada com sucesso.');
define('_LANG_C_MESS_DELE','Categoria apagada com sucesso.');
define('_LANG_C_MESS_UP','Categoria atualizada com sucesso.');
/* File Name wp-admin/edit.php */
define('_LANG_E_LATEST_POSTS','ôþtimos posts');
define('_LANG_E_LATEST_COMMENTS','ôþtimos comentôþios');
define('_LANG_E_AWAIT_MODER','Comentôþios pendentes de aprovação');
define('_LANG_E_SHOW_POSTS','Mostrar posts:');
define('_LANG_E_TITLE_COMMENTS','Comentôþios');
define('_LANG_E_FILL_REQUIRED','ERRO: preencha os campos obrigatôþios. (nome e comentôþio)');
define('_LANG_E_TITLE_LEAVECOM','Comentar');
define('_LANG_E_RESULTS_FOUND','Nenhum resultado foi encontrado.');

/* File Name wp-admin/edit-comments.php */
define('_LANG_EC_SHOW_COM','Mostrar comentôþio:');
define('_LANG_EC_EDIT_COM','Editar comentôþio');
define('_LANG_EC_DELETE_COM','Apagar comentôþio');
define('_LANG_EC_EDIT_POST','Editar post &#8220;');
define('_LANG_EC_VIEW_POST','Ver post');
define('_LANG_EC_SEARCH_MODE','Realiza pesquisas dentro dos comentôþios, e-mail, URL e endereôþ IP.');
define('_LANG_EC_VIEW_MODE','Modo de visualização');
define('_LANG_EC_EDIT_MODE','Modo de edição em massa');
define('_LANG_EC_CHECK_INVERT','Inverter caixa de seleção');
define('_LANG_EC_CHECK_DELETE','Apagar os comentôþios selecionados');
define('_LANG_EC_LINK_VIEW','Ver');
define('_LANG_EC_LINK_EDIT','Editar');
define('_LANG_EC_LINK_DELETE','Apagar');

/* File Name wp-admin/edit-form.php */
define('_LANG_EF_PING_FORM','<label for="pingback">Fazer <strong>pingback</strong> nas <acronym title="Uniform Resource Locators">URL</acronym>s dos posts</label> <a href="http://wordpress.org/docs/reference/post/#pingback" title="Ajuda com pingbacks">?</a><br />');
define('_LANG_EF_TRACK_FORM','<p><label for="trackback"><a href="http://wordpress.org/docs/reference/post/#trackback" title="Ajuda com trackbacks">Fazer <strong>trackback</strong> numa <acronym title="Uniform Resource Locator">URL</acronym></a>:</label> (Separar môþtiplas <acronym title="Uniform Resource Locator">URL</acronym>s por espaôþs.)<br />');
define('_LANG_EF_AD_POSTTITLE','Tôþulo');
define('_LANG_EF_AD_CATETITLE','Categorias');
define('_LANG_EF_AD_POSTAREA','Post');
define('_LANG_EF_AD_POSTQUICK','Quicktags');
define('_LANG_EF_AD_DRAFT','Salvar como rascunho');
define('_LANG_EF_AD_PRIVATE','Salvar como particular');
define('_LANG_EF_AD_PUBLISH','Publicar');
define('_LANG_EF_AD_EDITING','Edição avanôþda &raquo;');

/* File Name wp-admin/edit-form-advanced.php */
define('_LANG_EFA_POST_STATUS','Estado do post');
define('_LANG_EFA_AD_COMMENTS','Comentôþios');
define('_LANG_EFA_AD_PINGS','Pings');
define('_LANG_EFA_POST_CUSTOM','Custom Field');
define('_LANG_EFA_POST_PASSWORD','Senha do post');
define('_LANG_EFA_POST_EXCERPT','Excerto');
define('_LANG_EFA_POST_LATITUDE','Latitude:');
define('_LANG_EFA_POST_LONGITUDE','Longitude:');
define('_LANG_EFA_POST_GEOINFO','Clique aqui para informações geogrôþicas');
define('_LANG_EFA_DEL_THISPOST','Apagar este post');
define('_LANG_EFA_SAVE_CONTINUE','Salvar e continuar editando');
define('_LANG_EFA_STATUS_OPEN','Aberto');
define('_LANG_EFA_STATUS_CLOSE','Fechado');
define('_LANG_EFA_STATUS_UPLOAD','Fazer o upload de um arquivo ou imagem');
define('_LANG_EFA_STATUS_DISCUSS','Discussôþ');
define('_LANG_EFA_STATUS_ALLOWC','Permitir comentôþios');
define('_LANG_EFA_STATUS_ALLOWP','Permitir pings');
define('_LANG_EFA_STATUS_SLUG','Separador de post');
define('_LANG_EFA_STATUS_POST','Postar');

/* File Name wp-admin/edit-form-comment.php */
define('_LANG_EFC_BUTTON_TEXT','Enviar');
define('_LANG_EFC_COM_NAME','Nome:');
define('_LANG_EFC_COM_MAIL','E-mail:');
define('_LANG_EFC_COM_URI','Site:');
define('_LANG_EFC_COM_COMMENT','Comentôþio:');

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
define('_LANG_WLA_SUB_DESC','Descrição:');
define('_LANG_WLA_SUB_REL','REL:');
define('_LANG_WLA_SUB_XFN','XFN:');
define('_LANG_WLA_SUB_NOTE','Notas:');
define('_LANG_WLA_SUB_RATE','Classificação:');
define('_LANG_WLA_SUB_TARGET','Pôþlico');
define('_LANG_WLA_SUB_VISIBLE','Visôþel:');
define('_LANG_WLA_SUB_CAT','Categoria:');
define('_LANG_WLA_SUB_FRIEND','Amizades:');
define('_LANG_WLA_SUB_PHYSICAL','Fisica:');
define('_LANG_WLA_SUB_PROFESSIONAL','Profissional:');
define('_LANG_WLA_SUB_GEOGRAPH','Geogrôþica:');
define('_LANG_WLA_SUB_FAMILY','Familiar:');
define('_LANG_WLA_SUB_ROMANTIC','Romôþtica:');
define('_LANG_WLA_CHECK_ACQUA','Conhecidos');
define('_LANG_WLA_CHECK_FRIE','Amigos');
define('_LANG_WLA_CHECK_NONE','Nenhum');
define('_LANG_WLA_CHECK_MET','Encontros');
define('_LANG_WLA_CHECK_WORKER','Sôþios');
define('_LANG_WLA_CHECK_COLL','Colegas');
define('_LANG_WLA_CHECK_RESI','Colegas de quarto');
define('_LANG_WLA_CHECK_NEIG','Vizinhos');
define('_LANG_WLA_CHECK_CHILD','Filhos');
define('_LANG_WLA_CHECK_PARENT','Pais');
define('_LANG_WLA_CHECK_SIBLING','Irmôþs');
define('_LANG_WLA_CHECK_SPOUSE','Esposa');
define('_LANG_WLA_CHECK_MUSE','Musa');
define('_LANG_WLA_CHECK_CRUSH','Paixôþ');
define('_LANG_WLA_CHECK_DATE','Encontros');
define('_LANG_WLA_CHECK_HEART','Namoros');
define('_LANG_WLA_CHECK_ZERO','Deixe em 0 para nenhuma classificação.');
define('_LANG_WLA_CHECK_STRICT','NOTA: o atributo <code>target</code> ôþilegal em XHTML 1.1 e restrito ôþ1.0.');
define('_LANG_WLA_TEXT_TOOLBAR','Vocôþpode arrastar "Link This" para sua barra de tarefas. Ao clicôþla, uma janela pop-up permitirôþôþvocôþadicionar qualquer site em que vocôþestiver aos seus links. (No momento, funciona apenas no Mozilla ou Netscape)');
define('_LANG_WLA_BUTTON_TEXTNAME','Adicionar link');

/* File Name wp-admin/link-categories.php */
define('_LANG_WLC_DONOT_DELETE','Nôþ ôþpossôþel apagar esta categoria de link pois ela ôþa padrôþ.');
define('_LANG_WLC_TITLE_TEXT','Editar categorias de link &#8220;');
define('_LANG_WLC_EPAGE_TITLE','Editar uma categoria de link:');
define('_LANG_WLC_ADD_TITLE','Adicionar uma categoria de link:');
define('_LANG_WLC_SUBEDIT_NAME','Nome:');
define('_LANG_WLC_SUBEDIT_TOGGLE','Auto-toggle');
define('_LANG_WLC_SUBEDIT_SHOW','Mostrar:');
define('_LANG_WLC_SUBEDIT_ORDER','Mostrar por:');
define('_LANG_WLC_SUBEDIT_IMAGES','Imagens');
define('_LANG_WLC_SUBEDIT_DESC','Descrição');
define('_LANG_WLC_SUBEDIT_RATE','Classificação');
define('_LANG_WLC_SUBEDIT_UPDATE','Atualização');
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
define('_LANG_WLC_SUBCATE_RATE','Classificação');
define('_LANG_WLC_SUBCATE_UPDATE','Atualização');
define('_LANG_WLC_SUBCATE_BEFORE','Antes');
define('_LANG_WLC_SUBCATE_BETWEEN','Entre');
define('_LANG_WLC_SUBCATE_AFTER','Depois');
define('_LANG_WLC_SUBCATE_EDIT','Editar');
define('_LANG_WLC_SUBCATE_DELETE','Apagar');
define('_LANG_WLC_SUBEDIT_EMPTY','Quantos de links devem ser mostrados. Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_EMPTY','Deixe em branco para ilimitados.');
define('_LANG_WLC_EPAGE_NOTE','Apagar uma categoria de links nôþ remove os links contidos nela, apenas move-os ôþcategoria padrôþ: ');
define('_LANG_WLC_RIGHT_PROM','Vocôþnôþ tem permissôþ para editar as categorias de links deste blog.<br>Peôþ uma promoção ao administrador do blog.');

/* File Name wp-admin/link-import.php */
define('_LANG_WLI_ROLL_TITLE','Importar blogroll');
define('_LANG_WLI_ROLL_DESC','Importar sua blogroll de outro sistema ');
define('_LANG_WLI_ROLL_OPMLCODE','Vôþem Blogrolling.com e identifique-se. Clique em <strong>Get Code</strong>, e procure pelo <strong>côþigo <abbr title="Outline Processor Markup Language">OPML</abbr></strong>.');
define('_LANG_WLI_ROLL_OPMLLINK','Vôþem Blo.gs e identifique-se. Na caixa &#8217;Welcome Back&#8217; da direita, clique em <strong>share</strong>, e procure pelo <strong>link <abbr title="Outline Processor Markup Language">OPML</abbr></strong> (favorites.opml).');
define('_LANG_WLI_ROLL_BELOW','Copie o texto e cole-o aqui.');
define('_LANG_WLI_ROLL_YOURURL','Sua URL OPML:');
define('_LANG_WLI_ROLL_UPLOAD','<strong>Ou</strong> faôþ o upload do arquivo OPML:');
define('_LANG_WLI_ROLL_THISFILE','Fazer upload do arquivo:');
define('_LANG_WLI_ROLL_CATEGORY','Agora, escolha a categoria onde vocôþdeseja inserir estes links.<br />Categoria:');
define('_LANG_WLI_ROLL_BUTTONTEXT','Importar');

/* File Name wp-admin/link-manager.php */
define('_LANG_WLM_PAGE_TITLE','Gerenciar links');
define('_LANG_WLM_LEVEL_ERROR','Vocôþnôþ tem permissôþ para editar os links para este blog.<br />Peôþ uma promoção ao administrador do blog.');
define('_LANG_WLM_SHOW_LINKS','<strong>Mostrar links por categorias:</strong>');
define('_LANG_WLM_ORDER_BY','<strong>Ordenar por:</strong>');
define('_LANG_WLM_SHOW_BUTTONTEXT','Enviar');
define('_LANG_WLM_SHOW_ACTIONTEXT','Ação');
define('_LANG_WLM_MULTI_LINK','Gerenciar links môþtiplos');
define('_LANG_WLM_CHECK_CHOOSE','Use as caixas de seleção da direita para selecionar vôþios links e escolha uma ação abaixo.');
define('_LANG_WLM_ASSIGN_TEXT','Assignar');
define('_LANG_WLM_OWNER_SHIP','Pertence a:');
define('_LANG_WLM_TOGGLE_TEXT','Toggle ');
define('_LANG_WLM_VISIVILITY_TEXT','Visibilidade');
define('_LANG_WLM_MOVE_TEXT','Mover');
define('_LANG_WLM_TO_CATEGORY',' para categoria');
define('_LANG_WLM_TOGGLE_BOXES','Selecionar tudo');
define('_LANG_WLM_EDIT_LINK','Editar um link:');
define('_LANG_WLM_SAVE_CHANGES','Salvar alterações');
define('_LANG_WLM_EDIT_CANCEL','Cancelar');

/* File Name wp-admin/menu.php */
define('_LANG_ADMIN_MENU_WRITE','Write');
define('_LANG_ADMIN_MENU_EDIT','Edit');
define('_LANG_ADMIN_MENU_CATE','Categories');
define('_LANG_ADMIN_MENU_LINK','Links');
define('_LANG_ADMIN_MENU_USER','Users');
define('_LANG_ADMIN_MENU_OPTION','Options');
define('_LANG_ADMIN_MENU_PLUG','Plugins');
define('_LANG_ADMIN_MENU_TEMP','Templates');
define('_LANG_ADMIN_MENU_UPLOAD','Upload');
define('_LANG_ADMIN_MENU_PROFILE','Profile');
define('_LANG_ADMIN_MENU_VIEW','View site &raquo;');
define('_LANG_ADMIN_MENU_LOGOUT','Logout (%s)');

/* File Name wp-admin/moderation.php */
define('_LANG_WPM_USER_LEVEL','Vocôþnôþ tem permissôþ para moderar comentôþios. Peôþ uma promoção ao administrador do blog.');
define('_LANG_WPM_LATE_POSTS','Posts');
define('_LANG_WPM_LATE_COMS','Comentôþios');
define('_LANG_WPM_AWIT_MODERATION','Pendentes de moderação');
define('_LANG_WPM_COM_APPROV',' comentôþio aprovado com sucesso.');
define('_LANG_WPM_COMS_APPROVS',' comentôþios aprovados com sucesso.');
define('_LANG_WPM_COM_DEL',' comentôþio apagado com sucesso.');
define('_LANG_WPM_COMS_DELS',' comentôþios apagados com sucesso.');
define('_LANG_WPM_COM_UNCHANGE',' comentôþio inalterado.');
define('_LANG_WPM_COMS_UNCHANGES',' comentôþios inalterados.');
define('_LANG_WPM_WAIT_APPROVAL','Os seguintes comentôþios estôþ pendentes de aprovação:');
define('_LANG_WPM_CURR_COMAPP','No momento, nôþ existem comentôþios a serem aprovados.');
define('_LANG_WPM_DEL_LATER','<p>Para cada comentôþio, vocôþdeve escolher entre <em>aprovar</em>, <em>apagar</em> ou <em>deixar para depois</em>.</p>');
define('_LANG_WPM_PUBL_VISIBLE','<p><em>Aprovar</em>: aprova o comentôþio, entôþ ele serôþvisôþel publicamente.');
define('_LANG_WPM_AUTHOR_NOTIFIED','O autor do post serôþnotificado sobre o novo comentôþio em seu post.');
define('_LANG_WPM_ASKED_AGAIN','<p><em>Apagar</em>: remove o conteôþo do blog (NOTA: vocôþnôþ serôþconsultado novamente, portanto tenha a certeza de que deseja realmente remover o comentôþio - uma vez apagados, eles nôþ poderôþ ser recuperados!)</p><p><em>Deixar para depois</em>: nôþ muda o estado dos comentôþios.</p>');
define('_LANG_WPM_MODERATE_BUTTON','Moderar comentôþios');
define('_LANG_WPM_DO_NOTHING','Deixar para depois');
define('_LANG_WPM_DO_DELETE','Apagar');
define('_LANG_WPM_DO_APPROVE','Aprovar');
define('_LANG_WPM_DO_ACTION','Ação:');
define('_LANG_WPM_JUST_THIS','Apagar apenas este comentôþio');
define('_LANG_WPM_JUST_EDIT','Editar');
define('_LANG_WPM_COMPOST_NAME','Nome:');
define('_LANG_WPM_COMPOST_MAIL','E-mail:');
define('_LANG_WPM_COMPOST_URL','URL:');

/* File Name wp-admin/options.php */
define('_LANG_WOP_USER_LEVEL','Vocôþnôþ tem permissôþ para editar as opções deste blog.<br />Peôþ uma promoção ao administrador do blog.');
define('_LANG_WOP_PERM_LINKS','Permalinks');
define('_LANG_WOP_PERM_CONFIG','Configurações de links permanentes');
define('_LANG_WOP_NO_HELPS',' Nôþ existem tôþicos de ajuda para este grupo de opções.');
define('_LANG_WOP_SUBMIT_TEXT','Enviar');
define('_LANG_WOP_SETTING_SAVED',' Configurações salvas com sucesso.');

/* File Name wp-admin/permalink.php */
define('_LANG_WPL_EDIT_UPDATED','Estrutura de permalinks atualizada.');
define('_LANG_WPL_EDIT_STRUCT','Editar estrutura dos permalink');
define('_LANG_WPL_CREATE_CUSTOM','WordPress oferece ôþvocôþa possibilidade de criar uma estrutura URL para os seus permalinks e arquivos. As seguintes &#8220;tags&#8221; estôþ disponôþeis:');
define('_LANG_WPL_CODE_YEAR','Ano, com 4 digitos. Ex.: <code>2004</code>.');
define('_LANG_WPL_CODE_MONTH','Môþ, com 2 digitos. Ex.: <code>05</code>.');
define('_LANG_WPL_CODE_DAY','Dia, com 2 digitos. Ex.: <code>28</code>.');
define('_LANG_WPL_CODE_HOUR','Hora, com 2 dôþitos. Ex.: <code>15</code>');
define('_LANG_WPL_CODE_MINUTE','Minutos, com 2 dôþitos. Ex.: <code>43</code>');
define('_LANG_WPL_CODE_SECOND','Segundos, com 2 dôþitos. Ex.: <code>33</code>');
define('_LANG_WPL_CODE_POSTNAME','Uma versôþ limpa do tôþulo do post. Ex.: "This Is A Great Post!" seria "this-is-a-great-post" no URL.');
define('_LANG_WPL_CODE_POSTID','O nôþID do post. Ex.: <code>423</code>.');
define('_LANG_WPL_USE_EXAMPLE','Um valor como <code>/archives/%year%/%monthnum%/%day%/%postname%/</code> daria um permalink como <code>/archives/2003/05/23/my-cheese-sandwich/</code>. Para que isso funcione, vocôþdeverôþter o mod_rewrite instalado em seu servidor para a criação das regras. Futuramente, poderôþ haver mais opções.');
define('_LANG_WPL_USE_TEMPTEXT','Use as tags de templates acima.');
define('_LANG_WPL_USE_BLANK','Se vocôþquiser, vocôþpode digitar um prefixo personalizado para a sua categoria de URIs aqui. Ex.: <code>/taxonomy/categorias</code> faria seus links de categoria ficarem como <code>http://examplo.org/taxonomy/categorias/general/</code>. Se vocôþdeixar isto em branco, as configurações padrôþs serôþ usadas.');
define('_LANG_WPL_USE_HTACCESS','No momento existem <code>%s</code> usando o valor da estrutura do permalink. Estas sôþ as regras do mod_rewrite que vocôþdeve ter no seu <code>.htaccess</code>. Clique no campo e aperte <kbd>CTRL + A</kbd> para selecionar tudo.');
define('_LANG_WPL_ENGINE_ON','RewriteEngine On RewriteBase');
define('_LANG_WPL_EDIT_TEMPLATE','<p>Se o seu arquivo <code>.htaccess</code> tiver permissôþ de escrita pelo WordPress, vocôþpode <a href="%s">editôþlo na tela de edição de templates</a>.</p>');
define('_LANG_WPL_MOD_REWRITE','No momento, vocôþnôþ esta usando permalinks personalizados. Nenhuma regra especifica do mod_rewrite ôþnecessôþia.');
define('_LANG_WPL_SUBMIT_UPDATE','Enviar');

/* File Name wp-admin/profile.php */
define('_LANG_WPF_ERR_NICKNAME','<strong>ERRO</strong>: digite seu nick (pode ser o mesmo que o seu nome de usuôþio).');
define('_LANG_WPF_ERR_ICQUIN','<strong>ERRO</strong>: seu ICQ UIN deve conter apenas nôþeros, letras nôþ sôþ permitidas.');
define('_LANG_WPF_ERR_TYPEMAIL','<strong>ERRO</strong>: digite seu e-mail.');
define('_LANG_WPF_ERR_CORRECT','<strong>ERRO</strong>: o endereôþ de e-mail ôþinvôþido.');
define('_LANG_WPF_ERR_TYPETWICE','<strong>ERRO</strong>: vocôþdigitou sua senha apenas uma vez. Volte e digite-a novamente.');
define('_LANG_WPF_ERR_DIFFERENT','<strong>ERRO</strong>: vocôþdigitou duas senhas diferentes. Volte e corrija-a.');
define('_LANG_WPF_ERR_PROFILE','<strong>ERRO</strong>: nôþ foi possôþel atualizar seu perfil. Contate o administrador.');
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
define('_LANG_WPF_SUBT_BOOK','Salve-o como wordpress.reg, e clique duas vezes nele numa janela do Explorer.<br />Responda \"Sim\" a pergunta, e reinicie o Internet Explorer.<br /><br />Assim, vocôþpode clicar com o botôþ direito numa janela do Internet Explorer<br />e selecionar "Postar no WP".');
define('_LANG_WPF_SUBT_CLOSE','Fechar esta janela');
define('_LANG_WPF_SUBT_UPDATED','Perfil atualizado com sucesso.');
define('_LANG_WPF_SUBT_EDIT','Editar seu perfil');
define('_LANG_WPF_SUBT_USERID','ID:');
define('_LANG_WPF_SUBT_LEVEL','Nôþel:');
define('_LANG_WPF_SUBT_POSTS','Posts:');
define('_LANG_WPF_SUBT_LOGIN','Usuôþio:');
define('_LANG_WPF_SUBT_DESC','Perfil:');
define('_LANG_WPF_SUBT_IDENTITY','Nome de exibição:');
define('_LANG_WPF_SUBT_NEWPASS','Nova <strong>senha</strong> (deixe em branco para manter a mesma.)');
define('_LANG_WPF_SUBT_MOZILLA','Nenhuma sidebar encontrada. Vocôþdeve ter Mozilla 0.9.4 ou superior.');
define('_LANG_WPF_SUBT_SIDEBAR','Sidebar');
define('_LANG_WPF_SUBT_FAVORITES','Adicionar este link aos Favoritos:');
define('_LANG_WPF_SUBT_UPDATE','Atualizar');

/* File Name wp-admin/sidebar.php */
define('_LANG_WAS_SIDE_POSTED','Post realizado com sucesso.');
define('_LANG_WAS_SIDE_AGAIN','Clique <a href="sidebar.php">aqui</a> para postar novamente.');

/* File Name wp-admin/templates.php */
define('_LANG_WAT_LEVEL_ERR','<p>Vocôþnôþ tem permissôþ para editar o template deste blog.<br />Peôþ uma promoção ao administrador do blog.</p>');
define('_LANG_WAT_SORRY_EDIT','Lamento, nôþ ôþpossôþel editar arquivos com ".." no nome. Se vocôþestiver tentando editar um arquivo no diretorio raiz do seu WordPress, vocôþdeve digitar apenas o seu nome.');
define('_LANG_WAT_SORRY_PATH','Lamento, nôþ ôþpossôþel chamar arquivos pelo seu caminho real.');
define('_LANG_WAT_EDITED_SUCCESS','<em>Arquivo editado com sucesso.</em>');
define('_LANG_WAT_FILE_CHMOD','Vocôþnôþ pode editar este arquivo/template. Ele deve ter permissôþ de escrita. Ex.: CHMOD 766');
define('_LANG_WAT_OOPS_EXISTS','<p>Arquivo nôþ encontrado! Cheque-o e tente novamente.</p>');
define('_LANG_WAT_OTHER_FILE','<p>Nome do arquivo: (Vocôþpode editar qualquer arquivo com permissôþ de escrita. Ex.: CHMOD 766.)</p>');
define('_LANG_WAT_TYPE_HERE','Nome do arquivo:');
define('_LANG_WAT_FTP_CLIENT','Nota: ôþclaro, vocôþpode editar os arquivos/templates em seu editor de textos favorito e fazer o upload. Este editor on-line sôþdeve ser usado caso vocôþnôþ tem um editor de textos ou cliente de FTP.');
define('_LANG_WAT_UPTEXT_TEMP','Enviar');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_ADMIN_DISABLED','Esta opção foi desativada pelo administrador.');
define('_LANG_WAU_FILE_UPLOAD','Fazer upload de um arquivo');
define('_LANG_WAU_CAN_TYPE','Extensôþs permitidas:');
define('_LANG_WAU_MAX_SIZE','Tamanho môþimo:');
define('_LANG_WAU_FILE_DESC','Descrição:');
define('_LANG_WAU_BUTTON_TEXT','Enviar');
define('_LANG_WAU_ATTACH_ICON','Apenas o ôþone do arquivo anexado');

/* File Name wp-admin/users.php */
define('_LANG_WUS_WHOSE_LEVEL','Nôþ ôþpossôþel alterar o nôþel de um usuôþio cujo nôþel ôþmaior que o seu.');
define('_LANG_WUS_WHOSE_DELETE','Nôþ ôþpossôþel apagar um usuôþio cujo nôþel ôþmaior que o seu.');
define('_LANG_WUS_CANNOT_DELU','Nôþ ôþpossôþel apagar este usuôþio.');
define('_LANG_WUS_CANNOT_DELUPOST','Nôþ ôþpossôþel apagar os posts desse usuôþio');
define('_LANG_WUS_AU_THOR','Autores');
define('_LANG_WUS_AU_NICK','Nick');
define('_LANG_WUS_AU_NAME','Nome');
define('_LANG_WUS_AU_MAIL','E-mail');
define('_LANG_WUS_AU_URI','URL');
define('_LANG_WUS_AU_LEVEL','Nôþel');
define('_LANG_WUS_AU_POSTS','Posts');
define('_LANG_WUS_AU_USERS','Usuôþios');
define('_LANG_WUS_AU_WARNING','Para apagar um usuôþio, mude seu nôþel para 0, e entôþ clique no X vermelho.<br /><strong>ATENÇÃO:</strong> apagar um usuôþio remove tambôþ todos os posts feitos por ele.');
define('_LANG_WUS_ADD_USER','Adicionar usuôþio');
define('_LANG_WUS_ADD_THEMSELVES','Os usuôþios podem registrar-se por si mesmos ou vocôþpode criôþlos manualmente por aqui.');
define('_LANG_WUS_ADD_FIRST','Nome');
define('_LANG_WUS_ADD_LAST','Sobrenome');
define('_LANG_WUS_ADD_TWICE','Senha (duas vezes)');

/* File Name wp-comments.php */
define('_LANG_WPCM_LOAD_DIRECTLY','Acesso negado.');
define('_LANG_WPCM_ENTER_PASS','<p>Digite sua senha para ver os comentôþios.<p>');
define('_LANG_WPCM_COM_TITLE','Comentôþios');
define('_LANG_WPCM_COM_RSS','<abbr title="Really Simple Syndication">RSS</abbr> feed dos comentôþios');
define('_LANG_WPCM_COM_TRACK','<acronym title="Uniform Resource Identifier">URL</acronym> da TrackBack:');
define('_LANG_WPCM_COM_YET','Ainda nôþ existem comentôþios.');
define('_LANG_WPCM_COM_LEAVE','Comentar');
define('_LANG_WPCM_HTML_ALLOWED','Parôþrafos e quebra-linhas automôþicos; site substitui o e-mail; <acronym title="Hypertext Markup Language">HTML</acronym> permitido.');
define('_LANG_WPCM_COM_YOUR','Seu comentôþio:');
define('_LANG_WPCM_PLEASE_NOTE','<strong>NOTA:</strong> a moderação de comentôþios estôþativada, portanto pode haver algum atraso entre quando vocôþenviar seu comentôþio e quando ele aparecer. Nôþ hôþnecessidade de enviôþlo novamente, seja paciente.');
define('_LANG_WPCM_COM_SAYIT','Enviar');
define('_LANG_WPCM_THIS_TIME','Lamento, no momento os comentôþios estôþ fechados.');
define('_LANG_WPCM_GO_BACK','Voltar');
define('_LANG_WPCM_COM_NAME','Nome');

/* File Name wp-comments-post.php */
define('_LANG_WPCP_SORRY_ITEM','Desculpe, os comentôþios estôþ fechados para este item.');
define('_LANG_WPCP_ERR_FILL','ERRO: preencha os campos obrigatôþios (nome e e-mail).');
define('_LANG_WPCP_ERR_TYPE','ERRO: escreva um comentôþio.');
define('_LANG_WPCP_SORRY_SECONDS','Lamento, vocôþsôþpode fazer um novo comentôþio apôþ 10 segundos.');

/* File Name wp-admin/upload.php */
define('_LANG_WAU_UPLOAD_DISABLED','Esta opção foi desativada pelo administrador.');
define('_LANG_WAU_UPLOAD_DIRECTORY','Vocôþnôþ pode fazer o upload de arquivos pois o diretorio especificado nôþ tem permissôþ de escrita pelo WordPress. Cheque as permissôþs dos diretôþios ou erros.');
define('_LANG_WAU_UPLOAD_EXTENSION','Vocôþpode fazer o upload de arquivos do tipo ');
define('_LANG_WAU_UPLOAD_BYTES','desde que eles nôþ ultrapassem ');
define('_LANG_WAU_UPLOAD_OPTIONS','Se vocôþôþum administrador, esses valores podem ser alterados em <a href="options.php?option_group_id=4">Opções</a>.');
define('_LANG_WAU_UPLOAD_FILE','Arquivo:');
define('_LANG_WAU_UPLOAD_ALT','Descrição:');
define('_LANG_WAU_UPLOAD_THUMBNAIL','Criar miniatura?');
define('_LANG_WAU_UPLOAD_NO','Nôþ');
define('_LANG_WAU_UPLOAD_SMALL','Pequena (larg. môþ 200px)');
define('_LANG_WAU_UPLOAD_LARGE','Grande (larg. môþ. 400px)');
define('_LANG_WAU_UPLOAD_CUSTOM','Tamanho personalizado');
define('_LANG_WAU_UPLOAD_PX','px (larg. môþ.)');
define('_LANG_WAU_UPLOAD_BTN','Enviar arquivo');
define('_LANG_WAU_UPLOAD_SUCCESS','Seu arquivo foi enviado com sucesso: ');
define('_LANG_WAU_UPLOAD_CODE','Aqui estôþo côþigo para mostrôþlo:');
define('_LANG_WAU_UPLOAD_START','Enviar');
define('_LANG_WAU_UPLOAD_DUPLICATE','Duplicar arquivo?');
define('_LANG_WAU_UPLOAD_EXISTS','Esse arquivo jôþexiste: ');
define('_LANG_WAU_UPLOAD_RENAME','Confirmar ou renomear:');
define('_LANG_WAU_UPLOAD_ALTER','Nome alternativo:');
define('_LANG_WAU_UPLOAD_REBTN','Renomear');
define('_LANG_WAU_UPLOAD_CODEIN','Inserir côþigo no formulôþio');
define('_LANG_WAU_UPLOAD_AMAZON','Amazon Associate');

/* File Name wp-admin/options-general.php */
define('_LANG_WAO_GENERAL_DISABLED','Vocôþnôþ tem permissôþ suficiente para editar as opções para este blog.');
define('_LANG_WAO_GENERAL_WPTITLE','Tôþulo do weblog:');
define('_LANG_WAO_GENERAL_TAGLINE','Tagline:');
define('_LANG_WAO_GENERAL_URI','Endereôþ do site (URL):');
define('_LANG_WAO_GENERAL_MAIL','Endereôþ de e-mail:');
define('_LANG_WAO_GENERAL_MEMBER','Usuôþio:');
define('_LANG_WAO_GENERAL_GMT','<acronym title="Greenwich Meridian Time">Fuso horôþio</acronym>:');
define('_LANG_WAO_GENERAL_DIFFER','Diferenôþ de horas:');
define('_LANG_WAO_GENERAL_EXPLIAIN','Faôþ uma breve descrição do blog.');
define('_LANG_WAO_GENERAL_ADMIN','Este endereôþ ôþusado apenas para questôþs administrativas.');
define('_LANG_WAO_GENERAL_REGISTER','Ativar cadastros');
define('_LANG_WAO_GENERAL_ARTICLES','Permitir a qualquer usuôþio cadastrado postar artigos.');
define('_LANG_WAO_GENERAL_UPDATE','Enviar');

/* File Name wp-admin/options-writing.php */
define('_LANG_WAO_WRITING_ERROR','Vocôþnôþ tem permissôþ para editar as opções para este blog.');
define('_LANG_WAO_WRITING_TITLE','Opções de escrita');
define('_LANG_WAO_WRITING_SIMPLE','Opções bôþicas');
define('_LANG_WAO_WRITING_ADVANCED','Opções avanôþdas');
define('_LANG_WAO_WRITING_LINES','linhas');
define('_LANG_WAO_WRITING_DISPLAY','Transformar smilies como :-) e :-P em grôþicos');
define('_LANG_WAO_WRITING_XHTML','Detectar codigos XHTML invôþidos automaticamente');
define('_LANG_WAO_WRITING_CHARACTER','Codificação (UTF-8 recomendado)');
define('_LANG_WAO_WRITING_STYLE','Quando comeôþr um post, mostrar:');
define('_LANG_WAO_WRITING_BOX','Tamanho da caixa de texto:');
define('_LANG_WAO_WRITING_FORMAT','Formatação:');
define('_LANG_WAO_WRITING_ENCODE','Codificação:');
define('_LANG_WAO_WRITING_SERVICES','Atualizar serviôþs');
define('_LANG_WAO_WRITING_SOMETHING','Digite os sites que vocôþgostaria de avisar quando publicar um novo texto. Para uma lista de sites recomendados a fazer ping, por favor veja [LINK TO SOMETHING]. Separar URLs môþtiplos por quebra-linhas.');
define('_LANG_WAO_WRITING_UPDATE','Enviar');

/* File Name wp-admin/options-discussion.php */
define('_LANG_WAO_DISCUSS_TITLE','Opções de discussôþ');
define('_LANG_WAO_DISCUSS_INDIVIDUAL','Configurações padrôþ para um artigo: <em>(estas configurações podem ser sobrepostas por artigos individuais.)</em>');
define('_LANG_WAO_DISCUSS_NOTIFY','Tentar avisar alguns weblogs linkados sobre o artigo. (deixa os posts mais lentos.)');
define('_LANG_WAO_DISCUSS_PINGTRACK','Aceitar aviso de outros weblogs. (pingbacks e trackbacks.)');
define('_LANG_WAO_DISCUSS_PEOPLE','Permitir que comentôþios sejam enviados nos artigos');
define('_LANG_WAO_DISCUSS_EMAIL','Contatar-me quando:');
define('_LANG_WAO_DISCUSS_ANYONE','Um comentôþio for postado');
define('_LANG_WAO_DISCUSS_DECLINED','Um comentôþio for aceito ou rejeitado');
define('_LANG_WAO_DISCUSS_APPEARS','Antes que um comentôþio apareôþ:');
define('_LANG_WAO_DISCUSS_ADMIN','Um administrador deve aprovar o comentôþio (independente de qualquer opção acima)');
define('_LANG_WAO_DISCUSS_MODERATION','Quando um comentôþio tiver alguma destas palavras em seu conteôþo, nome, URL, ou e-mail, colocôþlo na fila de moderação: (separar novas palavras por quebra-linha.)');

/* File Name wp-admin/options-reading.php */
define('_LANG_WAO_READING_TITLE','Opções de leitura');
define('_LANG_WAO_READING_FRONT','Pagina frontal');
define('_LANG_WAO_READING_RECENT','Mostrar os mais recentes:');
define('_LANG_WAO_READING_FEEDS','Syndication Feeds');
define('_LANG_WAO_READING_ARTICLE','Para cada artigo, mostrar:');
define('_LANG_WAO_READING_ENCODE','Codificação para paginas e feeds:');
define('_LANG_WAO_READING_CHARACTER','A codificação usada no seu blog (<a href="http://developer.apple.com/documentation/macos8/TextIntlSvcs/TextEncodingConversionManager/TEC1.5/TEC.b0.html">UTF-8 recomendado</a>)');
define('_LANG_WAO_READING_GZIP','Permitir que o WordPress comprima os artigos em gzip caso os visitantes peôþm por eles');
define('_LANG_WAO_READING_BTNTXT','Enviar');

/* Cheatin&#8217; uh? */
define('_LANG_P_CHEATING_ERROR','Vocôþnôþ tem permissôþ para realizar esta operação.');


/* Start Install ************************************************/
/* File Name install.php */
define('_LANG_INST_GUIDE_WPCONFIG','<p>O arquivo <code>wp-config.php</code> nôþ existe. Ele ôþnecessôþio na instalação do WordPress ME. Precisa de ajuda? Clique <a href="http://wordpress.org/docs/faq/#wp-config">aqui</a>. Vocôþpode <a href="wp-admin/install-config.php">criar um arquivo <code>wp-config.php</code></a> na interface web. Para isso, ôþpreciso dar as permissôþs de escrita corretamente (707~777), mas ela pode nôþ funcionar em todos os servidores. O jeito mais seguro ôþcriôþlo manualmente.</p>');
define('_LANG_INST_GUIDE_INSTALLED','<p>O WordPress jôþestôþinstalado. Se vocôþquiser reinstalôþlo, apague as informações antigas.</p></body></html>');
define('_LANG_INST_GUIDE_WEL','<br />Bem-vindo ao WordPress. Vocôþterôþque passar por algumas etapas antes de ter rodando a ôþtima em plataformas de publicação pessoal. Antes de comeôþr, lembre-se de que ôþnecessôþia pelo menos a versôþ 4.0.6 do PHP.');
define('_LANG_INST_GUIDE_COM','Vocôþtambôþ deve determinar as configurações do banco de dados no <code>wp-config.php</code>. Vocôþdeve alterar a permissôþ do arquivo weblogs.com.changes.cache para 666.<br />Veja o leia-me <a href="../wp-readme/">aqui</a>.</p> Se vocôþestiver pronto, clique <a href="install.php?step=1">aqui</a>.');
define('_LANG_INST_STEP1_FIRST','<p>O banco de dados de links serôþconfigurado. Isso te permitirôþhospedar seu prôþrio blogroll completo, com atualizações do Weblogs.com.</p>');
define('_LANG_INST_STEP1_LINKS','<p>Instalando WP-Links.</p><p>Checando as tabelas...</p>');
define('_LANG_INST_STEP1_ALLDONE','Perfeito! Vocôþestôþpronto para o <a href="install.php?step=2">2ôþpasso</a>.');
define('_LANG_INST_STEP2_INFO','As tabelas necessôþias para o blog serôþ criadas no banco de dados.');
/* base options from b2cofig */
define('_LANG_INST_BASE_VALUE1','URL do blog (sem a barra invertida).');
define('_LANG_INST_BASE_VALUE2','Nome do arquivo padrôþ do blog.');
define('_LANG_INST_BASE_VALUE3','Nome do blog.');
define('_LANG_INST_BASE_VALUE4','Descrição do seu blog.');
define('_LANG_INST_BASE_VALUE7','Permitir que novos usuôþios possam postar depois de cadastrados.');
define('_LANG_INST_BASE_VALUE8','Permitir que os visitantes se cadastrem no seu blog.');
define('_LANG_INST_BASE_VALUE54','E-mail do administrador.');
// general blog setup
define('_LANG_INST_BASE_VALUE9','O dia em que a semana comeôþ.');
define('_LANG_INST_BASE_VALUE11','Usar BBCode. Ex.: [b]negrito[/b].');
define('_LANG_INST_BASE_VALUE12','Usar GreyMatter-styles. Ex.: **negrito** \\\\itôþico\\\\ __sublinhado__.');
define('_LANG_INST_BASE_VALUE13','Ativar botôþs de HTML tags. (ainda nôþ funcionam no IE do Mac)');
define('_LANG_INST_BASE_VALUE14','ATENÇÃO: desative isto caso esteja usando Chinôþ, Japonôþ, Coreano, ou outro idioma multi-byte.');
define('_LANG_INST_BASE_VALUE15','Isto deve ajudar a equilibrar o côþigo HTML. Caso dôþmaus resultados, basta desativôþlo.');
define('_LANG_INST_BASE_VALUE16','Ativar a transformação de smilies nos seus posts. (NOTA: ela ôþfeita em TODOS os posts)');
define('_LANG_INST_BASE_VALUE17','Diretôþio de smilies. (sem a barra invertida)');
define('_LANG_INST_BASE_VALUE18','Ative isto para fazer de e-mail and nome campos obrigatôþios.');
define('_LANG_INST_BASE_VALUE20','Ativar aviso de novos comentôþios aos autores dos posts.');
/* rss/rdf feeds */
define('_LANG_INST_BASE_VALUE21','Nôþero de ôþtimos posts a sindicar.');
define('_LANG_INST_BASE_VALUE22','Idioma do blog (veja <a href="http://backend.userland.com/stories/storyReader$16" target="_blank">http://backend.userland.com/stories/storyReader$16</a>)');
define('_LANG_INST_BASE_VALUE23','Permitir HTML codificado na tag &lt;description> do b2rss.php.');
define('_LANG_INST_BASE_VALUE24','Tamanho dos excertos no RSS feed? (0=ilimitado) NOTA: no b2rss.php, ele serôþdesativado se vocôþusa HTML codificado');
define('_LANG_INST_BASE_VALUE25','Usar o campo excerto para RSS feed.');
define('_LANG_INST_BASE_VALUE26','Listar em http://weblogs.com quando um novo post for feito.');
define('_LANG_INST_BASE_VALUE27','Listar em http://blo.gs quando um novo post for feito.');
define('_LANG_INST_BASE_VALUE28','Vocôþnôþ deve precisar mudar isto.');
define('_LANG_INST_BASE_VALUE29','Permitir trackbacks. Se desativado, o envio de trackbacks tambôþ serôþdesligado.');
define('_LANG_INST_BASE_VALUE30','Permitir pingbacks. Se desativado, o envio de pingbacks tambôþ serôþdesligado.');
define('_LANG_INST_BASE_VALUE31','Permitir o upload de arquivos');
define('_LANG_INST_BASE_VALUE32','Digite o caminho real do diretôþio onde as imagens serôþ armazenadas. Se nôþ tiver certeza do que ôþisto, por favor contate seu host. NOTA: o diretôþio deve ter permissôþ de escrita pelo servidor (CHMOD 766).');
define('_LANG_INST_BASE_VALUE33','Digite a URL do diretôþio. Ela serôþusada para gerar os links das imagens.');
define('_LANG_INST_BASE_VALUE34','Extensôþs de arquivos permitidas, separadas por espaôþ.');
define('_LANG_INST_BASE_VALUE35','Por padrôþ, na maioria dos servidores o upload de arquivos ôþ2048 KB. Para determinar um valor menor, mude isto. (vocôþnôþ poderôþdeterminar um valor maior do que o limite do seu servidor)');
define('_LANG_INST_BASE_VALUE36','Caso nôþ queira permitir o upload de arquivos ôþtodos os usuôþios, escolha um nôþel môþimo,');
define('_LANG_INST_BASE_VALUE37','Ou vocôþpode especificar apenas alguns usuôþios. Digite seus nomes de usuôþio, separados por espaôþ. Se vocôþdeixar esta variôþel em branco, todos os usuôþios com o nôþel môþimo poderôþ fazer o upload de arquivos.');
/* email settings */
define('_LANG_INST_BASE_VALUE38','Servidor de e-mail.');
define('_LANG_INST_BASE_VALUE39','Nome de usuôþio.');
define('_LANG_INST_BASE_VALUE40','Senha.');
define('_LANG_INST_BASE_VALUE41','Porta.');
define('_LANG_INST_BASE_VALUE42','Por padrôþ, os posts terôþ esta categoria.');
define('_LANG_INST_BASE_VALUE43','Prefixo do assunto');
define('_LANG_INST_BASE_VALUE44','Body terminator string (a partir disto, tudo serôþignorado)');
define('_LANG_INST_BASE_VALUE45','Ativa modo de teste.');
define('_LANG_INST_BASE_VALUE46','Ative isto caso seu serviôþ de e-mail por celulares envie assunto e conteôþo idôþticos na mesma linha.');
define('_LANG_INST_BASE_VALUE47','Se vocôþativou a opção acima, quando redigir uma mensagem, vocôþterôþque digitar o assunto, o string separador, usuôþio:senha, o string separador, e o conteôþo.');
define('_LANG_INST_BASE_VALUE48','Nôþero de posts mostrados na pôþina principal.');
define('_LANG_INST_BASE_VALUE49','Posts, dias, ou posts arquivados.');
define('_LANG_INST_BASE_VALUE50','Tipo de arquivo.');
define('_LANG_INST_BASE_VALUE51','Diferenôþ entre o seu fuso horôþio e o do seu servidor.');
define('_LANG_INST_BASE_VALUE52','Ver <a href="http://www.php.net/manual/pt_BR/function.date.php" target="_blank">ajuda</a> para formato de data.');
define('_LANG_INST_BASE_VALUE53','Ver <a href="http://www.php.net/manual/pt_BR/function.date.php" target="_blank">ajuda</a> para formato de hora.');
/* 'pages' of options */
define('_LANG_INST_BASE_HELP1','Outras configurações');
define('_LANG_INST_BASE_HELP2','Configurações gerais do blog');
define('_LANG_INST_BASE_HELP3','Configurações de RSS/RDF feeds e track/ping-backs');
define('_LANG_INST_BASE_HELP4','Configurações de upload de arquivos');
define('_LANG_INST_BASE_HELP5','Configurações de postagem via e-mail');
define('_LANG_INST_BASE_HELP6','Configurações bôþicas');
define('_LANG_INST_BASE_HELP7','Configurações padrôþ de postagem');
define('_LANG_INST_BASE_HELP8','Configurações de links');
define('_LANG_INST_BASE_HELP9','Configurações geogrôþicas');
define('_LANG_INST_BASE_VALUE55','O estado padrôþ dos novos posts.');
define('_LANG_INST_BASE_VALUE56','O estado padrôþ dos comentôþios dos novos posts.');
define('_LANG_INST_BASE_VALUE57','O estado padrôþ do ping dos novos posts.');
define('_LANG_INST_BASE_VALUE58','Ativar \'Fazer pingback as URLs neste post\' por padrôþ.');
define('_LANG_INST_BASE_VALUE59','A categoria padrôþ dos novos posts.');
define('_LANG_INST_BASE_VALUE83','O nôþero de linhas no formulôþio de edição. (môþ. 3, môþ. 100)');
define('_LANG_INST_BASE_VALUE60','Nôþel môþimo para editar os links.');
define('_LANG_INST_BASE_VALUE61','Desative isto para ter os links visôþeis e editôþeis por todos no gerenciador de links.');
define('_LANG_INST_BASE_VALUE62','Escolha qual o tipo de avaliação a utilizar.');
define('_LANG_INST_BASE_VALUE63','Se caracter, qual usar?');
define('_LANG_INST_BASE_VALUE64','Ative para ignorar valores "0", ou desative para processôþlo normalmente. (Nôþero/Imagem)');
define('_LANG_INST_BASE_VALUE65','Usar a mesma imagem para cada ponto de avaliação?');
define('_LANG_INST_BASE_VALUE66','Imagem 0 para avaliação.');
define('_LANG_INST_BASE_VALUE67','Imagem 1 para avaliação.');
define('_LANG_INST_BASE_VALUE68','Imagem 2 para avaliação.');
define('_LANG_INST_BASE_VALUE69','Imagem 3 para avaliação.');
define('_LANG_INST_BASE_VALUE70','Imagem 4 para avaliação.');
define('_LANG_INST_BASE_VALUE71','Imagem 5 para avaliação.');
define('_LANG_INST_BASE_VALUE72','Imagem 6 para avaliação.');
define('_LANG_INST_BASE_VALUE73','Imagem 7 para avaliação.');
define('_LANG_INST_BASE_VALUE74','Imagem 8 para avaliação.');
define('_LANG_INST_BASE_VALUE75','Imagem 9 para avaliação.');
define('_LANG_INST_BASE_VALUE76','O caminho para o cache deve ter permissôþ de escrita pelo servidor.');
define('_LANG_INST_BASE_VALUE77','Receber arquivos de weblogs.com.');
define('_LANG_INST_BASE_VALUE78','Tempo de cache em minutos.');
define('_LANG_INST_BASE_VALUE79','Formato de data e hora.');
define('_LANG_INST_BASE_VALUE80','Texto anexado ôþum link recente. (Prôþimo)');
define('_LANG_INST_BASE_VALUE81','Texto anexado ôþum link recente. (Anterior)');
define('_LANG_INST_BASE_VALUE82','Tempo em minutos para considerar um link recentemente atualizado.');
define('_LANG_INST_BASE_VALUE84','Ativar GeoURL no WordPress.');
define('_LANG_INST_BASE_VALUE85','Ativar localização GeoURL ICBM padrôþ quando nenhuma for especificada.');
define('_LANG_INST_BASE_VALUE86','O valor padrôþ da latitude ICBM - Veja <a href="http://www.geourl.org/resources.html" target="_blank">aqui</a>.');
define('_LANG_INST_BASE_VALUE87','O valor-padrôþ da longitude ICBM');
/* Last Question */
define('_LANG_INST_STEP2_LAST','Hôþapenas algumas coisas que precisam ser informadas:');
define('_LANG_INST_STEP2_URL','Usuôþio criado com sucesso.');
define('_LANG_INST_STEP3_SET','<p>Agora vocôþpode se <a href="../wp-login.php">identificar</a> com o <strong>usuôþio</strong> "admin" e <strong>senha</strong> "');
define('_LANG_INST_STEP3_UP','".</p><p><strong><em>Anote a senha</em></strong> com cuidado! ôþuma senha <em>randonôþica</em> gerada especialmente para vocôþ Se vocôþperdôþla, terôþque apagar as tabelas do banco de dados e reinstalar o WordPress.</p>');
define('_LANG_INST_STEP3_DONE','Instalação completada com sucesso!');
define('_LANG_INST_CAUTIONS','<ul><li>Diretôþio : [755]</li><li>wp-config.php : [604~644]</li></ul>');

/* Start Upgrade ************************************************/
/* File Name wp-admin/upgrade.php */
define('_LANG_UPG_STEP_INFO','Parece que o arquivo wp-config.php nôþ existe. Verifique se vocôþatualizou o wp-config.sample.php com as informações corretas do banco de dados e renomeou-o para wp-config.php.');
define('_LANG_UPG_STEP_INFO2','<p>Este arquivo atualiza seu WordPress para a ôþtima versôþ. Seja paciente, pode levar alguns instantes. </p><p>Se vocôþestiver pronto, clique <a href="upgrade.php?step=1">aqui</a>.</p>');
define('_LANG_UPG_STEP_INFO3','<p>ôþuma ôþica etapa, portanto se vocôþestôþvendo isso, ôþporque a atualização foi concluôþa. <a href="../">Divirta-se</a>! </p>');

/* File Name wp-admin/upgrade-functions.php */
define('_LANG_INST_BASE_VALUE88','Mostrar comentôþios apenas apôþ serem aprovados.');
define('_LANG_INST_BASE_VALUE89','Avisar sobre novos comentôþios pendentes de aprovação.');
define('_LANG_INST_BASE_VALUE90','Como os permalinks para o seu site sôþ feitos. Veja <a href=\"options-permalink.php\">Configurações de permalinks</a> para as regras mod_rewrite necessôþias e maiores informações.');
define('_LANG_INST_BASE_VALUE91','Se o arquivo de destino deve ser Gzip ou nôþ. Ative-o se vocôþnôþ tiver mod_gzip rodando ainda.');
define('_LANG_INST_BASE_VALUE92','Altere este valor para verdadeiro se vocôþplaneja usar arquivos hackeados. Aqui vocôþpoderôþguardar côþigos hackeados que nôþ serôþ sobreescritos quando vocôþatualizar. O arquivo deve estar na pasta raiz do wordpress e se chamar <code>my-hacks.php</code>');
define('_LANG_INST_BASE_VALUE93','blog_charset');
define('_LANG_INST_BASE_VALUE94','Diferenôþ em horas entre o fuso horôþio do servidor e o seu.');

/* File Name wp-admin/plugins.php */
define('_LANG_PG_LEAST_LEVEL','Para instalar um plug-in, ôþnecessôþio ter pelo menos nôþel 8.');
define('_LANG_PG_ACTIVATED_OK','Plug-ins <strong>ativados</strong>');
define('_LANG_PG_DEACTIVATED_OK','Plug-ins <strong>desativados</strong>');
define('_LANG_PG_PAGE_TITLE','Gerenciamento de plug-ins');
define('_LANG_PG_NEED_PUT','Plug-ins sôþ arquivos especiais que servem para adicionar novas opções no WordPress. Para instalar um plug-in, basta colocar os arquivos no diretôþio <code>wp-content/plugins</code>. Caso queira instalar um plug-in temporariamente, ôþpossôþel ativôþlo e desativôþlo nesta pôþina.');
define('_LANG_PG_OPEN_ERROR','Nôþ ôþpossôþel acessar o diretôþio "plugins" ou nôþ existem plug-ins a serem instalados.');
define('_LANG_PG_SUB_PLUGIN','Plug-in');
define('_LANG_PG_SUB_VERSION','Versôþ');
define('_LANG_PG_SUB_AUTHOR','Autor');
define('_LANG_PG_SUB_DESCR','Descrição');
define('_LANG_PG_SUB_ACTION','Ação');
define('_LANG_PG_SUB_DEACTIVATE','Desativar');
define('_LANG_PG_SUB_ACTIVATE','Ativar');
define('_LANG_PG_GOOGLE_HILITE','Quando alguôþ ôþindicado por um site de busca como Google e Yahoo, ou a pesquisa interna do WordPress, os termos pesquisados sôþ marcados com este plug-in. Pacote por <a href="http://photomatt.net/">Matt</a>.');
define('_LANG_PG_MARK_DOWN','Markdown ôþum conversor de texto para HTML para programadores. A <a href="http://daringfireball.net/projects/markdown/syntax">sôþtaxe Markdown</a> permite ôþvocôþescrever em formato texto e convertôþlo em um XHTML estruturalmente vôþido. Este plug-in ativa <strong>Markdown</strong> em seus posts e comentôþios. Escrito por <a href="http://daringfireball.net/">John Gruber</a> em Perl, portado para PHP por <a href="http://www.michelf.com/">Michel Fortin</a>, e transformado em plug-in WP por <a href="http://photomatt.net/">Matt</a>. Se vocôþativar este plug-in, vocôþdeve desativar o Textile 1 e 2 por causa do conflito de sôþtaxe.');
define('_LANG_PG_TEXTILE_2','Este ôþum wrapper simples para o Humane Web Text Generator de <a href="http://textism.com/?wp">Dean Allen</a>, tambôþ conhecido como <a href="http://www.textism.com/tools/textile/">Textile</a>. A versôþ 2 dôþmuita flexibilidade, o que faz dele quase um HTML meta-linguagem, porôþ ôþmais lento. Se vocôþativar este plug-in, deve desativar o Textile 1 e Markdown, pois eles nôþ funcionam bem juntos.');
define('_LANG_PG_HELLO_DOLLY','Este nôþ ôþapenas um plug-in, ele simboliza a esperanôþ e o entusiasmo de uma geração inteira somada em 2 palavras cantadas por Louis Armstrong. Este ôþo primeiro plug-in oficial do WordPress no mundo inteiro. Quando ativado, ele mostra randonomicamente uma frase de <cite>Hello, Dolly</cite> em todas as pôþinas da Administração, exceto nas configurações de plug-ins.');
define('_LANG_PG_TEXTILE_1','Este ôþum wrapper simples para o Humane Web Text Generator de <a href="http://textism.com/?wp">Dean Allen</a>, tambôþ conhecido como <a href="http://www.textism.com/tools/textile/">Textile</a>. Se vocôþativar este plug-in, deve desativar o Textile 2 e Markdown, pois eles nôþ funcionam muito bem juntos.');
}
?>