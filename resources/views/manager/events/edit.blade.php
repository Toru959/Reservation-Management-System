<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            イベントの詳細
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-black bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class ="max-w-2xl mx-auto">
                    <x-jet-validation-errors class="mb-4" />
                
                @if (session('status'))
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="post" action="{{ route('events.update', [ 'event' => $event->id ]) }}">
                @csrf
                @method('put')
                    <div class="mt-4">
                        <x-jet-label for="event_name" value="イベント名" />
                        <x-jet-input id="event_name" class="block mt-1 w-full" type="text" name="event_name" value="{{ $event->name }}" required autofocus autocomplete="username" />
                    </div>
                    <div class="mt-4">
                        <x-jet-label for="information" value="イベント詳細" />
                        <x-textarea row="6" id="information" name="information" class="block mt-1 w-full">{{ $event->information }}</x-textarea>
                    </div>

                    <div class="md:flex justify-between">
                        <div class="mt-4">
                            <x-jet-label for="event_date" value="イベント日付" />
                            <x-jet-input id="event_date" class="block mt-1 w-full" type="text" name="event_date" value="{{ $eventDate }}" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="start_time" value="開始時間" />
                            <x-jet-input id="start_time" class="block mt-1 w-full" type="text" name="start_time" value="{{ $startTime }}" required />
                        </div>
                        <div class="mt-4">
                            <x-jet-label for="end_time" value="終了時間" />
                            <x-jet-input id="end_time" class="block mt-1 w-full" type="text" name="end_time" value="{{ $endTime }}" required />
                        </div>
                    </div>
                    <div class="md:flex justify-between items-end mb-4">
                        <div class="mt-4">
                            <x-jet-label for="max_people" value="定員数" />
                            <x-jet-input id="max_people" class="block mt-1 w-full" type="number" name="max_people" value="{{ $event->max_people }}" required />
                        </div>
                        <div class="flex space-x-4 justify-around">
                            <input type="radio" name="is_visible" value="1" @if( $event->is_visible === 1 ){ checked } @endif />表示
                            <input type="radio" name="is_visible" value="0" @if( $event->is_visible === 0 ){ checked } @endif />非表示
                        </div>
                        <x-jet-button class="ml-4">
                            更新する
                        </x-jet-button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>