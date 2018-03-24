<?php

class UrlManagerTest extends TestCase
{
    private $config;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * newsLevelBUrl
     * Test UrlManager function newsLevelBUrl
     * $cate_slug = null
     * $cate_id = 12345
     */
    public function testNewsLevelBUrlInputCateSlugNull()
    {
        $url = new UrlManager();
        $result = $url->newsLevelBUrl(null, '12345');
        $this->assertEquals(NULL, $result);
    }

    /**
     * newsLevelBUrl
     * Test UrlManager function newsLevelBUrl
     * $cate_slug = array('test')
     * $cate_id = 12345
     */
    public function testNewsLevelBUrlInputCateSlugArray()
    {
        $url = new UrlManager();
        $result = $url->newsLevelBUrl(array('test'), '12345');
        $this->assertTrue(!empty($result));
    }

    /**
     * newsLevelBUrl
     * Test UrlManager function newsLevelBUrl
     * $cate_slug = 'test'
     * $cate_id = null
     */
    public function testNewsLevelBUrlInputCateIdNull()
    {
        $url = new UrlManager();
        $result = $url->newsLevelBUrl('test', null);
        $this->assertEquals(NULL, $result);
    }

    /**
     * newsLevelBUrl
     * Test UrlManager function newsLevelBUrl
     * $cate_slug = 'test'
     * $cate_id = '12345'
     */
    public function testNewsLevelBUrlReturnUrl()
    {
        $this->config = Config::shouldReceive("get")
            ->andReturn("news_level_b_url");

        $url = new UrlManager();
        $result = $url->newsLevelBUrl('test', '12345');
        $this->assertTrue(!empty($result));
    }

    /**
     * newsLevelDUrl
     * Test UrlManager function newsLevelDUrl
     * $news_slug = 'new slug'
     * $newsID = '12345'
     */
    public function testNewsLevelDUrlNewSlugNull()
    {
        $url = new UrlManager();
        $result = $url->newsLevelDUrl(null, '12345');
        $this->assertEquals(NULL, $result);
    }

    /**
     * newsLevelDUrl
     * Test UrlManager function newsLevelDUrl
     * $news_slug = 'new slug'
     * $newsID = null
     */
    public function testNewsLevelDUrlNewIdNull()
    {
        $url = new UrlManager();
        $result = $url->newsLevelDUrl('slug', null);
        $this->assertEquals(NULL, $result);
    }

    /**
     * newsLevelDUrl
     * Test UrlManager function newsLevelDUrl
     * $news_slug = 'new slug'
     * $newsID = '12345'
     */
    public function testNewsLevelDUrlReturnUrl()
    {
        $url = new UrlManager();
        $result = $url->newsLevelDUrl('slug', '12345');
        $this->assertTrue(!empty($result));
    }

    /**
     * urlTitle
     * Test UrlManager function urlTitle
     * $str = 'slug'
     * $separator = 'xxx'
     */
    public function testNewsUrlTitleReturnData()
    {
        $url = new UrlManager();
        $result = $url->urlTitle('slug', 'xxx');
        $this->assertTrue(!empty($result));
    }

}