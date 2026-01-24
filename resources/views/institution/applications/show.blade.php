@extends('layouts.employer')

@section('title', 'Application Details')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4">
    <div class="bg-white shadow-sm rounded-lg p-6 space-y-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ $application->user->name }}</h1>
                <p class="text-sm text-gray-600">Applied to: {{ $application->program->title }}</p>
            </div>
            <form action="{{ route('institution.applications.status', $application) }}" method="POST" class="flex items-center gap-2">
                @csrf
                @method('PATCH')
                <select name="status" class="rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 text-sm">
                    @foreach(['pending','reviewing','accepted','rejected'] as $status)
                        <option value="{{ $status }}" @selected($application->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">Update</button>
            </form>
        </div>

        @if($application->message)
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Message</h3>
                <p class="text-sm text-gray-700 whitespace-pre-line">{{ $application->message }}</p>
            </div>
        @endif

        <div class="text-xs text-gray-500">
            Submitted {{ $application->created_at->diffForHumans() }}
        </div>
    </div>
</div>
@endsection
