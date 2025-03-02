<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\CarbonImmutable;
use App\Services\EventService;

class Calendar extends Component
{
    public $currentDate; 
    public $day;
    public $currentWeek;
    public $sevenDaysLater;
    public $events;
    public $checkDay;
    public $dayOfWeek;

    public function mount()
    {
        $this->currentDate = CarbonImmutable::today();
        $this->sevenDaysLater = $this->currentDate->addDays(7);
        $this->currentWeek = [];

        $this->events = EventService::getWeekEvents(
            $this->currentDate->format('Y-m-d'), // 既に現在の日付から＋７日されている。
            $this->sevenDaysLater->format('Y-m-d'),
        );

        for($i = 0; $i < 7; $i++)
        {
            $this->day = CarbonImmutable::today()->addDays($i)->format('m月d日');
            $this->checkDay = CarbonImmutable::today()->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::today()->addDays($i)->dayName;
            array_push($this->currentWeek,[
            'day' => $this->day, // カレンダー表示用(○月△日)
            'checkDay' => $this->checkDay, //判定用(〇〇〇〇-△△-□□)
            'dayOfWeek' => $this->dayOfWeek, //曜日
            ]);
        }
        //dd($this->currentWeek);
    }

   public function getDate($date)
    {
        $this->currentDate = $date; //文字列
        $this->currentWeek =[];
        $this->sevenDaysLater = CarbonImmutable::parse($this->currentDate)->addDays(7);

        $this->events = EventService::getWeekEvents(
            $this->currentDate,
            $this->sevenDaysLater->format('Y-m-d'),
        );

        for($i = 0; $i < 7; $i++)
        {
            $this->day = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('m月d日'); //parseでCarbonインスタンスに変換後日付を加算
            $this->checkDay = CarbonImmutable::parse($this->currentDate)->addDays($i)->format('Y-m-d');
            $this->dayOfWeek = CarbonImmutable::parse($this->currentDate)->addDays($i)->dayName;
            array_push($this->currentWeek, [
                'day' => $this->day,
                'checkDay' => $this->checkDay,
                'dayOfWeek' => $this->dayOfWeek,
            ]);
        }
    } 

    public function render()
    {
        return view('livewire.calendar');
    }
}
