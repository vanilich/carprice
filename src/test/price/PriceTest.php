<?php
class PriceTest extends BaseTest {

    protected $correctSelector = 'div .price';
    protected $failSelector = '.random-selector';
    
    /**
     * @throws PriceException
     */
    public function testParse404() {
        $this->expectException(\PriceException::class);
        $this->expectExceptionCode(PriceModel::HOST_NOT_FOUND);

        PriceModel::parse('http://parser.local/test/price404', $this->failSelector);
    }

    /**
     * @throws PriceException
     */
    public function testEntityNotFound() {
        $this->expectException(\PriceException::class);
        $this->expectExceptionCode(PriceModel::DOM_ENTITY_NOT_FOUND);

        PriceModel::parse('http://parser.local/test/price', $this->failSelector);
    }

    /**
     * @throws PriceException
     */
    public function testTimeoutPrice() {
        $this->expectException(\PriceException::class);
        $this->expectExceptionCode(PriceModel::HOST_NOT_FOUND);

        PriceModel::parse('http://parser.local/test/priceTimeout', $this->correctSelector);
    }

    public function testSuccessPrice() {
        try {
            $price = PriceModel::parse('http://parser.local/test/price', $this->correctSelector);

            $this->assertTrue(ctype_digit($price));
            $this->assertEquals($price, "1239600323");
        } catch(\PriceException $exp) {
            $this->fail("Parse throws fail exception");
        } catch(\Exception $exp) {
            $this->fail($exp);
        }
    }

}