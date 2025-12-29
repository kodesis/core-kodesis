<?php
function format_phone_pretty($phone)
{
	$phone = preg_replace('/\D/', '', $phone);
	if (substr($phone, 0, 2) == '62') {
		$phone = '0' . substr($phone, 2);
	}
	return preg_replace('/^(\d{4})(\d{4})(\d+)$/', '$1 $2 $3', $phone);
}


// Status bayar check
$sudah_bayar = ($invoice->status_bayar == 1);
?>
<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<title><?= $invoice->no_invoice ?> - Bukti Pembayaran</title>
	<link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon.ico" type="image/x-icon">
	<style>
		/* ===== PAGE ===== */
		@page {
			size: A5 landscape;
			margin: 8mm;
		}

		body {
			font-family: Arial, sans-serif;
			font-size: 10px;
			margin: 0;
			color: #000;
		}

		/* ===== CONTAINER ===== */
		.receipt-container {
			position: relative;
			width: 100%;
			padding: 8px 10px;
			border: 1px solid #000;
			box-sizing: border-box;
		}

		.receipt-container::before {
			content: "";
			position: absolute;
			top: 50%;
			left: 50%;
			width: 65%;
			height: 65%;
			transform: translate(-50%, -50%);
			background: url('<?= $this->session->userdata('icon') ?>') no-repeat center;
			background-size: contain;
			opacity: 0.04;
		}

		.receipt-container * {
			position: relative;
			z-index: 1;
		}

		/* ===== HEADER ===== */
		.header-table {
			width: 100%;
			margin-bottom: 6px;
		}

		.header-left h1 {
			margin: 0;
			font-size: 13px;
		}

		.header-left h2 {
			margin: 1px 0 0;
			font-size: 11px;
			font-weight: normal;
		}

		.header-right {
			text-align: right;
			font-size: 9px;
			line-height: 1.3;
		}

		.header-right img {
			max-height: 32px;
			margin-bottom: 2px;
		}

		.company-name {
			font-weight: bold;
			font-size: 10px;
		}

		hr {
			border: none;
			border-top: 1px solid #000;
			margin: 6px 0;
		}

		/* ===== INFO ===== */
		.info-section {
			margin-bottom: 5px;
		}

		.info-section h3 {
			margin: 0 0 3px;
			font-size: 10px;
			font-weight: bold;
			text-transform: uppercase;
			border-bottom: 1px solid #ccc;
		}

		.info-table {
			width: 100%;
			border-collapse: collapse;
		}

		.info-table td {
			padding: 1px 3px;
			vertical-align: top;
		}

		.info-table td:first-child {
			width: 32%;
		}

		/* ===== TOTAL ===== */
		.amount-box {
			border: 1px solid #000;
			padding: 6px;
			margin: 6px 0;
		}

		.amount-box .total-label {
			font-size: 9px;
		}

		.amount-box .total-amount {
			font-size: 13px;
			font-weight: bold;
		}

		.amount-box .terbilang {
			font-size: 9px;
			font-style: italic;
		}

		/* ===== STATUS ===== */
		.status-badge {
			display: inline-block;
			padding: 3px 8px;
			font-size: 9px;
			border: 1px solid #000;
			font-weight: bold;
		}

		/* ===== FOOTER ===== */
		.footer {
			margin-top: 6px;
			border-top: 1px solid #000;
			padding-top: 4px;
			font-size: 9px;
		}

		.footer-info {
			display: flex;
			justify-content: space-between;
			align-items: flex-end;
		}

		.signature-box {
			margin-top: 14px;
			text-align: center;
		}

		.signature-line {
			border-top: 1px solid #000;
			width: 120px;
			margin: 0 auto;
			padding-top: 2px;
		}

		/* ===== PRINT ===== */
		@media print {
			.no-print {
				display: none !important;
			}
		}
	</style>


</head>

<body>
	<?php if ($sudah_bayar) : ?>
		<button class="print-button no-print" onclick="window.print()">
			🖨️ Cetak Bukti Pembayaran
		</button>

		<div class="receipt-container">
			<table class="header-table">
				<tr>
					<td class="header-left" style="width: 60%;">
						<h1>BUKTI PEMBAYARAN</h1>
						<h2>Invoice #<?= $invoice->no_invoice ?></h2>
					</td>
					<td class="header-right" style="width: 40%;">
						<?php if (!empty($settings_map['logo'])) : ?>
							<img src="<?= base_url('assets/img/' . $settings_map['logo']) ?>" alt="Logo">
						<?php endif; ?>
						<div class="company-name"><?= $settings_map['nama_perusahaan'] ?? $this->session->userdata('nama_perusahaan') ?></div>
						<?= $settings_map['alamat'] ?? '' ?><br>
						<?php if (!empty($settings_map['no_contact'])) : ?>
							Telp: <?= format_phone_pretty($settings_map['no_contact']) ?><br>
						<?php endif; ?>
						<?php if (!empty($settings_map['email'])) : ?>
							Email: <?= $settings_map['email'] ?>
						<?php endif; ?>
					</td>
				</tr>
			</table>

			<hr>

			<div class="info-section">
				<h3>📋 Informasi Customer</h3>
				<table class="info-table">
					<tr>
						<td>Nama Customer</td>
						<td>:</td>
						<td><?= $customer->nama_customer ?></td>
					</tr>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td><?= $customer->alamat_customer ?: '-' ?></td>
					</tr>
					<tr>
						<td>Telepon</td>
						<td>:</td>
						<td><?= $customer->telepon_customer ?: '-' ?></td>
					</tr>
					<tr>
						<td>NPWP</td>
						<td>:</td>
						<td><?= $customer->no_npwp ?: '-' ?></td>
					</tr>
				</table>
			</div>

			<div class="info-section">
				<h3>📄 Detail Invoice</h3>
				<table class="info-table">
					<tr>
						<td>No. Invoice</td>
						<td>:</td>
						<td><strong><?= $invoice->no_invoice ?></strong></td>
					</tr>
					<tr>
						<td>Tanggal Invoice</td>
						<td>:</td>
						<td><?= format_indo($invoice->tanggal_invoice) ?></td>
					</tr>
					<tr>
						<td>Tanggal Pembayaran</td>
						<td>:</td>
						<td><strong><?= format_indo($invoice->tanggal_bayar) ?></strong></td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td><?= $invoice->keterangan ?: '-' ?></td>
					</tr>
				</table>
			</div>

			<div class="info-section">
				<h3>💰 Rincian Pembayaran</h3>
				<table class="info-table">
					<tr>
						<td>Subtotal</td>
						<td>:</td>
						<td>Rp <?= number_format($invoice->subtotal, 0, ',', '.') ?></td>
					</tr>
					<?php if ($invoice->besaran_diskon > 0) : ?>
						<tr>
							<td>Diskon (<?= $invoice->diskon ?>%)</td>
							<td>:</td>
							<td>Rp <?= number_format($invoice->besaran_diskon, 0, ',', '.') ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($invoice->opsi_ppn == 1 && $invoice->besaran_ppn > 0) : ?>
						<tr>
							<td>PPN (<?= $invoice->ppn ?>%)</td>
							<td>:</td>
							<td>Rp <?= number_format($invoice->besaran_ppn, 0, ',', '.') ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($invoice->opsi_pph23 == 1 && $invoice->besaran_pph > 0) : ?>
						<tr>
							<td>PPh 23 (<?= $invoice->pph ?>%)</td>
							<td>:</td>
							<td>Rp <?= number_format($invoice->besaran_pph, 0, ',', '.') ?></td>
						</tr>
					<?php endif; ?>
					<?php if ($invoice->admin_fee > 0) : ?>
						<tr>
							<td>Biaya Admin</td>
							<td>:</td>
							<td>Rp <?= number_format($invoice->admin_fee, 0, ',', '.') ?></td>
						</tr>
					<?php endif; ?>
				</table>
			</div>

			<div class="amount-box">
				<div class="total-label">Total yang Dibayarkan:</div>
				<div class="total-amount">Rp <?= number_format($invoice->nominal_bayar, 0, ',', '.') ?></div>
				<div class="terbilang">
					Terbilang: <strong><?= ucwords(terbilang($invoice->nominal_bayar)) ?> Rupiah</strong>
				</div>
			</div>

			<div style="text-align: center; margin: 20px 0;">
				<span class="status-badge status-lunas">✓ LUNAS</span>
			</div>

			<div class="footer">
				<div class="footer-info">
					<div class="footer-left">
						<p>Dokumen ini dicetak otomatis pada:<br>
							<strong><?= format_indo(date('Y-m-d H:i:s')) ?> WIB</strong>
						</p>
						<p style="margin-top: 10px; font-size: 10px;">
							<em>* Bukti pembayaran ini sah dan tidak memerlukan tanda tangan basah.</em>
						</p>
					</div>
					<div class="footer-right">
						<div style="margin-bottom: 50px;">Hormat kami,</div>
						<div class="signature-box">
							<div class="signature-line">
								<?= $settings_map['nama_perusahaan'] ?? $this->session->userdata('nama_perusahaan') ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

	<?php else : ?>
		<div class="waiting-message">
			<strong>⚠️ Invoice Belum Dibayar</strong><br><br>
			<p>Invoice <strong><?= $invoice->no_invoice ?></strong> belum dilunasi.</p>
			<p>Tanggal Invoice: <strong><?= format_indo($invoice->tanggal_invoice) ?></strong></p>
			<br>
			<p style="font-size: 14px; color: #666;">
				Bukti pembayaran hanya dapat dicetak setelah pembayaran dilakukan dan diverifikasi.
			</p>
		</div>
	<?php endif; ?>

</body>

</html>