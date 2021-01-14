<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class OnlineTraidParse extends Command
{
    public const GOODS_START_PAGE = 'https://www.onlinetrade.ru/catalogue/vinnye_shkafy-c1083/?browse_mode=2&per_page=36&page=0';
    public const DOMAIN = 'https://www.onlinetrade.ru';
    private $lastRequestTimestamp = 0;
    private $perRequestDelaySeconds = 5;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:onlinetraid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Onlinetraid site parse';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    private function getPageDomDocumentWithThrottle(string $uri): \DOMDocument
    {
        if (time() - $this->lastRequestTimestamp < $this->perRequestDelaySeconds) {
            sleep($this->perRequestDelaySeconds);
        }
        $domOptions = LIBXML_NOWARNING | LIBXML_NOERROR;
        $page = new \DOMDocument();
        $page->loadHTMLFile($uri, $domOptions);
        $this->lastRequestTimestamp = time();
        return $page;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $page = null;
        $fp = fopen(__DIR__ . 'onlinetraidout.csv','w');
        while ($uri = $this->getNextPageUrl($page)) {
            $page = $this->getPageDomDocumentWithThrottle($uri);
            foreach ($page->getElementsByTagName('a') as $tag) {
                /** @var \DOMElement $tag */
                if (strpos($tag->getAttribute('class'), 'indexGoods__item__name  ') === false)
                    continue;
                $goodUri = (self::DOMAIN . $tag->getAttribute('href'));
                try {
                    echo 'Parse: ' . $goodUri . PHP_EOL;
                    $goodPage = $this->getPageDomDocumentWithThrottle($goodUri);
                    fputcsv($fp, $this->parseGoodPage($goodPage));
                } catch (\Exception $e) {
                    echo 'Error load good page: ' . $goodUri . PHP_EOL;
                }
            }
        }
        fclose($fp);
        echo 'Parse finish' . PHP_EOL;
        return 0;
    }

    /**
     * @param \DOMDocument|null $currentPage
     * @return null|string
     */
    private function getNextPageUrl(?\DOMDocument $currentPage = null): ?string
    {
        if (is_null($currentPage)) return self::GOODS_START_PAGE;
        foreach ($currentPage->getElementsByTagName('a') as $tag) {
            /** @var \DOMElement $tag */
            if (strpos($tag->getAttribute('class'), 'js__paginator__linkNext') === false)
                continue;
            return (self::DOMAIN . $tag->getAttribute('href'));
        }
        return null;
    }

    /**
     * @param \DOMDocument $goodPage
     * @return array
     */
    private function parseGoodPage(\DOMDocument $goodPage): array
    {
        $good = [];
        foreach ($goodPage->getElementsByTagName('h1') as $tag) {
            /** @var \DOMElement $tag */
            if ($tag->getAttribute('itemprop') !== 'name') continue;
            $good[0] = preg_replace('/(^|\s)?[а-яА-ЯёЁ]+(\s|$)/iu', '',  $tag->nodeValue);
            break;
        }
        foreach ($goodPage->getElementsByTagName('span') as $tag) {
            /** @var \DOMElement $tag */
            if ($tag->getAttribute('class') !== 'js__actualPrice') continue;
            $good[1] = floatval(str_replace(' ', '',$tag->nodeValue));
            break;
        }
        foreach ($goodPage->getElementsByTagName('div') as $tag) {
            /** @var \DOMElement $tag */
            if ($tag->getAttribute('class') !== 'productPage__afterLine small gray') continue;
            foreach ($tag->getElementsByTagName('div') as $innerTag) {
                /** @var \DOMElement $innerTag */
                if ($innerTag->getAttribute('class') !== 'floatRight') continue;
                $good[2] = preg_match('/([0-9\.]+)/iu', $innerTag->nodeValue, $m) ? $m[1] :$innerTag->nodeValue;
                break;
            }
            break;
        }
        foreach ($goodPage->getElementsByTagName('div') as $tag) {
            /** @var \DOMElement $tag */
            if ($tag->getAttribute('class') !== 'descriptionText_cover richcontent__cover') continue;
            $good[3] = $tag->textContent;
            break;

        }
        foreach ($goodPage->getElementsByTagName('ul') as $tag) {
            /** @var \DOMElement $tag */
            if ($tag->getAttribute('class') !== 'featureList js__backlightingClick') continue;
            foreach ($tag->getElementsByTagName('li') as $innerTag) {
                /** @var \DOMElement $innerTag */
                switch (($titleElement = $innerTag->getElementsByTagName('span')->item(0))->nodeValue) {
                    case 'Высота:':
                        $i = 4;
                        break;
                    case 'Ширина:':
                        $i = 5;
                        break;
                    case 'Глубина:':
                        $i = 6;
                        break;
                    case 'Вес:':
                        $i = 7;
                        break;
                }
                if (!isset($i)) continue;
                $val = str_replace($titleElement->textContent, '', $innerTag->nodeValue);
                if (preg_match('/([0-9]+\.?[0-9]?)/', $val, $m)) {
                    $good[$i] = floatval($m[1]);
                }

            }
            break;
        }
        return $good;

    }

}
