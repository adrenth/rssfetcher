<?php

namespace Adrenth\RssFetcher\Models;

use Backend\Models\ExportModel;

/**
 * Class SourceExport
 *
 * @package Adrenth\RssFetcher\Models
 */
class SourceExport extends ExportModel
{
    /**
     * {@inheritdoc}
     */
    public $table = 'adrenth_rssfetcher_sources';

    /**
     * {@inheritdoc}
     */
    public function exportData($columns, $sessionKey = null)
    {
        return self::make()->get()->toArray();
    }
}
