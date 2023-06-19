<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>File Upload</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body class="antialiased">
    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Alert!</strong>
            <span class="block sm:inline">{{ implode('', $errors->all(':message')) }}</span>
        </div>
    @endif
    <div class="flex justify-center items-center min-h-screen">
        <div class="bg-gray-100 p-8 rounded-lg shadow-lg flex flex-col justify-center items-center">
            <form action="{{route('csv.process')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label class="block text-gray-700 font-bold mb-2" for="file-upload">
                        Choose a file to upload:
                    </label>
                    <input class="w-full py-2 px-3 border border-gray-300 rounded" type="file" id="file-upload" name="file-upload" accept="text/csv" />
                </div>
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                    Upload
                </button>
            </form>
        </div>
    </div>

    </body>
</html>
