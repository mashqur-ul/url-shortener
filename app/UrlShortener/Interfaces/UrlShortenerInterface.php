<?php

namespace App\UrlShortener\Interfaces;

interface UrlShortenerInterface
{
    /**
     * @param string $url
     * @return string
     */
    public function make(string $url): string;

    /**
     * @param string $shortUrl
     * @return string|null
     */
    public function resolve(string $shortUrl): ?string;
}
