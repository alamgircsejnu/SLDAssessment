@props(['picture'])
<div class="flex items-center" x-data="picturePreview()">
    <div class="rounded-md bg-gray-200 mr-4">
        <img src="{{$picture}}" alt="photo" class="w-24 h-24 rounder-md object-cover" id="preview_photo">
    </div>
    <div>
        <x-primary-button type="button" @click="document.getElementById('profile_picture').click()" class="relative">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                </svg>
                Upload Photo
            </div>
            <input @change="showPreview(event)" type="file" name="photo" id="profile_picture" class="absolute inset-0 -z-10 opacity-0">
        </x-primary-button>
    </div>

    <script>
        function picturePreview(e) {
           return {
               showPreview: (event) => {
                   if (event.target.files.length > 0) {
                       document.getElementById('preview_photo').src = URL.createObjectURL(event.target.files[0]);
                   }
               }
           }
        }
    </script>
</div>
