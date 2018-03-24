<?php
/**
 * Class SuperDealRepositoryTest
 */
class SuperDealRepositoryTest extends TestCase
{
    
	public function setUp()
    {
        parent::setUp();

        $this->pcmsClient = $this->mockSpecific('pcmsClient');
        App::shouldReceive('make')->andReturn( $this->pcmsClient );
        $this->superDeal = new SuperDealRepository();
    }
    public function tearDown()
    {
        parent::tearDown();
    }


     public function testParseData(){

        $productsWow = array();
    	$variants['active_special_discount'] = 'test variant';

    	$productsWow['products'][0]['pkey'] = '2324324';
    	$productsWow['products'][0]['title'] = 'testTitle';
    	$productsWow['products'][0]['slug'] = 'testSlug';
    	$productsWow['products'][0]['translate']['title'] = 'testTitle';
    	$productsWow['products'][0]['price_range'] = 'testPriceRange';
    	$productsWow['products'][0]['net_price_range'] = 'NetPriceRange';
    	$productsWow['products'][0]['percent_discount'] = 'testPercentDiscount';
    	$productsWow['products'][0]['discount_ended'] = 'discountEnded';
    	$productsWow['products'][0]['variants'][0] = $variants;

     
        $test2 = $this->superDeal->parseData($productsWow);

    	$EXproductsWow['products'][0]['pkey'] = '2324324';
    	$EXproductsWow['products'][0]['title'] = 'testTitle';
    	$EXproductsWow['products'][0]['slug'] = 'testSlug';
    	$EXproductsWow['products'][0]['translate']['title'] = 'testTitle';
    	$EXproductsWow['products'][0]['price_range'] = 'testPriceRange';
    	$EXproductsWow['products'][0]['net_price_range'] = 'NetPriceRange';
    	$EXproductsWow['products'][0]['percent_discount'] = 'testPercentDiscount';
    	$EXproductsWow['products'][0]['discount_ended'] = 'discountEnded';
    	$EXproductsWow['products'][0]['variants'][0] = $variants;

    	$this->assertEquals($EXproductsWow,$test2);	
    }

    public function testParseDataInputEmpty(){
    	$productsWow = array();
    	$data = array();
    	$test = $this->superDeal->parseData($data);
        $this->assertEquals(array(),$test);
    }

}
