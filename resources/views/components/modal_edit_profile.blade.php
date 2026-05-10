<style>
    .profile-modal-content {
        border-radius: 18px;
        border: none;
        overflow: hidden;
        width: 100%;
        max-width: 360px;
        background: var(--color-background-primary);
    }

    .profile-modal-header {
        background: linear-gradient(135deg, #95cd41 0%, #ea5c2b 100%);
        padding: 1.25rem 1.25rem 3rem;
        position: relative;
    }

    .btn-close-custom {
        position: absolute;
        top: 12px;
        right: 14px;
        background: rgba(255, 255, 255, 0.25);
        border: none;
        border-radius: 50%;
        width: 28px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #fff;
        font-size: 14px;
    }

    .profile-avatar {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.5rem;
        font-size: 1.7rem;
        font-weight: 700;
        color: #fff;
        border: 3px solid rgba(255, 255, 255, 0.6);
        position: relative;
        overflow: hidden;
        cursor: pointer;
        transition: filter 0.2s;
    }

    .profile-avatar:hover { filter: brightness(0.88); }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay "Ganti" saat hover avatar */
    .profile-avatar .avatar-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0,0,0,0.38);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.2s;
        border-radius: 50%;
        gap: 2px;
    }
    .profile-avatar:hover .avatar-overlay { opacity: 1; }
    .avatar-overlay span {
        font-size: 0.6rem;
        color: #fff;
        font-weight: 600;
        letter-spacing: 0.04em;
    }

    /* Badge preview baru */
    .avatar-preview-badge {
        position: absolute;
        bottom: 2px;
        right: 2px;
        background: #fff;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1.5px solid #95cd41;
        box-shadow: 0 1px 4px rgba(0,0,0,0.18);
        z-index: 2;
    }

    .photo-preview-strip {
        display: none;
        align-items: center;
        gap: 10px;
        background: rgba(255,255,255,0.18);
        border-radius: 10px;
        padding: 0.4rem 0.75rem;
        margin-top: 0.5rem;
        font-size: 0.72rem;
        color: #fff;
    }
    .photo-preview-strip.show { display: flex; }
    .photo-preview-strip img {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid rgba(255,255,255,0.7);
    }
    .photo-preview-strip .strip-name {
        flex: 1;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .photo-preview-strip .strip-cancel {
        cursor: pointer;
        font-size: 0.7rem;
        opacity: 0.8;
        background: rgba(255,255,255,0.22);
        border: none;
        border-radius: 50px;
        color: #fff;
        padding: 1px 7px;
    }

    .profile-body {
        background: var(--color-background-primary);
        border-radius: 18px 18px 0 0;
        padding: 1.25rem 1.25rem 1.25rem;
        margin-top: -1.5rem;
    }

    .form-label-custom {
        font-size: 0.72rem;
        color: var(--color-text-secondary);
        margin-bottom: 4px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .form-control-custom {
        width: 100%;
        border: 0.5px solid var(--color-border-secondary);
        border-radius: var(--border-radius-md);
        padding: 0.5rem 0.75rem;
        font-size: 0.88rem;
        color: var(--color-text-primary);
        background: var(--color-background-secondary);
        outline: none;
        transition: border-color 0.15s;
        box-sizing: border-box;
        font-family: var(--font-sans);
    }

    .form-control-custom:focus {
        border-color: #95cd41;
        box-shadow: 0 0 0 2px rgba(149, 205, 65, 0.18);
        background: var(--color-background-primary);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
    }

    .input-icon-wrap { position: relative; }
    .input-icon-wrap i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: var(--color-text-secondary);
    }
    .input-icon-wrap .form-control-custom { padding-left: 2rem; }

    .section-divider {
        font-size: 0.7rem;
        font-weight: 500;
        color: var(--color-text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.06em;
        margin: 1rem 0 0.6rem;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-divider::after {
        content: '';
        flex: 1;
        height: 0.5px;
        background: var(--color-border-tertiary);
    }

    .btn-save {
        width: 100%;
        border-radius: 50px;
        border: none;
        background: linear-gradient(90deg, #95cd41, #7ab52e);
        color: #fff;
        font-weight: 600;
        font-size: 0.88rem;
        padding: 0.6rem 1rem;
        cursor: pointer;
        margin-top: 1rem;
        transition: opacity 0.2s;
    }
    .btn-save:hover { opacity: 0.88; }

    .btn-cancel {
        width: 100%;
        border-radius: 50px;
        border: 1.5px solid var(--color-border-secondary);
        background: transparent;
        color: var(--color-text-secondary);
        font-weight: 500;
        font-size: 0.88rem;
        padding: 0.55rem 1rem;
        cursor: pointer;
        margin-top: 0.5rem;
        transition: background 0.2s;
        font-family: var(--font-sans);
    }
    .btn-cancel:hover { background: var(--color-background-secondary); }

    .gender-row { display: flex; gap: 8px; }
    .gender-btn {
        flex: 1;
        border: 0.5px solid var(--color-border-secondary);
        border-radius: var(--border-radius-md);
        padding: 0.45rem 0;
        font-size: 0.82rem;
        background: var(--color-background-secondary);
        color: var(--color-text-secondary);
        cursor: pointer;
        text-align: center;
        transition: all 0.15s;
        font-family: var(--font-sans);
    }
    .gender-btn.active {
        background: #eaf3de;
        color: #3B6D11;
        border-color: #95cd41;
        font-weight: 500;
    }

    @media (max-width: 400px) {
        .form-row { grid-template-columns: 1fr; }
        .profile-body { padding: 1rem; }
    }
    .modal-dialog { margin: auto; }
</style>

@php
    $authUser = \Illuminate\Support\Facades\DB::table('users')
                    ->where('id', session('user_id'))
                    ->first();
@endphp

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">

            {{-- ── Header ── --}}
            <div class="profile-modal-header">
                <button class="btn-close-custom" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="ti ti-x"></i>
                </button>
                <div style="text-align:center; margin-top:0.5rem;">

                    {{-- Avatar — klik untuk pilih foto --}}
                    <div class="profile-avatar" id="avatarCircle"
                         onclick="document.getElementById('photoInput').click()"
                         title="Klik untuk ganti foto">

                        {{-- Foto saat ini (dari DB atau inisial) --}}
                        @if (!empty($authUser->photo))
                            <img id="avatarCurrentImg"
                                 src="{{ asset('storage/' . $authUser->photo) }}"
                                 alt="foto">
                        @else
                            <span id="avatarInitial">
                                {{ strtoupper(substr($authUser->name ?? 'U', 0, 1)) }}
                            </span>
                        @endif

                        {{-- Preview foto baru (tersembunyi sampai ada file dipilih) --}}
                        <img id="avatarPreviewImg" src="" alt="preview"
                             style="display:none; position:absolute; inset:0; width:100%; height:100%; object-fit:cover;">

                        {{-- Overlay hover --}}
                        <div class="avatar-overlay">
                            <i class="ti ti-camera" style="font-size:18px; color:#fff;"></i>
                            <span>Ganti foto</span>
                        </div>

                        {{-- Badge kamera (pojok kanan bawah) --}}
                        <div class="avatar-preview-badge">
                            <i class="ti ti-camera" style="font-size:10px; color:#95cd41;"></i>
                        </div>
                    </div>

                    {{-- Strip preview: muncul setelah foto dipilih --}}
                    <div class="photo-preview-strip" id="previewStrip">
                        <img id="stripThumb" src="" alt="">
                        <span class="strip-name" id="stripFileName"></span>
                        <button type="button" class="strip-cancel" onclick="resetPhoto()">✕ Batal</button>
                    </div>

                    <p style="color:rgba(255,255,255,0.85); font-size:0.7rem; margin:0.3rem 0 0;"
                       id="photoHint">Ketuk avatar untuk ganti foto</p>
                </div>
            </div>

            {{-- ── Body ── --}}
            <div class="profile-body">
                <form action="{{ route('profile.update') }}" method="POST"
                      enctype="multipart/form-data" id="editProfileForm">
                    @csrf
                    @method('PUT')

                    {{-- Input file tersembunyi --}}
                    <input type="file" id="photoInput" name="photo"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           style="display:none">

                    <div class="section-divider">Informasi akun</div>

                    <div class="mb-2">
                        <label class="form-label-custom">Nama lengkap</label>
                        <div class="input-icon-wrap">
                            <i class="ti ti-user"></i>
                            <input type="text" name="name" class="form-control-custom"
                                   placeholder="Nama lengkap"
                                   value="{{ old('name', $authUser->name ?? '') }}" required>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-custom">Email</label>
                        <div class="input-icon-wrap">
                            <i class="ti ti-mail"></i>
                            <input type="email" name="email" class="form-control-custom"
                                   placeholder="email@contoh.com"
                                   value="{{ old('email', $authUser->email ?? '') }}" required>
                        </div>
                    </div>

                    <div class="section-divider">Data kesehatan</div>

                    <div class="form-row mb-2">
                        <div>
                            <label class="form-label-custom">Berat (kg)</label>
                            <input type="number" name="berat_badan" class="form-control-custom"
                                   placeholder="kg" min="1" max="500" step="0.1"
                                   value="{{ old('berat_badan', $authUser->berat_badan ?? '') }}">
                        </div>
                        <div>
                            <label class="form-label-custom">Tinggi (cm)</label>
                            <input type="number" name="tinggi_badan" class="form-control-custom"
                                   placeholder="cm" min="1" max="300" step="0.1"
                                   value="{{ old('tinggi_badan', $authUser->tinggi_badan ?? '') }}">
                        </div>
                    </div>

                    <div class="form-row mb-2">
                        <div>
                            <label class="form-label-custom">Umur (tahun)</label>
                            <div class="input-icon-wrap">
                                <i class="ti ti-user-circle"></i>
                                <input type="number" name="umur" class="form-control-custom"
                                       placeholder="Umur" min="1" max="120"
                                       value="{{ old('umur', $authUser->umur ?? '') }}">
                            </div>
                        </div>
                        <div>
                            <label class="form-label-custom">Jenis kelamin</label>
                            @php
                                $currentGender = old('jenis_kelamin', $authUser->jenis_kelamin ?? 'Laki-laki');
                            @endphp
                            <input type="hidden" name="jenis_kelamin" id="genderInput"
                                   value="{{ $currentGender }}">
                            <div class="gender-row">
                                <button class="gender-btn {{ $currentGender === 'Perempuan' ? 'active' : '' }}"
                                        type="button"
                                        onclick="setGender('Perempuan', this)">Wanita</button>
                                <button class="gender-btn {{ $currentGender === 'Laki-laki' ? 'active' : '' }}"
                                        type="button"
                                        onclick="setGender('Laki-laki', this)">Pria</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label-custom">Tujuan nutrisi</label>
                        @php
                            $currentTarget = old('target', $authUser->target ?? 'maintenance');
                            $targets = [
                                'maintenance' => 'Menjaga berat badan',
                                'lose'        => 'Menurunkan berat badan',
                                'gain'        => 'Menaikkan berat badan',
                                'muscle'      => 'Meningkatkan massa otot',
                            ];
                        @endphp
                        <select name="target" class="form-control-custom">
                            @foreach ($targets as $value => $label)
                                <option value="{{ $value }}"
                                    {{ $currentTarget === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn-save">Simpan perubahan</button>
                    <button type="button" class="btn-cancel" data-bs-dismiss="modal">Batal</button>

                </form>
            </div>

        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<script>
    /* ── Gender toggle ── */
    function setGender(value, btn) {
        document.getElementById('genderInput').value = value;
        btn.closest('.gender-row').querySelectorAll('.gender-btn').forEach(el => el.classList.remove('active'));
        btn.classList.add('active');
    }

    /* ── Photo preview ── */
    const photoInput    = document.getElementById('photoInput');
    const previewImg    = document.getElementById('avatarPreviewImg');
    const currentImg    = document.getElementById('avatarCurrentImg');
    const initialSpan   = document.getElementById('avatarInitial');
    const previewStrip  = document.getElementById('previewStrip');
    const stripThumb    = document.getElementById('stripThumb');
    const stripFileName = document.getElementById('stripFileName');
    const photoHint     = document.getElementById('photoHint');

    photoInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        // Validasi ukuran maks 2 MB
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran foto maksimal 2 MB.');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            const src = e.target.result;

            // Tampilkan preview di avatar circle
            previewImg.src = src;
            previewImg.style.display = 'block';

            // Sembunyikan foto lama / inisial
            if (currentImg) currentImg.style.display = 'none';
            if (initialSpan) initialSpan.style.display = 'none';

            // Tampilkan strip info di bawah avatar
            stripThumb.src = src;
            stripFileName.textContent = file.name.length > 24
                ? file.name.substring(0, 21) + '...'
                : file.name;
            previewStrip.classList.add('show');
            photoHint.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });

    /* Reset: batal pilih foto baru */
    function resetPhoto() {
        photoInput.value = '';
        previewImg.src = '';
        previewImg.style.display = 'none';

        if (currentImg) currentImg.style.display = 'block';
        if (initialSpan) initialSpan.style.display = 'block';

        previewStrip.classList.remove('show');
        photoHint.style.display = 'block';
    }

    /* Reset preview setiap kali modal ditutup / dibuka ulang */
    document.getElementById('editProfileModal').addEventListener('hidden.bs.modal', resetPhoto);
</script>