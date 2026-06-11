<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
            Point of Sales (Kasir)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-r shadow-sm" role="alert">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif
            @if($errors->any())
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm" role="alert">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Daftar Barang -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-700">Pilih Barang</h3>
                            <p class="text-sm text-gray-500">Kasir: {{ $cashierName }}</p>
                        </div>
                        <form action="{{ route('cashier.pos.create') }}" method="GET" class="w-full sm:w-auto grid grid-cols-1 gap-2 sm:grid-cols-2">
                            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau SKU" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" />
                            <select name="category_id" onchange="this.form.submit()" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-96 overflow-y-auto pr-2">
                        @forelse($stocks as $stock)
                            <div class="border border-gray-200 rounded-xl p-4 hover:border-indigo-500 cursor-pointer transition" onclick="addToCart({{ $stock->product->id }}, '{{ $stock->product->name }}', {{ $stock->product->price }}, {{ $stock->stock }})">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="font-bold text-gray-800">{{ $stock->product->name }}</div>
                                    @if($stock->product->category)
                                        <span class="text-xs uppercase tracking-wide text-slate-500 bg-slate-100 px-2 py-1 rounded-full">{{ $stock->product->category->name }}</span>
                                    @endif
                                </div>
                                <div class="text-xs uppercase tracking-wide text-slate-400">{{ $stock->product->sku }}</div>
                                <div class="text-sm text-gray-500 mt-2">Stok tersedia: {{ $stock->stock }}</div>
                                <div class="mt-2 text-indigo-600 font-semibold">Rp {{ number_format($stock->product->price, 0, ',', '.') }}</div>
                            </div>
                        @empty
                            <div class="col-span-1 sm:col-span-2 text-center text-gray-500 italic py-10">
                                Barang tidak ditemukan.
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Keranjang -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 p-6 flex flex-col">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Keranjang</h3>
                    
                    <form action="{{ route('cashier.pos.store') }}" method="POST" id="checkout-form" class="flex-grow flex flex-col">
                        @csrf
                        <div id="cart-items" class="flex-grow overflow-y-auto mb-4 space-y-3">
                            <p class="text-gray-400 text-center italic mt-10" id="empty-cart-msg">Keranjang kosong</p>
                        </div>

                        <div class="space-y-4 mb-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar</label>
                                    <input id="payment-amount" type="number" min="0" step="1000" class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Masukkan jumlah uang pelanggan" oninput="updatePayment()" required />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="rounded-lg border border-gray-200 p-4 bg-slate-50">
                                        <div class="text-sm text-slate-500">Total Tagihan</div>
                                        <div class="text-xl font-bold text-gray-900" id="cart-total">Rp 0</div>
                                    </div>
                                    <div class="rounded-lg border border-gray-200 p-4 bg-slate-50">
                                        <div class="text-sm text-slate-500">Kembalian</div>
                                        <div class="text-xl font-bold text-green-600" id="change-amount">Rp 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="payment_amount" id="payment-amount-hidden" value="0">
                        <div id="payment-error" class="text-sm text-red-600 hidden">Jumlah bayar harus lebih besar atau sama dengan total transaksi.</div>
                        <div class="border-t pt-4">
                            <button type="submit" id="checkout-btn" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-4 rounded-xl shadow-lg transition duration-300 transform hover:-translate-y-1 opacity-50 cursor-not-allowed" disabled>
                                Proses Pembayaran
                            </button>
                        </div>
                    </form>

                    <div id="confirmation-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">
                        <div class="w-full max-w-2xl rounded-3xl bg-white shadow-2xl border border-slate-200 overflow-hidden">
                            <div class="p-6 border-b border-slate-200">
                                <h3 class="text-xl font-semibold text-slate-900">Konfirmasi Transaksi</h3>
                                <p class="text-sm text-slate-500 mt-1">Periksa kembali detail pembayaran sebelum memproses penjualan.</p>
                            </div>
                            <div class="p-6 space-y-4">
                                <div class="grid grid-cols-2 gap-4 text-sm text-slate-700">
                                    <div class="rounded-lg bg-slate-50 p-4">
                                        <div class="text-slate-500">Total Belanja</div>
                                        <div class="text-xl font-bold text-slate-900" id="confirm-total">Rp 0</div>
                                    </div>
                                    <div class="rounded-lg bg-slate-50 p-4">
                                        <div class="text-slate-500">Bayar</div>
                                        <div class="text-xl font-bold text-slate-900" id="confirm-payment">Rp 0</div>
                                    </div>
                                </div>
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="text-slate-500">Kembalian</div>
                                    <div class="text-2xl font-bold text-emerald-600" id="confirm-change">Rp 0</div>
                                </div>
                                <div class="rounded-lg bg-slate-50 p-4">
                                    <div class="text-slate-500">Jumlah Produk</div>
                                    <div class="text-lg font-semibold text-slate-900" id="confirm-count">0 item</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-end gap-3 p-6 bg-slate-50 border-t border-slate-200">
                                <button id="confirmation-cancel" type="button" class="px-4 py-2 rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 transition">Batal</button>
                                <button id="confirmation-confirm" type="button" class="px-4 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700 transition">Konfirmasi & Bayar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = [];
        const cartItemsContainer = document.getElementById('cart-items');
        const emptyCartMsg = document.getElementById('empty-cart-msg');
        const cartTotalEl = document.getElementById('cart-total');
        const changeAmountEl = document.getElementById('change-amount');
        const paymentAmountEl = document.getElementById('payment-amount');
        const paymentAmountHidden = document.getElementById('payment-amount-hidden');
        const paymentError = document.getElementById('payment-error');
        const checkoutBtn = document.getElementById('checkout-btn');
        const form = document.getElementById('checkout-form');

        function addToCart(id, name, price, maxStock) {
            const existingItem = cart.find(item => item.id === id);
            
            if (existingItem) {
                if (existingItem.qty < maxStock) {
                    existingItem.qty++;
                } else {
                    alert('Maksimal stok tercapai!');
                }
            } else {
                cart.push({ id, name, price, qty: 1, maxStock });
            }
            renderCart();
        }

        function removeFromCart(id) {
            cart = cart.filter(item => item.id !== id);
            renderCart();
        }

        function updatePayment() {
            const paymentValue = Number(paymentAmountEl.value) || 0;
            const totalValue = Number(cartTotalEl.dataset.value || 0);
            const remaining = paymentValue - totalValue;

            paymentAmountHidden.value = paymentValue;
            changeAmountEl.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(Math.max(remaining, 0))}`;

            const needsPayment = cart.length > 0 && totalValue > 0;
            const enoughPayment = paymentValue >= totalValue;

            if (needsPayment && !enoughPayment) {
                paymentError.classList.remove('hidden');
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                paymentError.classList.add('hidden');
                if (cart.length > 0) {
                    checkoutBtn.disabled = !enoughPayment;
                    checkoutBtn.classList.toggle('opacity-50', !enoughPayment);
                    checkoutBtn.classList.toggle('cursor-not-allowed', !enoughPayment);
                }
            }
        }

        function updateQty(id, delta) {
            const item = cart.find(item => item.id === id);
            if (item) {
                const newQty = item.qty + delta;
                if (newQty > 0 && newQty <= item.maxStock) {
                    item.qty = newQty;
                }
            }
            renderCart();
        }

        function renderCart() {
            cartItemsContainer.innerHTML = '';
            let total = 0;

            if (cart.length === 0) {
                cartItemsContainer.appendChild(emptyCartMsg);
                emptyCartMsg.style.display = 'block';
                checkoutBtn.disabled = true;
                checkoutBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                emptyCartMsg.style.display = 'none';
                checkoutBtn.disabled = false;
                checkoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');

                cart.forEach((item, index) => {
                    const subtotal = item.price * item.qty;
                    total += subtotal;

                    const div = document.createElement('div');
                    div.className = 'flex justify-between items-center p-3 bg-gray-50 rounded-lg border border-gray-100';
                    div.innerHTML = `
                        <div class="flex-grow">
                            <div class="font-semibold text-gray-800">${item.name}</div>
                            <div class="text-indigo-600 text-sm">Rp ${new Intl.NumberFormat('id-ID').format(item.price)}</div>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="flex items-center bg-white rounded border border-gray-200">
                                <button type="button" class="px-2 text-gray-600 hover:bg-gray-100" onclick="updateQty(${item.id}, -1)">-</button>
                                <span class="px-2 text-sm font-medium">${item.qty}</span>
                                <button type="button" class="px-2 text-gray-600 hover:bg-gray-100" onclick="updateQty(${item.id}, 1)">+</button>
                            </div>
                            <button type="button" class="text-red-500 hover:text-red-700" onclick="removeFromCart(${item.id})">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        <!-- Hidden Inputs for Form Submission -->
                        <input type="hidden" name="items[${index}][product_id]" value="${item.id}">
                        <input type="hidden" name="items[${index}][quantity]" value="${item.qty}">
                        <input type="hidden" name="items[${index}][price]" value="${item.price}">
                    `;
                    cartItemsContainer.appendChild(div);
                });
            }

            cartTotalEl.dataset.value = total;
            cartTotalEl.innerText = `Rp ${new Intl.NumberFormat('id-ID').format(total)}`;
            updatePayment();
        }

        function showConfirmationModal() {
            document.getElementById('confirm-total').innerText = cartTotalEl.innerText;
            document.getElementById('confirm-payment').innerText = `Rp ${new Intl.NumberFormat('id-ID').format(Number(paymentAmountEl.value) || 0)}`;
            document.getElementById('confirm-change').innerText = changeAmountEl.innerText;
            document.getElementById('confirm-count').innerText = `${cart.reduce((sum, item) => sum + item.qty, 0)} item`;
            document.getElementById('confirmation-modal').classList.remove('hidden');
        }

        function hideConfirmationModal() {
            document.getElementById('confirmation-modal').classList.add('hidden');
        }

        function handleCheckout(event) {
            event.preventDefault();

            const paymentValue = Number(paymentAmountEl.value) || 0;
            const totalValue = Number(cartTotalEl.dataset.value || 0);
            const enoughPayment = cart.length > 0 && paymentValue >= totalValue;

            if (!enoughPayment) {
                paymentError.classList.remove('hidden');
                return;
            }

            showConfirmationModal();
        }

        const confirmationCancel = document.getElementById('confirmation-cancel');
        const confirmationConfirm = document.getElementById('confirmation-confirm');
        const confirmationModal = document.getElementById('confirmation-modal');

        confirmationCancel.addEventListener('click', hideConfirmationModal);
        confirmationConfirm.addEventListener('click', () => {
            hideConfirmationModal();
            form.submit();
        });

        form.addEventListener('submit', handleCheckout);
    </script>
</x-app-layout>
