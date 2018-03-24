<?php

class SolrSearchRepositoryTest extends TestCase
{

    /**
     * @var pcmsClient
     */
    protected $pcmsClient;

    /**
     * @var SolrSearchRepository
     */
    protected $solrSearchRepository;

    public function setUp()
    {
        parent::setUp();

        $this->pcmsClient = $this->mockSpecific('pcmsClient');
        App::shouldReceive('make')->andReturn( $this->pcmsClient );

        $this->solrSearchRepository = new SolrSearchRepository();
    }

    public function testParseDataThrowDataNotFound()
    {

    }

    public function testParseDataSuccessWithLangTH()
    {

    }

    public function testParseDataSuccessWithLangEN()
    {

    }

    public function testGetAutoSuggestionEmptyQuery()
    {

    }

    public function testGetAutoSuggestionThrowErrorNoData()
    {

    }

    public function testGetAutoSuggestionThrowErrorWrongCode()
    {

    }

    public function testGetAutoSuggestionSuccess()
    {

    }
}
