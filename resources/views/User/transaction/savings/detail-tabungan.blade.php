@extends('layouts1.app')

@section('content')
<div class="page-wrapper">
  <div class="content container-fluid">

    <div class="page-header">
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <div class="card">
            <div class="card-body">
              <div class="row align-center mb-4">
                <div class="col">
                  <h5 class="card-title">Tabunganku</h5>
                </div>
                <div class="col-auto">
                  <a href="invoices.html" class="btn-right btn btn-sm btn-outline-primary"> Edit </a>
                  <a href="invoices.html" class="btn-right btn btn-sm btn-outline-danger"> Keluar </a>
                </div>
              </div>
              <div class="dash-widget-header mb-4">
                <span class="dash-widget-icon bg-1">
                  <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="dash-count" style="width: 60%">
                  <div class="dash-counts">
                    <p>Rp 1.642 / 2.000.000</p>
                  </div>
                  <div class="progress progress-sm mt-3">
                    <div class="progress-bar bg-5" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
              <ul class="nav nav-tabs">
                <li class="nav-item">
                  <a href="#deskripsi" data-bs-toggle="tab" aria-expanded="false" class="nav-link active"> Deskripsi </a>
                </li>
                <li class="nav-item">
                  <a href="#anggota" data-bs-toggle="tab" aria-expanded="true" class="nav-link"> Anggota </a>
                </li>
              </ul>
              <div class="tab-content">
                <div class="tab-pane show active" id="deskripsi">
                  <p>Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.</p>
                  <p class="mb-0">Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.Lorem ipsum is placeholder text commonly used in the graphic, print, and publishing industries for previewing layouts and visual mockups.</p>
                </div>
                <div class="tab-pane" id="anggota">
                  <div id="accordion">
                    <div class="mb-4">
                      <div id="headingOne">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="true">
                              <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image" />
                              Barbara Moore
                            </a>
                            <p class="text-muted text-small">
                              Rp. 100.000
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bukti</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleSatu tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleSatu tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleSatu" aria-expanded="false" aria-controls="collapseExampleSatu">Show more...</button>
                            <a href="#" class="btn btn-danger">Kick</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mb-4">
                      <div id="headingTwo">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapseTwo" aria-expanded="true">
                              <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image" />
                              Barbara Moore
                            </a>
                            <p class="text-muted text-small">
                              Rp. 100.000
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bukti</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleDua tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleDua tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleDua" aria-expanded="false" aria-controls="collapseExampleDua">Show more...</button>
                            <a href="#" class="btn btn-danger">Kick</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mb-4">
                      <div id="headingThree">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapseThree" aria-expanded="true">
                              <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image" />
                              Barbara Moore
                            </a>
                            <p class="text-muted text-small">
                              Rp. 100.000
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bukti</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleTiga tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleTiga tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleTiga" aria-expanded="false" aria-controls="collapseExampleTiga">Show more...</button>
                            <a href="#" class="btn btn-danger">Kick</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="mb-4">
                      <div id="headingFour">
                        <h6 class="accordion-faq m-0">
                          <div class="d-flex justify-content-between">
                            <a class="text-dark buttonRowCollapse" data-bs-toggle="collapse" href="#collapseFour" aria-expanded="true">
                              <img class="avatar avatar-sm me-2 avatar-img rounded-circle" src="assets/img/profiles/avatar-04.jpg" alt="User Image" />
                              Barbara Moore
                            </a>
                            <p class="text-muted text-small">
                              Rp. 100.000
                            </p>
                          </div>
                        </h6>
                      </div>
                      <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-bs-parent="#accordion">
                        <div class="card-body">
                          <table class="table table-stripped table-hover mb-3">
                            <thead class="thead-light">
                              <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Bukti</th>
                                <th>Status</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr>
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleEmpat tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                              <tr class="collapse collapseExampleEmpat tableRowCollapse">
                                <td>23 Nov 2020</td>
                                <td>Rp 12.000</td>
                                <td>
                                  <button class="btn btn-primary" data-bs-target="#modalImage" data-bs-toggle="modal">Lihat</button>
                                </td>
                                <td><span class="badge bg-success-light">Dibayar</span></td>
                              </tr>
                            </tbody>
                          </table>
                          <div class="d-flex justify-content-between">
                            <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target=".collapseExampleEmpat" aria-expanded="false" aria-controls="collapseExampleEmpat">Show more...</button>
                            <a href="#" class="btn btn-danger">Kick</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 col-sm-4">
          <div class="card">
            <div class="card-header">
              <div class="card-title">Pie Chart</div>
            </div>
            <div class="card-body">
              <div class="chartjs-wrapper-demo">
                <canvas id="chartDonut" class="h-300"></canvas>
              </div>
            </div>
          </div>
          <div>
            <a href="#" class="btn btn-primary" style="width: 100%">Kembali</a>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

<div class="modal fade" id="modalImage" tabindex="-1" aria-labelledby="modalImageLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalImageLabel">Gambar Attachment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <img style="width: 100%" id="attachmentImage" src="{{ asset('assets/img/product-list-img-2.jpg') }}" alt="Attachment" data-filename="">
      </div>
    </div>
  </div>
</div>


@endsection

@section('script')
<script src="assets/plugins/chartjs/chart.min.js"></script>
<script src="assets/plugins/chartjs/chart-data.js"></script>
<script>
  $(function(){
    $("#accordion").on("click", function(e){
      if($(e.target).hasClass("buttonRowCollapse")){
        if($(".tableRowCollapse").hasClass("show"));
        $(".tableRowCollapse").removeClass("show");
      }
    });
  });
</script>
@endsection