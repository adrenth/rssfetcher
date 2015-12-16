<?php

namespace Adrenth\RssFetcher;

use Backend;
use System\Classes\PluginBase;

/**
 * Class Plugin
 *
 * @package Adrenth\RssHeadlines
 */
class Plugin extends PluginBase
{
    /**
     * {@inheritdoc}
     */
    public function pluginDetails()
    {
        return [
            'name' => 'RssFetcher',
            'description' => 'Fetches RSS items from various sources to put on your website',
            'author' => 'A. Drenth <adrenth@gmail.com>',
            'icon' => 'icon-rss',
            'homepage' => 'http://github.com/adrenth/rssfetcher'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        $this->registerConsoleCommand(
            'Adrenth.RssFetcher',
            'Adrenth\RssFetcher\Commands\FetchRssCommand'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerComponents()
    {
        return [
            'Adrenth\RssFetcher\Components\Items' => 'rssItems'
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerReportWidgets()
    {
        return [
            'Adrenth\RssFetcher\ReportWidgets\Headlines' => [
                'label' => 'RSS Headlines',
                'code' => 'headlines'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerPermissions()
    {
        return [
            'adrenth.rssfetcher.access_sources' => [
                'tab' => 'RSS Fetcher',
                'label' => 'Access Sources'
            ],
            'adrenth.rssfetcher.access_items' => [
                'tab' => 'RSS Fetcher',
                'label' => 'Access Items'
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerNavigation()
    {
        return [
            'rssfetcher' => [
                'label' => 'RSS Fecther',
                'url' => Backend::url('adrenth/rssfetcher/sources'),
                'icon' => 'icon-rss',
                'permissions' => ['adrenth.rssfetcher.*'],
                'order' => 500,
                'sideMenu' => [
                    'sources' => [
                        'label' => 'Sources',
                        'icon' => 'icon-globe',
                        'url' => Backend::url('adrenth/rssfetcher/sources'),
                        'permissions' => ['adrenth.rssfetcher.access_sources']
                    ],
                    'items' => [
                        'label' => 'Items',
                        'icon' => 'icon-files-o',
                        'url' => Backend::url('adrenth/rssfetcher/items'),
                        'permissions' => ['adrenth.rssfetcher.access_items']
                    ]
                ]
            ]
        ];
    }
}
