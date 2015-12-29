<?php

return [
    'plugin' => [
        'name' => 'RSS Fetcher',
        'description' => 'Haalt RSS items op van diverse bronnen om op jouw website te plaatsen',
    ],
    'permissions' => [
        'access_sources_label' => 'Toegang tot bronnen',
        'access_items_label' => 'Toegang tot items',
    ],
    'navigation' => [
        'menu_label' => 'RSS Fecther',
        'side_menu_label_sources' => 'Bronnen',
        'side_menu_label_items' => 'Items',
    ],
    'source' => [
        'source' => 'Bron',
        'sources' => 'Bronnen',
        'title' => 'Titel',
        'link' => 'Link',
        'description' => 'Omschrijving',
        'author' => 'Auteur',
        'category' => 'Categorie',
        'comments' => 'Reacties',
        'published_at' => 'Gepubliceerd op',
        'source_not_enabled' => 'Bron is niet inschakeld',
        'items_fetch_success' => 'RSS items succesvol opgehaald van deze bron',
        'items_fetch_fail' => 'Er is een fout opgetreden tijdens het ophalen van de items: :error',
        'new_source' => 'Nieuwe bron',
        'create_source' => 'Bron aanmaken',
        'edit_source' => 'Wijzig bron',
        'manage_sources' => 'Beheer bronnen',
        'return_to_sources' => 'Terug naar bronlijst',
        'fetch_items' => 'Items ophalen',
        'fetching_items' => 'Items ophalen...',
        'delete_confirm' => 'Weet je zeker dat je deze bron wilt verwijderen?'
    ],
    'item' => [
        'item' => 'Item',
        'items' => 'Items',
        'name' => 'Naam',
        'source_url' => 'Bron URL',
        'max_items' => 'Maximum items',
        'max_items_description' => 'Maximaal aantal items om op te halen van bron',
        'enabled' => 'Ingeschakeld',
        'enabled_comment' => 'Schuif om de bron in te schakelen',
        'description' => 'Omschrijving',
        'items_count' => 'Aantal items',
        'last_fetched' => 'Laatst opgehaald',
        'new_item' => 'Nieuw item',
        'create_item' => 'Item aanmaken',
        'edit_item' => 'Wijzig item',
        'manage_items' => 'Beheer items',
        'return_to_items' => 'Terug naar itemlijst',
        'delete_confirm' => 'Weet je zeker dat je dit item wilt verwijderen?'
    ],
    'component' => [
        'item_list' => [
            'name' => 'Itemlijst',
            'description' => 'Toont een lijst van meest recente items op de pagina.',
        ]
    ],
    'report_widget' => [
        'headlines' => [
            'name' => 'RSS Item Widget',
            'description' => 'Toont de meest recente RSS items',
            'title_title' => 'Widget titel',
            'title_default' => 'Laatste headlines',
            'title_required' => 'Widget titel is vereist',
            'max_items_title' => 'Aantal items om te tonen',
            'date_format_title' => 'Datum formaat',
            'date_format_description' => 'Raadpleeg de officiële `date` PHP documentatie op php.net.',
        ]
    ]
];
