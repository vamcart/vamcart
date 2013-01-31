<?php

class DiscountsController extends AppController {
	public $name = 'Discounts';
        public $uses = array('ContentProductPrice');

	public function admin_delete ($content_id, $id)
	{
                // Ok, delete the currency
                $this->ContentProductPrice->delete($id);
                $this->Session->setFlash( __('Record deleted.', true));

		$this->redirect('/discounts/admin/'.$content_id);
	}

	public function admin_edit($content_id = null, $id = null)
	{
		$this->set('current_crumb', __('Discounts Details', true));
		$this->set('title_for_layout', __('Discounts Details', true));
		// If they pressed cancel
		if(isset($this->data['cancelbutton']))
		{
			$this->redirect('/discounts/admin/'.$content_id);
			die();
		}

		if(empty($this->data))
		{
			$this->request->data = $this->ContentProductPrice->read(null,$id);
                        if ($this->data['ContentProductPrice']['content_product_id'] == '')
                              $this->request->data['ContentProductPrice']['content_product_id'] = $content_id;
		}
		else
		{
			$this->ContentProductPrice->save($this->data);
			$this->Session->setFlash(__('Record saved.', true));
			$this->redirect('/discounts/admin/'.$this->data['ContentProductPrice']['content_product_id']);
		}
	}

	public function admin_new($content_id = null)
	{
		$this->redirect('/discounts/admin_edit/'.$content_id);
	}

	public function admin_modify_selected()
	{
		$build_flash = "";
		foreach($this->params['data']['Currency']['modify'] AS $value)
		{
			// Make sure the id is valid
			if($value > 0)
			{
				$this->Currency->id = $value;
				$currency = $this->Currency->read();

				switch ($this->data['multiaction'])
				{
					case "delete":
						// Make sure it's not the default currency
						if($currency['Currency']['default'] == 0)
						{
						    $this->Currency->delete($value);
							$build_flash .= __('Record deleted.', true) . ' (' . $currency['Currency']['name'] . ')<br />';
						}
						else
						{
							$build_flash .= __('Error: Could not delete default record.', true) . ' (' . $currency['Currency']['name'] . ')<br />';
						}
					break;
					case "activate":
						$currency['Currency']['active'] = 1;
						$this->Currency->save($currency);
						$build_flash .= __('Record activated.', true) . ' (' . $currency['Currency']['name'] . ')<br />';
					break;
					case "deactivate":
						// Don't let them deactivate the default currency
						if($currency['Currency']['default'] == 1)
						{
							$build_flash .=  __('Error: Could not deactivate default record.', true) .' (' . $currency['Currency']['name'] . ')<br />';
						}
						else
						{
							$currency['Currency']['active'] = 0;
							$this->Currency->save($currency);
							$build_flash .= __('Record deactivated.', true) . ' (' . $currency['Currency']['name'] . ')<br />';
						}
					break;
				}
			}
		}
		$this->Session->setFlash($build_flash);
		$this->redirect('/currencies/admin/');
	}

	public function admin($content_id = null, $ajax = false)
	{
		$this->set('current_crumb', __('Discounts Listing', true));
		$this->set('title_for_layout', __('Discounts Listing', true));
                $this->set('content_product_id', $content_id);
		$this->set('discount_data',$this->ContentProductPrice->find('all', array('conditions' => array('content_product_id' => $content_id), 'order' => 'quantity ASC')));
	}
}
?>