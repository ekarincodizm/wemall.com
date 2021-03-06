<?php

class EncrypterTest extends TestCase
{
    private $secureKey = 'my_fixed_secure_key_test';

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Test original value is equal self decoded value.
     */
    public function testEqualValueDecoded()
    {
        $encrypter = \App::make('Encrypter', array($this->secureKey));
        $originalValue = $this->generateRandomString();
        $encodedValue = $encrypter->encode($originalValue);
        $decodedValue = $encrypter->decode($encodedValue);
        $this->assertEquals($decodedValue, $originalValue);
    }

    /**
     * Test with second Encrypter and check the encoded value is equal, because secure key is fixed.
     */
    public function testEqualSecondEncrypterFixed()
    {
        $encrypter = \App::make('Encrypter', array($this->secureKey));
        $encrypter2 = \App::make('Encrypter'); // Create random
        $encrypter2->setSecureKey($this->secureKey); // Then change to fixed secure key
        $originalValue = $this->generateRandomString();
        $encodedValue1 = $encrypter->encode($originalValue);
        $encodedValue2 = $encrypter2->encode($originalValue);
        $this->assertEquals($encodedValue1, $encodedValue2);
    }

    /**
     * generateRandomString
     *
     * @param int $length
     * @return string
     */
    protected function generateRandomString($length = 255)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }

    /**
     * Test encode empty value and return false.
     */
    public function testEncodedReturnFalse()
    {
        $encrypter = \App::make('Encrypter', array($this->secureKey));
        $originalValue = "";
        $encodedValue = $encrypter->encode($originalValue);
        $this->assertEquals(false, $encodedValue);
    }

    /**
     * Test decode empty value and return false.
     */
    public function testDecodeReturnFalse()
    {
        $encrypter = \App::make('Encrypter', array($this->secureKey));
        $originalValue = "";
        $decodedValue = $encrypter->decode($originalValue);
        $this->assertEquals(false, $decodedValue);
    }

}