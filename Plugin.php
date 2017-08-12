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
            'name' => 'adrenth.rssfetcher::lang.plugin.name',
            'description' => 'adrenth.rssfetcher::lang.plugin.name',
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
            Commands\FetchRssCommand::class
        );
    }

    /**
     * {@inheritdoc}
     */
    public function registerComponents()
    {
        return [
            Components\Items::class => 'rssItems',
            Components\PaginatableItems::class => 'rssPaginatableItems',
            Components\Sources::class => 'rssSources'
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
                'tab' => 'adrenth.rssfetcher::lang.plugin.name',
                'label' => 'adrenth.rssfetcher::lang.permissions.access_sources'
            ],
            'adrenth.rssfetcher.access_items' => [
                'tab' => 'adrenth.rssfetcher::lang.plugin.name',
                'label' => 'adrenth.rssfetcher::lang.permissions.access_items'
            ],
            'adrenth.rssfetcher.access_import_export' => [
                'tab' => 'adrenth.rssfetcher::lang.plugin.name',
                'label' => 'adrenth.rssfetcher::lang.permissions.access_import_export'
            ],
            'adrenth.rssfetcher.access_feeds' => [
                'tab' => 'adrenth.rssfetcher::lang.plugin.name',
                'label' => 'adrenth.rssfetcher::lang.permissions.access_feeds'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerNavigation()
    {
        return [
            'rssfetcher' => [
                'label' => 'adrenth.rssfetcher::lang.navigation.menu_label',
                'url' => Backend::url('adrenth/rssfetcher/sources'),
                'icon' => 'icon-rss',
                'permissions' => ['adrenth.rssfetcher.*'],
                'order' => 500,
                'sideMenu' => [
                    'sources' => [
                        'label' => 'adrenth.rssfetcher::lang.navigation.side_menu_label_sources',
                        'icon' => 'icon-globe',
                        'url' => Backend::url('adrenth/rssfetcher/sources'),
                        'permissions' => ['adrenth.rssfetcher.access_sources']
                    ],
                    'items' => [
                        'label' => 'adrenth.rssfetcher::lang.navigation.side_menu_label_items',
                        'icon' => 'icon-files-o',
                        'url' => Backend::url('adrenth/rssfetcher/items'),
                        'permissions' => ['adrenth.rssfetcher.access_items']
                    ],
                    'feeds' => [
                        'label' => 'adrenth.rssfetcher::lang.navigation.side_menu_label_feeds',
                        'icon' => 'icon-rss',
                        'url' => Backend::url('adrenth/rssfetcher/feeds'),
                        'permissions' => ['adrenth.rssfetcher.access_feeds']
                    ]
                ]
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function registerFormWidgets()
    {
        return [
            FormWidgets\TextWithPrefix::class => 'textWithPrefix'
        ];
    }
}
