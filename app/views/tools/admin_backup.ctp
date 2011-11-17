<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo $html->script('jquery/jquery.min', array('inline' => false));
echo $admin->ShowPageHeaderStart($current_crumb, 'database-backup.png');
?>
<iframe src="/sxd/?sid=<?php echo session_name(); ?>&lang=<?php echo $lang ?>" width="586" height="462" frameborder="0" style="margin:0;"></iframe>
<?php
echo $admin->ShowPageHeaderEnd();