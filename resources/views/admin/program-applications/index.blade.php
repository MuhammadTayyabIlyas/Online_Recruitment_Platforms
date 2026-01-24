@extends('layouts.admin')

@section('title', 'Program Applications')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">All Program Applications</h1>
    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Program</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Submitted</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <td class="px-4 py-2 text-sm text-gray-900">{{ $application->program->title }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $application->user->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700 capitalize">{{ $application->status }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $application->created_at->toDayDateTimeString() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No applications found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $applications->links() }}
    </div>
</div>
@endsection
