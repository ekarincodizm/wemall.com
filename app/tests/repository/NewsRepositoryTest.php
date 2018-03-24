<?php

class NewsRepositoryTest extends TestCase
{
    private $itruemart;
    private $process;
    protected $mainClass = "NewsRepository";

    public function setUp()
    {
        parent::setUp();
        $this->itruemart = $this->mockSpecific("itruemart");
        $this->process = $this->mockSpecific("ItruemartClient\Process");
    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    public function testGetNewsListWithValidParamsThenReturnArrayData()
    {
        $params = array(
            'cat_id' => "86",
            'page' => null,
            'limit' => 3,
            'condition' => "category",
            'order_by' => "create_date desc",
            'format' => "json"
        );

        $this->process->shouldReceive("getRawResponse")
            ->andReturn(array("status" => 0));

        $this->itruemart->shouldReceive("api")
            ->with("news/listing", $params, 'get')
            ->andReturn($this->process);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getNewsList($params);
        $this->assertNotEmpty($res);
    }

    public function testGetNewsListWithSomeProblemsThenThrowException()
    {
        $params = array(
            'cat_id' => "86",
            'page' => null,
            'limit' => 3,
            'condition' => "category",
            'order_by' => "create_date desc",
            'format' => "json"
        );
        $this->itruemart->shouldReceive("api")
            ->with("news/listing", $params, 'get')
            ->andThrow(new Exception("custom error"));

        $newsRepository = $this->getInstance();
        try {
            $newsRepository->getNewsList($params);
        } catch (Exception $e) {
            $res = $e->getMessage();
        }

        $this->assertEquals("custom error", $res);
    }

    public function testGetNewsGroupWithValidParamsThenReturnArrayData()
    {
        $params = array(
            'cat_id' => "1",
            'condition' => "group",
            'format' => "json"
        );

        $this->process->shouldReceive("getRawResponse")
            ->andReturn(array("status" => 0));

        $this->itruemart->shouldReceive("api")
            ->with("news/listing", $params, 'get')
            ->andReturn($this->process);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getNewsGroup($params);
        $this->assertNotEmpty($res);
    }

    public function testGetNewsGroupWithSomeProblemsThenThrowException()
    {
        $params = array(
            'cat_id' => "1",
            'condition' => "group",
            'format' => "json"
        );

        $this->itruemart->shouldReceive("api")
            ->with("news/listing", $params, 'get')
            ->andThrow(new Exception("custom error"));

        $newsRepository = $this->getInstance();
        try {
            $newsRepository->getNewsGroup($params);
        } catch (Exception $e) {
            $res = $e->getMessage();
        }

        $this->assertEquals("custom error", $res);
    }

    public function testGetByCategoryWithValidParamsThenReturnArrayData()
    {
        $params = array(
            'cat_id' => 1,
            'condition' => "category",
            'format' => "json",
            'order_by' => 'create_date desc',
        );

        $this->process->shouldReceive("getRawResponse")
            ->andReturn(array("status" => 0));

        $this->itruemart->shouldReceive("api")
            ->with("news", $params)
            ->andReturn($this->process);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getByCategory(1);

        $this->assertNotEmpty($res->getRawResponse());
    }

    public function testGetInsightWithValidParamsThenReturnArrayData()
    {

        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc/rest/news/listing");

        $params = array(
            'cat_name' => "announcement",
            'cat_id' => 0,
            'page' => 1,
            'limit' => 3,
            'condition' => "all",
            'order_by' => "create_date desc",
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/rest/news/listing", $params, 'get')
            ->andReturn('{"data_response": ["data"]}');

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getInsight();
        $this->assertNotEmpty($res);
    }

    public function testGetInsightWithNoFoundDataThenReturnEmptyArray()
    {

        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc/rest/news/listing");

        $params = array(
            'cat_name' => "announcement",
            'cat_id' => 0,
            'page' => 1,
            'limit' => 3,
            'condition' => "all",
            'order_by' => "create_date desc",
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/rest/news/listing", $params, 'get')
            ->andReturn(false);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getInsight();
        $this->assertEmpty($res);
    }

    public function testGetAllInsightWithValidParamsThenReturnArrayData()
    {
        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc/rest/news/listing");

        $params = array(
            'cat_id' => 0,
            'page' => 1,
            'limit' => 2,
            'condition' => "category",
            'order_by' => "create_date desc",
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/rest/news/listing", $params, 'get')
            ->andReturn('{"data_response": ["data"]}');

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getAllInsight();
        $this->assertNotEmpty($res);
    }

    public function testGetAllInsightWithNoFoundDataThenReturnEmptyArray()
    {
        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc/rest/news/listing");

        $params = array(
            'cat_id' => 0,
            'page' => 1,
            'limit' => 2,
            'condition' => "category",
            'order_by' => "create_date desc",
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/rest/news/listing", $params, 'get')
            ->andReturn(false);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getAllInsight();
        $this->assertEmpty($res);
    }

    public function testGetDetailWithValidParamsThenReturnArrayData()
    {
        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc");

        $params = array(
            'news_id' => 0,
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/news/detail", $params, 'get')
            ->andReturn('{"data_response": ["data"]}');

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getDetail(0);
        $this->assertNotEmpty($res);
    }

    public function testGetDetailWithNoFoundDataThenReturnEmptyArray()
    {
        Config::shouldReceive("get")
            ->andReturn("http://api.itruemart.moc");

        $params = array(
            'news_id' => 0,
            'format' => "json"
        );

        $this->itruemart->shouldReceive("execCurl")
            ->with("http://api.itruemart.moc/news/detail", $params, 'get')
            ->andReturn(false);

        $newsRepository = $this->getInstance();
        $res = $newsRepository->getDetail(0);
        $this->assertEmpty($res);
    }


}