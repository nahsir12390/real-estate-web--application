<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6" x-data="{ accountType: '{{ old('account_type', 'user') }}' }">
        <x-auth-header :title="__('Create your account')" :description="__('Choose account type and complete your details.')" />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <div class="rounded-xl border border-zinc-300 bg-zinc-50 p-4 dark:border-zinc-700 dark:bg-zinc-900">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('Account Type') }}</p>
                <div class="grid gap-3 md:grid-cols-2">
                    <label class="cursor-pointer rounded-lg border px-4 py-3 text-sm transition"
                        :class="accountType === 'user' ? 'border-zinc-900 bg-zinc-900 text-white dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 bg-white text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100'">
                        <input type="radio" name="account_type" value="user" class="sr-only" x-model="accountType">
                        <span class="font-semibold">{{ __('Regular User') }}</span>
                        <span class="mt-1 block text-xs opacity-80">{{ __('Browse, save favorites, and contact agents') }}</span>
                    </label>

                    <label class="cursor-pointer rounded-lg border px-4 py-3 text-sm transition"
                        :class="accountType === 'agent' ? 'border-zinc-900 bg-zinc-900 text-white dark:border-zinc-100 dark:bg-zinc-100 dark:text-zinc-900' : 'border-zinc-300 bg-white text-zinc-900 dark:border-zinc-700 dark:bg-zinc-950 dark:text-zinc-100'">
                        <input type="radio" name="account_type" value="agent" class="sr-only" x-model="accountType">
                        <span class="font-semibold">{{ __('Agent') }}</span>
                        <span class="mt-1 block text-xs opacity-80">{{ __('Post and manage listings after verification') }}</span>
                    </label>
                </div>
            </div>

            <div class="rounded-xl border border-zinc-300 p-4 dark:border-zinc-700">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('Basic Information') }}</p>
                <div class="grid gap-3">
                    <flux:input
                        name="name"
                        :label="__('Name')"
                        :value="old('name')"
                        type="text"
                        required
                        autofocus
                        autocomplete="name"
                        :placeholder="__('Full name')"
                    />

                    <flux:input
                        name="email"
                        :label="__('Email address')"
                        :value="old('email')"
                        type="email"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />
                </div>
            </div>

            <div class="rounded-xl border border-zinc-300 p-4 dark:border-zinc-700">
                <p class="mb-3 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('Security') }}</p>
                <div class="grid gap-3">
                    <flux:input
                        name="password"
                        :label="__('Password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Password')"
                        viewable
                    />

                    <flux:input
                        name="password_confirmation"
                        :label="__('Confirm password')"
                        type="password"
                        required
                        autocomplete="new-password"
                        :placeholder="__('Confirm password')"
                        viewable
                    />
                </div>
            </div>

            <div x-show="accountType === 'agent'" x-cloak class="rounded-xl border border-zinc-300 p-4 dark:border-zinc-700">
                <p class="mb-1 text-xs font-semibold uppercase tracking-wide text-zinc-500">{{ __('Agent Details') }}</p>
                <p class="mb-3 text-sm text-zinc-500">{{ __('Required for agent account verification.') }}</p>

                <div class="grid gap-3 md:grid-cols-2">
                    <flux:input
                        name="company_name"
                        :label="__('Company Name')"
                        :value="old('company_name')"
                        type="text"
                        :placeholder="__('Your agency/company name')"
                    />

                    <flux:input
                        name="nin"
                        :label="__('NIN (11 digits)')"
                        :value="old('nin')"
                        type="text"
                        inputmode="numeric"
                        maxlength="11"
                        :placeholder="__('e.g. 12345678901')"
                    />

                    <flux:input
                        name="license_number"
                        :label="__('License Number')"
                        :value="old('license_number')"
                        type="text"
                        :placeholder="__('Optional license number')"
                    />

                    <flux:input
                        name="experience_years"
                        :label="__('Experience (years)')"
                        :value="old('experience_years')"
                        type="number"
                        min="0"
                        :placeholder="__('e.g. 5')"
                    />

                    <div class="md:col-span-2">
                        <flux:input
                            name="specialization"
                            :label="__('Specialization')"
                            :value="old('specialization')"
                            type="text"
                            :placeholder="__('Residential, Commercial, Land, etc.')"
                        />
                    </div>
                </div>
            </div>

            <div x-show="accountType === 'agent'" x-cloak class="rounded-xl border border-zinc-300 bg-zinc-50 p-3 text-sm text-zinc-700 dark:border-zinc-700 dark:bg-zinc-900 dark:text-zinc-300">
                {{ __('Agent accounts remain pending until identity documents are submitted and approved by admin.') }}
            </div>

            <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                {{ __('Create account') }}
            </flux:button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
