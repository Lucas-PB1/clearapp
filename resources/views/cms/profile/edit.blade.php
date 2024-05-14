<x-cms-layout>

    <x-cms.partials.forms.card>
        <div class="border-bottom">
            <x-cms.profile.update-profile-information-form :user="$user" />
        </div>

        <div class="border-bottom">
            <x-cms.profile.update-password-form :user="$user" />
        </div>

        <div class="border-bottom">
            <x-cms.profile.update-roles-form :user="$user" :roles="$roles" />
        </div>

    </x-cms.partials.forms.card>
</x-cms-layout>
