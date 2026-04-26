<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [GuestController::class, 'home'])->name('home');
Route::get('/properties', [GuestController::class, 'properties'])->name('properties.index');
Route::get('/properties/{slug}', [GuestController::class, 'showProperty'])->name('properties.show');

Route::middleware(['auth', 'active', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->isAgent()) {
            return redirect()->route('agent.dashboard');
        }

        return redirect()->route('user.home');
    })->name('dashboard');

    Route::middleware(['role:user'])->group(function () {
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('home', [UserController::class, 'home'])->name('home');
            Route::get('favorites', [UserController::class, 'favorites'])->name('favorites');
            Route::get('inquiries', [UserController::class, 'inquiries'])->name('inquiries');
            Route::get('reports', [UserController::class, 'reports'])->name('reports');
            Route::get('properties/{slug}', [UserController::class, 'showProperty'])->name('properties.show');
        });
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('home', fn () => redirect()->route('admin.dashboard'))->name('home');
            Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            Route::get('agents', [AdminController::class, 'agents'])->name('agents.index');
            Route::patch('agents/{agent}/approve', [AdminController::class, 'approveAgent'])->name('agents.approve');
            Route::patch('agents/{agent}/reject', [AdminController::class, 'rejectAgent'])->name('agents.reject');
            Route::get('verifications', [AdminController::class, 'verifications'])->name('verifications.index');
            Route::patch('verifications/{agentVerification}/approve', [AdminController::class, 'approveVerification'])->name('verifications.approve');
            Route::patch('verifications/{agentVerification}/reject', [AdminController::class, 'rejectVerification'])->name('verifications.reject');

            Route::get('properties', [AdminController::class, 'properties'])->name('properties.index');
            Route::post('properties', [AdminController::class, 'storeProperty'])->name('properties.store');
            Route::patch('properties/{property}/approve', [AdminController::class, 'approveProperty'])->name('properties.approve');
            Route::patch('properties/{property}/reject', [AdminController::class, 'rejectProperty'])->name('properties.reject');
            Route::delete('properties/{property}', [AdminController::class, 'deleteProperty'])->name('properties.delete');

            Route::get('plans', [AdminController::class, 'plans'])->name('plans.index');
            Route::post('plans', [AdminController::class, 'storePlan'])->name('plans.store');
            Route::patch('plans/{plan}', [AdminController::class, 'updatePlan'])->name('plans.update');
            Route::delete('plans/{plan}', [AdminController::class, 'deletePlan'])->name('plans.delete');

            Route::get('subscriptions', [AdminController::class, 'subscriptions'])->name('subscriptions.index');
            Route::patch('subscriptions/{subscription}', [AdminController::class, 'updateSubscription'])->name('subscriptions.update');

            Route::get('inquiries', [AdminController::class, 'inquiries'])->name('inquiries.index');
            Route::patch('inquiries/{inquiry}', [AdminController::class, 'updateInquiry'])->name('inquiries.update');

            Route::get('reports', [AdminController::class, 'reports'])->name('reports.index');
            Route::patch('reports/{report}', [AdminController::class, 'updateReport'])->name('reports.update');

            Route::get('users', [AdminController::class, 'users'])->name('users.index');
            Route::patch('users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

            Route::get('settings', [AdminController::class, 'settings'])->name('settings.index');
            Route::patch('settings', [AdminController::class, 'updateSettings'])->name('settings.update');
        });
    });

    Route::middleware(['role:agent'])->group(function () {
        Route::prefix('agent')->name('agent.')->group(function () {
            Route::get('home', fn () => redirect()->route('agent.dashboard'))->name('home');
            Route::get('dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
            Route::get('verification', [AgentController::class, 'verification'])->name('verification');
            Route::get('subscription', [AgentController::class, 'subscription'])->name('subscription');
            Route::get('inquiries', [AgentController::class, 'inquiries'])->name('inquiries');
            Route::get('properties', [AgentController::class, 'properties'])->name('properties.index');

            Route::middleware(['verified.agent'])->group(function () {
                Route::get('properties/create', [AgentController::class, 'createProperty'])->name('properties.create');
                Route::get('properties/{property}/edit', [AgentController::class, 'editProperty'])->name('properties.edit');
            });
        });
    });
});

require __DIR__.'/settings.php';
