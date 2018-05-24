# Adrenth.RssFetcher OctoberCMS plugin

Fetches RSS/Atom feeds to put on your website. It can be automated using a cronjob or triggered manually.

## Installation

Install this plugin within OctoberCMS. It's available on the OctoberCMS Market Place.

## RSS & Atom feeds

The plugin uses the `zendframework/rss-feed` package to parse the RSS and/or Atom feeds. For more information on this package goto http://framework.zend.com/manual/current/en/index.html#zend-feed

## Components

The plugin is configured with 4 example sources and has a few components which help you to display items and/or sources on your website.

### Items

Shows a list of most recent RSS items limited on the maximun number of items provided by you.

An example of implementation code in your CMS page:

````
title = "A list of items"
url = "/items"
layout = "default"
is_hidden = 0

[rssItems]
maxItems = 10
==
{% component 'rssItems' %}
````

### PaginatableItems

Shows a list of most recent RSS items with an additional paginator element.

An example of implementation code in your CMS page:

````
title = "A list of items (paginatable)"
url = "/items"
layout = "default"
is_hidden = 0

[rssPaginatableItems]
itemsPerPage = 3
==
{% component 'rssPaginatableItems' %}
````

### Sources

Shows a list of sources.

An example of implementation code in your CMS page:

````
title = "A list of sources"
url = "/sources"
layout = "default"
is_hidden = 0

[rssSources]
==
{% component 'rssSources' %}
````

## Reporting Widgets

This plugin contains also a **RSS Headlines** widget to show the latest headlines on your Dashboard. This widget has three configurable properties: `maxItems`, `title` and `dateFormat`.

## Cronjob

There are many ways to configure a cronjob. Here's an basic example of cronjob configuration line:

````
5/* * * * php path/to/artisan adrenth:fetch-rss >> /dev/null 2>&1
````

The above line takes care of fetching all sources every 5 minutes.

The `adrenth:fetch-rss` command takes an optional `source_id` argument. Provide the source ID if you want to fetch only 1 source at that time.

## Execute from code

In your plugin code you can also use the following code to execute the Artisan command:

````
<?php

use Artisan;
// ...

Artisan::call('adrenth:fetch-rss', ['source' => 2]);
````

Or using the `RssFetcher` singleton:

````
RssFetcher::instance()->fetch(2);
````

## Issues

If you have issues using this plugin. Please create an issue or just send me an email [adrenth@gmail.com]().

## Contribution

Any help is appreciated. Or feel free to create a Pull Request.
