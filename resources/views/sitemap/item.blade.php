<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($items as $item)
        <url>
            <loc>https://agrofilter.ru/products/{{ $item->id }}</loc>
            <lastmod>{{ \Illuminate\Support\Carbon::parse($item->created_at)->format('Y-m-d') }}</lastmod>
            <changefreq>always</changefreq>
            <priority>0.6</priority>
        </url>
    @endforeach
</urlset>
