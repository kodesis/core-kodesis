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

  .speech-right {
    max-width: 300px !important;
  }

  .font-weight-bold {
    font-weight: bold;
  }

  .color-black {
    color: #000 !important;
  }
</style>
<div id="page">
  <?php include APPPATH . '/views/mobile/v_nav.php' ?>
  <div class="page-content">
    <div class=" mt-0 mb-3">
      <?php

      $seg_4 = $this->uri->segment(5);
      $allowed_status = ['progress', 'hold', 'overdue', 'closed'];

      // if ($this->uri->segment(5) == false)
      if (($this->uri->segment(4) == true && $this->uri->segment(5) == false) || in_array(strtolower($seg_4), $allowed_status)) {  ?>
        <h3 class="text-center my-3">TASK</h3>
        <div class="card card-style">
          <div class="text-center">
            <h2 class="color-success p-2"><?= $task->name ?></h2>
            <p class="m-2"><?= $task->comment ?></p>
            <hr>
            <span class="m-0 p-1">
              <b>Member Name</b> : <?php
                                    $data_nip = explode(';', $task->member);
                                    foreach ($data_nip as $x) {
                                      if ($x != '') {
                                        $this->db->where('nip', $x);
                                        $get = $this->db->get('users')->row_array();
                                        echo $get ? $get['nama'] . ', ' : 'SOMEONE, ';
                                      }
                                    }
                                    ?>
            </span>
          </div>
        </div>
        <div class="w-100 d-flex align-items-center justify-content-between px-3 mb-3">

          <div>
            <a href="<?= base_url('mobile/task/task') ?>" class="btn btn-warning rounded-sm">
              <i class="fa fa-arrow-left"></i> Back
            </a>
          </div>

          <div class="d-flex gap-1">
            <?php
            $cek_status = $this->db->get_where('task', ['id' => $this->uri->segment(4)])->row_array();
            $cek_role = $cek_status['pic'] == $this->session->userdata('nip');

            if ($cek_role == true && $cek_status['activity'] == '1') { ?>
              <a href="<?= base_url('mobile/task/detail_task/' . $this->uri->segment(4)) ?>" class="btn btn-primary rounded-sm">
                <i class="fa fa-plus"></i> Add Task
              </a>
            <?php } ?>

            <?php
            if ($cek_status['activity'] == '1' && $cek_role == true) { ?>
              <a href="<?= base_url('mobile/task/close_task/' . $this->uri->segment(4)) ?>" class="btn btn-danger rounded-sm" id="btn-close-task">
                Close Project
              </a>
            <?php } ?>
          </div>
        </div>
        <div class="w-100 d-flex flex-wrap justify-content-center align-items-center gap-1 px-2" style="display: flex !important; float: none; clear: both; padding-top: 10px;">

          <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4)) ?>" class="btn <?= empty($seg_4) ? 'btn-dark' : 'btn-outline-dark color-black' ?> rounded-pill">
            All <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_all ?></span>
          </a>

          <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/progress') ?>" class="btn <?= ($seg_4 == 'progress') ? 'btn-dark' : 'btn-outline-dark color-black' ?> rounded-pill">
            Progress <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_progress ?></span>
          </a>

          <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/hold') ?>" class="btn <?= ($seg_4 == 'hold') ? 'btn-dark' : 'btn-outline-dark color-black' ?> rounded-pill">
            Hold <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_hold ?></span>
          </a>

          <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/overdue') ?>" class="btn <?= ($seg_4 == 'overdue') ? 'btn-danger' : 'btn-outline-danger color-black' ?> rounded-pill">
            Overdue <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_overdue ?></span>
          </a>

          <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/closed') ?>" class="btn <?= ($seg_4 == 'closed') ? 'btn-dark' : 'btn-outline-dark color-black' ?> rounded-pill">
            Closed <span class="badge bg-light text-dark ms-1 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 11px; padding: 0;"><?= $count_closed ?></span>
          </a>

        </div>
      <?php } ?>

      <?php


      if (($this->uri->segment(4) == true && $this->uri->segment(5) == false) || in_array(strtolower($seg_4), $allowed_status)) {

        if (!empty($task_detail)) {
          foreach ($task_detail as $x) {
            $nip = $this->session->userdata('nip');
      ?>
            <div class="card card-style mt-3">
              <div class="content">
                <div class="text-end">
                  <?php if ($x->responsible == $nip || $cek_status['pic'] == $nip) { ?>
                    <a href="<?= base_url('mobile/task/card_edit/' . $this->uri->segment(4) . '/' . $x->id_detail) ?>" class="badge gradient-green"><i class="fa fa-pencil"></i> Update</a>
                  <?php } ?>

                  <?php
                  // Menggunakan >= agar hari terakhir jatuh tempo tetap terhitung 'Open'
                  // if ($x->activity == '1' && $x->due_date >= date('Y-m-d')) {
                  if ($x->activity == '1') {
                    // echo "<span class='badge gradient-blue color-white'>Open</span>";
                  } else if ($x->activity == '3') {
                    echo "<span class='badge gradient-dark color-white'>Closed</span>";
                  } else if ($x->activity == '2') {
                    echo "<span class='badge gradient-dark color-white'>Hold</span>";
                  } else {
                    echo "<span class='badge gradient-red color-white'>Over Due</span>";
                  }
                  ?>

                  <?= (!preg_match("/$nip/i", $x->read ?? '') && $x->activity != '3') ? "<span class='badge gradient-yellow color-white'>New</span>" : ""; ?>
                </div>

                <div class="text-start">
                  <?php
                  if ($x->member_detail) {
                    $data_nip_member = explode(';', $x->member_detail);
                  } else {
                    $data_nip_member = []; // DIUBAH JADI ARRAY KOSONG AGAR in_array() TIDAK ERROR
                  }
                  $soeryo = '2146501';
                  $task = $this->db->get_where('task', ['id' => $x->id_task])->row();

                  if ($soeryo != $this->session->userdata('nip') && $this->session->userdata('level_jabatan') <= 4 && $task->pic != $this->session->userdata('nip') && $x->responsible != $this->session->userdata('nip') && !in_array($this->session->userdata('nip'), $data_nip_member)) {
                  ?>
                    <p class="mb-0 my-2" style="font-weight:bolder; cursor:pointer">
                      <?php
                      $responsible = $this->db->get_where('users', ['nip' => $x->responsible])->row_array();
                      echo $responsible['nama'] ?? 'Unknown'; // Ditambahkan fallback jika nama user tidak ditemukan
                      ?>
                    </p>
                  <?php
                  } else {
                  ?>
                    <p class="mb-0 my-2" style="font-weight:bolder; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/' . $x->id_detail) ?>'">
                      <?php
                      $responsible = $this->db->get_where('users', ['nip' => $x->responsible])->row_array();
                      echo $responsible['nama'] ?? 'Unknown'; // Ditambahkan fallback jika nama user tidak ditemukan
                      ?>
                    </p>
                  <?php
                  }
                  if ($x->member_detail) {
                  ?>
                    <span class="m-0 p-1">
                      <b>Member </b> : <?php
                                        $data_nip = explode(';', $x->member_detail);
                                        foreach ($data_nip as $m) {
                                          if ($m != '') {
                                            $this->db->where('nip', $m);
                                            $get = $this->db->get('users')->row_array();
                                            echo $get['nama'] . ', ' ?? 'SOMEONE' . ', ';
                                          }
                                        }
                                        ?>
                    </span>
                  <?php
                  }
                  ?>
                  <?php

                  if ($x->activity == '1' || $x->activity == '2') {
                    if ($x->due_date) {
                      // Buat objek tanggal untuk hari ini dan tanggal jatuh tempo
                      $today = new DateTime(date('Y-m-d'));
                      $due = new DateTime($x->due_date);

                      // Hitung selisih hari
                      $diff = $today->diff($due);
                      $days_left = (int)$diff->format('%r%a');

                      if ($days_left > 0) {
                        // Belum lewat (Hari H atau sisa waktu masih ada) -> Progress Biru
                        // $badge_class = 'gradient-blue';
                        $badge_class = 'gradient-dark';
                        $badge_text = 'On Progress';
                      } else {
                        // Sudah LEWAT (Nilai $days_left negatif, kita ubah jadi positif agar mudah dibaca)
                        $days_overdue = abs($days_left);

                        if ($days_overdue <= 7) {
                          // Lewat 1 minggu kebawah (1 - 7 hari) -> Kuning
                          // $badge_class = 'gradient-yellow';
                          $badge_class = 'gradient-red';
                          $badge_text = 'Overdue';
                        } elseif ($days_overdue > 7 && $days_overdue <= 30) {
                          // Lewat 1 minggu sampai 1 bulan (8 - 30 hari) -> Merah
                          $badge_class = 'gradient-red';
                          // $badge_class = 'bg-black'; // Sesuaikan class CSS hitam Anda (misal: 'bg-black' / 'gradient-black')
                          $badge_text = 'Alert';
                        } else {
                          // Lewat 1 bulan ke atas (> 30 hari) -> Hitam
                          // $badge_class = 'bg-black'; // Sesuaikan class CSS hitam Anda (misal: 'bg-black' / 'gradient-black')
                          // $badge_text = 'Alert Overdue > 1 Bln';
                          $badge_class = 'gradient-red';
                          $badge_text = 'Alert';
                        }


                        //   $badge_class = 'gradient-yellow';
                        //   $badge_text = 'Overdue < 1 Ming';
                      }

                      // Cetak button badge-nya
                      $badge_due_time = '<button class="badge ' . $badge_class . ' color-white font-10"><i class="fa fa-clock-o"></i> ' . $badge_text . '</button>';
                    } else {
                      $badge_due_time = '';
                    }
                  } else {
                    if ($x->closed_on) {
                      if ($x->closed_on == 'On Progress') {
                        // $badge_class = 'gradient-blue';
                        $badge_class = 'gradient-dark';
                        $badge_text = 'Progress';
                      } else if ($x->closed_on == 'Overdue < 1 Ming') {
                        // $badge_class = 'gradient-yellow';
                        $badge_class = 'gradient-dark';
                        $badge_text = 'Overdue < 1 Ming';
                      } else if ($x->closed_on == 'Overdue < 1 Bln') {
                        $badge_class = 'gradient-red';
                        $badge_text = 'Overdue < 1 Bln';
                      } else if ($x->closed_on == 'Overdue > 1 Bln') {
                        $badge_class = 'gradient-red'; // Sesuaikan class CSS hitam Anda (misal: 'bg-black' / 'gradient-black')
                        $badge_text = 'Overdue > 1 Bln';
                      } else {
                        $badge_class = 'gradient-dark'; // Sesuaikan class CSS hitam Anda (misal: 'bg-black' / 'gradient-black')
                        $badge_text = 'Unknown';
                      }

                      $badge_due_time = '<button class="badge ' . $badge_class . ' color-white font-10"><i class="fa fa-clock-o"></i> Closed On ' . $badge_text . '</button>';
                    } else {
                      $badge_due_time = '';
                    }


                    // Cetak button badge-nya
                  }
                  ?>
                  <p class="font-10 mb-0 opacity-80"><?= date('d/m/y', strtotime($x->start_date)) . ' - ' . date('d/m/y', strtotime($x->due_date)) . ' ' . $badge_due_time ?></p>
                </div>

                <div class="d-flex">
                  <div class="flex-grow-1">
                    <p class="mb-n1" style="font-weight: <?= preg_match("/$nip/i", $x->read ?? '') ? 'normal' : 'bolder' ?>; cursor:pointer" onclick="location.href='<?= base_url('mobile/task/task_view/' . $this->uri->segment(4) . '/' . $x->id_detail) ?>'">
                      <?= $x->task_name ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          <?php }
        } else { ?>
          <div class="card card-style mt-3 py-4 text-center">
            <div class="content">
              <i class="fa fa-folder-open fa-3x text-fade opacity-40 mb-2"></i>
              <h5 class="opacity-60">No Result</h5>
              <p class="font-11 opacity-50 mb-0">Tidak ada item data detail pada kategori filter ini.</p>
            </div>
          </div>
        <?php }
        // } else if ($this->uri->segment(5)) {
      } else if ($seg_4) {
        ?>
        <div class="content">
          <h3 class="text-center">Task Detail</h3>
          <div class="text-center mb-3">
            <h2 class="badge bg-success"><?= $task_comment['task_name'] ?></h2>
          </div>

          <div class="item form-group">
            <div class="row">
              <div class="col-md-4">
                <a href="<?= base_url('mobile/task/task_view/' . $this->uri->segment(4)) ?>" class="btn btn-warning rounded-sm"><i class="fa fa-arrow-left"></i> Back</a>
              </div>
            </div>
          </div>
          <div class="card p-2 rounded-3">
            <table>
              <tr>
                <th>Task Name</th>
                <td>:</td>
                <td><?= $task_comment['task_name'] ?></td>
              </tr>
              <tr>
                <th>Responsible</th>
                <td>:</td>
                <td><?= $task_comment['nama'] ?></td>
              </tr>
              <?php
              if ($task_comment['member_detail']) {
              ?>

                <tr>
                  <th>Member</th>
                  <td>:</td>
                  <td><?php
                      $data_nip = explode(';', $task->member);
                      foreach ($data_nip as $x) {
                        if ($x != '') {
                          $this->db->where('nip', $x);
                          $get = $this->db->get('users')->row_array();
                          echo $get ? $get['nama'] . ', ' : 'SOMEONE, ';
                        }
                      }
                      ?></td>
                </tr>
              <?php
              }
              ?>
              <tr>
                <th>Description</th>
                <td>:</td>
                <td><?= $task_comment['description'] ?></td>
              </tr>
              <tr>
                <th>Start Date</th>
                <td>:</td>
                <td><?= $task_comment['start_date'] ?></td>
              </tr>
              <tr>
                <th>Due Date</th>
                <td>:</td>
                <td><?= $task_comment['due_date'] ?></td>
              </tr>
              <tr>
                <th>Attachment</th>
                <td>:</td>
                <td>

                  <?php if ($task_comment['attachment'] != "") {
                    $att_xx = explode(';', $task_comment['attachment']);
                    $i = 1;
                  ?>
                    <ul>
                      <?php foreach ($att_xx as $x) {

                        //   if (file_exists('upload/task_comment/' . $x)) {
                        //     $url = base_url('upload/task_comment/' . $x);
                        //   } else {
                        //     $url = base_url('upload/card_task/' . $x);
                        //   }

                        $array = explode('.', $x);
                        $extension = end($array);
                        if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
                      ?>
                          <li>
                            <a href="#" download style="white-space: pre-line;" data-bs-toggle="modal" data-bs-target="#exampleModal">File <?= $i++ ?></a>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Attachment</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">
                                    <img src="https://moc.mlejitoffice.id/upload/task_comment/<?= $x ?>" alt="attachment" width="100%">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </li>
                        <?php } else { ?>
                          <li><a href="https://moc.mlejitoffice.id/upload/task_comment/<?= $x ?>" download style="white-space: pre-line;" onclick="PageReload()">File <?= $i++ ?></a></li>
                      <?php }
                      } ?>
                    </ul>
                  <?php } else {
                    echo "";
                  } ?>

                </td>
              </tr>
            </table>
          </div>

          <?php foreach ($task_comment_member as $x) {
            if ($x->member == $this->session->userdata('nip')) {
          ?>
              <div class="speech-bubble speech-left bg-highlight">
                <div style="white-space: pre-wrap;" class="message"><?= $x->comment_member ?></div>
                <?php if ($x->attachment != null) { ?>
                  <hr>
                  Attachment :
                  <b>
                    <?php
                    $i = 1;
                    foreach (explode(';', $x->attachment) as $xx) {
                      $array = explode('.', $xx);
                      $extension = end($array);
                      if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
                    ?>
                        <a style="color: white;" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          File <?= $i++ ?> ||
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Attachment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <img src="https://moc.mlejitoffice.id/upload/task_comment/<?= $xx ?>" alt="attachment" width="100%">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } else { ?>
                        <li><a style="color: white;" href="https://moc.mlejitoffice.id/<?= $xx ?>" download onclick="PageReload()">
                            File <?= $i++ ?> ||
                          </a></li>
                    <?php }
                    } ?>
                  </b>
                <?php } ?>
                <hr>
                <span><?= date('d M y, H:i:s', strtotime($x->date_created)) . ' WIB' ?></span>
              </div>
              <div class="clearfix"></div>
            <?php } else { ?>
              <div class="speech-bubble speech-right color-black">
                <b><?= $x->nama ?>:</b> <br>
                <div style="white-space: pre-wrap;" class="message"><?= $x->comment_member ?></div>
                <?php if ($x->attachment != null) { ?>
                  <hr>
                  <b>
                    <?php
                    $i = 1;
                    foreach (explode(';', $x->attachment) as $xx) {
                      $array = explode('.', $xx);
                      $extension = end($array);
                      if ($extension == "png" || $extension == "jpg" || $extension == "jpeg") {
                    ?>
                        <a style="color: black;" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">
                          File <img src="https://moc.mlejitoffice.id/upload/task_comment/<?= $xx ?>" alt="attachment" width="30px"> ||
                        </a>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Attachment</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <img src="https://moc.mlejitoffice.id/upload/task_comment/<?= $xx ?>" alt="attachment" width="100%">
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      <?php } else { ?>
                        <a style="color: black;" href="https://moc.mlejitoffice.id/upload/task_comment/<?= $xx ?>" download onclick="PageReload()">
                          File <?= $i++ ?> ||
                        </a>
                    <?php
                      }
                    } ?>
                  </b>
                <?php } ?>
                <hr>
                <span><?= date('d M y, H:i:s', strtotime($x->date_created)) . ' WIB' ?></span>
              </div>
              <div class="clearfix"></div>
          <?php }
          } ?>
        </div>

    </div>
  <?php } ?>
  </div>
</div>
</div>