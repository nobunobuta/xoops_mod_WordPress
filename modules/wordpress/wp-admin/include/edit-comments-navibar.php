<?php /* Don't remove this line */ if (!defined('XOOPS_ROOT_PATH')) { exit; }?>
<div class="wrap">
<table width="100%">
  <tr>
    <td valign="top" width="200">
      <?php echo _LANG_EC_SHOW_COM; ?>
    </td>
    <td>
      <table cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td colspan="2" align="center"><!-- show next/previous X comments -->
            <form name="previousXcomments" method="get" action="">
<?php
if ($previousXstart >= 0) {
?>
              <input type="hidden" name="showcomments" value="<?php echo $showcomments; ?>" />
              <input type="hidden" name="commentstart" value="<?php echo $previousXstart; ?>" />
              <input type="hidden" name="commentend" value="<?php echo $previousXend; ?>" />
              <input type="submit" name="submitprevious" value="< <?php echo $showcomments ?>" />
<?php
}
?>
            </form>
          </td>
          <td>
            <form name="nextXcomments" method="get" action="">
              <input type="hidden" name="showcomments" value="<?php echo $showcomments; ?>" />
              <input type="hidden" name="commentstart" value="<?php echo $nextXstart; ?>" />
              <input type="hidden" name="commentend" value="<?php echo $nextXend; ?>" />
              <input type="submit" name="submitnext" value="<?php echo $showcomments ?> >" />
            </form>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td valign="top" width="200"><!-- show X first/last comments -->
      <form name="showXfirstlastcomments" method="get" action="">
        <input type="text" name="showcomments" value="<?php echo $showcomments ?>" style="width:40px;" /?>
        <select name="commentorder">
          <option value="DESC" <?php selected($commentorder,"DESC") ?>>last comments</option>
          <option value="ASC" <?php selected($commentorder,"ASC") ?>>first comments</option>
        </select>&nbsp;
        <input type="submit" name="submitfirstlast" value="OK" />
      </form>
    </td>
    <td valign="top"><!-- show comment X to comment X -->
      <form name="showXfirstlastcomments" method="get" action="">
        <input type="text" name="commentstart" value="<?php echo $commentstart ?>" style="width:40px;" /?>&nbsp;to&nbsp;<input type="text" name="commentend" value="<?php echo $commentend ?>" style="width:40px;" /?>&nbsp;
        <select name="commentorder">
          <option value="DESC" <?php selected($commentorder,"DESC") ?>>from the end</option>
          <option value="ASC" <?php selected($commentorder,"ASC") ?>>from the start</option>
        </select>&nbsp;
        <input type="submit" name="submitXtoX" value="OK" />
      </form>
    </td>
  </tr>
</table>
</div>
