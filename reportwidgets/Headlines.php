<?php

namespace Adrenth\RssFetcher\ReportWidgets;

use Adrenth\RssFetcher\Components\Items;
use Backend\Classes\ReportWidgetBase;

/**
 * Class Headlines
 *
 * @package Adrenth\RssFetcher\ReportWidgets
 */
class Headlines extends ReportWidgetBase
{
    /**
     * @return array
     */
    public function widgetDetails()
    {
        return [
            'name' => 'RSS Item Widget',
            'description' => 'Shows the latest fetched RSS items'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties()
    {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Latest Headlines',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'maxItems' => [
                'title' => 'Number of items to display',
                'default' => '5',
                'type' => 'string',
                'validationPattern' => '^[0-9]+$'
            ],
            'dateFormat' => [
                'title' => 'Date format',
                'description' => 'Please check official PHP documentation on date formatting on php.net',
                'default' => 'Y-m-d H:i',
                'type' => 'string',
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $this->vars['title'] = $this->property('title');
        $this->vars['items'] = Items::loadItems($this->property('maxItems'));
        $this->vars['dateFormat'] = $this->property('dateFormat');
        return $this->makePartial('widget');
    }
}
