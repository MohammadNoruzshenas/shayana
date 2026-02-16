<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach ($podcasts as $podcast)
    <url>
     <loc>{{route('customer.singlePodcast',$podcast)}}</loc>
     <priority>1.0</priority>
     <lastmod>{{ $podcast->created_at->tz('UTC')->toAtomString() }}</lastmod>
     <changefreq>daily</changefreq>
     </url>
    @endforeach
     </urlset>
