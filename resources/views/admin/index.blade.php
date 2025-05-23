<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Persetujuan Modul
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>User</th>
                                <th>Modul</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pendingModules as $module)
                            <tr>
                                <td>{{ $module->user->name }}</td>
                                <td>{{ $module->module_type }}</td>
                                <td>{{ $module->created_at->format('d M Y') }}</td>
                                <td class="flex space-x-2">
                                    <form method="POST" 
                                          action="{{ route('admin.module-approvals.update', $module) }}">
                                        @csrf @method('PUT')
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Setujui
                                        </button>
                                    </form>
                                    <form method="POST" 
                                          action="{{ route('admin.module-approvals.destroy', $module) }}">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $pendingModules->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>