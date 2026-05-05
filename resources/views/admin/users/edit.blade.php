@extends('layouts.admin')
@section('title','Edit Pengguna')
@section('page-title','Edit Pengguna')
@section('content')
<div class="max-w-xl">
    <div class="bg-white rounded-xl border border-amber-100 p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Role</label>
                <select name="role" required class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400 bg-white">
                    <option value="customer" {{ old('role',$user->role)=='customer'?'selected':'' }}>Customer</option>
                    <option value="staff" {{ old('role',$user->role)=='staff'?'selected':'' }}>Staff</option>
                    <option value="manager" {{ old('role',$user->role)=='manager'?'selected':'' }}>Manager</option>
                    <option value="admin" {{ old('role',$user->role)=='admin'?'selected':'' }}>Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Password Baru <span class="text-amber-400 font-normal">(kosongkan jika tidak diubah)</span></label>
                <input type="password" name="password" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="mb-6">
                <label class="block text-xs font-medium text-amber-700 mb-1.5 uppercase tracking-wide">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 border border-amber-200 rounded-lg text-sm focus:outline-none focus:border-amber-400">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="px-6 py-2.5 text-white text-sm font-medium rounded-lg hover:opacity-90" style="background:linear-gradient(135deg,#C8A97E,#A8855A);">Update</button>
                <a href="{{ route('admin.users.index') }}" class="px-6 py-2.5 border border-amber-300 text-amber-700 text-sm font-medium rounded-lg hover:bg-amber-50">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
