<?php
// GIJOE's Ticket Class (based on Marijuana's Oreteki XOOPS)
// nobunobu's suggestions are applied

if( ! class_exists( '_XoopsTicket' ) ) {
class _XoopsTicket {

	var $_errors = array() ;
	var $_latest_token = '' ;
	var $_post_param_name;
	var $_session_param_name;
	
	
	// intialize parameter names
	function _XoopsTicket()
	{
		$this->_post_param_name = 'XOOPS_TICKET';
		$this->_session_param_name = 'XOOPS_TICKET';
	}

	// render form as plain html
	function getTicketHtml( $salt = '' , $timeout = 1800 )
	{
		return '<input type="hidden" name="'.$this->_post_param_name.'" value="'.$this->issue( $salt , $timeout ).'" />' ;
	}

	// returns an object of XoopsFormHidden including theh ticket
	function getTicketXoopsForm( $salt = '' , $timeout = 1800 )
	{
		return new XoopsFormHidden( $this->_post_param_name , $this->issue( $salt , $timeout ) ) ;
	}

	// returns an array for xoops_confirm() ;
	function getTicketArray( $salt = '' , $timeout = 1800 )
	{
		return array( $this->_post_param_name => $this->issue( $salt , $timeout ) ) ;
	}

	// return GET parameter string.
	function getTicketParamString( $salt = '' , $noamp = false , $timeout=1800 )
	{
	    return ( $noamp ? '' : '&amp;' ) . $this->_post_param_name .'='. $this->issue( $salt, $timeout ) ;
	}

	// issue a ticket
	function issue( $salt = '' , $timeout = 1800 )
	{
		// create a token
		list( $usec , $sec ) = explode( " " , microtime() ) ;
		$token = crypt( $salt . $usec . $_ENV['PATH'] . $sec ) ;
		$this->_latest_token = $token ;

		// store stub
		$_SESSION[$this->_session_param_name][] = array(
			'expire' => time() + $timeout ,
			'ip' => $_SERVER['REMOTE_ADDR'] ,
			'token' => $token
		) ;

		// paid md5ed token as a ticket
		return md5( $token . XOOPS_DB_PREFIX ) ;
	}

	// check a ticket
	function check( $post = true )
	{

		$this->_errors = array() ;

		// CHECK: stubs are not stored in session
		if( empty( $_SESSION[$this->_session_param_name] ) || ! is_array($_SESSION[$this->_session_param_name])) {
			$this->clear() ;
			$this->_errors[] = 'Invalid Session' ;
			return false ;
		}

		// get key&val of the ticket from a user's query
		if( $post ) {
			$ticket = empty( $_POST[$this->_post_param_name] ) ? '' : $_POST[$this->_post_param_name] ;
		} else {
			$ticket = empty( $_GET[$this->_post_param_name] ) ? '' : $_GET[$this->_post_param_name] ;
		}

		// CHECK: no tickets found
		if( empty( $ticket ) ) {
			$this->clear() ;
			$this->_errors[] = 'Irregular post found' ;
			return false ;
		}

		// gargage collection & find a right stub
		$stubs_tmp = $_SESSION[$this->_session_param_name] ;
		$_SESSION[$this->_session_param_name] = array() ;
		foreach( $stubs_tmp as $stub ) {
			// default lifetime 30min
			if( $stub['expire'] >= time() ) {
				if( md5( $stub['token'] . XOOPS_DB_PREFIX ) === $ticket ) {
					$found_stub = $stub ;
				} else {
					// store the other valid stubs into session
					$_SESSION[$this->_session_param_name][] = $stub ;
				}
			} else {
				if( md5( $stub['token'] . XOOPS_DB_PREFIX ) === $ticket ) {
					// not CSRF but Time-Out
					$timeout_flag = true ;
				}
			}
		}

		// CHECK: no right stub found
		if( empty( $found_stub ) ) {
			$this->clear() ;
			if( empty( $timeout_flag ) ) $this->_errors[] = 'Invalid Session' ;
			else $this->_errors[] = 'Time out' ;
			return false ;
		}

		// CHECK: different ip
		if( $found_stub['ip'] != $_SERVER['REMOTE_ADDR'] ) {
			$this->clear() ;
			$this->_errors[] = 'IP has been changed' ;
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
	}
}
// create a instance in global scope
$GLOBALS['xoopsWPTicket'] = new XoopsWPTicket() ;

}
?>
