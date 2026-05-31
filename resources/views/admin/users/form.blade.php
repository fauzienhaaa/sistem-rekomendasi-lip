@extends('layouts.admin')

@section('title', $user->exists ? 'Edit Administrator' : 'Tambah Administrator')

@section('content')
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-2xl">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50">
            <h2 class="text-xl font-bold text-gray-800">
                {{ $user->exists ? 'Edit Data Administrator' : 'Tambah Administrator Baru' }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                {{ $user->exists ? 'Ubah informasi akun admin di bawah ini.' : 'Buat akun baru untuk memberikan akses admin ke sistem.' }}
            </p>
        </div>

        <div class="p-6">
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ $user->exists ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
                method="POST">
                @csrf
                @if($user->exists)
                    @method('PUT')
                @endif

                <div class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span
                                class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                    </div>

                    <div class="pt-4 border-t border-gray-100">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Pengaturan Password</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Password Baru {!! $user->exists ? '(Opsional)' : '<span class="text-red-500">*</span>' !!}
                                </label>
                                <input type="password" name="password" id="password" {{ $user->exists ? '' : 'required' }}
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                                @if($user->exists)
                                    <p class="text-xs text-gray-500 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
                                @endif
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    Konfirmasi Password
                                    {!! $user->exists ? '(Opsional)' : '<span class="text-red-500">*</span>' !!}
                                </label>
                                <input type="password" name="password_confirmation" id="password_confirmation" {{ $user->exists ? '' : 'required' }}
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-rose-500 focus:ring-rose-500 sm:text-sm border p-2">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end space-x-3">
                    <a href="{{ route('admin.users.index') }}"
                        class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-rose-600 hover:bg-rose-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-rose-500 transition-colors">
                        {{ $user->exists ? 'Simpan Perubahan' : 'Buat Akun Admin' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection