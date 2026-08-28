<style>
  #btn-create {
    position: fixed;
    bottom: 12%;
    right: 10px;
    z-index: 99;
    font-size: 18px;
    border: none;
    outline: none;
    background-color: #4A89DC;
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 4px;
  }

  #btn-create:hover {
    background-color: #555;
  }


  .color-black {
    color: #000 !important;
  }
</style>
<div id="page">
  <?php include APPPATH . '/views/mobile/v_nav.php' ?>
  <div class="page-content">
    <div class="content mt-0 mb-3">
      <div class="search-box shadow-xl border-0 bg-theme rounded-sm bottom-0">
        <form action="" method="get">
          <i class="fa fa-search"></i>
          <input type="text" class="border-0" placeholder="Fill in the project name you want to search." id="search" name="search" value="<?= strtolower($this->input->get('search') ?? '') ?>">
        </form>
      </div>
    </div>

    <?php
    $seg_2 = $this->uri->segment(2);
    if ($seg_2 != 'task_closed') {
    ?>
      <div class="w-100 d-flex flex-wrap justify-content-center align-items-center gap-2 p-3" style="display: flex !important; float: none; clear: both;">

        <a href="<?= base_url('mobile/task/' . $seg_2) ?>" class="btn <?= empty($current_filter) ? 'btn-secondary' : 'btn-outline-secondary color-black' ?> rounded-pill">All
          <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_all ?></span>
        </a>

        <a href="<?= base_url('mobile/task/' . $seg_2 . '/progress') ?>" class="btn <?= ($current_filter == 'progress') ? 'btn-secondary' : 'btn-outline-secondary color-black' ?> rounded-pill">Progress
          <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_progress ?></span>
        </a>

        <a href="<?= base_url('mobile/task/' . $seg_2 . '/hold') ?>" class="btn <?= ($current_filter == 'hold') ? 'btn-secondary' : 'btn-outline-secondary color-black' ?> rounded-pill">Hold
          <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_hold ?></span>
        </a>

        <a href="<?= base_url('mobile/task/' . $seg_2 . '/overdue') ?>" class="btn <?= ($current_filter == 'overdue') ? 'btn-danger' : 'btn-outline-danger color-black' ?> rounded-pill">Overdue
          <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_overdue ?></span>
        </a>

        <!-- <a href="<?= base_url('mobile/task/' . $seg_2 . '/closed') ?>" class="btn <?= ($current_filter == 'closed') ? 'btn-dark' : 'btn-outline-dark color-black' ?> rounded-pill">Closed
        <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_closed ?></span>
      </a> -->

      </div>
    <?php
    }
    ?>
    <?php
    //Jika terdapat data task
    if ($task) {
      foreach ($task as $value) {
        $nip = $this->session->userdata('nip');
        $cek_detail = $this->db->get_where('task_detail', ['id_task' => $value->id])->result();
        $cek_num = $this->db->get_where('task_detail', ['id_task' => $value->id])->num_rows();
        if ($cek_num == true) {
          foreach ($cek_detail as $k) {
            if ($k->due_date > date('Y-m-d')) {
              $cek_task = 1;
            } else {
              $cek_task = 0;
            }
          }
        } else {
          $cek_task = 0;
        }
    ?>
        <div class="card card-style">
          <div class="content">
            <div class="text-end">
              <?php if ($value->pic == $this->session->userdata('nip')) { ?>
                <a href="<?= base_url('mobile/task/create_task/' . $value->id) ?>" class="badge gradient-green" style="background-color: black;color:white;"><i class="fa fa-pencil"></i> Update</a>
              <?php } ?>
              <?php
              // if ($value->activity == '1' && $cek_task == 1) {
              if ($value->activity == '1') {
                // echo "<span class='badge gradient-dark color-white'>Open</span>";
              } else if ($value->activity == '3') {
                echo "<span class='badge gradient-dark color-white'>Closed</span>";
              } else if ($value->activity == '2') {
                echo "<span class='badge gradient-dark color-white'>Hold On</span>";
              } else {
                echo "<span class='badge gradient-red color-white'>Over Due</span>";
              }
              ?>
              <?= preg_match("/$nip/i", $value->read ?? "") ? "" : "<span class='badge gradient-yellow color-white'>New</span>"; ?>
            </div>


            <?php

            $cek_card = $this->db->get_where('task_detail', ['id_task' => $value->id])->num_rows();

            if ($cek_card > 0) {
            ?>
              <div class="d-flex">
                <div class="flex-grow-1">
                  <p class="mb-n1" style="font-weight: bolder; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/task_view/' . $value->id) ?>'"><?= $value->name ?></p>
                </div>
              </div>
              <div class="text-start">
                <p class="mb-0 my-2" style="font-weight: <?= preg_match("/$nip/i", $value->read) ? '' : 'bolder' ?>; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/task_view/' . $value->id) ?>'">
                  <?php
                  $pic = $this->db->get_where('users', ['nip' => $value->pic])->row_array();

                  $nama_pic = $pic['nama'] ?? 'SOMEONE';
                  ?>
                  PIC : <?= $nama_pic ?>
                <p class="font-10 mb-0 opacity-80"><?= date('d/m/y', strtotime($value->date_created)) ?></p>
                <?php
                $today = date('Y-m-d');

                // 1. Hitung yang OVERDUE
                // Kriteria: activity = 1 (masih aktif) DAN due_date sudah terlewati (< hari ini)
                $this->db->from('task_detail');
                $this->db->where('id_task', $value->id);
                $this->db->where('activity', 1);
                $this->db->where('due_date <=', $today);
                $count_overdue = $this->db->get()->num_rows();

                // 2. Hitung yang PROGRESS (On Progress)
                // Kriteria: activity = 1 (masih aktif) DAN due_date belum terlewati (>= hari ini)
                $this->db->from('task_detail');
                $this->db->where('id_task', $value->id);
                $this->db->where('activity', 1);
                $this->db->where('due_date >', $today);
                $count_progress = $this->db->get()->num_rows();

                // 3. Hitung yang CLOSED
                // Kriteria: activity != 1 (sudah tidak aktif / selesai)
                $this->db->from('task_detail');
                $this->db->where('id_task', $value->id);
                $this->db->where('activity', 3); // atau sesuaikan jika menggunakan '0'
                $count_closed = $this->db->get()->num_rows();

                // 3. Hitung yang CLOSED
                // Kriteria: activity != 1 (sudah tidak aktif / selesai)
                $this->db->from('task_detail');
                $this->db->where('id_task', $value->id);
                $this->db->where('activity', 2); // atau sesuaikan jika menggunakan '0'
                $count_hold = $this->db->get()->num_rows();
                ?>

                <span class='badge gradient-dark color-white'>Progress : <?= $count_progress ?></span>
                <span class='badge gradient-dark color-white'>Hold : <?= $count_hold ?></span>
                <span class='badge gradient-<?= $count_overdue > 0 ? 'red' : 'dark' ?> color-white'>Overdue : <?= $count_overdue ?></span>
                <span class='badge gradient-dark color-white'>Closed : <?= $count_closed ?></span>

              </div>
            <?php
            } else {
            ?>
              <div class="d-flex">
                <div class="flex-grow-1">
                  <p class="mb-n1" style="font-weight: bolder; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/detail_task/' . $value->id) ?>'"><?= $value->name ?></p>
                </div>
              </div>
              <div class="text-start">
                <p class="mb-0 my-2" style="font-weight: <?= preg_match("/$nip/i", $value->read ?? "") ? '' : 'bolder' ?>; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/detail_task/' . $value->id) ?>'">
                  <?php
                  $pic = $this->db->get_where('users', ['nip' => $value->pic])->row_array();

                  $nama_pic = $pic['nama'] ?? 'SOMEONE';
                  ?>
                  PIC : <?= $nama_pic ?>
                <p class="font-10 mb-0 opacity-80"><?= date('d/m/y', strtotime($value->date_created)) ?></p>
              </div>
            <?php
            }
            ?>

          </div>
        </div>
      <?php }
      // Jika data tidak ada atau tidak ditemukan
    } else { ?>
      <div class="card card-style">
        <div class="content">
          <h5 class="text-center">No result</h5>
        </div>
      </div>
    <?php } ?>

    <!-- Pagination -->
    <div class="content">
      <div class="row">
        <div class="col-12 font-15">
          <nav>
            <?= $pagination ?>
          </nav>
        </div>
      </div>
    </div>

    <!-- Button Create -->
    <a href="<?= base_url('mobile/task/create_task') ?>" class="btn" id="btn-create"><i class="fa-solid fa-plus"></i></a>
  </div>
</div>