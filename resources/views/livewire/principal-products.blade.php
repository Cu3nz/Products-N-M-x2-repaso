<div>
    <x-propios.principal>
        <div class="flex w-full mb-1 items-center">

            <div class="flex-1">
                <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-3/4"
                    placeholder="Busca un articulo" wire:model.live="buscar">
            </div>

            <div>
                @livewire('crear-products')
            </div>

        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-16 py-3">
                        <span class="sr-only">Image</span>
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('nombre')">
                        <i class="fa-solid fa-sort mr-2"></i>Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Descripcion
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('stock')">
                        <i class="fa-solid fa-sort mr-2"></i> Stock
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('pvp')">
                        <i class="fa-solid fa-sort mr-2"></i>Precio
                    </th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="ordenar('disponible')">
                        <i class="fa-solid fa-sort mr-1"></i>DISPONIBLE
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($productos as $item)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4">
                            <img src="{{ Storage::url($item->imagen) }}" class="w-16 md:w-32 max-w-full max-h-full"
                                alt="Apple Watch">
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $item->nombre }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->descripcion }}
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            <div class="flex items-center">

                                <button wire:click="bajarStock(2)"
                                    class="inline-flex items-center justify-center p-1 me-3 text-sm font-medium h-6 w-6 text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                    type="button">
                                    <span class="sr-only">Quantity button</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M1 1h16" />
                                    </svg>
                                </button>

                                <div>
                                    <input readonly id="first_product" @class([
                                        'bg-gray-50 w-14 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-2.5 py-1 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-50',
                                        'text-red-600' => $item->stock < 10,
                                        'text-green-600' => $item->stock >= 10,
                                        'line-trough font-bold' => $item->stock === 0,
                                    ])
                                        value="{{ $item->stock }}" required />
                                </div>
                                <button wire:click="subirStock({{ $item->id }})"
                                    class="inline-flex items-center justify-center h-6 w-6 p-1 ms-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-full focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                    type="button">
                                    <span class="sr-only">Quantity button</span>
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="M9 1v16M1 9h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-white">
                            {{ $item->pvp }}€
                        </td>
                        <td @class([
                            'px-6 py-4 font-semibold text-gray-900 cursor-pointer',
                            'text-green-600' => $item->disponible == 'SI',
                            'text-red-600' => $item->disponible == 'NO',
                        ]) wire:click="actualizarDisponibleClick({{ $item->id }})">
                            {{ $item->disponible }}
                        </td>
                        <td class="px-6 py-4">
                            <button wire:click="info({{$item -> id}})"><i class="fas fa-info text-blue-600 mr-2"></i></button>
                            <button wire:click="pedirConfirmacion({{ $item->id }})" type="submit"><i
                                    class="fas fa-trash text-red-600"></i></button>

                            <button wire:click="edit(2)"><i class="fas fa-edit text-yellow-600"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-2">
            {{ $productos->links() }}
        </div>



        {{-- todo Modal info --}}

        @isset($Producto -> imagen)
        <x-dialog-modal>
            <x-slot name="title">
                Informacion del producto <span class="text-red-600">{{$Producto -> nombre}}</span>
            </x-slot>
            <x-slot name="content">
                <div
                    class="max-w-sm mx-auto bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">

                    <img class="rounded-t-lg" src="{{Storage::url($Producto -> imagen)}}" alt="" />

                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$Producto -> nombre}}</h5>

                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$Producto -> descripcion}}</p>

                        <p>Stock : <span @class(["text-green-600" => $Producto -> stock > 0,
                        ])>{{$Producto -> stock}}</span></p>

                        <h2>Disponibilidad: <span @class(["text-red-600" => $Producto -> disponible == 'NO', 
                        'text-green-600' => $Producto -> disponible == 'SI'])>{{$Producto -> disponible}}</span> </h2>
                    </div>
                </div>


            </x-slot>
            <x-slot name="footer">
                <button wire:click="salirModalCreate"
                    class="mr-2 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-xmark"></i> CANCELAR
                </button>
            </x-slot>
        </x-dialog-modal>
        @endisset

        {{-- todo Modal info --}}





    </x-propios.principal>

</div>
