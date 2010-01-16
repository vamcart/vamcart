<?php
/* -----------------------------------------------------------------------------------------
   VaM Cart
   http://vamcart.com
   http://vamcart.ru
   Copyright 2010 VaM Cart
   -----------------------------------------------------------------------------------------
   Portions Copyright:
   Copyright 2007 by Kevin Grandon (kevingrandon@hotmail.com)
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

echo __('Date: ', true) . $time->niceShort($data['ModuleReview']['created']);
echo '<br /><br />';
echo __('Author: ', true) . $data['ModuleReview']['name'];
echo '<br /><br />';
echo __('Review: ', true) . $data['ModuleReview']['content'];
echo '<br /><br />';
echo $html->link(__('Return to menu', true),'/module_reviews/admin/admin_index/',array('class' => 'button'));


?>