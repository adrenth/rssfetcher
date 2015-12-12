<?php

namespace Adrenth\RssFetcher\Controllers;

use Adrenth\RssFetcher\Models\Source;
use ApplicationException;
use BackendMenu;
use Backend\Classes\Controller;
use Artisan;
use Flash;

/**
 * Sources Back-end Controller
 */
class Sources extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Adrenth.RssFetcher', 'rssfetcher', 'sources');
    }

    /**
     * Fetches RSS items from source
     *
     * @throws ApplicationException
     * @return void
     */
    public function onFetch()
    {
        try {
            $source = Source::findOrFail($this->params[0]);

            if ($source instanceof Source && !$source->getAttribute('is_enabled')) {
                throw new \RuntimeException('Source is not enabled, please enabled it first.');
            }

            Artisan::call('adrenth:fetch-rss', ['source' => $this->params[0]]);
            Flash::success('Successfully fetched RSS items for this source');
        } catch (\Exception $e) {
            throw new ApplicationException('Error while fetching RSS items: ' . $e->getMessage());
        }
    }
}
