<?php
// GIJOE's Ticket Class (based on Marijuana's Oreteki XOOPS)
// nobunobu's suggestions are applied

if( ! class_exists( '_XoopsNTicket' ) ) {
class _XoopsNTicket {

	var $_errors = array() ;
	var $_latest_token = '' ; //for Debug purpose
	var $_post_param_name = 'XOOPS_N_TICKET';
	var $_session_param_name = 'XOOPS_N_STUBS';
	var $_max_stub_size = 10;
	var $_default_timeout = 1800;
	var $messages;
	
	function _XoopsNTicket()
	{
		// language file
		if( defined( 'XOOPS_ROOT_PATH' ) && ! empty( $GLOBALS['xoopsConfig']['language'] ) && ! strstr( $GLOBALS['xoopsConfig']['language'] , '/' ) ) {
			if( file_exists( dirname( dirname( __FILE__ ) ) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/wp_ticket.msg.php' ) ) {
				include dirname( dirname( __FILE__ ) ) . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/wp_ticket.msg.php' ;
			}
		}
		// default messages
		if( empty( $this->messages ) ) $this->messages = array(
			'err_general' => 'Ticket Error' ,
			'err_nostubs' => 'No stubs found' ,
			'err_noticket' => 'No ticket found' ,
			'err_nopair' => 'No valid ticket-stub pair found' ,
			'err_timeout' => 'Time out' ,
			'err_areaorref' => 'Invalid area or referer' ,
			'fmt_prompt4repost' => '<h2>Error(s) found</h2><span style="background-color:red;font-weight:bold;color:white;">%s</span><br />Confirm it.<br />And do you want to post again?' ,
			'btn_repost' => 'repost' ,
		) ;
	}

	// render form as plain html
	function getTicketHtml( $salt = '' , $timeout = -1 , $area = '' )
	{
		return '<input type="hidden" name="'.$this->_post_param_name.'" value="'.$this->issue( $salt , $timeout , $area).'" />' ;
	}

	// returns an object of XoopsFormHidden including theh ticket
	function getTicketXoopsForm( $salt = '' , $timeout = -1 , $area = '' )
	{
		return new XoopsFormHidden( $this->_post_param_name , $this->issue( $salt , $timeout , $area) ) ;
	}

	// add a ticket as Hidden Element into XoopsForm
	function addTicketXoopsFormElement( &$form , $salt = '' , $timeout = 1800 , $area = '' )
	{
		$form->addElement( new XoopsFormHidden( $this->_post_param_name  , $this->issue( $salt , $timeout , $area ) ) ) ;
	}

	// returns an array for xoops_confirm() ;
	function getTicketArray( $salt = '' , $timeout = -1 , $area = '' )
	{
		return array( $this->_post_param_name => $this->issue( $salt , $timeout , $area) ) ;
	}

	// return GET parameter string.
	function getTicketParamString( $salt = '' , $noamp = false , $timeout = -1 , $area = '' )
	{
	    return ( $noamp ? '' : '&amp;' ) . $this->_post_param_name .'=' . $this->issue( $salt, $timeout , $area) ;
	}

	// issue a ticket
	function issue( $salt = '' , $timeout = -1 , $area = '' )
	{
		global $xoopsModule ;

		if ($timeout==-1) $timeout = $this->_default_timeout;
		$param_name = $this->_session_param_name;

		// create a token
		list( $usec , $sec ) = explode( " " , microtime() ) ;
		$appendix_salt = empty( $_SERVER['PATH'] ) ? XOOPS_DB_NAME : $_SERVER['PATH'] ;
		$token = crypt( $salt . $usec . $appendix_salt . $sec ) ;
		$this->_latest_token = $token ;

		if( empty( $_SESSION[$param_name] ) || !is_array($_SESSION[$param_name])) {
			$_SESSION[$param_name] = array() ;
		}

		// limit max stubs
		if( sizeof( $_SESSION[$param_name] ) > $this->_max_stub_size ) {
			$_SESSION[$param_name] = array_slice( $_SESSION[$param_name], -$this->_max_stub_size ) ;
		}

		// record referer if browser send it
		$referer = empty( $_SERVER['HTTP_REFERER'] ) ? '' : $_SERVER['REQUEST_URI'] ;

		// area as module's dirname
		if( ! $area && is_object( @$xoopsModule ) ) {
			$area = $xoopsModule->getVar('dirname') ;
		}

		// store stub
		$_SESSION[$param_name][] = array(
			'expire' => time() + $timeout ,
			'referer' => $referer ,
			'area' => $area ,
			'token' => $token
		) ;

		// paid md5ed token as a ticket
		return md5( $token . XOOPS_DB_PREFIX ) ;
	}

	// check a ticket
	function check($reqtype='BOTH', $area = '', $allow_repost = true  )
	{
		global $xoopsModule ;

		$this->_errors = array() ;

		$param_name = $this->_session_param_name;

		// CHECK: stubs are not stored in session
		if( empty( $_SESSION[$param_name] ) || !is_array($_SESSION[$param_name])) {
			$this->_errors[] = $this->messages['err_nostubs'] ;
			$_SESSION[$param_name] = array() ;
		}

		// get key&val of the ticket from a user's query
		switch(strtoupper($reqtype)) {
		  case 'POST':
			$ticket = empty( $_POST[$this->_post_param_name] ) ? '' : $_POST[$this->_post_param_name] ;
			break;
		  case 'GET':
			$ticket = empty( $_GET[$this->_post_param_name] ) ? '' : $_GET[$this->_post_param_name] ;
			break;
		  case 'BOTH':
		  default:
			$ticket = empty( $_REQUEST[$this->_post_param_name] ) ? '' : $_REQUEST[$this->_post_param_name] ;
		}

		// CHECK: no tickets found
		if( empty( $ticket ) ) {
			$this->_errors[] = $this->messages['err_noticket'] ;
		}

		// gargage collection & find a right stub
		$stubs_tmp = $_SESSION[$param_name] ;
		$_SESSION[$param_name] = array() ;
		foreach( $stubs_tmp as $stub ) {
			// default lifetime 30min
			if( $stub['expire'] >= time() ) {
				if (md5( $stub['token'].XOOPS_DB_PREFIX ) === $ticket) {
					$found_stub = $stub ;
				} else {
					// store the other valid stubs into session
					$_SESSION[$param_name] = $stub ;
				}
			} else {
				if(md5( $stub['token'] . XOOPS_DB_PREFIX ) === $ticket) {
					// not CSRF but Time-Out
					$timeout_flag = true ;
				}
			}
		}

		// CHECK: the right stub found or not
		if( empty( $found_stub ) ) {
			if( empty( $timeout_flag ) ) $this->_errors[] = $this->messages['err_nopair'] ;
			else $this->_errors[] = $this->messages['err_timeout'] ;
		} else {

		    // set area if necessary
		    // area as module's dirname
		    if( ! $area && is_object( @$xoopsModule ) ) {
			    $area = $xoopsModule->getVar('dirname') ;
		    }
    
		    // check area or referer
		    if( @$found_stub['area'] == $area ) $area_check = true ;
		    if( ! empty( $found_stub['referer'] ) && strstr( @$_SERVER['HTTP_REFERER'] , $found_stub['referer'] ) ) $referer_check = true ;
    
		    if( empty( $area_check ) && empty( $referer_check ) ) { // loose
			    $this->_errors[] = $this->messages['err_areaorref'] ;
		    }
		}

		if( ! empty( $this->_errors ) ) {
			if( $allow_repost ) {
				// repost form
				$this->draw_repost_form( $area ) ;
				exit ;
			} else {
				// failed
				$this->clear() ;
				return false ;
			}
		} else {
			// all green
			return true;
		}
	}

	// draw form for repost
	function draw_repost_form( $area = '' )
	{
		// Notify which file is broken
		if( headers_sent() ) {
			restore_error_handler() ;
			set_error_handler( '_XoopsNTicket_ErrorHandler4FindOutput' ) ;
			header( 'Dummy: for warning' ) ;
			restore_error_handler() ;
			exit ;
		}
	
		error_reporting( 0 ) ;
		while( ob_get_level() ) ob_end_clean() ;
	    global $xoopsTpl, $xoopsConfig, $xoopsOption, $xoopsLogger;
	    if (file_exists(XOOPS_ROOT_PATH.'/themes/default/theme.html')) {
	        $xoopsConfig['theme_set'] = 'default';
	    }
        unset($xoopsOption['template_main']);
        $xoopsTpl =& new XoopsTpl();
    	$xoopsOption['theme_use_smarty'] = 1;
        $xoopsConfig['debug_mode'] = 0;
		ob_start();
    	$xoopsTpl->assign(array('xoops_theme' => $xoopsConfig['theme_set'], 'xoops_imageurl' => XOOPS_THEME_URL.'/'.$xoopsConfig['theme_set'].'/', 'xoops_themecss'=> xoops_getcss($xoopsConfig['theme_set']), 'xoops_sitename' => htmlspecialchars($xoopsConfig['sitename'], ENT_QUOTES), 'xoops_slogan' => htmlspecialchars($xoopsConfig['slogan'], ENT_QUOTES)));
		$table = '<table class="outer">' ;
		$form = '<form action="?'.htmlspecialchars(@$_SERVER['QUERY_STRING'],ENT_QUOTES).'" method="post" >' ;
		foreach( $_POST as $key => $val ) {
			if( $key == $this->_post_param_name ) continue ;
			if( get_magic_quotes_gpc() ) {
				$key = stripslashes( $key ) ;
			}
			if( is_array( $val ) ) {
				list( $tmp_table , $tmp_form ) = $this->extract_post_recursive( htmlspecialchars($key,ENT_QUOTES) , $val ) ;
				$table .= $tmp_table ;
				$form .= $tmp_form ;
			} else {
				if( get_magic_quotes_gpc() ) {
					$val = stripslashes( $val ) ;
				}
				$table .= '<tr><th><code>'.htmlspecialchars($key,ENT_QUOTES).'</code></th><td class="odd"><pre style="margin:0;padding:0;overflow:auto;"><code>'.htmlspecialchars($val,ENT_QUOTES).'</code></pre></td></tr>'."\n" ;
				$form .= '<input type="hidden" name="'.htmlspecialchars($key,ENT_QUOTES).'" value="'.htmlspecialchars($val,ENT_QUOTES).'" />'."\n" ;
			}
		}
		$table .= '</table>' ;
		$form .= $this->getTicketHtml(__LINE__,300,$area).'<input type="submit" value="'.$this->messages['btn_repost'].'" /></form>' ;

//		echo '<html><head><title>'.$this->messages['err_general'].'</title><style>table,td,th {border:solid black 1px; border-collapse:collapse;}</style></head><body>' . sprintf( $this->messages['fmt_prompt4repost'] , $this->getErrors() ) . $table . $form . '</body></html>' ;
		echo sprintf( $this->messages['fmt_prompt4repost'] , $this->getErrors() ) . $table . $form ;
        include XOOPS_ROOT_PATH.'/footer.php';
	}

	function extract_post_recursive( $key_name , $tmp_array ) {
		$table = '' ;
		$form = '' ;
		foreach( $tmp_array as $key => $val ) {
			if( get_magic_quotes_gpc() ) {
				$key = stripslashes( $key ) ;
			}
			if( is_array( $val ) ) {
				list( $tmp_table , $tmp_form ) = $this->extract_post_recursive( $key_name.'['.htmlspecialchars($key,ENT_QUOTES).']' , $val ) ;
				$table .= $tmp_table ;
				$form .= $tmp_form ;
			} else {
				if( get_magic_quotes_gpc() ) {
					$val = stripslashes( $val ) ;
				}
				$table .= '<tr><th><code>'.$key_name.'['.htmlspecialchars($key,ENT_QUOTES).']</code></th><td class="odd"><pre style="margin:0;padding:0;overflow:auto;"><code>'.htmlspecialchars($val,ENT_QUOTES).'</code></pre></td></tr>'."\n" ;
				$form .= '<input type="hidden" name="'.$key_name.'['.htmlspecialchars($key,ENT_QUOTES).']" value="'.htmlspecialchars($val,ENT_QUOTES).'" />'."\n" ;
			}
		}
		return array( $table , $form ) ;
	}


	// clear all stubs
	function clear()
	{
		$_SESSION[$this->_session_param_name] = array() ;
	}


	// Ticket Using
	function using()
	{
		if( ! empty( $_SESSION[$this->_session_param_name] ) ) {
			return true;
		} else {
			return false;
		}
	}


	// return errors
	function getErrors( $ashtml = true )
	{
		if( $ashtml ) {
			$ret = '' ;
			foreach( $this->_errors as $msg ) {
				$ret .= "$msg<br />\n" ;
			}
		} else {
			$ret = $this->_errors ;
		}
		return $ret ;
	}

// end of base class
}

}

if( ! class_exists( 'XoopsWPTicket' ) ) {

class XoopsWPTicket extends _XoopsNTicket {
	// intialize parameter names
	function XoopsWPTicket()
	{
	    parent::_XoopsNTicket();
		$this->_post_param_name = 'XOOPS_WP_TICKET';
		$this->_session_param_name = 'XOOPS_WP_STUBS';
		$this->_max_stub_size = 20;
		$this->_default_timeout = 1800;
	}
}
// create a instance in global scope
$GLOBALS['xoopsWPTicket'] = new XoopsWPTicket() ;

}

if( ! function_exists( '_XoopsNTicket_ErrorHandler4FindOutput' ) ) {
function _XoopsNTicket_ErrorHandler4FindOutput($errNo, $errStr, $errFile, $errLine)
{
	if( preg_match( '?'.preg_quote(XOOPS_ROOT_PATH).'([^:]+)\:(\d+)?' , $errStr , $regs ) ) {
		echo "Irregular output! check the file ".htmlspecialchars($regs[1])." line ".htmlspecialchars($regs[2]) ;
	} else {
		echo "Irregular output! check language files etc." ;
	}
	return ;
}
}
?>
