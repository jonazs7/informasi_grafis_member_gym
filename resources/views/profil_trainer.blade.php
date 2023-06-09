<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  @include('structure/asset')
</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  @include('structure/header')
  <!-- end Main Header -->

  <!-- Left side column. contains the logo and sidebar -->
  @include('structure/sidebar_trainer')
  <!-- end Left side column. contains the logo and sidebar -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profil
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
        <li class="active">Here</li>
      </ol>
      @if(session('success'))
      <div class="alert alert-success alert-dismissible" style="margin-top: 8px">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <h4><i class="icon fa fa-check"></i> Berhasil !</h4>
        {{ session('success') }}
      </div>
      @endif
    </section>

    <!-- Main content -->
    <section class="content container-fluid">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">Ubah Profil</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form class="form-horizontal" action="{{ route('updateProfil') }}" method="POST" enctype='multipart/form-data'>
                  @csrf
                  <div class="box-body" style="margin-top: 2%; margin-left: -5%;">
                    <div class="form-group">
                      <label class="control-label col-sm-2">Nama Lengkap :</label>
                      <div class="col-sm-3">
                        <input type="text" name="nama_lengkap" value="{{ $pengguna->name }}" maxlength="45" class="form-control">
                      </div>
                    </div>
                    {{-- <div class="form-group">
                      <label class="control-label col-sm-2">Tanggal Lahir :</label>
                      <div class="col-sm-2">
                        <div class="input-group">                       
                            <div class="input-group-addon">
                              <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" name="tanggal_lahir" value="{{ $pengguna->tgl_lahir }}" class="form-control" 
                            data-inputmask="'alias': 'yyyy/mm/dd'" data-mask>
                        </div>
                      </div>
                    </div> --}}
                    {{-- <div class="form-group">
                      <label class="control-label col-sm-2">Gender :</label>
                      <div class="col-sm-5">
                        <div class="radio">
                            <label>
                              <input type="radio" name="option_gender" value="Pria" {{ old('option', $pengguna->gender) == 'Pria' ? 'checked' : '' }}> Pria
                            </label>
                            <label style="margin-left: 12px">
                              <input type="radio" name="option_gender" value="Wanita" {{ old('option', $pengguna->gender) == 'Wanita' ? 'checked' : '' }}> Wanita
                            </label>
                        </div>
                      </div>
                    </div> --}}
                    <div class="form-group">
                      <div>
                        <label class="control-label col-sm-2">No Telepon :</label>
                        <div class="col-sm-2">
                          <input type="text" name="no_telepon" id="telephone" value="{{ $pengguna->tlpn }}" 
                          class="form-control" oninput="formatTelephone()" maxlength="14" >
                        </div>
                      </div>
                      {{-- <p class="help-block">Contoh: 08xx-xxxx-xxxx</p> --}}
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-2">Alamat :</label>
                      <div class="col-sm-4">
                        <input type="text" name="alamat" value="{{ $pengguna->alamat }}" maxlength="39" class="form-control">
                      </div>
                      {{-- <textarea class="form-control" name="alamat" rows="3" placeholder="Enter ..." style="width: 25%; text-align: left padding: 0;">
                        {{ trim($pengguna->alamat) }}
                      </textarea> --}}
                      {{-- <div contenteditable="true" name="alamat" style="width: 300px; height: 150px; border: 1px solid #ccc; overflow: auto; padding:8px 8px 8px 8px;">
                        {{ trim($pengguna->alamat) }}
                      </div> --}}
                    </div>
                    {{-- <div class="form-group">
                      <label class="control-label col-sm-2">Kidal :</label>
                      <div class="col-sm-5">
                        <div class="radio">
                            <label>
                              <input type="radio" name="option_kidal" value="Ya" {{ old('option', $pengguna->kidal) == 'Ya' ? 'checked' : '' }}> Ya
                            </label>
                            <label style="margin-left: 12px">
                              <input type="radio" name="option_kidal" value="Tidak" {{ old('option', $pengguna->kidal) == 'Tidak' ? 'checked' : '' }}> Tidak
                            </label>
                        </div>
                      </div>
                    </div> --}}
                    {{-- <div class="form-group" style="width: 10%">
                      <label>Kidal</label>
                      <select class="form-control" name="kidal">
                        <option value="Tidak" <?php if($pengguna->kidal == 'Tidak') echo 'selected'; ?>>Tidak</option>
                        <option value="Ya" <?php if($pengguna->kidal == 'Ya') echo 'selected'; ?>>Ya</option>
                      </select>
                    </div> --}}
                    <div class="form-group">
                      <label class="control-label col-sm-2">Lama pengalaman :</label>
                      <div class="col-sm-2">
                        <select class="form-control" name="lama_pengalaman" value="{{ $pengguna->lama_pnglmn }}">
                          <option value="Belum pernah" <?php if($pengguna->lama_pnglmn == 'Belum pernah') echo 'selected'; ?>>Belum pernah</option>
                          <option value="< 3 Bulan" <?php if($pengguna->lama_pnglmn == '< 3 Bulan') echo 'selected'; ?>>< 3 Bulan</option>
                          <option value="> 3 Bulan" <?php if($pengguna->lama_pnglmn == '> 3 Bulan') echo 'selected'; ?>>> 3 Bulan</option>
                        </select>
                      </div>
                    </div>
                    {{-- <div class="form-group">
                      <label>Goal</label>
                      <select class="form-control" style="width: 25%" name="goal">
                        <option value="Increase muscle size" <?php if($pengguna->goal == 'Increase muscle size') echo 'selected'; ?>>Increase muscle size</option>
                        <option value="Lose body fat" <?php if($pengguna->goal == 'Lose body fat') echo 'selected'; ?>>Lose body fat</option>
                        <option value="Sport spesific training" <?php if($pengguna->goal == 'Sport spesific training') echo 'selected'; ?>>Sport spesific training</option>
                        <option value="Rehabilitate an injury" <?php if($pengguna->goal == 'Rehabilitate an injury') echo 'selected'; ?>>Rehabilitate an injury</option>
                        <option value="Nutrition education" <?php if($pengguna->goal == 'Nutrition education') echo 'selected'; ?>>Nutrition education</option>
                        <option value="Start an work out train" <?php if($pengguna->goal == 'Start an work out train') echo 'selected'; ?>>Start an work out train</option>
                        <option value="Fan" <?php if($pengguna->goal == 'Fan') echo 'selected'; ?>>Fan</option>
                        <option value="Motivation" <?php if($pengguna->goal == 'Motivation') echo 'selected'; ?>>Motivation</option>
                        <option value="Lainnya" <?php if($pengguna->goal == 'Lainnya') echo 'selected'; ?>>Lainnya</option>
                      </select>
                    </div> --}}
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <img src="{{ asset('images/' . $imageName) }}" style="width: 6%; height: 6%; margin-top: 8px">
                        <p class="help-block">Anda dapat unggah foto profil anda.</p>
                        <label>File Foto</label>
                        <input type="file" name="gambar">   
                      </div>
                    </div>      
                  </div>
                    <!-- box-footer -->
                    <div class="box-footer">
                      <button type="submit" class="btn btn-block btn-primary">Simpan</button>
                    </div>
                    <!-- /.box-footer -->
                </form>
                <!-- end form start -->
            </div>
            <!-- /.col-lg-6 -->
        </div>
        <!-- /.row -->
    
        
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  @include('structure/footer')
  <!-- end Main Footer -->

</div>
<!-- ./wrapper -->

</body>
</html>


<script>
  function formatTelephone() {
    var telephoneInput = document.getElementById('telephone');
    var input = telephoneInput.value.replace(/\D/g, ''); // Hapus semua karakter non-digit. 
    // Ekspresi reguler /\D/g mencocokkan semua karakter yang bukan digit dan '' adalah string kosong 
    // yang digunakan untuk menghapus karakter-karakter tersebut.
  
    // Tambahkan garis setiap empat angka
    var formattedInput = '';  // sebagai string kosong yang akan berisi nilai input yang telah diformat.
    for (var i = 0; i < input.length; i++) {
      if (i > 0 && i % 4 === 0) {
        formattedInput += '-';
      }
      formattedInput += input[i]; // kita menambahkan karakter saat ini ke dalam formattedInput.
      // Dalam setiap iterasi loop for, input[i] adalah karakter saat ini yang sedang diproses dalam masukan telepon. 
      // Operator += digunakan untuk menggabungkan karakter tersebut dengan nilai yang sudah ada dalam formattedInput. 
      // Dengan demikian, pada setiap iterasi, karakter saat ini akan ditambahkan ke akhir nilai yang sudah ada dalam 
      // formattedInput.
      // Misalnya, jika formattedInput saat ini adalah '123' dan input[i] adalah '4', maka operasi formattedInput += 
      // input[i]; akan menghasilkan formattedInput menjadi '1234'. Hal ini memungkinkan kita untuk membangun nilai 
      // yang sudah diformat langkah demi langkah selama loop berlangsung.
    }
    telephoneInput.value = formattedInput; // input telepon yang ditampilkan akan diformat dengan garis setiap empat angka.
  }
  </script>