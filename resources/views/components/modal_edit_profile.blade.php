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

    .btn-save:hover {
        opacity: 0.88;
    }

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

    .btn-cancel:hover {
        background: var(--color-background-secondary);
    }

    .gender-row {
        display: flex;
        gap: 8px;
    }

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
        .form-row {
            grid-template-columns: 1fr;
        }

        .profile-body {
            padding: 1rem;
        }
    }

    .modal-dialog {
        margin: auto;
    }
</style>


<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content profile-modal-content">

            {{-- Header --}}
            <div class="profile-modal-header">
                <button class="btn-close-custom" data-bs-dismiss="modal" aria-label="Tutup">
                    <i class="ti ti-x"></i>
                </button>
                <div style="text-align:center; margin-top: 0.5rem;">
                    <div class="profile-avatar">
                        A
                        <div class="avatar-edit-btn" title="Ganti foto">
                            <i class="ti ti-camera" style="font-size:11px; color:#555;"></i>
                        </div>
                    </div>
                    <p style="color:rgba(255,255,255,0.85); font-size:0.72rem; margin:0;">
                        Ketuk ikon kamera untuk ganti foto
                    </p>
                </div>
            </div>

            {{-- Body --}}
            <div class="profile-body">
                <div class="section-divider">Informasi akun</div>

                <div class="mb-2">
                    <label class="form-label-custom">Nama lengkap</label>
                    <div class="input-icon-wrap">
                        <i class="ti ti-user"></i>
                        <input type="text" class="form-control-custom" placeholder="Nama lengkap"
                            value="Adelia Putri">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label-custom">Email</label>
                    <div class="input-icon-wrap">
                        <i class="ti ti-mail"></i>
                        <input type="email" class="form-control-custom" placeholder="email@contoh.com"
                            value="adelia@gmail.com">
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label-custom">Nomor telepon</label>
                    <div class="input-icon-wrap">
                        <i class="ti ti-phone"></i>
                        <input type="tel" class="form-control-custom" placeholder="+62..."
                            value="+62 812 3456 7890">
                    </div>
                </div>

                <div class="section-divider">Data kesehatan</div>

                <div class="form-row mb-2">
                    <div>
                        <label class="form-label-custom">Berat (kg)</label>
                        <input type="number" class="form-control-custom" placeholder="kg" value="55">
                    </div>
                    <div>
                        <label class="form-label-custom">Tinggi (cm)</label>
                        <input type="number" class="form-control-custom" placeholder="cm" value="162">
                    </div>
                </div>

                <div class="form-row mb-2">
                    <div>
                        <label class="form-label-custom">Tanggal lahir</label>
                        <div class="input-icon-wrap">
                            <i class="ti ti-calendar"></i>
                            <input type="date" class="form-control-custom" value="2000-04-15">
                        </div>
                    </div>
                    <div>
                        <label class="form-label-custom">Jenis kelamin</label>
                        <div class="gender-row">
                            <button class="gender-btn active" type="button"
                                onclick="this.classList.add('active'); this.nextElementSibling.classList.remove('active')">Wanita</button>
                            <button class="gender-btn" type="button"
                                onclick="this.classList.add('active'); this.previousElementSibling.classList.remove('active')">Pria</button>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <label class="form-label-custom">Tujuan nutrisi</label>
                    <select class="form-control-custom">
                        <option>Menjaga berat badan</option>
                        <option>Menurunkan berat badan</option>
                        <option>Menaikkan berat badan</option>
                        <option>Meningkatkan massa otot</option>
                    </select>
                </div>

                <button class="btn-save">Simpan perubahan</button>
                <button class="btn-cancel" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">