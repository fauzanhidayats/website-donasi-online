<h2>Halo {{ $pengajuan->nama ?? 'Pengaju' }},</h2>

<p>Status pengajuan donasi Anda dengan judul <strong>{{ $pengajuan->judul_pengajuan }}</strong> saat ini adalah:
    <strong>{{ ucfirst($pengajuan->status_pengajuan) }}</strong>.</p>

@if ($pengajuan->status_pengajuan === 'disetujui')
    <p>Selamat! Pengajuan Anda telah disetujui oleh admin.</p>
@elseif($pengajuan->status_pengajuan === 'ditolak')
    <p>Mohon maaf, pengajuan Anda ditolak oleh admin.</p>
@endif

<p>Terima kasih sudah menggunakan layanan kami.</p>

<p>Salam,</p>
<p>Tim Admin</p>
