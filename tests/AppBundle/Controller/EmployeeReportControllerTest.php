<?php

namespace Tests\AppBundle\Controller;

use Tests\AbstractTestCase;

/**
 * Class LunchOccasionControllerTest
 * @package Tests\AppBundle\Controller
 */
class EmployeeReportControllerTest extends AbstractTestCase
{
    /**
     * @param string $url
     * @param array  $data
     * @param float  $expectedTotals
     *
     * @dataProvider lunchesActionDataProvider
     */
    public function testLunchesAction($url, $data, $expectedTotals)
    {
        $client = static::createClient();

        //Create new instance
        $client->request('GET', $url, $data);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertEquals($expectedTotals, $data['totalLunchAmount']);
    }

    /**
     * @return array
     */
    public function lunchesActionDataProvider()
    {
        return [
            'employee A this month' => [
                'url' => '/api/employees/reports/lunches',
                'data' => [
                    'startDate' => '2016-09-01',
                    'endDate' => null,
                    'employees' => [1],
                    'expand' => null,
                ],
                'expectedTotals' => '0.80',
            ],
            'employee A last month' => [
                'url' => '/api/employees/reports/lunches',
                'data' => [
                    'startDate' => '2016-08-01',
                    'endDate' => '2016-08-31',
                    'employees' => [1],
                    'expand' => null,
                ],
                'expectedTotals' => '15.00',
            ],
            'employee A and B last month' => [
                'url' => '/api/employees/reports/lunches',
                'data' => [
                    'startDate' => '2016-08-01',
                    'endDate' => '2016-08-31',
                    'employees' => [1, 2],
                    'expand' => null,
                ],
                'expectedTotals' => '42.00',
            ],
            'all last month' => [
                'url' => '/api/employees/reports/lunches',
                'data' => [
                    'startDate' => '2016-08-01',
                    'endDate' => '2016-08-31',
                    'employees' => null,
                    'expand' => null,
                ],
                'expectedTotals' => '42.00',
            ],
            'all until some date' => [
                'url' => '/api/employees/reports/lunches',
                'data' => [
                    'startDate' => null,
                    'endDate' => '2016-08-31',
                    'employees' => null,
                    'expand' => null,
                ],
                'expectedTotals' => '42.00',
            ],
        ];
    }
}
