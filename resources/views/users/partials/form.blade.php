<!-- Prefix Name -->
<div class="mt-4">
    <x-input-label for="prefixname" :value="__('Prefix Name')"/>
    <select name="prefixname" class="block mt-1 w-full rounded border-gray-300" id="prefixname">
        <option value="" {{ (old('prefixname') ?? $user->prefixname ?? '') == '' ? 'selected' : '' }}></option>
        <option value="Mr" {{ (old('prefixname') ?? $user->prefixname ?? '') == 'Mr' ? 'selected' : '' }}>Mr</option>
        <option value="Mrs" {{ (old('prefixname') ?? $user->prefixname ?? '') == 'Mrs' ? 'selected' : '' }}>Mrs</option>
        <option value="Ms" {{ (old('prefixname') ?? $user->prefixname ?? '') == 'Ms' ? 'selected' : '' }}>Ms</option>
    </select>
    <x-input-error :messages="$errors->get('prefixname')" class="mt-2"/>
</div>

<!-- First Name -->
<div class="mt-4">
    <div class="flex">
        <x-input-label for="firstname" :value="__('First Name')"/>
        <span class="text-red-700 ms-2">*</span>
    </div>
    <x-text-input id="firstname" class="block mt-1 w-full" type="text" name="firstname"
                  :value="old('firstname') ?? $user->firstname ?? ''" autocomplete="firstname"/>
    <x-input-error :messages="$errors->get('firstname')" class="mt-2"/>
</div>

<!-- Middle Name -->
<div class="mt-4">
    <x-input-label for="middlename" :value="__('Middle Name')"/>
    <x-text-input id="middlename" class="block mt-1 w-full" type="text" name="middlename"
                  :value="old('middlename') ?? $user->middlename ?? ''" autocomplete="middlename"/>
    <x-input-error :messages="$errors->get('middlename')" class="mt-2"/>
</div>

<!-- Last Name -->
<div class="mt-4">
    <div class="flex">
        <x-input-label for="lastname" :value="__('Last Name')"/>
        <span class="text-red-700 ms-2">*</span>
    </div>
    <x-text-input id="lastname" class="block mt-1 w-full" type="text" name="lastname"
                  :value="old('lastname') ?? $user->lastname ?? ''" autocomplete="lastname"/>
    <x-input-error :messages="$errors->get('lastname')" class="mt-2"/>
</div>

<!-- Suffix Name -->
<div class="mt-4">
    <x-input-label for="suffixname" :value="__('Suffix Name')"/>
    <x-text-input id="suffixname" class="block mt-1 w-full" type="text" name="suffixname"
                  :value="old('suffixname') ?? $user->suffixname ?? ''" autocomplete="suffixname"/>
    <x-input-error :messages="$errors->get('suffixname')" class="mt-2"/>
</div>

<!-- User Name -->
<div class="mt-4">
    <div class="flex">
        <x-input-label for="username" :value="__('User Name')"/>
        <span class="text-red-700 ms-2">*</span>
    </div>
    <x-text-input id="username" class="block mt-1 w-full" type="text" name="username"
                  :value="old('username') ?? $user->username ?? ''" autocomplete="username"/>
    <x-input-error :messages="$errors->get('username')" class="mt-2"/>
</div>

<!-- Email Address -->
<div class="mt-4">
    <div class="flex">
        <x-input-label for="email" :value="__('Email Name')"/>
        <span class="text-red-700 ms-2">*</span>
    </div>
    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                  :value="old('email') ?? $user->email ?? ''" autocomplete="username"/>
    <x-input-error :messages="$errors->get('email')" class="mt-2"/>
</div>

<!-- Password -->
<div class="mt-4">
    <x-input-label for="password" :value="__('Password')"/>

    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password"/>

    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
</div>

<!-- Confirm Password -->
<div class="mt-4">
    <x-input-label for="password_confirmation" :value="__('Confirm Password')"/>

    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password"/>

    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2"/>
</div>

<!-- Profile Picture -->
<div class="mt-4">
    <x-input-label for="profile_picture" :value="__('Profile Picture')" class="mb-2"/>
    <x-photo-input :picture="old('avatar') ?? $user->avatar ?? asset('media/profile_photo/default/default.jpg')" />
    <x-input-error :messages="$errors->get('photo')" class="mt-2"/>
</div>
