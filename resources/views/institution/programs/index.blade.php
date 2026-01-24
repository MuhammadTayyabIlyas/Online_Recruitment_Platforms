@php use Illuminate\Support\Str; @endphp
@extends('layouts.employer')

@section('title', 'My Study Programs')

@section('content')
<div class="max-w-6xl mx-auto py-6 px-4">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">My Study Programs</h1>
            <p class="text-sm text-gray-600">Manage programs you publish for students.</p>
        </div>
        <a href="{{ route('institution.programs.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Add Program
        </a>
    </div>

    @if(session('status'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 px-4 py-3 text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Degree</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">University</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee (€/year)</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($programs as $program)
                    <tr>
                        <td class="px-4 py-2">
                            <div class="font-semibold text-gray-900">{{ $program->title }}</div>
                            <div class="text-xs text-gray-500">{{ $program->study_mode }} @if($program->intake) • Intake {{ $program->intake }} @endif</div>
                        </td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $program->degree->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $program->university->name }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">
                            @if($program->tuition_fee)
                                €{{ number_format($program->tuition_fee, 0) }}
                            @else
                                Contact
                            @endif
                        </td>
                        <td class="px-4 py-2 text-right text-sm">
                            <a href="{{ route('study-programs.show', [Str::slug($program->country->name), $program->slug]) }}" class="text-blue-600 hover:text-blue-800 mr-3">View</a>
                            <a href="{{ route('institution.programs.edit', $program) }}" class="text-indigo-600 hover:text-indigo-800 mr-3">Edit</a>
                            <form action="{{ route('institution.programs.destroy', $program) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Delete this program?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500">No programs yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $programs->links() }}
    </div>
</div>
@endsection
