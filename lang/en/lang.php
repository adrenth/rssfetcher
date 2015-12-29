<?php

return [
    'plugin' => [
        'name' => 'RSS Fetcher',
        'description' => 'Fetches RSS items from various sources to put on your website',
    ],
    'permissions' => [
        'access_sources_label' => 'Access sources',
        'access_items_label' => 'Access items',
    ],
    'navigation' => [
        'menu_label' => 'RSS Fecther',
        'side_menu_label_sources' => 'Sources',
        'side_menu_label_items' => 'Items',
    ],
    'source' => [
        'source' => 'Source',
        'sources' => 'Sources',
        'title' => 'Title',
        'link' => 'Link',
        'description' => 'Description',
        'author' => 'Author',
        'category' => 'Category',
        'comments' => 'Comments',
        'published_at' => 'Published At',
        'source_not_enabled' => 'Source is not enabled, please enabled it first',
        'items_fetch_success' => 'Successfully fetched RSS items for this source',
        'items_fetch_fail' => 'An error has occurred while fetching RSS items: :error',
        'new_source' => 'New Source',
        'create_source' => 'Create Source',
        'edit_source' => 'Edit Source',
        'manage_sources' => 'Manage Sources',
        'return_to_sources' => 'Return to sources list',
        'fetch_items' => 'Fetch items',
        'fetching_items' => 'Fetching items...',
        'delete_confirm' => 'Do you really want to delete this source?'
    ],
    'item' => [
        'item' => 'Item',
        'items' => 'Items',
        'name' => 'Name',
        'source_url' => 'Source URL',
        'max_items' => 'Max Items',
        'max_items_description' => 'Maximum items to fetch from source',
        'enabled' => 'Enabled',
        'enabled_comment' => 'Flick this switch to enable this RSS source',
        'description' => 'Description',
        'items_count' => '# items',
        'last_fetched' => 'Last fetched',
        'new_item' => 'New Item',
        'create_item' => 'Create Item',
        'edit_item' => 'Edit Item',
        'manage_items' => 'Manage Items',
        'return_to_items' => 'Return to items list',
        'delete_confirm' => 'Do you really want to delete this item?'
    ],
    'component' => [
        'item_list' => [
            'name' => 'Item List',
            'description' => 'Displays a list of latest RSS items on the page.',
        ],
        'source_list' => [
            'name' => 'Source List',
            'description' => 'Displays a list of sources.'
        ]
    ],
    'report_widget' => [
        'headlines' => [
            'name' => 'RSS Item Widget',
            'description' => 'Shows the latest fetched RSS items',
            'title_title' => 'Widget title',
            'title_default' => 'Latest Headlines',
            'title_required' => 'Widget title is required',
            'max_items_title' => 'Number of items to display',
            'date_format_title' => 'Date format',
            'date_format_description' => 'Please check official PHP documentation on date formatting on php.net.',
        ]
    ]
];
