<!-- resources/views/modals/tailwind-modal.blade.php -->

<div id="tailwindModal" class="fixed inset-0 hidden flex items-center justify-center">
    <div class="bg-black bg-opacity-50 w-full h-full absolute"></div>
    <div class="bg-white p-8 rounded-lg max-w-md z-10 relative">
        <div class="flex justify-end">
            <button onclick="closeTailwindModal()" class="text-gray-700 hover:text-gray-900">&times;</button>
        </div>
        <h2 id="modalTitle" class="text-2xl font-bold mb-4">Modal Title</h2>
        <p id="modalContent">This is the modal content.</p>
    </div>
</div>
