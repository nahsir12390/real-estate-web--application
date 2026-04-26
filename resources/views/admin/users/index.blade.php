<x-layouts::app :title="__('Manage Users')">
    <div class="p-6">
        <!-- Navigation Button -->
        <div class="mb-4 flex justify-end">
            <a href="{{ route('admin.dashboard') }}"
               class="inline-flex items-center rounded-md bg-zinc-900 px-3 py-1.5 text-sm font-medium text-white hover:bg-zinc-700 dark:bg-zinc-100 dark:text-zinc-900 dark:hover:bg-zinc-300">
                <svg class="mr-1.5 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
            </a>
        </div>
        @include('admin.partials.nav')
        <h1 class="mb-4 text-2xl font-semibold">Manage Users</h1>

        @if (session('status'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        <form method="GET" class="mb-4 grid gap-2 md:grid-cols-3">
            <input name="search" value="{{ $search }}" placeholder="Name or email" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
            <select name="role" class="rounded border border-zinc-300 px-3 py-2 dark:border-zinc-700 dark:bg-zinc-900">
                <option value="">All roles</option>
                @foreach(['user','agent','admin'] as $r)
                    <option value="{{ $r }}" @selected($role === $r)>{{ ucfirst($r) }}</option>
                @endforeach
            </select>
            <button class="rounded bg-zinc-900 px-3 py-2 text-white dark:bg-zinc-100 dark:text-zinc-900">Filter</button>
        </form>

        <div class="overflow-x-auto rounded border border-zinc-200 dark:border-zinc-700">
            <table class="min-w-full text-sm">
                <thead class="bg-zinc-50 dark:bg-zinc-900">
                    <tr>
                        <th class="px-3 py-2 text-left">Name</th>
                        <th class="px-3 py-2 text-left">Email</th>
                        <th class="px-3 py-2 text-left">Role</th>
                        <th class="px-3 py-2 text-left">Active</th>
                        <th class="px-3 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr class="border-t border-zinc-200 dark:border-zinc-700">
                            <td class="px-3 py-2">{{ $user->name }}</td>
                            <td class="px-3 py-2">{{ $user->email }}</td>
                            <td class="px-3 py-2">{{ ucfirst($user->role) }}</td>
                            <td class="px-3 py-2">{{ $user->is_active ? 'Yes' : 'No' }}</td>
                            <td class="px-3 py-2">
                                <form method="POST" action="{{ route('admin.users.update', $user) }}" class="flex flex-wrap gap-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="role" class="rounded border border-zinc-300 px-2 py-1 dark:border-zinc-700 dark:bg-zinc-900">
                                        @foreach(['user','agent','admin'] as $r)
                                            <option value="{{ $r }}" @selected($user->role === $r)>{{ ucfirst($r) }}</option>
                                        @endforeach
                                    </select>
                                    <label class="flex items-center gap-1 text-xs"><input type="checkbox" name="is_active" value="1" @checked($user->is_active)> Active</label>
                                    <button class="rounded bg-blue-600 px-3 py-1 text-white">Save</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-3 py-4 text-center text-zinc-500">No users found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">{{ $users->links() }}</div>
    </div>
</x-layouts::app>
