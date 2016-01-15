<?php

namespace Adrenth\RssFetcher\Controllers;

use Adrenth\RssFetcher\Exceptions\SourceNotEnabledException;
use Adrenth\RssFetcher\Models\Source;
use ApplicationException;
use Artisan;
use Backend\Classes\Controller;
use BackendMenu;
use Flash;
use Lang;

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
                throw new SourceNotEnabledException(Lang::get('adrenth.rssfetcher::lang.source.source_not_enabled'));
            }

            Artisan::call('adrenth:fetch-rss', ['source' => $this->params[0]]);
            Flash::success(Lang::get('adrenth.rssfetcher::lang.source.items_fetch_success'));
        } catch (SourceNotEnabledException $e) {
            Flash::warning($e->getMessage());
        } catch (\Exception $e) {
            throw new ApplicationException(
                Lang::get('adrenth.rssfetcher::lang.source.items_fetch_fail', [
                    'error' => $e->getMessage()
                ])
            );
        }
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
            foreach ($checkedIds as $sourceId) {
                if (!$source = Source::find($sourceId)) {
                    continue;
                }

                $source->delete();
            }
        }

        return $this->listRefresh();
    }
}
