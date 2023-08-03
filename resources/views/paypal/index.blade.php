<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('PayPal') }}
        </h2>
    </x-slot>


		@if (session()->has('message'))
        <div class="flex justify-center">
					<div class="m-4 p-4 w-1/2 rounded relative {{ session()->get('color') }}">
						<p class="font-bold text-lg text-center text-white">{{ session()->get('message') }}</p>
					</div>
				</div>
    @endif


		<div class="flex items-center justify-center bg-gray-100">
		  <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
		    <div class="flex flex-col md:flex-row items-center">
		      <div class="md:w-1/2 mb-4 md:mb-0">
		        <img src="{{ asset('images/vaccum.jpg') }}" alt="Vacuum Cleaner" class="rounded-lg shadow-md float-right">
		      </div>

		      <!-- Purchase Form (Right Side) -->
		      <div class="md:w-1/2 md:ml-4 bg-white p-6 rounded-lg shadow-md">
		        <h2 class="text-2xl font-semibold mb-4">Buy Dustbuster 3000</h2>
		        <form action="handle-payment" method="POST">

		        	<div class="mb-4">
		            <p class="italic">Introducing the magical Dustbuster 3000 - your personal wizard to vanquish dust bunnies and defeat dirt dragons! Say goodbye to the tyranny of crumbs and hello to a cleaner, happier home. Don't let dust rule your life, claim your freedom with the Dustbuster 3000 today!</p>
		          </div>

		          @csrf
		          <!-- Product Details -->
		          <div class="mb-4">
		          	<p class="text-xl font-bold mb-8">Price: $2500</p>
		            <label for="quantity" class="block text-gray-700 font-bold mb-2">Quantity</label>
		            <input type="number" id="quantity" name="quantity" min="1" class="form-input w-full rounded-lg" required>
		          </div>

		          <!-- Submit Button -->
		          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-4 px-4 mt-6 rounded-lg w-full text-xl">Purchase</button>
		        </form>
		      </div>
		    </div>
		  </div>
		</div>


</x-app-layout>
