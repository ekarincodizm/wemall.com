<?php

class AclTest extends TestCase
{

    private $memberRepository;

    public function setUp()
    {
        parent::setUp();
        $this->memberRepository = $this->mock("MemberRepositoryInterface");

    }

    public function tearDown()
    {
        parent::tearDown();
        \Mockery::close();
    }

    /**
     * Test Curl function isLoggedIn condition //
     */
    public function testAclIsLoggedIn()
    {

        $this->memberRepository->shouldReceive("getUser")
            ->andReturn(array("group"=>"user"));

        $acl = new Acl\ACL();
        $result = $acl->isLoggedIn();
        $this->assertTrue($result);
    }

}