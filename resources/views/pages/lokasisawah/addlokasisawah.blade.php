@extends('layouts.mother')

@section('container')

<div class="card-header">
    <a href="/viewlokasisawah" class="btn btn-sm btn-outline-secondary mt-1">
        <i class="menu-icon mdi mdi-arrow-left"></i>
    </a>

    <h5 class="card-title mt-3">Form Tambah Data Lokasi Sawah</h5>
    <p class="mt-1">Formulir ini bertujuan untuk mengumpulkan data lokasi sawah pertanian bawang merah yang dimiliki oleh Bapak/Ibu. Silakan melengkapi formulir di bawah ini agar sistem kami dapat memberikan rekomendasi terbaik untuk kegiatan pertanian Bapak/Ibu.</p>
</div>

<form action="/storelokasisawah" method="POST">
    @csrf
    <div class="form-group mt-3">
        <label for="lokasisawah_latitude">Latitude</label>
        <input type="number" name="lokasisawah_latitude" class="form-control form-control-lg" id="lokasisawah_latitude">
    </div>

    <div class="form-group">
        <label for="lokasisawah_longitude">Longitude</label>
        <input type="number" name="lokasisawah_longitude" class="form-control form-control-lg" id="lokasisawah_longitude">
    </div>

    <div class="form-group">
        <label for="kabupaten_id">Kabupaten *</label>
        <select class="form-control form-control-lg @error('kabupaten_id') is-invalid @enderror" name="kabupaten_id" id="kabupaten_id">
            <option selected disabled>--- pilih Kabupaten ---</option>
            @foreach ($kabupatens as $kabupaten)
                <option value="{{ $kabupaten->id }}">{{ $kabupaten->kabupaten_nama }}</option>
            @endforeach
        </select>
        @error('kabupaten_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label for="lokasisawah_keterangan">Alamat Lokasi Sawah</label>
        <textarea class="form-control form-control-lg" name="lokasisawah_keterangan" id="lokasisawah_keterangan" rows="3"></textarea>
    </div>

    <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-success me-3">Submit</button>
        <button type="reset" class="btn btn-danger">Cancel</button>
    </div>
</form>

@endsection