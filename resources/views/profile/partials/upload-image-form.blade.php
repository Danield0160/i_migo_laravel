<form id="send-image" method="post" action="{{ route('setImage') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
    @csrf
    <x-input-label for="name" :value="__('Subir imagen')" />
    <input type="file" style="background-color: white" name="file_upload">
    <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        {{ __('Click here to re-send the verification email.') }}
    </button>
</form>