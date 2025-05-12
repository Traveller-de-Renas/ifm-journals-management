@php use Illuminate\Support\Str; @endphp

<div>
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @foreach ($failedJobs as $key => $job)
        @php
            $payload = $job->payload;
            $jobName = $payload['displayName'] ?? ($payload['job'] ?? 'Unknown Job');
        @endphp

        <div class="mb-4 font-bold flex flex-wrap md:flex-nowrap gap-4 w-full border-b pb-4">
            <div>
                {{ ++$key }}
            </div>

            <div class="w-full md:w-8/12">
                <div><span class="text-red-600">Connection:</span> {{ $job->connection }}</div>
                <div><span class="text-red-600">Queue:</span> {{ $job->queue }}</div>
                <div><span class="text-red-600">Job:</span> {{ $jobName }}</div>
                <div><span class="text-red-600">Payload:</span> {{ Str::limit(json_encode($payload), 100) }}</div>

                <div class="mt-2 w-full overflow-auto">
                    <span class="text-red-600 block">Exception:</span>
                    <pre
                        class="text-sm text-red-700 whitespace-pre-wrap break-words break-all w-full overflow-x-auto bg-gray-100 p-2 rounded">
                {{ Str::limit($job->exception, 300) }}
                    </pre>
                </div>


                <div class="mt-2 flex gap-2">
                    <x-button class="bg-green-500 hover:bg-green-700" wire:click="retryJob('{{ $job->id }}')"
                        wire:loading.attr="disabled">
                        Retry
                    </x-button>

                    <x-button class="bg-red-500 hover:bg-red-700" wire:click="forgetJob('{{ $job->id }}')"
                        wire:loading.attr="disabled">
                        Delete
                    </x-button>
                </div>
            </div>

            <div class="text-right md:w-4/12 w-full mt-2 md:mt-0">
                Failed at: {{ \Carbon\Carbon::parse($job->failed_at)->format('Y-m-d H:i:s') }}
            </div>
        </div>
    @endforeach
</div>
