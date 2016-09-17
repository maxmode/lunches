<?php

namespace Tests\AppBundle\Controller;

use Tests\AbstractTestCase;

/**
 * Class EmployeeControllerTest
 * @package Tests\AppBundle\Controller
 */
class EmployeeControllerTest extends AbstractTestCase
{
    /**
     * @param string  $url
     * @param integer $expectedCount
     * @param array   $expectedColumns
     *
     * @dataProvider cgetActionDataProvider
     */
    public function testCgetAction($url, $expectedCount, $expectedColumns)
    {
        $client = static::createClient();

        $client->request('GET', $url);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount($expectedCount, $data);

        foreach ($data as $item) {
            $this->assertEquals($expectedColumns, array_keys($item));
        }
    }

    /**
     * @return array
     */
    public function cgetActionDataProvider()
    {
        return [
            'case1' => [
                'url' => '/api/employees',
                'expectedCount' => 3,
                'expectedColumns' => ['id', 'name'],
            ],
        ];
    }

    /**
     * @param string  $url
     * @param array   $data
     * @param array   $expectedColumns
     * @param string  $countUrl
     * @param integer $expectedCount
     *
     * @dataProvider newActionDataProvider
     */
    public function testNewAction($url, $data, $expectedColumns, $countUrl, $expectedCount)
    {
        $this->setDataChanged(true);
        $client = static::createClient();

        //Create new instance
        $client->request('POST', $url, $data);

        $this->assertEquals(201, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($expectedColumns, array_keys($data));

        //Fetch overview
        $client->request('GET', $countUrl);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);

        $this->assertCount($expectedCount, $data);
    }

    /**
     * @return array
     */
    public function newActionDataProvider()
    {
        return [
            'case1' => [
                'url' => '/api/employees',
                'data' => ['name' => 'Max'],
                'expectedColumns' => ['id', 'name'],
                'countUrl' => '/api/employees',
                'expectedCount' => 4,
            ],
        ];
    }


}
