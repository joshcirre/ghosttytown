<?php
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

use function Laravel\Folio\name;

name('login');

new class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('/', absolute: false), navigate: true);
    }
};
?>


<x-layouts.auth>
    @volt("pages.auth.login")
        <flux:card>
            <flux:button variant="primary" class="w-full" icon="github" href="/auth/redirect">
                Continue with GitHub
            </flux:button>
            <form wire:submit="login" class="mt-6 space-y-6">
                <div class="space-y-6">
                    <flux:separator text="or use email & password" />

                    <flux:input wire:model="form.email" label="Email" type="email" placeholder="Your email address" />

                    <flux:field>
                        <flux:label class="flex justify-between">
                            Password

                            <flux:link href="{{ route("password.request") }}" wire:navigate variant="subtle">
                                Forgot password?
                            </flux:link>
                        </flux:label>

                        <flux:input wire:model="form.password" type="password" placeholder="Your password" />

                        <flux:error name="form.password" />
                    </flux:field>

                    <flux:checkbox wire:model="form.remember" label="Remember me" />
                </div>

                <div class="space-y-2">
                    <flux:button variant="filled" class="w-full" type="submit">Log in</flux:button>

                    <flux:button variant="ghost" class="w-full" href="{{ route("register") }}" wire:navigate>
                        Sign up for a new account
                    </flux:button>
                </div>
            </form>
        </flux:card>
    @endvolt
</x-layouts.auth>
