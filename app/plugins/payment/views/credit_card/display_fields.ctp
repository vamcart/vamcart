<div class="css_form">
<div id="credit_card_details">
	<div>
		<label>CC Number:</label>
		<?php 
			echo $form->input('CreditCard.cc_number'); 
		?>
	</div>
	<div>
		<label>CC Expiration:</label>
		<?php
			echo $form->month('CreditCard.cc_expiration',null,null,false);
			echo '&nbsp;&nbsp;';
			echo $form->year('CreditCard.cc_expiration',2005,2050,2005,null,false);	
		?>
	</div>
	<div>
	</div>
</div>
</div>
<span class="button"><button type="submit" value="{lang}Confirm Order{/lang}">{lang}Confirm Order{/lang}</button></span>