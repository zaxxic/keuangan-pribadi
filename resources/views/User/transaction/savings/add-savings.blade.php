@extends('layouts1.app')
@section('content')
    <script>
        function addInput() {
            var container = document.getElementById("inputContainer");
            var inputGroup = document.createElement("div");
            inputGroup.className = "input-group mb-3";

            var input = document.createElement("input");
            input.type = "email";
            input.className = "form-control";
            input.placeholder = "Masukkan email teman Anda";

            // Mengganti nama input dengan array yang dinamis
            var inputName = "dynamicInput[" + (container.children.length + 1) + "]";
            input.name = inputName;

            var inputGroupAppend = document.createElement("div");
            inputGroupAppend.className = "input-group-append";

            var removeButton = document.createElement("button");
            removeButton.type = "button";
            removeButton.className = "btn btn-danger btn-sm";
            removeButton.textContent = "Hapus";
            removeButton.addEventListener("click", function() {
                container.removeChild(inputGroup);
            });

            inputGroupAppend.appendChild(removeButton);
            inputGroup.appendChild(input);
            inputGroup.appendChild(inputGroupAppend);

            container.appendChild(inputGroup);
        }
    </script>
    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="page-header">
                <div class="content-page-header">
                    <h5>Add Customers</h5>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <form action="#">
                        <div class="card-body">
                            <div class="form-group-item">
                                <h5 class="form-title">Pilih foto untuk card</h5>
                                <input  checked type="radio" id="photo1" name="selectedPhoto" value="photo1">
                                <label for="photo1"><img src="{{ asset('assets/img/Savings1.png') }}" width="190px"
                                        alt="Photo 1"></label>

                                <input type="radio" id="photo2" name="selectedPhoto" value="photo2">
                                <label for="photo2"><img src="{{ asset('assets/img/savings2.png') }}" width="190px"
                                        alt="Photo 2"></label>

                                <input type="radio" id="photo3" name="selectedPhoto" value="photo3">
                                <label for="photo3"><img src="{{ asset('assets/img/savings3.png') }}" width="190px"
                                        alt="Photo 3"></label>

                                <input type="radio" id="photo4" name="selectedPhoto" value="photo4">
                                <label for="photo4"><img src="{{ asset('assets/img/savings4.png') }}" width="190px"
                                        alt="Photo 4"></label>

                                <input type="radio" id="photo5" name="selectedPhoto" value="photo5">
                                <label for="photo5"><img src="{{ asset('assets/img/savings5.png') }}" width="190px"
                                        alt="Photo 5"></label>
                            </div>

                            <div class="form-group-item">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="billing-btn mb-2">
                                            <h5 class="form-title">Billing Address</h5>
                                        </div>
                                        <div class="form-group">
                                            <label>Jumlah uang</label>
                                            <input type="number" class="form-control" placeholder="Jumlah tabungan" />

                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Metode Pembeyaran</label>
                                                <select name="payment_method" class="select">
                                                    <option value="">Pilih Metode Pembayaran</option>
                                                    <option value="Debit">Debit</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="E-Wallet">E-Wallet</option>
                                                </select>
                                                <span id="payment_method-error" class="text-danger"></span>

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="form-group">
                                                <label>Jenis metode</label>
                                                <select name="recurring" class="select">
                                                    <option value="once">sekali</option>
                                                    <option value="week">Mingguan</option>
                                                    <option value="month">Bulanan</option>
                                                    <option value="year">Tahunan</option>
                                                </select>
                                                <span id="recurring-error" class="text-danger"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="billing-btn">
                                            <h5 class="form-title mb-0">Shipping Address</h5>
                                            <a href="#" class="btn btn-primary">Copy from Billing</a>
                                        </div>
                                        <div class="form-group">
                                            <label>Tanggal mulai transaksi</label>
                                            <input type="date" name="date" class="form-control"
                                                placeholder="Tanggal Mulai Pembayaran"
                                                min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" />
                                        </div>
                                        <div class="form-group">
                                            <label>Email yang anda ingin ajak ( Untuk tabungan bersama ) </label>
                                            <div id="inputContainer">
                                                <!-- Input dinamis akan ditambahkan di sini -->
                                            </div>
                                            <button type="button" class="btn btn-primary btn-sm"
                                                onclick="addInput()">Tambah
                                                Input</button>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="add-customer-btns text-end">
                                <a href="customers.html" class="btn customer-btn-cancel">Cancel</a>
                                <a href="customers.html" class="btn customer-btn-save">Save Changes</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
