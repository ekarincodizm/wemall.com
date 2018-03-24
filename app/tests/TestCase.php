<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    const NONUSER = "non-user";
    const USER = "user";

    /**
     * @usage $this->get('/'); // similar to $this->call('GET', '/');
     * @param $method
     * @param $args
     * @return \Illuminate\Http\Response
     */
    public function __call($method, $args)
    {
        if (in_array($method, array('get', 'post', 'put', 'path', 'delete'))) {
            return $this->call($method, $args[0]);
        }

        throw new BadMethodCallException;
    }

    /**
     * Creates the application.
     *
     * @return Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        $unitTesting = true;
        $testEnvironment = 'testing';

        return require __DIR__ . '/../../bootstrap/start.php';
    }

    public function assertStatusCode($expected_code = 200, $expected_status = 'success', $response = NULL, $debug = FALSE, $uri = NULL, $param = array())
    {

        if (empty($response)) {
            $this->fail('Curl Return Empty');
        } else {

            $response = json_decode($response->getContent());
            if ($debug === TRUE) {

                echo PHP_EOL . PHP_EOL . '-------------------------------' . PHP_EOL;
                echo '####### Debug ######' . PHP_EOL;
                echo '-------------------------------' . PHP_EOL;
                echo 'url => ' . $this->makeRequestUrl($uri) . PHP_EOL;
                echo 'params => ' . PHP_EOL;
                print_r($param);
                echo 'response => ' . PHP_EOL;
                print_r($response);
                echo '-------------------------------' . PHP_EOL . PHP_EOL;

            }

            $test_result = isset($response->status) ? $response->status : NULL;

            $this->assertTrue($expected_code == $response->code,
                'Expected Result is \'' . $expected_status . '\' but API return \'' . $test_result . '\'' . PHP_EOL . 'code = ' . $response->code . ',' . PHP_EOL . 'message = ' . $response->message . PHP_EOL . PHP_EOL);
        }

    }

    protected function beforeAssertResponse($response = NULL, $debug = FALSE, $uri = NULL, $params = array())
    {
        if (empty($response)) {
            $this->fail('Curl Return Empty');
        }

        if ($debug === TRUE) {
            $response = json_decode($response->getContent());

            echo PHP_EOL . PHP_EOL . '-------------------------------' . PHP_EOL;
            echo '####### Debug ######' . PHP_EOL;
            echo '-------------------------------' . PHP_EOL;
            echo 'url => ' . $this->makeRequestUrl($uri) . PHP_EOL;
            echo 'params => ' . PHP_EOL;
            print_r($params);
            echo 'response => ' . PHP_EOL;
            print_r($response);
            echo '-------------------------------' . PHP_EOL . PHP_EOL;

        }
    }

    public function assertResponseNodeValue($node, $expectedValue, $response = NULL, $debug = FALSE, $uri = NULL, $params = array())
    {
        $this->beforeAssertResponse($response, $debug, $uri, $params);

        $responseArr = json_decode($response->getContent(), true);

        $testValue = array_get($responseArr, $node);

        $this->assertTrue($expectedValue == $testValue,
            "Expected Value from responce has {$node} is {$expectedValue} but API return {$testValue}." . PHP_EOL . PHP_EOL
        );
    }

    public function assertResponseNodeExists($expectedNode, $response = NULL, $debug = FALSE, $uri = NULL, $params = array())
    {
        $this->beforeAssertResponse($response, $debug, $uri, $params);

        $responseArr = json_decode($response->getContent(), true);

        $seedDefault = "DEFAULT-CHECKER-" . md5(rand());
        $testNode = array_get($responseArr, $expectedNode, $seedDefault);

        $this->assertTrue($testNode != $seedDefault,
            "Expected response has {$expectedNode} node." . PHP_EOL . PHP_EOL
        );
    }

    public function assertArrayValue($node, $expectedValue, $array)
    {
        $testValue = array_get($array, $node);

        $this->assertTrue($expectedValue == $testValue,
            "Expected Value from array has {$node} is {$expectedValue} but array has {$testValue}." . PHP_EOL . PHP_EOL
        );
    }

    public function assertArrayExists($expectedNode, $array)
    {
        $seedDefault = "DEFAULT-CHECKER-" . md5(rand());
        $testNode = array_get($array, $expectedNode, $seedDefault);

        $this->assertTrue($testNode != $seedDefault,
            "Expected array has {$expectedNode}." . PHP_EOL . PHP_EOL
        );
    }

    public function makeRequestUrl($uri)
    {
        return '/api/' . $this->_app_pkey . '/' . $uri;
    }

    public function getMemberId()
    {
        return md5(Request::getClientIP() . time() . rand(10, 99));
    }

    public function getSampleProduct()
    {
        $app = $this->_app_pkey;

        $appQuery = function ($query) use ($app) {
            $query->wherePkey($app);
        };


        $productQuery = function ($query) {
            $query->limit(1)->whereStatus('publish');
        };


        $collection = Collection::with(array('apps' => $appQuery, 'products' => $productQuery))
            ->whereHas('apps', $appQuery)
            ->whereHas('products', $productQuery)
            ->first();

        return $collection->products->first();
    }

    /**
     * @Description Put mocking class to Laravel's Service Provider.
     * @param $class String
     * @return \Mockery\MockInterface
     */
    protected function mock($class)
    {
        $mock = Mockery::mock('Eloquent', $class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    protected function mockSpecific($class)
    {
        $mock = Mockery::mock($class);
        $this->app->instance($class, $mock);
        return $mock;
    }

    /**
     * @Description Set Up property to Eloquent Model.
     * @param $mock MockeryInterace
     * @param $properties Array
     * @return \Mockery\MockInterface
     */
    protected function setProperties($mock, $properties)
    {
        $mock->shouldReceive('setAttribute');
        foreach ($properties as $key => $value) {
            $mock->shouldReceive('getAttribute')->with($key)->andReturn($value);
        }
        return $mock;
    }

    /**
     * Set data to any object
     * @param $inst
     * @param array $properties
     * @return mixed
     */
    protected function setInstanceProperties($inst, $properties = array())
    {
        foreach ($properties as $key => $value) {
            $inst->{$key} = $value;
        }
        return $inst;
    }

    /**
     * Mock all Teeplus Theme's methods. (All in one)
     * @return void
     */
    protected function MockTheme()
    {
        $theme = $this->getTeeplusThemeMock();

        $theme->shouldReceive("layout")->andReturn(Mockery::self());
        $theme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $theme->shouldReceive("add")->andReturn(Mockery::self());
        $theme->shouldReceive("asset")->andReturn(Mockery::self());
        $theme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $theme->shouldReceive("of")->andReturn(Mockery::self());
        $theme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $theme->shouldReceive("container")->andReturn(Mockery::self());
        $theme->shouldReceive("usePath")->andReturn(Mockery::self());
        $theme->shouldReceive("partialComposer")->andReturn(Mockery::self());
        $theme->shouldReceive("script")->andReturn(Mockery::self());
        $theme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $theme->shouldReceive("append")->andReturn(Mockery::self());
        $theme->shouldReceive("render")->andReturn("success");

        return $theme;
    }

    protected function MockThemeWithScope()
    {
        $theme = $this->getTeeplusThemeMock();

        $theme->shouldReceive("layout")->andReturn(Mockery::self());
        $theme->shouldReceive("breadcrumb")->andReturn(Mockery::self());
        $theme->shouldReceive("add")->andReturn(Mockery::self());
        $theme->shouldReceive("asset")->andReturn(Mockery::self());
        $theme->shouldReceive("writeContent")->andReturn(Mockery::self());
        $theme->shouldReceive("of")->andReturn(Mockery::self());
        $theme->shouldReceive("setTitle")->andReturn(Mockery::self());
        $theme->shouldReceive("container")->andReturn(Mockery::self());
        $theme->shouldReceive("usePath")->andReturn(Mockery::self());
        $theme->shouldReceive("partialComposer")->andReturn(Mockery::self());
        $theme->shouldReceive("script")->andReturn(Mockery::self());
        $theme->shouldReceive("writeScript")->andReturn(Mockery::self());
        $theme->shouldReceive("scope")->andReturn(Mockery::self());
        $theme->shouldReceive("render")->andReturn("success");

        return $theme;
    }


    /**
     * Alternate method to mock Teeplus Theme.
     * @return Object TeeplussTheme_Mock
     */
    protected function getTeeplusThemeMock()
    {
        $theme = Theme::shouldReceive('uses')->andReturn(Mockery::self());
        return $theme;
    }

    /**
     * get yml dataset from fixtures
     * avialable method for dataset is
     * - getTable( table_name )
     *   - getRow( row_index )
     *   - getRowCount()
     *
     * @param $fixture_path
     * @param $table_name
     * @return PHPUnit_Extensions_Database_DataSet_YamlDataSet | array
     */
    public function getYMLDataset($fixture_path, $table_name = false)
    {
        $dataset = new PHPUnit_Extensions_Database_DataSet_YamlDataSet($fixture_path);
        return !empty($table_name) ? $dataset->getTable($table_name) : $dataset;
    }

    /**
     * prepareUserData mock user data
     *
     * @param  boolean $authen false => return non-user, true => return member
     * @return array
     */
    public function prepareUserData($authen = false)
    {
        $dataset = $this->getYMLDataset(__DIR__ . '/fixtures/user.yml', 'user');
        $user_data = $dataset->getRow($authen ? $authen : 0);

        return $user_data;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param array|bool $args
     * @return mixed
     */
    public function prepareProtectedMethod($className, $methodName, $args = false)
    {
        $reflectionMethod = new ReflectionMethod(
            $className, $methodName
        );
        $reflectionMethod->setAccessible(true);

        if (is_array($args)) {
            $data = $reflectionMethod->invokeArgs(new $className(), $args);
        } else {
            $data = $reflectionMethod->invoke(new $className());
        }

        return $data;
    }

    /**
     * mockACL mock ACL::getUser
     * @param  boolean $authen false => non-user, true => member
     */
    public function mockACL($authen = false)
    {
        //$mockACL = Mockery::mock('alias:ACL');
        $mockACL = ACL::shouldReceive('getUser')->andReturn($this->prepareUserData($authen));
        //$mockACL->shouldReceive('getUser')->andReturn($this->prepareUserData($authen));
        $mockACL->shouldReceive('isLoggedIn')->andReturn($authen);
    }

    protected function getInstance()
    {
        return App::make($this->mainClass);
    }

}
