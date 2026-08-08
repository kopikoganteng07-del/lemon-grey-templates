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

// og:image WAJIB URL mutlak. Jalur relatif membuat pratinjau bagikan di
// WhatsApp dan Facebook gagal memuat gambar.
$ogAbs = $ogImage ? ((strpos($ogImage, 'http') === 0) ? $ogImage : $origin . $ogImage) : '';

// Menu halaman informasi. Dicocokkan dengan AKHIRAN slug, bukan slug persis,
// karena staf memakai pola berawalan nama domain (mis. domain-link-alternatif).
// Pola yang lebih panjang didahulukan supaya 'cara-daftar' tidak tertelan 'daftar'.
// Satu label hanya dipakai sekali. Halaman yang belum ada tidak ditampilkan,
// jadi tidak pernah ada tautan mati.
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

$menuHalaman = [];
$labelDipakai = [];
foreach ($polaMenu as $pola => $label) {
if (isset($labelDipakai[$label])) { continue; }
foreach ($semuaPost as $slug => $item) {
if (isset($menuHalaman[$slug])) { continue; }
$s = strtolower(trim($slug));
if ($s === $pola || substr($s, -(strlen($pola) + 1)) === '-' . $pola) {
$menuHalaman[$slug] = $label;
$labelDipakai[$label] = true;
break;
}
}
}
// Artikel biasa dipisah dari menu supaya Disclaimer tidak ikut muncul di
// daftar bacaan lain.
$bacaanLain = array_diff_key($semuaPost, $menuHalaman);

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

$namaSitus = explode('.', $host)[0];

$svg = [
'home'   => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M3 11.2 12 3l9 8.2V21a1 1 0 0 1-1 1h-5v-7H9v7H4a1 1 0 0 1-1-1z"/></svg>',
'api'    => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M12 2c1.2 4.2-3 5.4-3 9.2a3 3 0 0 0 6 0c0-1.1-.5-2.1-1-3.1 2.2 1.1 4 3.2 4 6.1a6 6 0 1 1-12 0C6 9 10 7.2 12 2z"/></svg>',
'reel'   => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M3 5h5v14H3zm6.5 0h5v14h-5zM16 5h5v14h-5z"/></svg>',
'sekop'  => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M12 2.5C9.2 7 5 8.8 5 12.8A3.8 3.8 0 0 0 11 16l-1.1 5.5h4.2L13 16a3.8 3.8 0 0 0 6-3.2c0-4-4.2-5.8-7-10.3z"/></svg>',
'bola'   => '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path d="m12 7 4 3-1.5 5h-5L8 10z"/></svg>',
'kotak'  => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><path d="M3 3h8v8H3zm10 0h8v8h-8zM3 13h8v8H3zm10 0h8v8h-8z"/></svg>',
'kartu'  => '<svg viewBox="0 0 24 24" width="26" height="26" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><rect x="4" y="3" width="16" height="18" rx="2"/><circle cx="12" cy="12" r="3.2"/></svg>',
'angka'  => '<svg viewBox="0 0 24 24" width="26" height="26" fill="currentColor" aria-hidden="true"><circle cx="6" cy="6" r="2.3"/><circle cx="12" cy="6" r="2.3"/><circle cx="18" cy="6" r="2.3"/><circle cx="6" cy="12" r="2.3"/><circle cx="12" cy="12" r="2.3"/><circle cx="18" cy="12" r="2.3"/><circle cx="6" cy="18" r="2.3"/><circle cx="12" cy="18" r="2.3"/><circle cx="18" cy="18" r="2.3"/></svg>',
'intan'  => '<svg viewBox="0 0 24 24" width="24" height="24" fill="currentColor" aria-hidden="true"><path d="M6 3h12l4 6-10 12L2 9z"/></svg>',
'wa'     => '<svg viewBox="0 0 24 24" width="25" height="25" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.6 15.1L2 22l5.1-1.3A10 10 0 1 0 12 2zm0 2a8 8 0 1 1-4.2 14.8l-.4-.2-2.6.7.7-2.5-.3-.4A8 8 0 0 1 12 4zM9 8.2c-.2 0-.5.1-.7.4-.3.3-.9.9-.9 2s.9 2.3 1 2.5c.1.2 1.7 2.8 4.3 3.8 2.1.8 2.6.7 3 .6.6-.1 1.7-.7 1.9-1.4.2-.7.2-1.2.2-1.4-.1-.1-.3-.2-.5-.3l-1.8-.9c-.2-.1-.4-.1-.6.1l-.8 1c-.1.2-.3.2-.5.1-.7-.3-1.5-.7-2.2-1.6-.5-.7-.5-1-.4-1.2l.5-.7c.1-.2.1-.4 0-.6l-.8-1.8c-.2-.4-.4-.3-.6-.3z"/></svg>',
'hadiah' => '<svg viewBox="0 0 24 24" width="25" height="25" fill="currentColor" aria-hidden="true"><path d="M20 8h-2.2A3 3 0 0 0 12 4.8 3 3 0 0 0 6.2 8H4a1 1 0 0 0-1 1v3h8V8h2v4h8V9a1 1 0 0 0-1-1zM4 14v6a1 1 0 0 0 1 1h6v-7zm9 7h6a1 1 0 0 0 1-1v-6h-7z"/></svg>',
'obrol'  => '<svg viewBox="0 0 24 24" width="25" height="25" fill="currentColor" aria-hidden="true"><path d="M4 3h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2H9l-5 4v-4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2zm3 5h10v2H7zm0 4h7v2H7z"/></svg>',
];

$navKategori = [
['t' => 'Home',         'i' => 'home'],
['t' => 'Hot Games',    'i' => 'api'],
['t' => 'Slots',        'i' => 'reel'],
['t' => 'Live Casino',  'i' => 'sekop'],
['t' => 'Sports',       'i' => 'bola'],
['t' => 'Arcade',       'i' => 'kotak'],
['t' => 'Poker',        'i' => 'kartu'],
['t' => 'Togel Online', 'i' => 'angka'],
];

$gameBest = [
['n' => 'Gerbang Rejeki', 'g' => 1],
['n' => 'Mahkota Petir',  'g' => 2],
['n' => 'Kuil Firaun',    'g' => 3],
['n' => 'Ular Fortuna',   'g' => 4],
['n' => 'Palung Samudra', 'g' => 5],
['n' => 'Sinar Rembulan', 'g' => 1],
];
$gameHarian = [
['n' => 'Pedang Perkasa',  'g' => 2],
['n' => 'Bangkit Asgard',  'g' => 3],
['n' => 'Brankas Terbuka', 'g' => 4],
['n' => 'Pusaka Agung',    'g' => 5],
['n' => 'Bangkit Samurai', 'g' => 1],
['n' => 'Tiga Permohonan', 'g' => 2],
];
$gamePanas = [
['n' => 'Kucing Hoki',    'g' => 3],
['n' => 'Ninja vs Ronin', 'g' => 4],
['n' => 'Perisai Athena', 'g' => 5],
['n' => 'Dewa Kekayaan',  'g' => 1],
['n' => 'Serbuan Horde',  'g' => 2],
['n' => 'Adu Jago',       'g' => 3],
];

$penyedia = ['Pragmatic','PG Soft','Habanero','CQ9','Spadegaming','TopTrend','Joker','Microgaming','ION','Sexy Gaming','Allbet','IDN Live'];
$bayarBank = ['BCA','Danamon','Permata','Mandiri','BNI','BRI','BTPN','Panin','Maybank','BJB'];
$bayarPulsa = ['XL Axiata','Tri','Telkomsel','Axis'];
$bayarEmoney = ['DANA','OVO','LinkAja','GoPay','ShopeePay','Jenius'];

$faqList = [
['t' => 'Apa arti angka pada papan Progressive Jackpot?',
'j' => 'Angka itu ilustrasi tampilan antarmuka, bukan nominal hadiah aktual dan bukan data waktu nyata. Nominal sebenarnya hanya berlaku sesuai ketentuan penyelenggara pada periode berjalan.'],
['t' => 'Apa fungsi link alternatif ' . $namaSitus . '?',
'j' => 'Link alternatif adalah jalur akses cadangan menuju server yang sama, dipakai ketika alamat utama sedang tidak dapat dibuka di suatu jaringan.'],
['t' => 'Apakah nama permainan di halaman ini mewakili katalog resmi?',
'j' => 'Tidak. Nama pada kartu permainan adalah label tampilan untuk menggambarkan jenis permainan, bukan daftar katalog resmi maupun klaim ketersediaan judul tertentu.'],
['t' => 'Apakah daftar penyedia berarti ada kemitraan resmi?',
'j' => 'Tidak. Nama penyedia dicantumkan sebagai informasi umum mengenai jenis layanan yang lazim dijumpai, bukan pernyataan kemitraan atau dukungan resmi.'],
['t' => 'Ke mana menghubungi bantuan?',
'j' => 'Lewat tombol WhatsApp dan Livechat pada bagian bawah halaman. Keduanya terbuka di tab baru.'],
];
?>
<!DOCTYPE html>
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
<meta property="og:type" content="<?= $isHome ? 'website' : 'article' ?>">
<meta property="og:url" content="<?= e($canonical) ?>">
<meta property="og:title" content="<?= e($page['title']) ?>">
<meta property="og:description" content="<?= e($page['meta_description']) ?>">
<meta property="og:image" content="<?= e($ogAbs) ?>">
<meta name="twitter:card" content="summary_large_image">

<script type="application/ld+json">
{
"@context":"https://schema.org",
"@graph":[
<?php if ($isHome): ?>
{
"@type":"FAQPage",
"mainEntity":[
<?php foreach ($faqList as $i => $f): ?>
{"@type":"Question","name":<?= json_encode($f['t'], JSON_UNESCAPED_UNICODE) ?>,"acceptedAnswer":{"@type":"Answer","text":<?= json_encode($f['j'], JSON_UNESCAPED_UNICODE) ?>}}<?= $i < count($faqList) - 1 ? ',' : '' ?>

<?php endforeach; ?>
]
},
<?php endif; ?>
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
"image":<?= json_encode($ogImage ? $origin . $ogImage : '', JSON_UNESCAPED_UNICODE) ?>,
"datePublished":<?= json_encode($dateMod, JSON_UNESCAPED_UNICODE) ?>,
"dateModified":<?= json_encode($dateMod, JSON_UNESCAPED_UNICODE) ?>,
"inLanguage":"id-ID",
"author":{"@type":"Organization","name":<?= json_encode($host, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>},
"publisher":{"@type":"Organization","name":<?= json_encode($host, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>,"logo":{"@type":"ImageObject","url":<?= json_encode($origin . $logoSrc, JSON_UNESCAPED_UNICODE) ?>}},
"mainEntityOfPage":{"@type":"WebPage","@id":<?= json_encode($canonical, JSON_UNESCAPED_UNICODE) ?>}
}
]
}
</script>
<style>
:root{--k-hitam:#000;--k-panel:#1a1a1a;--k-naik:#242424;--k-garis:#333;--k-hijau:#12a150;--k-hijau-t:#1ec46a;--k-hijau-g:#0b7a3c;--k-emas:#f5c518;--k-teks:#fff;--k-samar:#9a9a9a}
*{box-sizing:border-box}
body{margin:0;background:var(--k-hitam);color:var(--k-teks);font-family:system-ui,"Segoe UI Variable","Segoe UI",Roboto,"Noto Sans",Ubuntu,sans-serif;font-size:16px;line-height:1.6;padding-bottom:84px}
.k-lebar{max-width:820px;margin:0 auto;padding:0 12px}
a{color:inherit}
img{max-width:100%;display:block}

.k-atas{position:sticky;top:0;z-index:70;background:var(--k-panel);border-bottom:1px solid var(--k-garis)}
.k-atas .k-lebar{display:grid;grid-template-columns:48px 1fr 48px;align-items:center;padding-top:10px;padding-bottom:10px}
.k-atas a:first-child{grid-column:2}
.k-atas img{height:42px;width:auto;margin:0 auto}
.k-burger{grid-column:3;display:grid;gap:5px;align-content:center;justify-items:center;min-width:48px;min-height:48px;text-decoration:none}
.k-burger span{display:block;width:26px;height:3px;border-radius:2px;background:var(--k-teks)}

.k-spanduk img{width:100%;height:auto;background:var(--k-naik)}

.k-aksi{display:grid;grid-template-columns:1fr 1fr}
.k-aksi a{display:grid;place-items:center;min-height:58px;font-size:19px;font-weight:600;text-decoration:none}
.k-aksi .daftar{background:linear-gradient(180deg,var(--k-hijau-t),var(--k-hijau-g));color:#fff}
.k-aksi .login{background:#6b6b6b;color:#fff}

.k-menu{display:grid;grid-template-columns:repeat(4,1fr);gap:6px;padding:18px 0 6px}
.k-menu a{display:grid;justify-items:center;gap:7px;padding:10px 2px;min-height:74px;text-decoration:none;font-size:12.5px;color:var(--k-samar);text-align:center;line-height:1.25}
.k-menu i{color:var(--k-hijau-t);line-height:0}

.k-jack{margin:16px 0 8px;border:2px solid var(--k-hijau-t);border-radius:8px;background:linear-gradient(180deg,#0e1a12,#050b07);padding:10px 12px;display:grid;grid-template-columns:auto 1fr;gap:12px;align-items:center}
.k-jack b{display:block;font-size:11px;letter-spacing:.16em;line-height:1.2;color:var(--k-hijau-t);text-transform:uppercase}
.k-jack b em{display:block;font-style:normal;font-size:16px;font-weight:800;letter-spacing:.08em}
.k-jack output{display:block;background:#000;border:1px solid var(--k-hijau-g);border-radius:5px;padding:9px 8px;text-align:center;font-family:ui-monospace,"Cascadia Mono","Roboto Mono",Menlo,monospace;font-size:clamp(16px,4.6vw,23px);font-weight:700;letter-spacing:.04em;color:var(--k-hijau-t)}
.k-ilus{font-size:11.5px;color:var(--k-samar);text-align:center;margin:0 0 22px;line-height:1.5}

.k-judul{display:flex;align-items:center;gap:9px;margin:0 0 9px}
.k-judul h2{font-size:23px;font-weight:600;margin:0}
.k-judul i{color:var(--k-hijau-t);line-height:0}
.k-judul .tujuh{color:var(--k-emas);font-size:26px;font-weight:800;line-height:1}
.k-rule{border:0;height:3px;background:var(--k-hijau);margin:0 0 14px;border-radius:2px}

.k-rak{display:grid;grid-template-columns:repeat(3,1fr);gap:9px;margin:0 0 26px}
.k-rak article{background:linear-gradient(180deg,var(--k-hijau-t),var(--k-hijau-g));border-radius:9px;padding:5px;overflow:hidden}
.k-rak img{width:100%;height:auto;aspect-ratio:1/1;object-fit:cover;border-radius:6px;background:#0d0d0d}
.k-rak h3{margin:0;padding:7px 3px 3px;font-size:13px;font-weight:500;text-align:center;color:#fff;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}

.k-remah{font-size:13px;color:var(--k-samar);margin:16px 0 0}
.k-remah a{color:var(--k-hijau-t);text-decoration:none}

.k-artikel{padding:22px 0 6px}
.k-artikel h1{font-size:clamp(27px,7vw,36px);font-weight:800;color:var(--k-hijau-t);text-align:center;line-height:1.2;margin:0 0 6px}
.k-cap{color:var(--k-samar);font-size:13px;text-align:center;margin:0 0 20px}
.k-artikel p,.k-artikel ul,.k-artikel ol{color:#e4e4e4}
.k-artikel p{text-align:justify;hyphens:auto;margin:0 0 18px}
.k-artikel h2{font-size:clamp(20px,5.2vw,26px);font-weight:800;color:var(--k-hijau-t);text-align:center;line-height:1.3;margin:26px 0 14px}
.k-artikel h3{font-size:18px;color:var(--k-hijau-t);margin:20px 0 8px}
.k-artikel ul,.k-artikel ol{padding-left:20px;margin:0 0 18px}
.k-artikel li{margin-bottom:7px}
.k-artikel a{color:var(--k-emas)}
.k-artikel strong{color:var(--k-hijau-t)}

.k-blok{text-align:center;font-size:18px;color:#d4d4d4;margin:26px 0 14px}
.k-kotak{border:1px solid var(--k-garis);border-radius:10px;padding:22px 14px;margin:0 0 22px}
.k-merek{display:grid;grid-template-columns:repeat(4,1fr);gap:22px 10px}
.k-merek span{text-align:center;font-size:12.5px;font-weight:600;letter-spacing:.02em;color:#cfcfcf;align-self:center;line-height:1.3}

.k-set{border:1px solid var(--k-garis);border-radius:10px;padding:4px 14px 16px;margin:0 0 14px}
.k-set legend{padding:0 7px;font-size:14px;color:#d4d4d4}
.k-set div{display:grid;grid-template-columns:repeat(4,1fr);gap:16px 6px;padding-top:8px}
.k-set b{display:flex;align-items:center;justify-content:center;gap:6px;font-size:11.5px;font-weight:600;color:#cfcfcf;text-align:center;line-height:1.25}
.k-set b::after{content:"";width:4px;height:15px;background:var(--k-hijau-t);border-radius:1px;flex:0 0 auto}
.k-set.tanpa b::after{display:none}

.k-tanya{border:1px solid var(--k-garis);border-radius:10px;padding:14px 15px;margin:0 0 10px;background:#0e0e0e}
.k-tanya:last-child{margin-bottom:0}
.k-tanya dt{font-weight:600;font-size:15px;color:var(--k-hijau-t);margin:0 0 5px}
.k-tanya dd{margin:0;font-size:14px;color:#b8b8b8}

.k-tautan{display:flex;flex-wrap:wrap;gap:8px}
.k-tautan a{padding:10px 15px;min-height:44px;display:inline-flex;align-items:center;background:var(--k-panel);border:1px solid var(--k-garis);border-radius:6px;text-decoration:none;font-size:13.5px}

footer{padding:28px 0 26px;text-align:center}
footer img{margin:0 auto 18px;height:40px;width:auto}
.k-ingat{border-top:1px solid var(--k-garis);padding-top:16px;font-size:12px;color:#8a8a8a;line-height:1.65;text-align:left}

.k-dok{position:fixed;left:0;right:0;bottom:0;z-index:80;background:var(--k-panel);border-top:1px solid var(--k-garis);padding:7px 0 8px}
.k-dok .k-lebar{display:grid;grid-template-columns:repeat(3,1fr)}
.k-dok a{display:grid;justify-items:center;gap:3px;min-height:56px;align-content:center;text-decoration:none;font-size:13px;color:var(--k-teks)}
.k-dok i{color:var(--k-hijau-t);line-height:0}

a:focus-visible{outline:3px solid var(--k-emas);outline-offset:2px}
@media (prefers-reduced-motion:reduce){*{scroll-behavior:auto !important}}
@media (max-width:359px){.k-menu{grid-template-columns:repeat(3,1fr)}}
.navinfo{border-bottom:1px solid rgba(255,255,255,.10);padding:10px 0}
.navinfo .k-tautan{margin:0}
</style>
</head>
<body>

<header class="k-atas">
<div class="k-lebar">
<a href="/"><img src="<?= e($logoSrc) ?>" width="190" height="42" alt="<?= e($host) ?>"></a>
<a class="k-burger" href="#k-lainnya" aria-label="Lompat ke daftar halaman"><span></span><span></span><span></span></a>
</div>
</header>

<?php if (count($menuHalaman) > 0): ?>
<nav class="navinfo" aria-label="Halaman informasi">
<div class="k-lebar">
<div class="k-tautan">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
</div>
</nav>
<?php endif; ?>

<?php if (!empty($banner1)): ?>
<div class="k-spanduk"><a href="<?= e($daftarUrl) ?>" rel="nofollow"><img src="<?= e($banner1) ?>" width="728" height="300" alt="Banner <?= e($host) ?>" fetchpriority="high" decoding="async"></a></div>
<?php endif; ?>

<div class="k-aksi">
<a class="daftar" href="<?= e($daftarUrl) ?>" rel="nofollow">Daftar</a>
<a class="login" href="<?= e($loginUrl) ?>" rel="nofollow">Login</a>
</div>

<main>
<div class="k-lebar">

<?php if ($isHome): ?>
<nav class="k-menu">
<?php foreach ($navKategori as $k): ?>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $svg[$k['i']] ?></i><?= e($k['t']) ?></a>
<?php endforeach; ?>
</nav>

<div class="k-jack">
<b>Progressive<em>Jackpot</em></b>
<output id="k-jp" data-awal="683286894">IDR 683.286.894</output>
</div>
<p class="k-ilus">Angka di atas <strong>ilustrasi tampilan</strong>, bukan nominal hadiah aktual dan bukan data waktu nyata.</p>

<section>
<div class="k-judul"><span class="tujuh">7</span><h2>Best Games</h2></div>
<hr class="k-rule">
<div class="k-rak">
<?php foreach ($gameBest as $g): ?>
<article><img src="/img/asset-game-<?= (int)$g['g'] ?>.jpg" width="220" height="220" alt="<?= e($g['n']) ?>" loading="lazy" decoding="async"><h3><?= e($g['n']) ?></h3></article>
<?php endforeach; ?>
</div>
</section>

<section>
<div class="k-judul"><i><?= $svg['intan'] ?></i><h2>Daily Wins</h2></div>
<hr class="k-rule">
<div class="k-rak">
<?php foreach ($gameHarian as $g): ?>
<article><img src="/img/asset-game-<?= (int)$g['g'] ?>.jpg" width="220" height="220" alt="<?= e($g['n']) ?>" loading="lazy" decoding="async"><h3><?= e($g['n']) ?></h3></article>
<?php endforeach; ?>
</div>
</section>

<section>
<div class="k-judul"><i><?= $svg['api'] ?></i><h2>Hot Games</h2></div>
<hr class="k-rule">
<div class="k-rak">
<?php foreach ($gamePanas as $g): ?>
<article><img src="/img/asset-game-<?= (int)$g['g'] ?>.jpg" width="220" height="220" alt="<?= e($g['n']) ?>" loading="lazy" decoding="async"><h3><?= e($g['n']) ?></h3></article>
<?php endforeach; ?>
</div>
</section>
<?php else: ?>
<p class="k-remah"><a href="/">Beranda</a> / <?= e($page['h1']) ?></p>
<?php endif; ?>

<article class="k-artikel">
<h1><?= e($page['h1']) ?></h1>
<p class="k-cap">Diperbarui <time datetime="<?= e($lastmod) ?>"><?= e($tglTampil) ?></time></p>
<?= $isiArtikel ?>
</article>

<?php if ($isHome): ?>
<p class="k-blok">Pertanyaan Umum</p>
<dl>
<?php foreach ($faqList as $f): ?>
<div class="k-tanya"><dt><?= e($f['t']) ?></dt><dd><?= e($f['j']) ?></dd></div>
<?php endforeach; ?>
</dl>

<p class="k-blok">Penyedia Games</p>
<div class="k-kotak"><div class="k-merek">
<?php foreach ($penyedia as $p): ?><span><?= e($p) ?></span><?php endforeach; ?>
</div></div>

<p class="k-blok">Metode Pembayaran</p>
<fieldset class="k-set"><legend>Transfer Bank</legend><div>
<?php foreach ($bayarBank as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<fieldset class="k-set tanpa"><legend>Pulsa</legend><div>
<?php foreach ($bayarPulsa as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<fieldset class="k-set tanpa"><legend>E-Money</legend><div>
<?php foreach ($bayarEmoney as $b): ?><b><?= e($b) ?></b><?php endforeach; ?>
</div></fieldset>
<?php endif; ?>

<?php if (count($bacaanLain) > 0): ?>
<section id="k-lainnya">
<p class="k-blok"><?= $isHome ? 'Bacaan Lain' : 'Halaman Terkait' ?></p>
<div class="k-tautan">
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
<div class="k-lebar">
<img src="<?= e($logoSrc) ?>" width="180" height="40" alt="<?= e($host) ?>" loading="lazy" decoding="async">
<?php if (count($menuHalaman) > 0): ?>
<div class="k-tautan" style="margin-bottom:16px">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
<?php endif; ?>
<p class="k-ingat"><strong>Khusus 18+.</strong> Halaman ini memuat informasi umum mengenai akses dan mekanisme layanan, bukan ajakan maupun jaminan kemenangan. Nama permainan dan penyedia dicantumkan sebagai label tampilan, bukan katalog resmi. Pahami risiko finansial dan tentukan batas sendiri sebelum berpartisipasi.<br><br>&copy; <?= date('Y') ?> <?= e($host) ?></p>
</div>
</footer>

<div class="k-dok">
<div class="k-lebar">
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank"><i><?= $svg['wa'] ?></i>Whatsapp</a>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><i><?= $svg['hadiah'] ?></i>Promosi</a>
<a href="<?= e($tgUrl) ?>" rel="nofollow noopener" target="_blank"><i><?= $svg['obrol'] ?></i>Livechat</a>
</div>
</div>

<script>
(function () {
var el = document.getElementById('k-jp');
if (!el) return;
var n = parseInt(el.getAttribute('data-awal'), 10);
if (!n) return;
function tulis() { el.textContent = 'IDR ' + n.toLocaleString('id-ID'); }
tulis();
if (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
setInterval(function () { n += 1000 + Math.floor(Math.random() * 9000); tulis(); }, 2200);
})();
</script>

</body>
</html>
