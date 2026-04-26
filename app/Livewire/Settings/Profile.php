<?php

namespace App\Livewire\Settings;

use App\Concerns\ProfileValidationRules;
use App\Models\Profile as ProfileModel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Title('Profile settings')]
class Profile extends Component
{
    use ProfileValidationRules, WithFileUploads;

    public string $name = '';

    public string $email = '';

    public ?string $phone = null;

    public ?string $address = null;

    public ?string $bio = null;

    public ?string $whatsapp_number = null;

    public ?string $facebook_url = null;

    public ?string $twitter_url = null;

    public ?string $instagram_url = null;

    public ?string $avatar = null;

    public $avatarUpload = null;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $profile = $user->profile;

        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $profile?->phone;
        $this->address = $profile?->address;
        $this->bio = $profile?->bio;
        $this->whatsapp_number = $profile?->whatsapp_number;
        $this->facebook_url = $profile?->facebook_url;
        $this->twitter_url = $profile?->twitter_url;
        $this->instagram_url = $profile?->instagram_url;
        $this->avatar = $profile?->avatar;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            ...$this->profileRules($user->id),
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'twitter_url' => ['nullable', 'url', 'max:255'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'avatarUpload' => ['nullable', 'image', 'max:2048'],
        ]);

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        if ($this->avatarUpload) {
            if ($this->avatar) {
                Storage::disk('public')->delete($this->avatar);
            }

            $this->avatar = $this->avatarUpload->store('avatars', 'public');
        }

        ProfileModel::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'bio' => $validated['bio'] ?? null,
                'whatsapp_number' => $validated['whatsapp_number'] ?? null,
                'facebook_url' => $validated['facebook_url'] ?? null,
                'twitter_url' => $validated['twitter_url'] ?? null,
                'instagram_url' => $validated['instagram_url'] ?? null,
                'avatar' => $this->avatar,
            ]
        );

        $this->avatarUpload = null;

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    #[Computed]
    public function hasUnverifiedEmail(): bool
    {
        return Auth::user() instanceof MustVerifyEmail && ! Auth::user()->hasVerifiedEmail();
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return ! (Auth::user() instanceof MustVerifyEmail)
            || (Auth::user() instanceof MustVerifyEmail && Auth::user()->hasVerifiedEmail());
    }

    #[Computed]
    public function avatarUrl(): ?string
    {
        return $this->avatar ? Storage::disk('public')->url($this->avatar) : null;
    }
}
