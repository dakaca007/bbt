<?php
class NewsScraper {
    private $url;

    public function __construct($url) {
        $this->url = $url;
    }

    public function scrape() {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $this->parse($response);
    }

    private function parse($html) {
        $news = []; // 初始化新闻数组
        $dom = new DOMDocument();
        @$dom->loadHTML($html); // 加载 HTML
        $xpath = new DOMXPath($dom);

        // CNN 新闻的热点新闻通常在 <h3> 标签中
        $items = $xpath->query('//h3/a'); // 选择 <h3> 标签下的 <a> 标签

        foreach ($items as $item) {
            $title = trim($item->nodeValue);
            $link = $item->getAttribute('href');
            if (!preg_match('/^http/', $link)) {
                $link = 'https://www.cnn.com' . $link; // 完整链接
            }
            $news[] = ['title' => $title, 'link' => $link];
        }

        return $news;
    }
}
