<?php

namespace Adrenth\RssFetcher\Controllers;

use Adrenth\RssFetcher\Models\Item;
use Backend\Behaviors\FormController;
use Backend\Behaviors\ListController;
use BackendMenu;
use Backend\Classes\Controller;

/**
 * Class Items
 *
 * @package Adrenth\RssFetcher\Controllers
 * @mixin FormController
 * @mixin ListController
 */
class Items extends Controller
{
    /**
     * {@inheritdoc}
     */
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    /**
     * @type string
     */
    public $formConfig = 'config_form.yaml';

    /**
     * @type string
     */
    public $listConfig = 'config_list.yaml';

    /**
     * {@inheritdoc}
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Adrenth.RssFetcher', 'rssfetcher', 'items');
    }

    /**
     * @return mixed
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked'))
            && is_array($checkedIds)
            && count($checkedIds)
        ) {
            foreach ((array) $checkedIds as $sourceId) {
                if (!$source = Item::find($sourceId)) {
                    continue;
                }

                $source->delete();
            }
        }

        return $this->listRefresh();
    }
}
