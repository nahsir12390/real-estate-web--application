<?php

namespace App\Actions\Fortify;

use App\Concerns\PasswordValidationRules;
use App\Concerns\ProfileValidationRules;
use App\Models\Agent;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
            'account_type' => ['required', Rule::in([User::ROLE_USER, User::ROLE_AGENT])],
            'company_name' => ['nullable', 'string', 'max:255', 'required_if:account_type,agent'],
            'nin' => [
                'nullable',
                'string',
                'regex:/^\d{11}$/',
                'required_if:account_type,agent',
                Rule::unique('agents', 'nin'),
            ],
            'license_number' => ['nullable', 'string', 'max:100'],
            'experience_years' => ['nullable', 'integer', 'min:0', 'max:80'],
            'specialization' => ['nullable', 'string', 'max:255'],
        ])->validate();

        return DB::transaction(function () use ($input): User {
            $isAgent = ($input['account_type'] ?? User::ROLE_USER) === User::ROLE_AGENT;

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => $input['password'],
                'role' => $isAgent ? User::ROLE_AGENT : User::ROLE_USER,
                'is_active' => true,
            ]);

            Profile::create([
                'user_id' => $user->id,
            ]);

            if ($isAgent) {
                Agent::create([
                    'user_id' => $user->id,
                    'company_name' => $input['company_name'] ?? null,
                    'nin' => $input['nin'] ?? null,
                    'license_number' => $input['license_number'] ?? null,
                    'experience_years' => (int) ($input['experience_years'] ?? 0),
                    'specialization' => $input['specialization'] ?? null,
                    'verification_status' => Agent::STATUS_PENDING,
                ]);
            }

            return $user;
        });
    }
}
