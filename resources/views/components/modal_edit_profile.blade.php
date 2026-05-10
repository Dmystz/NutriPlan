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
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 0.6rem;
        font-size: 1.5rem;
        font-weight: 700;
        color: #fff;
        border: 3px solid rgba(255, 255, 255, 0.6);
        position: relative;
        overflow: hidden;
    }

    .profile-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
    }

    .avatar-edit-btn {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 22px;
        height: 22px;
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1.5px solid #ddd;
        overflow: visible;
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

    .input-icon-wrap {
        position: relative;
    }

    .input-icon-wrap i {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 15px;
        color: var(--color-text-secondary);
    }

    .input-icon-wrap .form-control-custom {
        padding-left: 2rem;
    }

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
    /*
     * Ambil data user dari database berdasarkan session user_id.
     * Kolom tabel users: id, name, email, jenis_kelamin, target,
     *   activity_level, umur, berat_badan, tinggi_badan, photo
     */
    $authUser = \Illuminate\Support\Facades\DB::table('users')
                    ->where('id', session('user_id'))
                    ->first();
@endphp

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">

            {{-- ── Header ─────────────────────────────────────────── --}}
            <div class="profile-modal-header">
                <button class="btn-close-custom" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="ti ti-x"></i>
                </button>
                <div style="text-align:center; margin-top:0.5rem;">
                    <div class="profile-avatar">
                        @if (!empty($authUser->photo))
                            <img src="{{ asset('storage/' . $authUser->photo) }}"
                                 alt="Foto {{ $authUser->name ?? '' }}">
                        @else
                            {{ strtoupper(substr($authUser->name ?? 'U', 0, 1)) }}
                        @endif
                        {{-- Tombol ganti foto: klik → trigger input file tersembunyi --}}
                        <div class="avatar-edit-btn" title="Ganti foto"
                             onclick="document.getElementById('photoInput').click()">
                            <i class="ti ti-camera" style="font-size:11px; color:#555;"></i>
                        </div>
                    </div>
                    <p style="color:rgba(255,255,255,0.85); font-size:0.72rem; margin:0;">
                        Ketuk ikon kamera untuk ganti foto
                    </p>
                </div>
            </div>

            {{-- ── Body ────────────────────────────────────────────── --}}
            <div class="profile-body">
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Input file foto — tersembunyi --}}
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
    function setGender(value, btn) {
        document.getElementById('genderInput').value = value;
        btn.closest('.gender-row').querySelectorAll('.gender-btn').forEach(function (el) {
            el.classList.remove('active');
        });
        btn.classList.add('active');
    }
</script>