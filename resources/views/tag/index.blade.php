<x-app-layout>

    <x-propios.principal>
       

<div class="relative overflow-x-auto">
    <div class="flex flex-row-reverse">
        <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-2" href="{{route('tag.create')}}"><i class="fas fa-add mr-2"></i>Crear una tag</a>
    </div>
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                 name
                </th>
                <th scope="col" class="px-6 py-3">
                    Color
                </th>

                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tag as $item)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$item -> nombre }}
                </th>
                <td class="px-6 py-4">
                    {{$item -> color}}
                </td>
                <td class="px-6 py-4">
                    <form action="{{route('tag.destroy' , $item -> id)}}" method="post">
                        @csrf
                        @method('delete')
                        <a href="{{route('tag.edit' , $item -> id)}}"><i class="mr-2 fas fa-edit text-yellow-600"></i></a>
                    <button type="submit"><i class="fas fa-trash text-red-600"></i></button>
                    </form>
                </td>
            </tr>
                        @endforeach
        </tbody>
    </table>
</div>

<div class="my-2">
    {{$tag -> links()}}
</div>

    </x-propios.principal>

</x-app-layout>