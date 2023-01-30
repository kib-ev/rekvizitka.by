<?php

namespace App\Console\Commands;

use App\Classes\LaravelHifiApi;
use App\Models\Contractor;
use App\Models\Filter;
use Illuminate\Console\Command;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generate sitemap.xml';

    protected int $perPage = 50000;

    public function handle()
    {
        $this->clearSitemapDir() && $this->generateSitemap();
    }

    private function clearSitemapDir(): bool
    {
        $sitemapDirName = public_path('sitemap');

        if(is_dir($sitemapDirName)) {
            $this->rmDir(public_path('sitemap'));
        }

        return mkdir($sitemapDirName);
    }

    private static function rmDir($dir): bool
    {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

    public function generateSitemap(): void
    {
        $indexLinks = $this->generateSitemapIndex();

        foreach ($indexLinks as $index => $link) {
            $this->generateSitemapItem($index + 1);
        }
    }

    public function generateSitemapIndex(): array
    {
        $totalCount = Contractor::count();
        $pagesCount = (int) ceil($totalCount / $this->perPage);

        $links = [];
        for($index = 1; $index <= $pagesCount; $index++) {
            $links[] = config('app.url') . "/" . $this->getFileName($index);
        }

        $view = view('sitemap.index', compact('links'))->render();
        file_put_contents(public_path('sitemap/index.xml'), $view);

        return $links;
    }

    public function generateSitemapItem($index)
    {
        $items = Contractor::select(['id', 'created_at'])
            ->skip(($index - 1) * $this->perPage)
            ->take($this->perPage)
            ->get();

        $filename = $this->getFileName($index);
        $view = view('sitemap.item', compact('items'))->render();

        file_put_contents(public_path($filename), $view);
    }

    public function getFileName($index): string
    {
        $number = str_pad($index, 3, '0', STR_PAD_LEFT);
        return "sitemap/contractors_$number.xml";
    }
}
