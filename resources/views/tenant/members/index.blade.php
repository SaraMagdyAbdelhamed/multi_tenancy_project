@extends('tenant.layouts.app')

@section('title', 'members')

@section('content')
    {{-- <h1 class="text-2xl font-bold mb-4">Members</h1> --}}
    <div class="mt-6 mb-2">
    <a href="{{ route('members.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Add Member</a>
    </div>
    <table class="min-w-full border border-gray-200">
        <thead>
            <tr>
                <th class="border-b border-gray-300 px-4 py-2">Name</th>
                <th class="border-b border-gray-300 px-4 py-2">Email</th>
                <th class="border-b border-gray-300">Action </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $index => $member)
              <tr class="{{ $index % 2 == 0 ? 'bg-gray-100' : 'bg-white' }}">
                    <td class="py-2 px-4 text-center">{{ $member->name }}</td>
                    <td class="py-2 px-4 text-center">{{ $member->email }}</td>
                    <td class="py-2 px-4 text-center">
                        <a href="{{ route('members.edit', $member) }}" class="text-blue-500 hover:text-blue-700 mr-2">Edit</a>
                        <form action="{{ route('members.destroy', $member) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700"
                                    onclick="return confirm('Are you sure you want to delete this member?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection