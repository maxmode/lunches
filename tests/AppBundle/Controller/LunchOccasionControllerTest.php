<?php

namespace Tests\AppBundle\Controller;

use Tests\AbstractTestCase;

/**
 * Class LunchOccasionControllerTest
 * @package Tests\AppBundle\Controller
 */
class LunchOccasionControllerTest extends AbstractTestCase
{
    /**
     * @param string  $url
     * @param array   $expectedColumns
     *
     * @dataProvider getActionDataProvider
     */
    public function testGetAction($url, $expectedColumns)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($expectedColumns, array_keys($data));
    }

    /**
     * @return array
     */
    public function getActionDataProvider()
    {
        return [
            'case1' => [
                'url' => '/api/lunches/1',
                'expectedColumns' => [
                    'id', 'occasionDate', 'place', 'address', 'ammount', 'description', 'receipt', 'employee'
                ],
            ],
        ];
    }

    /**
     * @param string  $url
     * @param array   $data
     * @param integer $expectedStatusCode
     * @param array   $expectedColumns
     *
     * @dataProvider newActionDataProvider
     */
    public function testNewAction($url, $data, $expectedStatusCode, $expectedColumns)
    {
        $this->setDataChanged(true);
        $client = static::createClient();

        $client->request('POST', $url, $data);

        $this->assertEquals($expectedStatusCode, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($expectedColumns, array_keys($data));
    }

    /**
     * @return array
     */
    public function newActionDataProvider()
    {
        return [
            'case success' => [
                'url' => '/api/lunches',
                'data' => [
                    'occasionDate' => '2016-09-15 12:53:00',
                    'placeName' => 'Food & Co',
                    'placeAddress' => 'Koetsierbaan 543, 1716DP Amsterdam',
                    'ammount' => '17.00',
                    'description' => 'Bla Bla bla',
                    'receipt' => ['src' => 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD=='],
                    'employee' => 1,
                ],
                'expectedStatusCode' => 201,
                'expectedColumns' => [
                    'id', 'occasionDate', 'place', 'address', 'ammount', 'description', 'receipt', 'employee'
                ],
            ],
            'case receipt missing' => [
                'url' => '/api/lunches',
                'data' => [
                    'occasionDate' => '2016-09-15 12:53:00',
                    'placeName' => 'Food & Co',
                    'placeAddress' => 'Koetsierbaan 543, 1716DP Amsterdam',
                    'ammount' => '17.00',
                    'description' => 'Bla Bla bla',
                    'receipt' => null,
                    'employee' => 1,
                ],
                'expectedStatusCode' => 400,
                'expectedColumns' => ['code', 'message', 'errors'],
            ],
        ];
    }
}
