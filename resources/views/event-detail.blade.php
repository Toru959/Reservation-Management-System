<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントの詳細
        </h2>
    </x-slot>

    <div class="pt-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-black bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class ="max-w-2xl mx-auto">
                    <x-jet-validation-errors class="mb-4" />
                
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="post" action="{{ route('events.reserve', [ 'id' => $event->id ]) }}">
                @csrf
                    <div class="mt-4">
                        <x-jet-label for="event_name" value="イベント名" />
                        {{ $event->name }}
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="information" value="イベント詳細" />
                        {!! nl2br(e($event->information)) !!}
                    </div>

                    <div class="md:flex justify-between">
                        <div class="mt-4">
                            <x-jet-label for="event_date" value="イベント日付" />
                            {{ $event->eventDate }}
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="start_time" value="開始時間" />
                            {{ $event->startTime }}
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="end_time" value="終了時間" />
                            {{ $event->endTime }}
                        </div>
                    </div>
                    <div class="md:flex justify-between items-end mb-4">
                        <div class="mt-4">
                            <x-jet-label for="max_people" value="定員数" />
                            {{ $event->max_people }}
                        </div>
                        <div class="mt-4">
                            @if($reservablePeople <= 0)
                                <span class="text-xs text-blue-300">このイベントは満員です。</span>
                            @else
                                <x-jet-label for="reservedPeople" value="予約人数" />
                                <select name="reservedPeople">
                                    @for($i = 1; $i <= $reservablePeople; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            @endif
                        </div>
                        @if($isReserved === null)
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            @if($reservablePeople > 0)
                                <x-jet-button class="ml-4">
                                    予約する
                                </x-jet-button>
                            @endif
                        @else
                            <span class="text-xs">このイベントは既に予約済みです。</span>
                        @endif
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>