<?php
/* -----------------------------------------------------------------------------------------
   VamCart - http://vamcart.com
   -----------------------------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class User extends AppModel {

	var $name = 'User';

	var $hasMany = array('UserPref' => array('dependent'     => true));

}

?>