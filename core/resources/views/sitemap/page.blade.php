<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
    @foreach ($pages as $page)
    <url>
     <loc>{{route('customer.page',$page)}}</loc>

     <priority>0.9</priority>
     <lastmod>{{ $page->created_at->tz('UTC')->toAtomString() }}</lastmod>
     <changefreq>daily</changefreq>
     </url>
    @endforeach
     </urlset>
