<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @foreach($links as $link)
        <sitemap>
            <loc>{{ $link }}</loc>
{{--            https://sitename.com/sitemap/1.xml--}}
        </sitemap>
    @endforeach
</sitemapindex>
