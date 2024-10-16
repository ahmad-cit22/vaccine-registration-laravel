<?php

namespace Tests\Unit;

use App\Services\VaccinationScheduler;
use Carbon\Carbon;
use Tests\TestCase;

class VaccinationSchedulerUnitTest extends TestCase
{
    /** @test */
    public function it_returns_the_next_available_weekday_if_today_is_thursday()
    {
        $scheduler = new VaccinationScheduler();
        $date = Carbon::create(2024, 10, 10); // a thursday

        $nextAvailableDay = $this->invokeMethod($scheduler, 'getNextAvailableWeekday', [$date]);

        $this->assertEquals('2024-10-13', $nextAvailableDay->toDateString());
    }

    /** @test */
    public function it_returns_the_next_available_weekday_if_today_is_friday()
    {
        $scheduler = new VaccinationScheduler();
        $date = Carbon::create(2024, 10, 11); // a friday

        $nextAvailableDay = $this->invokeMethod($scheduler, 'getNextAvailableWeekday', [$date]);

        $this->assertEquals('2024-10-13', $nextAvailableDay->toDateString());
    }

    /** @test */
    public function it_returns_the_same_day_if_it_is_a_weekday()
    {
        $scheduler = new VaccinationScheduler();
        $date = Carbon::create(2024, 10, 9); // a weekday (wednesday)

        $nextAvailableDay = $this->invokeMethod($scheduler, 'getNextAvailableWeekday', [$date]);

        $this->assertEquals('2024-10-09', $nextAvailableDay->toDateString());
    }

    protected function invokeMethod($object, $methodName, array $parameters = [])
    {
        $reflection = new \ReflectionClass($object);
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

}
