<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<div class="wrap">
	<table width="100%">
	  <tr>
	    <td valign="top" width="200">
	      <?php echo _LANG_E_SHOW_POSTS; ?>
	    </td>
	    <td>
	      <table cellpadding="0" cellspacing="0" border="0">
	        <tr>
	          <td colspan="2" align="center"><!-- show next/previous X posts -->
	            <form name="previousXposts" method="get" action="">
	<?php if ($previousXstart >= 0) { ?>
	              <input type="hidden" name="showposts" value="<?php echo $showposts; ?>" />
	              <input type="hidden" name="poststart" value="<?php echo $previousXstart; ?>" />
	              <input type="hidden" name="postend" value="<?php echo $previousXend; ?>" />
	              <input type="submit" name="submitprevious" value="< <?php echo $showposts ?>" />
	<?php } ?>
	            </form>
	          </td>
	          <td>
	            <form name="nextXposts" method="get" action="">
	              <input type="hidden" name="showposts" value="<?php echo $showposts; ?>" />
	              <input type="hidden" name="poststart" value="<?php echo $nextXstart; ?>" />
	              <input type="hidden" name="postend" value="<?php echo $nextXend; ?>" />
	              <input type="submit" name="submitnext" value="<?php echo $showposts ?> >" />
	            </form>
	          </td>
	        </tr>
	      </table>
	    </td>
	  </tr>
	  <tr>
	    <td valign="top" width="200"><!-- show X first/last posts -->
	      <form name="showXfirstlastposts" method="get" action="">
	        <input type="text" name="showposts" value="<?php echo $showposts ?>" style="width:40px;" /?>
	        <select name="order">
	          <option value="DESC" <?php selected($order,"DESC") ?>>last posts</option>
	          <option value="ASC"  <?php selected($order,"ASC") ?>>first posts</option>
	        </select>&nbsp;
	        <input type="submit" name="submitfirstlast" value="OK" />
	      </form>
	    </td>
	    <td valign="top"><!-- show post X to post X -->
	      <form name="showXfirstlastposts" method="get" action="">
	        <input type="text" name="poststart" value="<?php echo $poststart ?>" style="width:40px;" /?>&nbsp;to&nbsp;<input type="text" name="postend" value="<?php echo $postend ?>" style="width:40px;" /?>&nbsp;
	        <select name="order">
	          <option value="DESC" <?php selected($order,"DESC") ?>>from the end</option>
	          <option value="ASC" <?php echo selected($order,"ASC") ?>>from the start</option>
	        </select>&nbsp;
	        <input type="submit" name="submitXtoX" value="OK" />
	      </form>
	    </td>
	  </tr>
	</table>
</div>
