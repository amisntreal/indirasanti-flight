@extends('layouts.admin')
@section('title','Pengguna')
@section('page-title','Pengguna')
@section('content')
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <form action="{{ route('admin.users.index') }}" method="GET" class="flex gap-2 flex-wrap">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email..." class="px-4 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 w-48">
        <select name="role" class="px-4 py-2 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
            <option value="">Semua Role</option>
            <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
            <option value="manager" {{ request('role')=='manager'?'selected':'' }}>Manager</option>
            <option value="staff" {{ request('role')=='staff'?'selected':'' }}>Staff</option>
            <option value="customer" {{ request('role')=='customer'?'selected':'' }}>Customer</option>
        </select>
        <button type="submit" class="px-4 py-2 border border-amber-300 text-amber-700 text-sm rounded-lg hover:bg-amber-50">Filter</button>
    </form>
    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">+ Tambah Pengguna</a>
</div>
<div class="bg-white rounded-xl border border-amber-100 overflow-hidden">
    <table class="w-full text-sm">
        <thead><tr class="border-b border-amber-100 bg-amber-50/60">
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Nama</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Email</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Role</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Bergabung</th>
            <th class="text-left px-6 py-3 text-xs text-amber-600 font-medium uppercase tracking-wide">Aksi</th>
        </tr></thead>
        <tbody class="divide-y divide-amber-50">
            @foreach($users as $user)
            <tr class="hover:bg-amber-50/40 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-semibold text-white flex-shrink-0" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">
                            {{ strtoupper(substr($user->name,0,2)) }}
                        </div>
                        <span class="font-medium text-amber-900">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-amber-600">{{ $user->email }}</td>
                <td class="px-6 py-4">
                    @php
                    $rc=['admin'=>'bg-red-100 text-red-700','manager'=>'bg-purple-100 text-purple-700','staff'=>'bg-blue-100 text-blue-700','customer'=>'bg-amber-100 text-amber-700'];
                    @endphp
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $rc[$user->role] ?? 'bg-gray-100 text-gray-700' }}">{{ ucfirst($user->role) }}</span>
                </td>
                <td class="px-6 py-4 text-amber-500 text-xs">{{ $user->created_at->format('d M Y') }}</td>
                <td class="px-6 py-4 flex gap-3">
                    <a href="{{ route('admin.users.edit', $user) }}" class="text-xs text-amber-700 hover:underline">Edit</a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus pengguna ini?')">
                        @csrf @method('DELETE')
                        <button class="text-xs text-red-500 hover:underline">Hapus</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="px-6 py-4 border-t border-amber-100">{{ $users->links() }}</div>
</div>
@endsection
