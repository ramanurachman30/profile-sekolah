<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use App\Models\SchoolProfile;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Hasilkan Sitemap XML dinamis untuk indeks mesin pencari (Google/Bing).
     */
    public function sitemap(): Response
    {
        $profile = SchoolProfile::first();
        $defaultLastMod = ($profile?->updated_at ?? now())->toAtomString();

        $staticPages = [
            ['url' => route('home'), 'priority' => '1.0', 'changefreq' => 'daily', 'lastmod' => $defaultLastMod],
            ['url' => route('ppdb.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => $defaultLastMod],
            ['url' => route('profile'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $defaultLastMod],
            ['url' => route('academic'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $defaultLastMod],
            ['url' => route('student-affairs'), 'priority' => '0.8', 'changefreq' => 'monthly', 'lastmod' => $defaultLastMod],
            ['url' => route('facilities'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => $defaultLastMod],
            ['url' => route('achievements'), 'priority' => '0.8', 'changefreq' => 'weekly', 'lastmod' => $defaultLastMod],
            ['url' => route('news.index'), 'priority' => '0.9', 'changefreq' => 'daily', 'lastmod' => $defaultLastMod],
            ['url' => route('gallery'), 'priority' => '0.7', 'changefreq' => 'weekly', 'lastmod' => $defaultLastMod],
            ['url' => route('contact.index'), 'priority' => '0.7', 'changefreq' => 'monthly', 'lastmod' => $defaultLastMod],
        ];

        $articles = NewsArticle::published()
            ->select(['slug', 'published_at', 'created_at'])
            ->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($staticPages as $page) {
            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($page['url'], ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= '    <lastmod>'.$page['lastmod']."</lastmod>\n";
            $xml .= '    <changefreq>'.$page['changefreq']."</changefreq>\n";
            $xml .= '    <priority>'.$page['priority']."</priority>\n";
            $xml .= "  </url>\n";
        }

        foreach ($articles as $article) {
            $articleUrl = route('news.show', $article->slug);
            $lastMod = ($article->published_at ?? $article->created_at ?? now())->toAtomString();

            $xml .= "  <url>\n";
            $xml .= '    <loc>'.htmlspecialchars($articleUrl, ENT_XML1, 'UTF-8')."</loc>\n";
            $xml .= '    <lastmod>'.$lastMod."</lastmod>\n";
            $xml .= "    <changefreq>weekly</changefreq>\n";
            $xml .= "    <priority>0.8</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    /**
     * Hasilkan aturan robots.txt dinamis beserta tautan Sitemap XML.
     */
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Allow: /',
            'Disallow: /admin',
            'Disallow: /admin/',
            'Disallow: /ppdb/sukses/',
            'Disallow: /ppdb/daftar',
            '',
            'Sitemap: '.route('seo.sitemap'),
        ];

        return response(implode("\n", $lines), 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
