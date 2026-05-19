<div class="shopping-list p-1">
    {{-- Items diisi oleh JS dari localStorage --}}
    <div id="shop-items-container"></div>

    <p class="text-muted tgl m-0" id="shop-empty" style="display:none">
        Belum ada item.
    </p>

    <div class="d-flex gap-1 mt-2 align-items-center">
        <input
            type="text"
            id="shop-new-item"
            class="form-control form-control-sm"
            placeholder="Tambah item..."
            style="font-size:0.78rem;"
            onkeydown="if(event.key==='Enter') addShopItem()"
        >
        <button onclick="addShopItem()" class="btn btn-sm btn-primary p-1 px-2" style="font-size:0.78rem;">+</button>
    </div>
</div>

<script>
(function () {
    const USER_ID   = "{{ session('user_id') }}";
    const STORE_KEY = `shopping_list_${USER_ID}`;

    // ── Ambil dari DB (server) + localStorage, merge, simpan ──
    const dbItems = @json(array_values($shoppingList));

    function loadItems() {
        const saved = JSON.parse(localStorage.getItem(STORE_KEY) || '[]');
        // Merge DB items yang belum ada di saved
        dbItems.forEach(name => {
            if (!saved.find(i => i.name === name)) {
                saved.push({ name, checked: false });
            }
        });
        return saved;
    }

    function saveItems(items) {
        localStorage.setItem(STORE_KEY, JSON.stringify(items));
    }

    function renderItems() {
        const items     = loadItems();
        const container = document.getElementById('shop-items-container');
        const empty     = document.getElementById('shop-empty');
        container.innerHTML = '';

        if (items.length === 0) {
            empty.style.display = 'block';
            return;
        }
        empty.style.display = 'none';

        items.forEach((item, index) => {
            const div = document.createElement('div');
            div.className = 'd-flex align-items-center gap-2 mb-1 shop-item';
            div.innerHTML = `
                <input type="checkbox" id="shop-item-${index}" ${item.checked ? 'checked' : ''}>
                <label for="shop-item-${index}" class="m-0 flex-grow-1"
                    style="${item.checked ? 'text-decoration:line-through;color:#9CA3AF;' : ''}">
                    ${item.name}
                </label>
                <button class="btn p-0 m-0 text-danger remove-btn" data-index="${index}" style="font-size:0.7rem;">✕</button>
            `;

            // Checkbox toggle
            div.querySelector('input').addEventListener('change', function () {
                const all = loadItems();
                all[index].checked = this.checked;
                saveItems(all);
                renderItems();
            });

            // Remove
            div.querySelector('.remove-btn').addEventListener('click', function () {
                const all = loadItems();
                all.splice(index, 1);
                saveItems(all);
                renderItems();
            });

            container.appendChild(div);
        });

        saveItems(items); // simpan hasil merge
    }

    window.addShopItem = function () {
        const input = document.getElementById('shop-new-item');
        const val   = input.value.trim();
        if (!val) return;

        const items = loadItems();
        items.push({ name: val, checked: false });
        saveItems(items);
        renderItems();
        input.value = '';
        input.focus();
    };

    document.addEventListener('DOMContentLoaded', renderItems);
})();
</script>