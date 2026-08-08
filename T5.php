<?php

$id   = (isset($_GET['id']) && $_GET['id'] !== '') ? $_GET['id'] : 'homepage';
$file = __DIR__ . '/data/data.json';

if (!file_exists($file)) {
http_response_code(500);
exit('data.json tidak ditemukan.');
}

$data = json_decode(file_get_contents($file), true);
$page = isset($data[$id]) ? $data[$id] : null;

if (!$page) {
http_response_code(404);
exit('<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><title>404</title></head><body><h1>404</h1><p><a href="/">Kembali ke Beranda</a></p></body></html>');
}

function e($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

$homepage   = isset($data['homepage']) ? $data['homepage'] : [];
$isHome     = ($page['category'] === 'homepage');
$host       = $_SERVER['HTTP_HOST'];
$origin     = 'https://' . $host;

$logoSrc    = $homepage['logo_src']        ?? '/img/logo.png';
$faviconSrc = $homepage['favicon_src']     ?? '/img/favicon.png';
$banner1    = $homepage['banner_src']      ?? '';
$waUrl      = $homepage['whatsapp_cta']    ?? '#';
$tgUrl      = $homepage['telegram_cta']    ?? '#';
$daftarUrl  = $homepage['cta_daftar_url']  ?? '#';
$loginUrl   = $homepage['cta_login_url']   ?? '#';

$noindex    = !empty($page['noindex']);
$lang       = $page['lang'] ?? 'id';
$lastmod    = $page['lastmod'] ?? date('Y-m-d');
$canonical  = $page['canonical_url'] ?? ($origin . '/');
$ogImage    = $page['image_src'] ?? $banner1;
$dateMod    = $lastmod . 'T00:00:00+07:00';

$bulanId = [1=>'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$ts = strtotime($lastmod);
$tglTampil = $ts ? (date('j', $ts) . ' ' . $bulanId[(int)date('n', $ts)] . ' ' . date('Y', $ts)) : $lastmod;

$semuaPost = array_filter($data, function ($item) {
return isset($item['category']) && $item['category'] === 'post';
});

// Halaman menu: hanya slug yang dikenal DAN benar-benar ada di data.json yang
// ditampilkan, sehingga tidak pernah muncul tautan mati. Sisanya jadi Bacaan Lain.
// Dicocokkan dengan AKHIRAN, bukan slug persis, karena staf memakai pola
// berawalan nama domain: zeus123-link-alternatif, zeus123-login, dan seterusnya.
// Pola yang lebih panjang didahulukan supaya 'cara-daftar' tidak tertelan 'daftar'.
$polaMenu = [
'about-us'        => 'Tentang Kami',
'tentang-kami'    => 'Tentang Kami',
'contact-us'      => 'Kontak',
'kontak'          => 'Kontak',
'link-alternatif' => 'Link Alternatif',
'cara-daftar'     => 'Cara Daftar',
'daftar'          => 'Cara Daftar',
'cara-masuk-akun' => 'Cara Masuk',
'cara-masuk'      => 'Cara Masuk',
'login'           => 'Cara Masuk',
'disclaimer'      => 'Disclaimer',
];

$menu = [];
$labelDipakai = [];
foreach ($polaMenu as $pola => $label) {
if (isset($labelDipakai[$label])) { continue; }
foreach ($semuaPost as $slug => $item) {
if (isset($menu[$slug])) { continue; }
$s = strtolower(trim($slug));
if ($s === $pola || substr($s, -(strlen($pola) + 1)) === '-' . $pola) {
$menu[$slug] = $label;
$labelDipakai[$label] = true;
break;
}
}
}
$bacaanLain = array_diff_key($semuaPost, $menu);

// Tautan internal di awal artikel: kemunculan PERTAMA nama situs di dalam
// content_html ditautkan ke beranda. Dikerjakan saat render, jadi artikel lama
// pun ikut mendapat tautan tanpa perlu regenerate.
// Penggantian HANYA pada teks di luar tag, supaya nama situs yang kebetulan
// berada di dalam atribut tidak ikut dirusak. Hanya satu kali per halaman.
// Variabel sengaja bernama $namaTaut, bukan $namaSitus, karena $namaSitus
// sudah dipakai untuk keperluan lain di template ini.
$isiArtikel = $page['content_html'];
$namaTaut   = !empty($homepage['keyword']) ? $homepage['keyword'] : explode('.', $host)[0];
if ($namaTaut !== '' && $isiArtikel !== '') {
    $bagian = preg_split('/(<[^>]*>)/', $isiArtikel, -1, PREG_SPLIT_DELIM_CAPTURE);
    $sudah = false;
    foreach ($bagian as $i => $b) {
        if ($sudah || $b === '' || $b[0] === '<') { continue; }
        $pos = stripos($b, $namaTaut);
        if ($pos !== false) {
            $asli = substr($b, $pos, strlen($namaTaut));
            $bagian[$i] = substr($b, 0, $pos) . '<a href="/">' . $asli . '</a>' . substr($b, $pos + strlen($namaTaut));
            $sudah = true;
        }
    }
    if ($sudah) { $isiArtikel = implode('', $bagian); }
}

// og:image dan schema wajib URL mutlak; jalur relatif membuat pratinjau bagikan gagal.
$ogAbs = $ogImage ? ((strpos($ogImage, 'http') === 0) ? $ogImage : $origin . $ogImage) : '';

$namaSitus = ucfirst(explode('.', $host)[0]);

$ikon = [
'rumah'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M11.3 2.7a1 1 0 0 1 1.4 0l8.3 7.9a1 1 0 0 1-.7 1.7H19v8.4a1.3 1.3 0 0 1-1.3 1.3h-3.4v-6.6h-4.6V22H6.3A1.3 1.3 0 0 1 5 20.7v-8.4H3.7a1 1 0 0 1-.7-1.7z"/></svg>',
'api'    => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M13.4 1.8c.3 3.5-2.4 4.3-2.4 7 0 1.1.7 2 1.7 2.3-.4-1.8.6-3 1.6-3.8.2 2.3 2.1 3 3.3 5a5.7 5.7 0 0 1-3.2 9.6 6.4 6.4 0 0 0 1.3-4c0-2.4-1.7-3.6-1.7-3.6-.3 1.9-1.6 2.5-2.6 3.4a4 4 0 0 0 .4 5.3A6.4 6.4 0 0 1 5.9 17c0-4.6 4.4-5.7 5.3-10.5.2-1.1.2-3-.2-4.2z"/></svg>',
'gulung' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M4 4h4.2v16H4zm5.9 0h4.2v16H9.9zM15.8 4H20v16h-4.2z"/></svg>',
'meja'   => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><ellipse cx="12" cy="9" rx="9" ry="5.4"/><path d="M3 9v4.6c0 3 4 5.4 9 5.4s9-2.4 9-5.4V9"/></svg>',
'bola'   => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 3v4m0 10v4M3 12h4m10 0h4M6 6l3 3m6 6 3 3M18 6l-3 3m-6 6-3 3"/></svg>',
'dadu'   => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="3.2"/><circle cx="8.5" cy="8.5" r="1.4" fill="currentColor" stroke="none"/><circle cx="15.5" cy="15.5" r="1.4" fill="currentColor" stroke="none"/><circle cx="12" cy="12" r="1.4" fill="currentColor" stroke="none"/></svg>',
'nomor'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><rect x="3.5" y="3.5" width="17" height="17" rx="2.6"/><path d="M3.5 9.2h17M3.5 14.8h17M9.2 3.5v17M14.8 3.5v17"/></svg>',
'cari'   => '<svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.2" aria-hidden="true"><circle cx="10.5" cy="10.5" r="6.5"/><path d="m15.4 15.4 4.1 4.1"/></svg>',
'wa'     => '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5.1-1.3A10 10 0 1 0 12 2zm0 2a8 8 0 1 1-4.2 14.8l-.4-.2-2.6.7.7-2.5-.3-.4A8 8 0 0 1 12 4zM9 8.2c-.2 0-.5.1-.7.4-.3.3-.9.9-.9 2s.9 2.3 1 2.5c.1.2 1.7 2.8 4.3 3.8 2.1.8 2.6.7 3 .6.6-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.5-.3l-1.8-.9c-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1-.7-.3-1.5-.7-2.2-1.6-.5-.7-.5-1-.4-1.2l.5-.7c.1-.2.1-.4 0-.6l-.8-1.8c-.2-.4-.4-.3-.6-.3z"/></svg>',
'tg'     => '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="M21.2 4.3 2.9 11.4c-1 .4-1 1 .1 1.3l4.6 1.4 1.8 5.4c.2.6.4.8.9.8.4 0 .6-.2.9-.5l2.2-2.2 4.6 3.4c.8.5 1.4.2 1.6-.8l3-14c.3-1.2-.5-1.8-1.4-1.4zM7.3 13.6l10-6.3c.5-.3.9-.1.5.2l-8.3 7.5-.3 3.4z"/></svg>',
'pesan'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M4 3h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4v-4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm3 5h10v2H7zm0 4h7v2H7z"/></svg>',
'tiket'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M3 6.5A1.5 1.5 0 0 1 4.5 5h15A1.5 1.5 0 0 1 21 6.5v3a2.5 2.5 0 0 0 0 5v3a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 17.5v-3a2.5 2.5 0 0 0 0-5zm12 .5h1.6v10H15z"/></svg>',
'masuk'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><path d="M14 3h4.5A1.5 1.5 0 0 1 20 4.5v15a1.5 1.5 0 0 1-1.5 1.5H14"/><path d="M10 8.5 13.5 12 10 15.5M13 12H4"/></svg>',
'daftar' => '<svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><circle cx="10" cy="8" r="3.6"/><path d="M3.6 20c0-3.5 2.9-5.6 6.4-5.6 1.3 0 2.5.3 3.5.8M18 14v6m3-3h-6"/></svg>',
'info'   => '<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.9" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="M12 11v5.5"/><circle cx="12" cy="7.8" r="1.1" fill="currentColor" stroke="none"/></svg>',
'bintang'=> '<svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true"><path d="m12 2.6 2.9 5.9 6.5.9-4.7 4.6 1.1 6.5-5.8-3-5.8 3 1.1-6.5L2.6 9.4l6.5-.9z"/></svg>',
];

$kategori = [
['api',    'Hot Game'],
['gulung', 'Slot'],
['bola',   'Sports'],
['meja',   'Live Casino'],
['dadu',   'Arcade'],
['nomor',  'Togel'],
['tiket',  'Promosi'],
];

$daftarGame = [
['Kilau Zamrud',    1],
['Naga Tirta',      2],
['Panen Raya',      3],
['Roda Fortuna',    4],
['Menara Emas',     5],
['Rimba Misteri',   1],
['Bintang Selatan', 2],
['Angin Topan',     3],
['Lentera Malam',   4],
['Karang Mutiara',  5],
['Layar Perak',     1],
['Puncak Salju',    2],
];

$fitur = [
['Selalu Ada Promo',      'Program promosi berjalan sepanjang periode tertentu sehingga waktu bermain terasa lebih panjang tanpa menambah pengeluaran di luar rencana.'],
['Bonus Cashback',        'Pada periode tertentu tersedia pengembalian sebagian dari nilai permainan yang sudah berjalan, dihitung mengikuti ketentuan yang berlaku saat itu.'],
['Bonus Rollingan',       'Perhitungan tambahan berdasarkan persentase dari modal yang digunakan selama periode berjalan, bukan jaminan hasil akhir.'],
['Dukungan Bantuan 24/7', 'Kanal bantuan tersedia setiap hari sepanjang waktu untuk pertanyaan seputar akses halaman, alamat cadangan, dan mekanisme layanan.'],
];

$bayarBank   = ['BCA','Mandiri','BNI','BRI','CIMB Niaga','Permata','Danamon','Maybank','Panin','Bank Mega'];
$bayarEmoney = ['DANA','OVO','GoPay','LinkAja','ShopeePay'];
$bayarPulsa  = ['Telkomsel','XL Axiata','Indosat','Tri'];

$penyedia = ['Pragmatic','PG Soft','Habanero','CQ9','Spadegaming','Joker','Microgaming','TopTrend','ION','Allbet','Sexy Gaming','IDN Live'];

$tanya = [
['Apa arti angka pada papan Jackpot di halaman ini?', 'Angka tersebut adalah ilustrasi tampilan antarmuka. Bukan nominal hadiah aktual, bukan data waktu nyata, dan tidak mencerminkan saldo mana pun.'],
['Apakah nama permainan di halaman ini katalog resmi?', 'Bukan. Nama pada kartu permainan adalah label tampilan untuk menggambarkan jenis permainan, bukan daftar katalog resmi maupun klaim ketersediaan judul tertentu.'],
['Apa fungsi alamat alternatif ' . $namaSitus . '?', 'Alamat alternatif adalah jalur akses cadangan menuju server yang sama, dipakai ketika alamat utama sedang tidak dapat dibuka pada jaringan tertentu.'],
['Apakah daftar penyedia dan metode pembayaran berarti ada kemitraan resmi?', 'Tidak. Keduanya dicantumkan sebagai informasi umum mengenai jenis layanan yang lazim dijumpai, bukan pernyataan kemitraan, dukungan, atau ketersediaan resmi.'],
['Ke mana menghubungi bantuan?', 'Melalui tombol WhatsApp dan Telegram pada bagian bawah halaman serta pada panel samping. Keduanya terbuka di tab baru.'],
];

?><!DOCTYPE html>
<html lang="<?= e($lang) ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="<?= e($faviconSrc) ?>">
<title><?= e($page['title']) ?></title>
<meta name="description" content="<?= e($page['meta_description']) ?>">
<meta name="robots" content="<?= $noindex ? 'noindex, nofollow' : 'index, follow' ?>">
<link rel="canonical" href="<?= e($canonical) ?>">
<?php if (!empty($page['amp_url']) && $page['amp_url'] !== '#'): ?>
<link rel="amphtml" href="<?= e($page['amp_url']) ?>">
<link rel="alternate" hreflang="id-id" href="<?= e($page['amp_url']) ?>">
<link rel="alternate" href="<?= e($page['amp_url']) ?>">
<link rel="alternate" hreflang="id" href="<?= e($page['amp_url']) ?>">
<link rel="alternate" hreflang="en" href="<?= e($page['amp_url']) ?>">
<link rel="alternate" hreflang="x-default" href="<?= e($page['amp_url']) ?>">
<?php endif; ?>
<meta property="og:type" content="website">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['meta_description']) ?>">
<?php if ($ogAbs): ?><meta property="og:image" content="<?= e($ogAbs) ?>"><?php endif; ?>
<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">
{
"@context":"https://schema.org",
"@graph":[
{
"@type":"FAQPage",
"mainEntity":[
<?php $n = count($tanya); foreach ($tanya as $i => $t): ?>
{"@type":"Question","name":<?= json_encode($t[0], JSON_UNESCAPED_UNICODE) ?>,"acceptedAnswer":{"@type":"Answer","text":<?= json_encode($t[1], JSON_UNESCAPED_UNICODE) ?>}}<?= $i < $n - 1 ? ',' : '' ?>
<?php endforeach; ?>
]
},
{
"@type":"BreadcrumbList",
"itemListElement":[
{"@type":"ListItem","position":1,"name":"Beranda","item":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>}<?php if (!$isHome): ?>,
{"@type":"ListItem","position":2,"name":<?= json_encode($page['h1'], JSON_UNESCAPED_UNICODE) ?>,"item":<?= json_encode($canonical, JSON_UNESCAPED_UNICODE) ?>}<?php endif; ?>

]
},
{
"@type":"Article",
"headline":<?= json_encode($page['h1'], JSON_UNESCAPED_UNICODE) ?>,
"description":<?= json_encode($page['meta_description'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
<?php if ($ogAbs): ?>"image":<?= json_encode($ogAbs, JSON_UNESCAPED_UNICODE) ?>,
<?php endif; ?>"datePublished":"<?= e($dateMod) ?>",
"dateModified":"<?= e($dateMod) ?>",
"inLanguage":"id-ID",
"author":{"@type":"Organization","name":<?= json_encode($host, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>},
"publisher":{"@type":"Organization","name":<?= json_encode($host, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>,"logo":{"@type":"ImageObject","url":<?= json_encode($origin . $logoSrc, JSON_UNESCAPED_UNICODE) ?>}},
"mainEntityOfPage":{"@type":"WebPage","@id":<?= json_encode($canonical, JSON_UNESCAPED_UNICODE) ?>}
}
]
}
</script>
<style>
:root{
--v-dasar:#071c30;--v-dalam:#0b2740;--v-panel2:#10395c;
--v-naik:#16456d;--v-emas:#f4c033;--v-emas-t:#ffdc6b;
--v-biru:#1a6fc9;--v-biru-t:#2f8ae0;--v-oranye:#e08a1e;--v-oranye-t:#f5a83a;
--v-sian:#4ec8ea;--v-teks:#fff;--v-samar:#9db4ca
}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{
margin:0;font-size:16px;line-height:1.65;color:var(--v-teks);
font-family:system-ui,"Segoe UI",Roboto,"Helvetica Neue",Arial,"Noto Sans",sans-serif;
background:var(--v-dasar);
background-image:linear-gradient(180deg,#071c30 0%,#0a2c48 42%,#0d3a52 100%);
background-attachment:fixed;
padding-bottom:78px
}
img{max-width:100%;display:block}
a{color:inherit}
.v-wrap{max-width:860px;margin:0 auto;padding:0 12px}

/* ---------- kepala ---------- */
.v-kepala{position:sticky;top:0;z-index:60;background:var(--v-dalam);border-bottom:2px solid var(--v-emas)}
.v-kepala .v-wrap{display:grid;grid-template-columns:46px 1fr 46px;align-items:center;padding:9px 12px}
.v-kepala a.v-logo{grid-column:2;justify-self:center}
.v-kepala img{height:40px;width:auto;display:block}
.v-burger{grid-column:3;display:grid;gap:5px;align-content:center;justify-items:center;min-width:46px;min-height:46px;text-decoration:none;border-radius:7px;border:1px solid var(--v-naik)}
.v-burger span{display:block;width:24px;height:3px;border-radius:2px;background:var(--v-teks)}
.v-menu{grid-column:3;position:relative;justify-self:end}
.v-menu>summary{display:grid;gap:5px;align-content:center;justify-items:center;min-width:46px;min-height:46px;border-radius:7px;border:1px solid var(--v-naik);cursor:pointer;list-style:none}
.v-menu>summary::-webkit-details-marker{display:none}
.v-menu>summary span{display:block;width:24px;height:3px;border-radius:2px;background:var(--v-teks)}
.v-menu[open]>summary{border-color:var(--v-emas)}
.v-menu[open]>summary span:first-child{background:var(--v-emas)}
.v-menu nav{position:absolute;right:0;top:calc(100% + 9px);min-width:206px;display:grid;background:var(--v-dalam);border:1px solid var(--v-emas);border-radius:10px;overflow:hidden;box-shadow:0 12px 28px rgba(0,0,0,.55)}
.v-menu nav a{display:flex;align-items:center;min-height:46px;padding:0 16px;font-size:14.5px;text-decoration:none}
.v-menu nav a+a{border-top:1px solid var(--v-naik)}
.v-menu nav a:hover{background:var(--v-panel2);color:var(--v-emas-t)}
.v-kaki{display:flex;flex-wrap:wrap;justify-content:center;gap:8px;margin:0 0 18px}
.v-kaki a{display:inline-flex;align-items:center;min-height:44px;padding:8px 14px;font-size:13.5px;text-decoration:none;color:var(--v-emas-t);background:var(--v-panel2);border:1px solid var(--v-naik);border-radius:7px}

/* ---------- teks berjalan ---------- */
.v-kabar{display:grid;grid-template-columns:auto 1fr;gap:9px;align-items:center;background:linear-gradient(90deg,#8a6a12,#c39a24);padding:7px 12px;overflow:hidden}
.v-kabar i{line-height:0;color:#2b1f02}
.v-kabar div{overflow:hidden;white-space:nowrap}
.v-kabar p{margin:0;display:inline-block;padding-left:100%;font-size:14px;color:#2b1f02;font-weight:600;animation:v-geser 26s linear infinite}
@keyframes v-geser{0%{transform:translateX(0)}100%{transform:translateX(-100%)}}

/* ---------- spanduk + aksi ---------- */
.v-spanduk img{width:100%;height:auto;background:var(--v-naik)}
.v-aksi{display:grid;grid-template-columns:1fr 1fr;gap:2px;background:var(--v-dalam)}
.v-aksi a{display:flex;align-items:center;justify-content:center;gap:9px;min-height:56px;font-size:18px;font-weight:700;text-decoration:none;letter-spacing:.02em}
.v-aksi i{line-height:0}
.v-aksi .v-reg{background:linear-gradient(180deg,var(--v-biru-t),var(--v-biru));color:#fff}
.v-aksi .v-log{background:linear-gradient(180deg,var(--v-oranye-t),var(--v-oranye));color:#2b1a02}

/* ---------- kategori geser ---------- */
.v-rak{display:flex;gap:8px;overflow-x:auto;scroll-snap-type:x mandatory;padding:14px 0 6px;-webkit-overflow-scrolling:touch;scrollbar-width:none}
.v-rak::-webkit-scrollbar{display:none}
.v-rak a{flex:0 0 auto;scroll-snap-align:start;display:grid;justify-items:center;gap:6px;min-width:88px;min-height:78px;padding:11px 8px;border-radius:10px;background:var(--v-panel2);border:1px solid var(--v-naik);text-decoration:none;font-size:12.5px;color:var(--v-samar);text-align:center;line-height:1.25}
.v-rak i{color:var(--v-emas);line-height:0}

/* ---------- jackpot ---------- */
.v-jack{margin:16px 0 6px;border:2px solid var(--v-emas);border-radius:12px;background:linear-gradient(180deg,#0c2f4e,#071d31);padding:14px 13px;text-align:center}
.v-jack h2{margin:0 0 10px;font-size:19px;letter-spacing:.14em;text-transform:uppercase;font-weight:700}
.v-jack h2 span{color:var(--v-emas)}
.v-jack output{display:block;background:#04121f;border:1px solid var(--v-naik);border-radius:8px;padding:11px 8px;font-family:ui-monospace,"Cascadia Mono","Roboto Mono",Menlo,monospace;font-size:clamp(18px,5.4vw,28px);font-weight:700;letter-spacing:.03em;color:var(--v-emas-t);font-variant-numeric:tabular-nums;min-height:52px}
.v-jack .v-main{display:inline-flex;align-items:center;justify-content:center;margin-top:12px;min-height:46px;padding:0 30px;border-radius:24px;background:linear-gradient(180deg,var(--v-emas-t),var(--v-emas));color:#2b1f02;font-weight:800;font-size:15px;letter-spacing:.08em;text-decoration:none}
.v-ilus{font-size:12px;color:var(--v-samar);text-align:center;margin:9px 0 24px;line-height:1.55}

/* ---------- judul bagian ---------- */
.v-tajuk{display:flex;align-items:center;justify-content:center;gap:9px;margin:0 0 4px}
.v-tajuk i{color:var(--v-emas);line-height:0}
.v-tajuk h2{margin:0;font-size:22px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--v-emas)}
.v-garis{border:0;height:2px;background:linear-gradient(90deg,transparent,var(--v-emas),transparent);margin:0 0 14px}

/* ---------- pencarian + kartu game ---------- */
.v-cari{position:relative;margin:0 0 14px}
.v-cari i{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--v-sian);line-height:0;pointer-events:none}
.v-cari input{width:100%;min-height:48px;padding:0 14px 0 42px;font-size:16px;color:#fff;background:var(--v-panel2);border:2px solid var(--v-biru);border-radius:9px;font-family:inherit}
.v-cari input::placeholder{color:#7f9ab3}
.v-cari input:focus{outline:0;border-color:var(--v-sian)}
.v-kosong{display:none;text-align:center;color:var(--v-samar);font-size:14px;padding:14px 0 4px}
.v-grid{display:grid;grid-template-columns:1fr 1fr;gap:11px;margin:0 0 26px}
.v-kartu{background:linear-gradient(180deg,var(--v-naik),#0d2f4d);border:1px solid var(--v-biru);border-radius:11px;overflow:hidden}
.v-kartu img{width:100%;height:auto;aspect-ratio:1/1;object-fit:cover;background:#0a2338}
.v-kartu h3{margin:0;padding:9px 9px 3px;font-size:14px;font-weight:600;line-height:1.3}
.v-kartu p{margin:0;padding:0 9px 10px;font-size:11px;letter-spacing:.1em;text-transform:uppercase;color:var(--v-sian);font-weight:700}

/* ---------- artikel ---------- */
.v-remah{font-size:13px;color:var(--v-samar);margin:20px 0 0}
.v-remah a{color:var(--v-sian);text-decoration:none}
.v-tulis{padding:16px 0 8px}
.v-tulis h1{font-size:clamp(26px,6.6vw,35px);font-weight:800;line-height:1.22;margin:0 0 6px;color:#fff}
.v-cap{color:var(--v-samar);font-size:13px;margin:0 0 20px}
.v-tulis p{margin:0 0 18px;text-align:justify;hyphens:auto;color:#dde8f2}
.v-tulis h2{font-size:clamp(20px,5vw,25px);font-weight:800;color:var(--v-emas);line-height:1.3;margin:26px 0 12px}
.v-tulis h3{font-size:18px;font-weight:700;color:var(--v-sian);margin:20px 0 8px}
.v-tulis ul,.v-tulis ol{padding-left:21px;margin:0 0 18px;color:#dde8f2}
.v-tulis li{margin-bottom:7px}
.v-tulis a{color:var(--v-emas)}
.v-tulis strong{color:var(--v-emas-t)}

/* ---------- fitur ---------- */
.v-fitur{display:grid;gap:11px;margin:0 0 26px}
.v-fitur article{background:var(--v-panel2);border:1px solid var(--v-naik);border-left:4px solid var(--v-emas);border-radius:9px;padding:14px 15px}
.v-fitur h3{margin:0 0 5px;font-size:15px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--v-emas-t)}
.v-fitur p{margin:0;font-size:14px;color:#c3d5e6}

/* ---------- pembayaran & penyedia ---------- */
.v-set{border:1px solid var(--v-naik);border-radius:10px;padding:4px 14px 15px;margin:0 0 12px;background:rgba(18,49,82,.55)}
.v-set legend{padding:0 8px;font-size:14px;font-weight:600;color:var(--v-emas-t)}
.v-set div{display:grid;grid-template-columns:repeat(3,1fr);gap:12px 8px;padding-top:9px}
.v-set b{display:flex;align-items:center;justify-content:center;min-height:34px;padding:4px 6px;font-size:12px;font-weight:600;color:#cfe0ee;text-align:center;line-height:1.25;background:var(--v-dalam);border:1px solid var(--v-naik);border-radius:6px}
.v-jam{display:flex;align-items:center;justify-content:center;gap:8px;min-height:46px;margin:0 0 24px;border-radius:8px;background:linear-gradient(180deg,#2bbd75,#178a52);color:#04240f;font-weight:800;font-size:13.5px;letter-spacing:.05em;text-decoration:none;text-align:center;padding:0 14px}
.v-merek{display:grid;grid-template-columns:repeat(3,1fr);gap:16px 10px;border:1px solid var(--v-naik);border-radius:10px;padding:18px 14px;margin:0 0 24px;background:rgba(18,49,82,.55)}
.v-merek span{text-align:center;font-size:12.5px;font-weight:600;color:#cfe0ee;line-height:1.3;align-self:center}

/* ---------- tanya jawab ---------- */
.v-tanya{border:1px solid var(--v-naik);border-radius:10px;padding:14px 15px;margin:0 0 10px;background:var(--v-panel2)}
.v-tanya:last-child{margin-bottom:24px}
.v-tanya dt{font-weight:700;font-size:15px;color:var(--v-emas-t);margin:0 0 5px}
.v-tanya dd{margin:0;font-size:14px;color:#c3d5e6}

/* ---------- tautan halaman ---------- */
.v-tautan{display:flex;flex-wrap:wrap;gap:8px;margin:0 0 8px}
.v-tautan a{display:inline-flex;align-items:center;min-height:44px;padding:10px 15px;background:var(--v-panel2);border:1px solid var(--v-naik);border-radius:7px;text-decoration:none;font-size:13.5px}

/* ---------- sisi & dok ---------- */
.v-sisi{position:fixed;left:0;top:50%;transform:translateY(-50%);z-index:70;display:grid;background:var(--v-dalam);border:1px solid var(--v-naik);border-left:0;border-radius:0 9px 9px 0;overflow:hidden}
.v-sisi a{display:grid;place-items:center;min-width:44px;min-height:44px;color:var(--v-emas);text-decoration:none}
.v-sisi a+a{border-top:1px solid var(--v-naik)}
.v-dok{position:fixed;left:0;right:0;bottom:0;z-index:80;background:var(--v-dalam);border-top:2px solid var(--v-emas);padding:5px 0 6px}
.v-dok .v-wrap{display:grid;grid-template-columns:repeat(5,1fr);padding:0 6px}
.v-dok a{display:grid;justify-items:center;gap:2px;align-content:center;min-height:56px;text-decoration:none;font-size:11.5px;color:var(--v-samar);text-align:center;line-height:1.2}
.v-dok i{line-height:0}
.v-dok .v-utama{color:var(--v-emas)}

/* ---------- kaki ---------- */
footer{padding:26px 0 24px;text-align:center}
footer img{margin:0 auto 16px;height:38px;width:auto}
.v-ingat{border-top:1px solid var(--v-naik);padding-top:15px;font-size:12px;color:#8ba3ba;line-height:1.65;text-align:left}

a:focus-visible,input:focus-visible{outline:3px solid var(--v-emas);outline-offset:2px}
@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.v-kabar p{animation:none;padding-left:0}}
@media (min-width:600px){.v-grid{grid-template-columns:repeat(3,1fr)}.v-set div,.v-merek{grid-template-columns:repeat(5,1fr)}.v-fitur{grid-template-columns:1fr 1fr}}
</style>
</head>
<body>

<header class="v-kepala">
<div class="v-wrap">
<a class="v-logo" href="/"><img src="<?= e($logoSrc) ?>" width="190" height="40" alt="<?= e($host) ?>"></a>
<?php if (count($menu) > 0): ?>
<details class="v-menu">
<summary aria-label="Buka menu halaman"><span></span><span></span><span></span></summary>
<nav aria-label="Menu halaman">
<a href="/">Beranda</a>
<?php foreach ($menu as $s => $label): ?><a href="/<?= e($s) ?>"><?= e($label) ?></a><?php endforeach; ?>
</nav>
</details>
<?php else: ?>
<a class="v-burger" href="#v-lainnya" aria-label="Lompat ke daftar halaman"><span></span><span></span><span></span></a>
<?php endif; ?>
</div>
</header>

<div class="v-kabar">
<i><?= $ikon['info'] ?></i>
<div><p>Selamat datang di <?= e($namaSitus) ?> &mdash; halaman informasi akses, alamat cadangan, dan mekanisme layanan. Terakhir diperbarui <?= e($tglTampil) ?>. Baca bagian tanya jawab sebelum mulai.</p></div>
</div>

<?php if ($banner1): ?>
<div class="v-spanduk"><a href="<?= e($daftarUrl) ?>" rel="nofollow"><img src="<?= e($banner1) ?>" width="860" height="330" alt="Banner <?= e($host) ?>" fetchpriority="high" decoding="async"></a></div>
<?php endif; ?>

<div class="v-aksi">
<a class="v-reg" href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $ikon['daftar'] ?></i>Daftar</a>
<a class="v-log" href="<?= e($loginUrl) ?>" rel="nofollow"><i><?= $ikon['masuk'] ?></i>Masuk</a>
</div>

<main>
<div class="v-wrap">

<nav class="v-rak" aria-label="Kategori permainan">
<?php foreach ($kategori as $k): ?>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $ikon[$k[0]] ?></i><?= e($k[1]) ?></a>
<?php endforeach; ?>
</nav>

<section class="v-jack">
<h2>Jackpot <span>Play</span></h2>
<output id="v-jp" data-awal="90107865095">IDR 90.107.865.095</output>
<a class="v-main" href="<?= e($daftarUrl) ?>" rel="nofollow">Play Now</a>
</section>
<p class="v-ilus">Angka di atas <strong>ilustrasi tampilan antarmuka</strong>, bukan nominal hadiah aktual dan bukan data waktu nyata.</p>

<section>
<div class="v-tajuk"><i><?= $ikon['bintang'] ?></i><h2>Demo Slots</h2></div>
<hr class="v-garis">
<div class="v-cari">
<i><?= $ikon['cari'] ?></i>
<input type="search" id="v-filter" placeholder="Cari game slots &hellip;" aria-label="Cari nama permainan">
</div>
<div class="v-grid" id="v-daftar">
<?php foreach ($daftarGame as $g): ?>
<article class="v-kartu" data-nama="<?= e(strtolower($g[0])) ?>">
<img src="/img/asset-game-<?= (int)$g[1] ?>.jpg" width="220" height="220" alt="<?= e($g[0]) ?>" loading="lazy" decoding="async">
<h3><?= e($g[0]) ?></h3>
<p>Slot Demo</p>
</article>
<?php endforeach; ?>
</div>
<p class="v-kosong" id="v-kosong">Tidak ada nama permainan yang cocok.</p>
</section>

<p class="v-remah"><a href="/">Beranda</a><?php if (!$isHome): ?> / <?= e($page['h1']) ?><?php endif; ?></p>

<article class="v-tulis">
<h1><?= e($page['h1']) ?></h1>
<p class="v-cap">Diperbarui <time datetime="<?= e($lastmod) ?>"><?= e($tglTampil) ?></time></p>
<?= $isiArtikel ?>
</article>

<section>
<div class="v-tajuk"><i><?= $ikon['bintang'] ?></i><h2>Fitur Permainan</h2></div>
<hr class="v-garis">
<div class="v-fitur">
<?php foreach ($fitur as $f): ?>
<article><h3><?= e($f[0]) ?></h3><p><?= e($f[1]) ?></p></article>
<?php endforeach; ?>
</div>
</section>

<section>
<div class="v-tajuk"><i><?= $ikon['tiket'] ?></i><h2>Metode Pembayaran</h2></div>
<hr class="v-garis">
<fieldset class="v-set"><legend>Transfer Bank</legend><div>
<?php foreach ($bayarBank as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<fieldset class="v-set"><legend>E-Money</legend><div>
<?php foreach ($bayarEmoney as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<fieldset class="v-set"><legend>Pulsa</legend><div>
<?php foreach ($bayarPulsa as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<a class="v-jam" href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank">Tanyakan Jam Operasional Bank</a>
</section>

<section>
<div class="v-tajuk"><i><?= $ikon['dadu'] ?></i><h2>Penyedia Games</h2></div>
<hr class="v-garis">
<div class="v-merek">
<?php foreach ($penyedia as $p): ?><span><?= e($p) ?></span><?php endforeach; ?>
</div>
</section>

<section>
<div class="v-tajuk"><i><?= $ikon['info'] ?></i><h2>Tanya Jawab</h2></div>
<hr class="v-garis">
<dl>
<?php foreach ($tanya as $t): ?>
<div class="v-tanya"><dt><?= e($t[0]) ?></dt><dd><?= e($t[1]) ?></dd></div>
<?php endforeach; ?>
</dl>
</section>

<?php if (count($bacaanLain) > 0): ?>
<section id="v-lainnya">
<div class="v-tajuk"><i><?= $ikon['pesan'] ?></i><h2><?= $isHome ? 'Bacaan Lain' : 'Halaman Terkait' ?></h2></div>
<hr class="v-garis">
<div class="v-tautan">
<?php foreach ($bacaanLain as $slug => $item): ?>
<?php if (!$isHome && isset($page['canonical_url']) && rtrim($page['canonical_url'], '/') === rtrim($origin . '/' . $slug, '/')) continue; ?>
<a href="/<?= e($slug) ?>"><?= e($item['title']) ?></a>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

</div>
</main>

<footer>
<div class="v-wrap">
<img src="<?= e($logoSrc) ?>" width="180" height="38" alt="<?= e($host) ?>" loading="lazy" decoding="async">
<?php if (count($menu) > 0): ?>
<nav class="v-kaki" aria-label="Halaman informasi">
<a href="/">Beranda</a>
<?php foreach ($menu as $s => $label): ?><a href="/<?= e($s) ?>"><?= e($label) ?></a><?php endforeach; ?>
</nav>
<?php endif; ?>
<p class="v-ingat"><strong>Khusus 18+.</strong> Halaman ini memuat informasi umum mengenai akses dan mekanisme layanan, bukan ajakan maupun jaminan kemenangan. Nama permainan, penyedia, dan metode pembayaran dicantumkan sebagai label tampilan, bukan katalog resmi maupun pernyataan kemitraan. Pahami risiko finansial dan tentukan batas sendiri sebelum berpartisipasi.<br><br>&copy; <?= date('Y') ?> <?= e($host) ?></p>
</div>
</footer>

<nav class="v-sisi" aria-label="Kontak cepat">
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank" aria-label="WhatsApp"><?= $ikon['wa'] ?></a>
<a href="<?= e($tgUrl) ?>" rel="nofollow noopener" target="_blank" aria-label="Telegram"><?= $ikon['tg'] ?></a>
</nav>

<nav class="v-dok" aria-label="Navigasi utama">
<div class="v-wrap">
<a href="/"><i><?= $ikon['rumah'] ?></i>Home</a>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $ikon['daftar'] ?></i>Daftar</a>
<a class="v-utama" href="<?= e($loginUrl) ?>" rel="nofollow"><i><?= $ikon['masuk'] ?></i>Masuk</a>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $ikon['tiket'] ?></i>Promosi</a>
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank"><i><?= $ikon['pesan'] ?></i>Kontak</a>
</div>
</nav>

<script>
(function () {
var jp = document.getElementById('v-jp');
if (jp) {
var n = parseInt(jp.getAttribute('data-awal'), 10);
var diam = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
var tulis = function () { jp.textContent = 'IDR ' + n.toLocaleString('id-ID'); };
if (n) { tulis(); if (!diam) { setInterval(function () { n += 1000 + Math.floor(Math.random() * 9000); tulis(); }, 2400); } }
}
var isi = document.getElementById('v-filter');
var rak = document.getElementById('v-daftar');
var pesan = document.getElementById('v-kosong');
if (isi && rak && pesan) {
var kartu = rak.querySelectorAll('.v-kartu');
isi.addEventListener('input', function () {
var q = isi.value.trim().toLowerCase();
var ada = 0;
for (var i = 0; i < kartu.length; i++) {
var cocok = q === '' || kartu[i].getAttribute('data-nama').indexOf(q) !== -1;
kartu[i].style.display = cocok ? '' : 'none';
if (cocok) ada++;
}
pesan.style.display = ada ? 'none' : 'block';
});
}
})();
</script>

</body>
</html>
