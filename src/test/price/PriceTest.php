<?php
class PriceTest extends BaseTest {

    /**
     * @throws PriceException
     */
    public function testParse404() {
        $this->expectException(\PriceException::class);
        $this->expectExceptionCode(PriceModel::HOST_NOT_FOUND);

        PriceModel::parse('http://parser.local/test/price404', '.random-selector');
    }

    /**
     * @throws PriceException
     */
    public function testEntityNotFound() {
        $this->expectException(PriceException::class);
        $this->expectExceptionCode(PriceModel::DOM_ENTITY_NOT_FOUND);

        PriceModel::parse('http://parser.local/test/price', '.random-selector');
    }


    public function testSuccessPrice() {
        try {
            $price = PriceModel::parse('http://parser.local/test/price', 'div .price');

            $this->assertTrue(ctype_digit($price));
            $this->assertEquals($price, "1239600323");
        } catch(\PriceException $exp) {
            $this->fail("Parse throws fail exception");
        } catch(\Exception $exp) {
            $this->fail($exp);
        }
    }
}