@extends('layouts.app')

@section('title', 'Complete Institution Profile')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome, {{ auth()->user()->name }}!</h1>
    <p class="text-sm text-gray-600 mb-6">Complete your institution details to start publishing study programs.</p>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Step 1: Institution Profile</h2>
            <p class="text-sm text-gray-600 mb-4">Set up your institution page (logo, name, website) used on program listings.</p>
            <a href="{{ route('employer.company.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                Create Institution Profile
            </a>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-3">Step 2: Publish a Program</h2>
            <p class="text-sm text-gray-600 mb-4">Add your first study program and make it visible to students.</p>
            <a href="{{ route('institution.programs.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                Add Program
            </a>
        </div>
    </div>
</div>
@endsection
