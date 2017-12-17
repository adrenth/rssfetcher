<?php

declare(strict_types=1);

namespace Adrenth\RssFetcher\Classes\Reader\Extension\Media;

use Zend\Feed\Reader\Extension\AbstractEntry;

/**
 * Class Entry
 *
 * @see http://www.rssboard.org/media-rss#media-content
 * @package Adrenth\RssFetcher\Classes\Reader\Extension\Media
 */
class Entry extends AbstractEntry
{
    /**
     * Get <media:content medium="image | audio | video | document | executable">
     *
     * @return string|null
     */
    public function getMediaContentMedium()
    {
        $data = $this->xpath->evaluate('string(' . $this->getXpathPrefix() . '/media:content/@medium)');

        if (!$data) {
            $data = null;
        }

        $this->data['mediaContentMedium'] = $data;

        return $data;
    }

    /**
     * Get <media:content url="">
     *
     * @return null|string
     */
    public function getMediaContentUrl()
    {
        $data = $this->xpath->evaluate('string(' . $this->getXpathPrefix() . '/media:content/@url)');

        if (!$data) {
            $data = null;
        }

        $this->data['mediaContentUrl'] = $data;

        return $data;
    }

    /**
     * Register XML namespaces
     *
     * @return void
     */
    protected function registerNamespaces()
    {
        $this->xpath->registerNamespace('media', 'http://search.yahoo.com/mrss/');
    }
}
