<?php

namespace App\UrlShortener\Services;

use App\Enums\LinkStatus;
use App\Models\Link;
use App\UrlShortener\Interfaces\UrlShortenerInterface;
use Illuminate\Support\Str;

class UrlShortenerService implements UrlShortenerInterface
{
    private function getNewUniqueHash()
    {
        $hash = Str::random(6);

        $link = Link::where('hash', $hash)->first();

        if (!blank($link)) {
            return $this->getNewUniqueHash();
        }

        return $hash;
    }

    /**
     * @param string $url
     * @return string
     */
    public function make(string $url): string
    {
        $link = Link::where('url', $url)->first();
        if (!blank($link)) {
            return $link->short_url;
        }

        $hash = $this->getNewUniqueHash();

        $link = new Link();
        $link->fill([
            'url' => $url,
            'hash' => $hash,
            'status' => LinkStatus::Active->value,
        ]);
        $link->save();

        return $link->short_url;
    }

    /**
     * @param string $hash
     * @return string
     */
    public function resolve(string $hash): ?string
    {
        $link = Link::where('hash', $hash)->first();

        if (!blank($link)) {
            return $link->url;
        }

        return '';
    }
}
