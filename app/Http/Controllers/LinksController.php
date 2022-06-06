<?php

namespace App\Http\Controllers;

use App\UrlShortener\Interfaces\ThreatCheckerInterface;
use App\UrlShortener\Interfaces\UrlShortenerInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LinksController extends Controller
{
    private UrlShortenerInterface $urlShortener;
    private ThreatCheckerInterface $threatChecker;

    /**
     * @param UrlShortenerInterface $urlShortener
     * @param ThreatCheckerInterface $threatChecker
     */
    public function __construct(
        UrlShortenerInterface $urlShortener,
        ThreatCheckerInterface $threatChecker
    ) {

        $this->urlShortener = $urlShortener;
        $this->threatChecker = $threatChecker;
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function getShortUrl(Request $request)
    {
        $url = $request->validate([
            'url' => 'required|string|active_url',
        ]);

        if (!$this->threatChecker->isSafe($url)) {
            throw ValidationException::withMessages([
                'url' => __('Malicious URL is not allowed!')
            ]);
        }

        try {
            $shortenedUrl = $this->urlShortener->make($request->get('url'));

            return [
                "success" => true,
                "shortened_url" => $shortenedUrl
            ];
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'url' => __('Sorry something went wrong. Please try again later.')
            ]);
        }

    }

    /**
     * @param string $hash
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(string $hash)
    {
        $url = $this->urlShortener->resolve($hash);

        if (empty($url)) {
            abort(404, 'Link not found.');
        }

        return redirect()->away($url);
    }
}
