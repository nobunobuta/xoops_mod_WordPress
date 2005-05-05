<?php
// GIJOE's Ticket Class (based on Marijuana's Oreteki XOOPS)
// nobunobu's suggestions are applied

if( ! class_exists( '_XoopsTicket' ) ) {
class _XoopsTicket {

	var $_errors = array() ;
	var $_latest_token = '' ; //for Debug purpose
	var $_post_param_name = 'XOOPS_TICKET';
	var $_session_param_name = 'XOOPS_STUBS';
	var $_max_stub_size = 10;
	var $_default_timeout = 1800;
	
	// render form as plain html
	function getTicketHtml( $salt = '' , $timeout = -1 )
	{
		return '<input type="hidden" name="'.$this->_post_param_name.'" value="'.$this->issue( $salt , $timeout ).'" />' ;
	}

	// returns an object of XoopsFormHidden including theh ticket
	function getTicketXoopsForm( $salt = '' , $timeout = -1 )
	{
		return new XoopsFormHidden( $this->_post_param_name , $this->issue( $salt , $timeout ) ) ;
	}

	// returns an array for xoops_confirm() ;
	function getTicketArray( $salt = '' , $timeout = -1 )
	{
		return array( $this->_post_param_name => $this->issue( $salt , $timeout ) ) ;
	}

	// return GET parameter string.
	function getTicketParamString( $salt = '' , $noamp = false , $timeout = -1 )
	{
	    return ( $noamp ? '' : '&amp;' ) . $this->_post_param_name .'=' . $this->issue( $salt, $timeout ) ;
	}

	// issue a ticket
	function issue( $salt = '' , $timeout = -1 )
	{
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

		// store stub
		$_SESSION[$param_name][] = array(
			'expire' => time() + $timeout ,
			'token' => $token
		) ;

		// paid md5ed token as a ticket
		return md5( $token . XOOPS_DB_PREFIX ) ;
	}

	// check a ticket
	function check($reqtype='BOTH')
	{
		$this->_errors = array() ;
		$param_name = $this->_session_param_name;

		// CHECK: stubs are not stored in session
		if( empty( $_SESSION[$param_name] ) || !is_array($_SESSION[$param_name])) {
			$this->clear() ;
			$this->_errors[] = "Invalid Session[$param_name]" ;
			return false ;
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
			$this->clear() ;
			$this->_errors[] = 'Irregular post found' ;
			return false ;
		}

		// gargage collection & find a right stub
		$stubs_tmp = array() ;
		foreach( $_SESSION[$param_name] as $stub ) {
			if( $stub['expire'] >= time() ) {
				if (md5( $stub['token'].XOOPS_DB_PREFIX ) === $ticket) {
					$found_stub = $stub ;
				} else {
					// store the other valid stubs into session
					$stubs_tmp[] = $stub ;
				}
			} else {
				if(md5( $stub['token'] . XOOPS_DB_PREFIX ) === $ticket) {
					// not CSRF but Time-Out
					$timeout_flag = true ;
				}
			}
		}
		$_SESSION[$param_name] = $stubs_tmp;

		// CHECK: no right stub found
		if( empty( $found_stub ) ) {
//			$this->clear() ;
			if( empty( $timeout_flag ) ) $this->_errors[] = 'Invalid Session' ;
			else $this->_errors[] = 'Time out' ;
			return false ;
		}

		// all green
		return true;
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

class XoopsWPTicket extends _XoopsTicket {
	// intialize parameter names
	function XoopsWPTicket()
	{
		$this->_post_param_name = 'XOOPS_WP_TICKET';
		$this->_session_param_name = 'XOOPS_WP_STUBS';
		$this->_max_stub_size = 20;
		$this->_default_timeout = 1800;
	}
}
// create a instance in global scope
$GLOBALS['xoopsWPTicket'] = new XoopsWPTicket() ;

}
?>
