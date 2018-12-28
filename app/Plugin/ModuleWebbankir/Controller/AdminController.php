<?php

class AdminController extends ModuleWebbankirAppController
{
    /**
     * @var array
     */
    private $settings;

    /**
     * @param CakeRequest         $request
     * @param CakeResponse | null $response
     */
    public function __construct($request, $response = null)
    {
        require_once $_SERVER['DOCUMENT_ROOT'] . '/app/Plugin/ModuleWebbankir/settings.php';

        foreach ($this->getSettings() as $moduleWebbankirSetting) {
            $setting = $moduleWebbankirSetting['ModuleWebbankirSetting'];
            $this->settings[$setting['code']] = $setting['value'];
        }

        parent::__construct($request, $response);
    }

    /**
     * @return void
     */
    public function admin_help()
    {
        $this->redirect('/module_webbankir/admin/admin_index/');
    }

    /**
     * @return array
     */
    public function getSettings()
    {
        $settings = $this->ModuleWebbankirSetting->find('all');

        foreach ($settings as $key => $value) {
            if ($settings[$key]['ModuleWebbankirSetting']['type'] === 'select') {
                $language = $this->Language->find('first', ['conditions' => ['active' => 1]]);
                $statuses = $this->OrderStatusDescription->find('all', [
                    'conditions' => [
                        'language_id' => $language['Language']['id']
                    ]
                ]);

                foreach ($statuses as $status) {
                    $settings[$key]['ModuleWebbankirSetting']['options'][] = $status['OrderStatusDescription']['name'];
                }
            }
        }

        return $settings;
    }

    /**
     * @param string | null $activePage
     *
     * @return void
     */
    public function admin_index($activePage = null)
    {
        if (empty($activePage)) {
            $this->redirect('/module_webbankir/admin/admin_index/' . WEBBANKIR_PAGE_SETTINGS);
        }

        $this->set('current_crumb', __d(WEBBANKIR_MODULE, 'WEBBANKIR'));
        $this->set('title_for_layout', __d(WEBBANKIR_MODULE, 'WEBBANKIR'));
        $this->set('activePage', $activePage);
        $this->set('pages', [
            WEBBANKIR_PAGE_SETTINGS => 'WEBBANKIR_SETTINGS',
        ]);

        $this->set('webbankirSettings', $this->getSettings());
    }

    /**
     * @return void
     */
    public function admin_save()
    {
        if (!empty($this->data)) {
            foreach ($this->data['settingsForm'] as $key => $value) {
                $currentConfig = $this->ModuleWebbankirSetting->find('first', ['conditions' => ['code' => $key]]);
                $currentConfig['ModuleWebbankirSetting']['value'] = $value;
                $this->ModuleWebbankirSetting->save($currentConfig);
            }

            $this->Session->setFlash(__('Record saved.', true));
        }

        $this->redirect('/module_webbankir/admin/admin_index/' . WEBBANKIR_PAGE_SETTINGS);
    }
}
