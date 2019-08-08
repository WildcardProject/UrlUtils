<?php
namespace Tests;

use PHPUnit\Framework\TestCase;

class buildFromRelatedUrlTest extends TestCase
{
    /**
     * 正常系のテスト.
     *
     * @return void
     */
    public function test正常系()
    {
        $expects = [
            'https://www.php.net/manual/ja/function.parse-url.php'=> ['/manual/ja/function.parse-url.php', 'https://www.php.net/downloads.php'],
            'https://www.php.net/manual/ja/function.parse-url.php'=> ['https://www.php.net/manual/ja/function.parse-url.php', 'https://www.php.net/downloads.php'],
        ];


        foreach ($expects as $expected=>$args) {
            $result = \programming_cat\util\UrlUtil::buildFromRelatedUrl($args[0], $args[1]);
            $this->assertEquals($result, $expected, sprintf("%s is not expected from %s and %s. expected url is %s.\n", $result, $args[1], $args[0], $expected));
        }
    }
    /**
     * 引数のエラーで例外が発生することをテスト
     *
     */
    public function test例外発生() {
        $expects = [
            'https://www.php.net/manual/ja/function.parse-url.php'=> ['/manual/ja/function.parse-url.php', '/downloads.php'],
            'https://www.php.net/manual/ja/function.parse-url.php'=> ['/manual/ja/function.parse-url.php', ''],
        ];

        $this->expectException('Exception');
        foreach ($expects as $expected=>$args) {
            $result = \programming_cat\util\UrlUtil::buildFromRelatedUrl($args[0], $args[1]);
        }
    }
}
