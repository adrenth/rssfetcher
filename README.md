# Adrenth.RssFetcher OctoberCMS plugin

Fetches RSS/Atom feeds to put on your website. It can be automated using a cronjob or triggered manually.

## Installation

Install this plugin within OctoberCMS. It's available on the OctoberCMS Market Place.

## RSS & Atom feeds

The plugin uses the `zendframework/rss-feed` package to parse the RSS and/or Atom feeds. For more information on this package goto http://framework.zend.com/manual/current/en/index.html#zend-feed

## Components

The plugin is configured with 3 example sources and an `Items` component to show how you can build your own implementation.

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

## Issues

If you have issues using this plugin. Please create an issue or just send me an email [adrenth@gmail.com]().

## Contribution

Any help is appreciated. Or feel free to create a Pull Request.
