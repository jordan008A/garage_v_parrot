<?php

namespace App\Tests\Unit;

use App\Entity\Schedules;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class SchedulesTest extends KernelTestCase
{
  private function createSchedule(): Schedules
  {
    return new Schedules();
  }

  public function testSetAndGetText(): void
  {
    $schedule = $this->createSchedule();
    $text = 'Open from 9 AM to 5 PM';
    $schedule->setText($text);
    $this->assertSame($text, $schedule->getText());
  }

  public function testSetAndGetDay(): void
  {
    $schedule = $this->createSchedule();
    $day = 'Monday';
    $schedule->setDay($day);
    $this->assertSame($day, $schedule->getDay());
  }

  public function testValidationForBlankText(): void
  {
    $this->performValidationTest('', 'setText', 'Text should not be blank');
  }

  public function testValidationForBlankDay(): void
  {
    $this->performValidationTest('', 'setDay', 'Day should not be blank');
  }

  private function performValidationTest($value, $method, $message): void
  {
    self::bootKernel();
    $container = static::getContainer();

    $schedule = $this->createSchedule();
    $schedule->{$method}($value);

    $errors = $container->get('validator')->validate($schedule);
    $this->assertGreaterThan(0, count($errors), $message);
  }
}
