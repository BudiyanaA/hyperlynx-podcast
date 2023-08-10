<?php
 
use App\Models\Episode;
use Illuminate\Support\Stringable;
use function Livewire\Volt\computed;
use function Livewire\Volt\state;
 
$episodes = computed(fn () => Episode::get());
 
$formatDuration = function ($seconds) {
    $hours = floor($seconds / 3600);
    $minutes = floor(($seconds % 3600) / 60);
    $remainingSeconds = $seconds % 60;

    $formattedDuration = "";
    
    if ($hours > 0) {
        $formattedDuration .= $hours . "h ";
    }
    
    if ($minutes > 0) {
        $formattedDuration .= $minutes . "m ";
    }
    
    if ($remainingSeconds > 0 || empty($formattedDuration)) {
        $formattedDuration .= $remainingSeconds . "s";
    }
    
    return trim($formattedDuration);
}
 
?>
 
<x-layout>
    @volt
        <div class="rounded-xl border border-gray-200 bg-white shadow">
            <ul class="divide-y divide-gray-100">
                @foreach ($this->episodes as $episode)
                    <li
                        wire:key="{{ $episode->number }}"
                        class="flex flex-col items-start gap-x-6 gap-y-3 px-6 py-4 sm:flex-row sm:items-center sm:justify-between"
                    >
                        <div>
                            <a
                                href="/episodes/{{ $episode->number }}"
                                class="transition hover:text-[#FF2D20]"
                                wire:navigate
                            >
                                <h2>
                                    No. {{ $episode->number }} - {{ $episode->title }}
                                </h2>
                            </a>
                            <div
                                class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm text-gray-500"
                            >
                                <p>
                                    Released:
                                    {{ $episode->released_at->format('M j, Y') }}
                                </p>
                                &middot;
                                <p>
                                    Duration:
                                    {{ $this->formatDuration($episode->duration_in_seconds) }}
                                </p>
                            </div>
                        </div>
                        <button
                            x-data
                            x-on:click="$dispatch('play-episode', @js($episode))"
                            type="button"
                            class="flex shrink-0 items-center gap-1 text-sm font-medium text-[#FF2D20] transition hover:opacity-60"
                        >
                            <img
                                src="/images/play.svg"
                                alt="Play"
                                class="h-8 w-8 transition hover:opacity-60"
                            />
                            <span>Play</span>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    @endvolt
</x-layout>