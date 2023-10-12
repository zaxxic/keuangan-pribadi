@extends('layouts1.app')
@section('content')
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="content-page-header">
                <h5>Tambah Pengeluaran</h5>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card-body">
                        <div class="form-group-item border-0 pb-0">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Judul</label>
                                        <input type="text" class="form-control" placeholder="Masukkan judul pemasukan" />
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="row">
                                        <div class="form-group col-12">
                                            <label for="kategori">Kategori</label>
                                            <div class="row gap-1">
                                                <div class="col-9">
                                                    <select class="select" id="kategori">
                                                        <option>Pilih kategori</option>
                                                        <option>Pendidikan</option>
                                                        <option>Kecantikan</option>
                                                        <option>Bayaran</option>
                                                    </select>
                                                </div>
                                                <div class="col-2">
                                                    <button class="btn btn-secondary" data-toggle="modal"
                                                        data-target="#tambahModal">
                                                        +
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Jumlah </label>
                                        <input type="number" class="form-control"
                                            placeholder="Masukkan jumlah pemasukkan" />
                                    </div>
                                </div>

                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Metode Pembeyaran</label>
                                        <select class="select">
                                            <option>Pilih Metode Pembayaran</option>
                                            <option>Cash</option>
                                            <option>Cheque</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Kategori Berulang</label>
                                        <select class="select">
                                            <option>Pilih Kategori Berulang</option>
                                            <option>Paid</option>
                                            <option>Pending</option>
                                            <option>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Status Pembayaran</label>
                                        <select class="select">
                                            <option>Pilih Kategori Berulang</option>
                                            <option>Paid</option>
                                            <option>Pending</option>
                                            <option>Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label>Tanggal</label>
                                        <input type="text" class="form-control datetimepicker"
                                            placeholder="Tanggal Mulai Pembayaran" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-12 description-box">
                                    <div class="form-group" id="summernote_container">
                                        <label class="form-control-label">Deskripsi</label>
                                        <textarea class="summernote form-control" placeholder="Ketikan deskripsi"></textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-lg-6 col-md-12 col-sm-12">
                                    <div class="form-group">
                                        <label>Lampiran</label>
                                        <div class="form-group service-upload mb-0">
                                            <span><img src="{{ asset('assets/img/icons/drop-icon.svg') }}"
                                                    alt="upload" /></span>
                                            <h6 class="drop-browse align-center">
                                                Letakan photo bukti trnasksi 
                                                <span class="text-primary ms-1">disini</span>
                                            </h6>
                                            <p class="text-muted">Ukuran maksimal: 5MB</p>
                                            <input type="file" name="attachment" multiple id="image_sign" />
                                            <div id="frames"></div>
                                        </div>
                                    </div>
                                </div> --}}
                            </div>
                        </div>
                        <div class="text-end">
                            <a href="expenses.html" class="btn btn-primary cancel me-2">Batal</a>
                            <a href="expenses.html" class="btn btn-primary">simpan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
