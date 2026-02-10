@extends('layouts.admin')
@section('title', 'Create Consultation Type')
@section('page-title', 'Create Consultation Type')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.consultation-types.store') }}" method="POST">
            @csrf
            @include('admin.consultation-types._form')

            <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.consultation-types.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-sm font-medium">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm font-medium">Create Type</button>
            </div>
        </form>
    </div>
</div>
@endsection
