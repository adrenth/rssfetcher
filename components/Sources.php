<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Components;

use Adrenth\RssFetcher\Models\Source;
use Cms\Classes\ComponentBase;
use InvalidArgumentException;
use October\Rain\Support\Collection;

/**
 * Class Sources
 *
 * @package Adrenth\RssFetcher\Components
 */
class Sources extends ComponentBase
{
    /**
     * @var Collection
     */
    public $sources;

    /**
     * {@inheritdoc}
     */
    public function componentDetails()
    {
        return [
            'name' => 'adrenth.rssfetcher::lang.component.source_list.name',
            'description' => 'adrenth.rssfetcher::lang.component.source_list.description',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function defineProperties(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function onRun()
    {
        $this->sources = $this->page['sources'] = self::loadSources();
    }

    /**
     * Load Sources
     *
     * @return array
     */
    public static function loadSources(): array
    {
        try {
            $sources = Source::where('is_enabled', '=', '1')->orderBy('name');
        } catch (InvalidArgumentException $e) {
            return [];
        }

        return $sources->get()->toArray();
    }
}
