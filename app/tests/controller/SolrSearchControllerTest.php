<?php

class SolrSearchControllerTest extends TestCase
{

    /**
     * @var SolrSearchRepositoryInterface
     */
    private $_solrSearchRepo;

    public function setUp()
    {
        parent::setUp();

        $this->_solrSearchRepo = $this->mockSpecific('SolrSearchRepositoryInterface');
    }

    public function testAutoSuggestionWithNoCache()
    {

    }

    public function testAutoSuggestionWithEmptyResponse()
    {

    }

    public function testAutoSuggestionWithResponse()
    {

    }

    public function testSearchWithNoCache()
    {

    }

    public function testSearchWithEmptyResponse()
    {

    }

    public function testSearchWithResponse()
    {

    }


}
