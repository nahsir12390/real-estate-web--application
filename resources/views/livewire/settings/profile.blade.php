<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your account and public profile details')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                @if ($this->hasUnverifiedEmail)
                    <div>
                        <flux:text class="mt-4">
                            {{ __('Your email address is unverified.') }}

                            <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                {{ __('Click here to re-send the verification email.') }}
                            </flux:link>
                        </flux:text>

                        @if (session('status') === 'verification-link-sent')
                            <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </flux:text>
                        @endif
                    </div>
                @endif
            </div>

            <flux:input wire:model="phone" :label="__('Phone')" type="text" autocomplete="tel" placeholder="+1 000 000 0000" />

            <flux:input wire:model="whatsapp_number" :label="__('WhatsApp Number')" type="text" autocomplete="tel" placeholder="+1 000 000 0000" />

            <flux:input wire:model="address" :label="__('Address')" type="text" autocomplete="street-address" placeholder="Street, city, state" />

            <div class="space-y-2">
                <flux:label>{{ __('Bio') }}</flux:label>
                <textarea
                    wire:model="bio"
                    rows="4"
                    class="w-full rounded-lg border border-zinc-300 px-3 py-2 text-sm dark:border-zinc-700 dark:bg-zinc-900"
                    placeholder="Tell users about your profile"
                ></textarea>
            </div>

            <flux:input wire:model="facebook_url" :label="__('Facebook URL')" type="url" placeholder="https://facebook.com/your-page" />
            <flux:input wire:model="twitter_url" :label="__('Twitter/X URL')" type="url" placeholder="https://x.com/your-handle" />
            <flux:input wire:model="instagram_url" :label="__('Instagram URL')" type="url" placeholder="https://instagram.com/your-handle" />

            <div class="space-y-2">
                <flux:label>{{ __('Avatar') }}</flux:label>
                @if ($this->avatarUrl)
                    <img src="{{ $this->avatarUrl }}" alt="{{ __('Avatar') }}" class="h-16 w-16 rounded-full object-cover" />
                @endif
                <input wire:model="avatarUpload" type="file" accept="image/*" class="block w-full text-sm" />
                @error('avatarUpload')
                    <flux:text class="text-red-600">{{ $message }}</flux:text>
                @enderror
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                </div>

                <x-action-message class="me-3" on="profile-updated">
                    {{ __('Saved.') }}
                </x-action-message>
            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:settings.delete-user-form />
        @endif
    </x-settings.layout>
</section>
