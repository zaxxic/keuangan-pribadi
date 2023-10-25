<div class="header header-one">

    <a href="javascript:void(0);" id="toggle_btn">
        <span class="toggle-bars">
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
            <span class="bar-icons"></span>
        </span>
    </a>

    <a class="mobile_btn" id="mobile_btn">
        <i class="fas fa-bars"></i>

    </a>


    <ul class="nav nav-tabs user-menu">
        <li class="me-2 saldo1">
            <span class="badge badge-soft-info fs-6 ">
                Saldo: Rp {{ number_format(Auth::user()->total(), 0, '', '.') }}
            </span>
        </li>



        <li class="nav-item  has-arrow dropdown-heads ">
            <a class="nav-link" data-bs-toggle="dropdown" href="#" role="button">
                <i class="fe fe-bell"></i>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifikasi</span>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                    </ul>
                </div>
            </div>
        </li>

        <li class="nav-item  has-arrow dropdown-heads ">
            <a href="javascript:void(0);" class="win-maximize">
                <i class="fe fe-maximize"></i>
            </a>
        </li>


        <li class="nav-item dropdown">
            <a href="javascript:void(0)" class="user-link  nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    <img src="{{ asset('storage/profile/' . Auth::user()->image) }}" alt="User Photo"
                        class="profilesidebar">
                    <span class="animate-circle"></span>
                </span>
                <span class="user-content">
                    <span class="user-details">{{ ucfirst(Auth::user()->role) }}</span>
                    <span
                        class="user-name">{{ strlen(Auth::user()->name) > 13 ? substr(Auth::user()->name, 0, 13) . '...' : Auth::user()->name }}</span>
                </span>
            </a>
            <div class="dropdown-menu menu-drop-user">
                <div class="profilemenu">
                    <div class="subscription-menu">
                        <ul>
                            <li>
                                <a href="{{ Route('setting') }}" class="dropdown-item" href="profile.html">Profile</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ Route('subs.index') }}">Upgrade</a>
                            </li>
                        </ul>
                    </div>
                    <div class="subscription-logout">
                        <ul>
                            <li class="pb-0">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">Log
                                    Out</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </li>

    </ul>

</div>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img id="modal-foto" src="" alt="" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <div><strong>Jumlah:</strong> <span id="modal-amount"></span></div>
                            <div class="mt-1"><strong>Judul:</strong> <span id="modal-title"></span></div>
                            <div class="mt-1"><strong>Deskripsi:</strong> <span id="modal-description"></span></div>
                            <div class="mt-1"><strong>Metode pembayaran:</strong> <span
                                    id="modal-payment-method"></span></div>
                            <div class="mt-1"><strong>Kategori :</strong> <span id="modal-category"></span></div>
                            <div class="d-flex justify-content-center mt-5">
                                <button type="button" class="btn me-2 btn-primary paid-cancel-btn"
                                    data-bs-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary paid-continue-btn" id="btn-approve"
                                    data-notification-id="">Setuju</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel">Edit Transaksi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateNotification" enctype="multipart/form-data">
                    <input type="hidden" id="modal-transaction-id" name="id">
                    <div class="mb-3">
                        <label for="modal-judul" class="form-label">Judul:</label>
                        <span id="modal-judul"></span>
                    </div>

                    <div class="mb-3">
                        <label for="modal-amount" class="form-label">Jumlah:</label>
                        <span id="modal-amount"></span>
                    </div>

                    <div class="mb-3">
                        <label for="modal-category" class="form-label">Kategori:</label>
                        <span id="modal-category"></span>
                    </div>
                    <div class="mb-3">
                        <label>Bukti transaksi</label>
                        <img id="modal-foto" src="" alt="" class="img-fluid mx-auto d-block mb-3">
                        <input type="file" id="modal-foto" name="attachment" class="form-control mb-3">
                    </div>
                    <div class="mb-3">
                        <label for="modal-description" class="form-label">Deskripsi:</label>
                        <textarea class="form-control" name="description" id="modal-description" cols="30" rows="5"></textarea>
                    </div>

                    <div class="mb-1">
                        <label for="modal-description" class="form-label">Metode Pembayaran Saat ini:</label>
                        <span id="modal-payment-method"></span>
                        <span>
                    </div>
                    </span>

                    <div class="mb-3">
                        {{-- <input type="text" id="modal-payment-method" name="payment_method"> --}}
                        <select name="payment_method" class="select">
                            <option id="modal-payment-method" name="payment_method" value="">Pilih Metode
                                Pembayaran Baru</option>
                            <option value="Debit">Debit</option>
                            <option value="Cash">Cash</option>
                            <option value="E-Wallet">E-Wallet</option>
                        </select>
                    </div>

                    <input type="hidden" id="modal-transaction-id">
                    <div class="d-flex mt-3">
                        <div class="col-6 me-2">
                            <button id="updateCategoryBtn" type="submit"
                                class="w-100 btn btn-primary paid-continue-btn">Simpan</button>

                            <div id="loadingIndicator" style="display: none;">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <button type="button" data-bs-dismiss="modal"
                                class="w-100 btn btn-primary paid-cancel-btn">Batal</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

