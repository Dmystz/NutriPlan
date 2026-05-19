@if($recommendedRecipe)

<div class="d-flex text-center w-100 flex-column align-items-center">

    <div class="px-2 m-0 d-flex justify-content-center w-100">
        <img
            src="{{ $recommendedRecipe->image_url }}"
            alt="{{ $recommendedRecipe->nama_makanan }}"
            class="gambar-rekomendasi p-0 m-0"
        >
    </div>

    <h6 class="fw-bold px-2">
        {{ $recommendedRecipe->nama_makanan }}
    </h6>

</div>

@else

<p class="text-muted">No recommendation available</p>

@endif