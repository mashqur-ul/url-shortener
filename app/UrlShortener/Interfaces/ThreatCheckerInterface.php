<?php

namespace App\UrlShortener\Interfaces;

interface ThreatCheckerInterface
{
    /**
     * @param array $urls
     * @return bool
     */
    public function isSafe(array $urls): bool;
}
