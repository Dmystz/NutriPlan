<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Complete Profile - NutriPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "SF Pro Display", -apple-system, sans-serif;
            background: linear-gradient(to top right, #ffd8df, #f0ffdf);
        }
        html, body { min-height: 100vh; overflow-x: hidden; }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card-auth {
            width: 100%;
            max-width: 440px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            background: rgba(255,255,255,0.92);
            backdrop-filter: blur(12px);
            padding: 2rem 2.5rem;
            animation: slideUp 0.5s ease;
            border: none;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .nutri { color: #95cd41; font-weight: bold; }
        .plan  { color: #ea5c2b; font-weight: bold; }

        .logo-block {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 0.25rem;
        }
        .logo-img   { width: 40px; height: 40px; object-fit: contain; }
        .brand-name { font-size: 1.6rem; }

        .form-control, .form-select {
            border-radius: 50px !important;
            padding: 0.5rem 1.1rem;
            font-size: 0.9rem;
            border: 1.5px solid #E5E7EB;
            background: rgba(149, 205, 65, 0.07);
        }
        .form-control:focus, .form-select:focus {
            box-shadow: 0 0 0 0.2rem rgba(149, 205, 65, .35);
            border-color: #95cd41;
        }

        .btn-ijo {
            background-color: #95cd41;
            color: white;
            border-radius: 50px;
            padding: 0.6rem;
            font-size: 1rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(149, 205, 65, 0.35);
            border: none;
        }
        .btn-ijo:hover {
            background-color: #6e9c29;
            color: white;
            transform: translateY(-1px);
        }

        @media (max-width: 480px) {
            .card-auth { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>
<body>
<div class="page-wrapper">
    <div class="card card-auth">

        <div class="logo-block">
            <img src="{{ asset('img/logo.png') }}" alt="NutriPlan Logo" class="logo-img">
            <span class="brand-name">
                <span class="nutri">Nutri</span><span class="plan">Plan</span>
            </span>
        </div>

        <h4 class="text-center fw-bold mt-2" style="color:#ea5c2b;">Lengkapi Profilmu</h4>
        <p class="text-center mb-3" style="color:#6B7280; font-size:0.88rem;">
            Isi data berikut agar NutriPlan bisa menghitung kebutuhan nutrisimu secara akurat.
        </p>

        @if (session('info'))
            <div class="alert alert-info py-2">{{ session('info') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.complete.store') }}">
            @csrf

            <div class="mb-2">
                <label class="form-label fw-semibold">Umur</label>
                <input type="number" name="umur"
                    class="form-control @error('umur') is-invalid @enderror"
                    placeholder="Contoh: 21"
                    value="{{ old('umur') }}" required>
                @error('umur')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-2">
                <div class="col-6">
                    <label class="form-label fw-semibold">Berat (kg)</label>
                    <input type="number" name="berat_badan"
                        class="form-control @error('berat_badan') is-invalid @enderror"
                        placeholder="60"
                        value="{{ old('berat_badan') }}" required>
                    @error('berat_badan')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-6">
                    <label class="form-label fw-semibold">Tinggi (cm)</label>
                    <input type="number" name="tinggi_badan"
                        class="form-control @error('tinggi_badan') is-invalid @enderror"
                        placeholder="170"
                        value="{{ old('tinggi_badan') }}" required>
                    @error('tinggi_badan')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold">Jenis Kelamin</label>
                <select name="jenis_kelamin"
                    class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih jenis kelamin</option>
                    <option value="Laki-laki"  {{ old('jenis_kelamin') == 'Laki-laki'  ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan"  {{ old('jenis_kelamin') == 'Perempuan'  ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-2">
                <label class="form-label fw-semibold">Target</label>
                <select name="target"
                    class="form-select @error('target') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih target</option>
                    <option value="loss"        {{ old('target') == 'loss'        ? 'selected' : '' }}>Turun Berat Badan</option>
                    <option value="maintenance" {{ old('target') == 'maintenance' ? 'selected' : '' }}>Jaga Berat Badan</option>
                    <option value="gain"        {{ old('target') == 'gain'        ? 'selected' : '' }}>Naik Berat Badan</option>
                </select>
                @error('target')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-semibold">Level Aktivitas</label>
                <select name="activity_level"
                    class="form-select @error('activity_level') is-invalid @enderror" required>
                    <option value="" disabled selected>Pilih level aktivitas</option>
                    <option value="1.2"   {{ old('activity_level') == '1.2'   ? 'selected' : '' }}>Sedentary (jarang olahraga)</option>
                    <option value="1.375" {{ old('activity_level') == '1.375' ? 'selected' : '' }}>Lightly Active (1–3x/minggu)</option>
                    <option value="1.55"  {{ old('activity_level') == '1.55'  ? 'selected' : '' }}>Moderately Active (3–5x/minggu)</option>
                    <option value="1.725" {{ old('activity_level') == '1.725' ? 'selected' : '' }}>Very Active (6–7x/minggu)</option>
                    <option value="1.9"   {{ old('activity_level') == '1.9'   ? 'selected' : '' }}>Extra Active (atlet/kerja berat)</option>
                </select>
                @error('activity_level')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-ijo w-100 fw-bold">Simpan & Lanjutkan</button>
        </form>

    </div>
</div>
</body>
</html>