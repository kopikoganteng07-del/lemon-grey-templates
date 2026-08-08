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

$logoSrc    = $homepage['logo_src']       ?? '/img/logo.png';
$faviconSrc = $homepage['favicon_src']    ?? '/img/favicon.png';
$banner1    = $homepage['banner_src']     ?? '';
$waUrl      = $homepage['whatsapp_cta']   ?? '#';
$tgUrl      = $homepage['telegram_cta']   ?? '#';
$daftarUrl  = $homepage['cta_daftar_url'] ?? '#';
$loginUrl   = $homepage['cta_login_url']  ?? '#';

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

$railKategori = [
['t' => $namaSitus,        'img' => '/img/asset-game-1.jpg'],
['t' => 'SITUS MAHJONG',   'img' => '/img/asset-game-2.jpg'],
['t' => 'RTP MAHJONG',     'img' => '/img/asset-game-3.jpg'],
['t' => 'LINK ALTERNATIF', 'img' => '/img/asset-game-4.jpg'],
['t' => 'LIVE CHAT',       'img' => '/img/asset-game-5.jpg'],
];

$infoRows = [
['k' => 'Nama Situs',           'v' => '<span class="chip">' . e($namaSitus) . '</span>'],
['k' => 'Jenis Layanan',        'v' => 'INFORMASI &amp; LINK ALTERNATIF'],
['k' => 'Minimal Top Up',       'v' => '<span class="chip">IDR 25.000</span>'],
['k' => 'Minimal Withdraw',     'v' => '<span class="chip">IDR 50.000</span>'],
['k' => 'Transaksi Pembayaran', 'v' => 'Transfer Bank Lokal &middot; E-wallet &middot; QRIS'],
['k' => 'Rating Tampilan Situs','v' => '<span class="stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span>'],
];

$marketRows = [
['t' => 'SLOT MAHJONG',    'n' => '4.9'],
['t' => 'MAHJONG GRATIS',  'n' => '4.9'],
['t' => 'LINK ALTERNATIF', 'n' => '4.6'],
];

$faqList = [
['t' => 'Apa fungsi utama dari link alternatif ' . $namaSitus . '?',
'j' => 'Link alternatif berfungsi sebagai jalur akses cadangan agar pemain tetap terhubung ke server yang sama meskipun akses utama terganggu atau terblokir di wilayah tertentu.'],
['t' => 'Berapa minimal top up dan withdraw?',
'j' => 'Minimal top up IDR 25.000 dan minimal withdraw IDR 50.000. Nominal ini dapat berubah, jadi periksa kembali informasi terbaru sebelum bertransaksi.'],
['t' => 'Metode pembayaran apa saja yang didukung?',
'j' => 'Transfer bank lokal, e-wallet, dan QRIS. Ketersediaan tiap metode dapat berbeda mengikuti jam operasional bank atau penyedia dompet digital.'],
['t' => 'Apakah angka rating di halaman ini penilaian resmi?',
'j' => 'Bukan. Angka tersebut merangkum tanggapan pengguna terhadap tampilan dan kemudahan akses halaman, bukan penilaian dari lembaga independen.'],
['t' => 'Bagaimana cara menghubungi bantuan?',
'j' => 'Melalui tombol Live Chat di bagian bawah halaman, atau lewat kontak WhatsApp dan Telegram yang tercantum di footer.'],
];

$ulasan = [
['n' => 'Aris Munandar', 'p' => 'Sangat membantu menemukan link alternatif yang benar-benar aktif. Aksesnya cepat dan tidak perlu bolak-balik cari domain baru.'],
['n' => 'Santi Wijaya',  'p' => 'Awalnya ragu, tapi setelah masuk tampilannya rapi dan informasinya jelas. Bagian minimal transaksi paling membantu buat pemula.'],
['n' => 'Fajar Pratama', 'p' => 'Info FAQ-ya lengkap, jadi tidak perlu tanya-tanya dulu ke admin. Link alternatifnya juga masih jalan waktu domain utama susah dibuka.'],
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
},
{
"@type":"BreadcrumbList",
"itemListElement":[
{"@type":"ListItem","position":1,"name":"Beranda","item":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>}<?php if (!$isHome): ?>,
{"@type":"ListItem","position":2,"name":<?= json_encode($page['h1'], JSON_UNESCAPED_UNICODE) ?>,"item":<?= json_encode($canonical, JSON_UNESCAPED_UNICODE) ?>}<?php endif; ?>

]
}<?php if ($isHome): ?>,
{
"@type":"FAQPage",
"mainEntity":[
<?php foreach ($faqList as $i => $f): ?>
{"@type":"Question","name":<?= json_encode($f['t'], JSON_UNESCAPED_UNICODE) ?>,"acceptedAnswer":{"@type":"Answer","text":<?= json_encode($f['j'], JSON_UNESCAPED_UNICODE) ?>}}<?= $i < count($faqList) - 1 ? ',' : '' ?>

<?php endforeach; ?>
]
}<?php endif; ?>

]
}
</script>
<style>
:root{--bg:#f1f2f4;--card:#fff;--ink:#14121f;--ink-soft:#4a4a55;--line:#e2e4e9;--orange:#f7761f;--orange-dk:#d95d09;--gold:#ffd23f;--blue:#4a55d4;--red:#e23b2e}
*{box-sizing:border-box}
body{margin:0;background:var(--bg);color:var(--ink);font-family:-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif;font-size:16px;line-height:1.6;padding-bottom:84px}
.wrap{max-width:900px;margin:0 auto;padding:0 14px}
a{color:inherit}
img{max-width:100%}
h1,h2,h3{line-height:1.25;letter-spacing:-.01em}

.masthead{background:#17151f;padding:18px 0 0}
.logoline{text-align:center;padding-bottom:16px}
.logoline img{height:52px;width:auto}
.seekbar{display:flex;border:3px solid var(--gold);border-radius:6px;overflow:hidden;background:#fff}
.seekbar span{flex:1;padding:13px 14px;color:#9aa0ac;font-size:14.5px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.seekbar i{width:58px;display:grid;place-items:center;background:var(--blue);color:#fff;font-style:normal;font-size:17px;border-left:3px solid var(--red)}
.tabs{display:flex;gap:26px;padding:16px 0 0;justify-content:center}
.tabs b,.tabs span{font-size:15px;padding-bottom:9px;font-weight:700;color:#8d93a1}
.tabs b{color:#fff;border-bottom:3px solid var(--blue)}
.rail{display:flex;gap:20px;overflow-x:auto;padding:16px 0 20px;scroll-snap-type:x proximity}
.rail::-webkit-scrollbar{display:none}
.rail a{flex:0 0 auto;width:104px;text-align:center;text-decoration:none;scroll-snap-align:start}
.rail img{width:66px;height:66px;border-radius:50%;object-fit:cover;border:2px solid var(--gold);background:#241f2e}
.rail b{display:block;margin-top:7px;color:#fff;font-size:12.5px;font-weight:700;line-height:1.3}

.ctapair{display:grid;grid-template-columns:1fr 1fr;gap:14px;padding:22px 0 6px}
.big{display:grid;place-items:center;min-height:56px;border-radius:12px;font-weight:800;font-size:19px;letter-spacing:.04em;text-decoration:none}
.big-login{background:linear-gradient(#fb9440,var(--orange-dk));color:#fff;box-shadow:0 4px 0 #a94806}
.big-daftar{background:linear-gradient(#31303a,#111017);color:var(--gold);box-shadow:0 4px 0 #000;border:2px solid var(--gold)}

h1{font-size:clamp(24px,5.6vw,32px);font-weight:800;margin:20px 0 10px}
.pricetag{font-size:clamp(28px,7vw,38px);font-weight:800;margin:0 0 6px;letter-spacing:-.02em}
.stampline{color:#6b7280;font-size:13.5px;margin:0 0 18px}
.crumb{font-size:13px;color:#6b7280;padding:14px 0 0;margin:0}
.crumb a{color:var(--orange-dk);text-decoration:none}

.slider{display:flex;gap:12px;overflow-x:auto;scroll-snap-type:x mandatory;padding-bottom:6px;margin:0 0 26px}
.slider::-webkit-scrollbar{display:none}
.slider a{flex:0 0 100%;scroll-snap-align:center}
.slider img{width:100%;height:auto;border-radius:12px;display:block;background:#ddd}

.panel{background:var(--card);border-radius:14px;padding:20px 16px;margin:0 0 20px;box-shadow:0 1px 2px rgba(20,18,31,.06)}
.panel h2{font-size:clamp(20px,4.6vw,25px);font-weight:800;margin:0 0 12px}
.rule{height:3px;background:var(--orange);width:100%;border-radius:2px;margin:0 0 18px}

.infocard{border:2px solid var(--red);border-radius:14px;overflow:hidden;margin:0 0 20px;background:#fff}
.infocard-top{background:#17151f;color:var(--red);text-align:center;padding:16px 12px;font-weight:800;font-size:19px}
.inforow{padding:13px 16px;border-bottom:1px solid var(--line)}
.inforow:last-child{border-bottom:0}
.inforow dt{font-weight:700;font-size:15.5px;margin:0 0 6px}
.inforow dd{margin:0;padding-left:12px;border-left:3px solid var(--red);font-size:15px;color:var(--ink-soft)}
.chip{display:inline-block;background:#fdeceb;color:var(--red);font-weight:700;padding:3px 10px;border-radius:5px;font-size:14px}
.stars{color:var(--red);letter-spacing:3px;font-size:17px}

.market{background:var(--blue);color:#fff;border-radius:14px;padding:26px 18px;text-align:center;margin:0 0 20px}
.market h2{font-size:clamp(21px,5vw,27px);font-weight:800;margin:0 0 22px;color:#fff}
.market dl{margin:0}
.market dt{font-weight:700;font-size:16px;margin:0 0 4px}
.market dd{margin:0 0 20px;font-size:14px;color:#dfe2ff}
.market dd:last-child{margin-bottom:0}
.gold{color:var(--gold);letter-spacing:2px;font-size:19px;display:block;margin-bottom:2px}

.notice{display:flex;gap:12px;align-items:flex-start;background:#eef0ff;border:1px solid #ccd2ff;border-radius:10px;padding:14px 16px;margin:0 0 20px;font-size:15px}
.notice em{font-style:normal;color:var(--blue);font-size:18px;line-height:1}

.prose p,.prose ul,.prose ol{color:#3c3c47}
.prose p{text-align:justify;hyphens:auto;margin:0 0 14px}
.prose h2{font-size:clamp(20px,4.6vw,25px);font-weight:800;margin:0 0 12px}
.prose h3{font-size:18px;margin:22px 0 8px}
.prose ul,.prose ol{padding-left:20px;margin:0 0 14px}
.prose li{margin-bottom:6px}
.prose a{color:var(--orange-dk);font-weight:600}

.qa{border:1px solid var(--line);border-radius:12px;padding:16px;margin:0 0 14px;background:#fafbfc}
.qa:last-child{margin-bottom:0}
.qa .q,.qa .a{display:grid;grid-template-columns:26px 1fr;gap:6px}
.qa .q{font-weight:800;font-size:16px;margin-bottom:12px}
.qa .a{color:var(--ink-soft);font-size:15px}
.qa .k{font-weight:800;color:var(--ink)}
.qa .a .k{color:#8d93a1}

.review{background:#fff;border-left:5px solid var(--orange);border-radius:10px;padding:15px 16px;margin:0 0 14px;box-shadow:0 1px 2px rgba(20,18,31,.05)}
.review:last-child{margin-bottom:0}
.review b{display:flex;align-items:center;gap:9px;font-size:17px;margin-bottom:7px}
.review p{font-style:italic;color:var(--ink-soft);margin:0;font-size:15px}

footer{padding:26px 0 30px;color:#6b7280;font-size:14px}
.flinks{display:flex;flex-wrap:wrap;gap:9px;margin-bottom:16px}
.flinks m{color:inherit}
.flinks a{background:#fff;border:1px solid var(--line);border-radius:999px;padding:9px 16px;text-decoration:none;font-size:14px;min-height:42px;display:inline-flex;align-items:center}
.warn{border-left:3px solid var(--red);padding-left:13px;font-size:13px;line-height:1.6;max-width:70ch}

.dock{position:fixed;left:0;right:0;bottom:0;z-index:60;background:linear-gradient(#f08a2c,#d1620c);border-top:2px solid rgba(255,255,255,.2);padding:10px 0 12px}
.dock .wrap{display:flex;gap:9px}
.dock a{flex:1;display:grid;place-items:center;min-height:48px;border:2px solid #fff;border-radius:999px;color:#fff;font-weight:800;font-size:14px;text-decoration:none;background:rgba(255,255,255,.12)}
.dock a.pri{background:#fff;color:var(--orange-dk)}

a:focus-visible{outline:3px solid var(--blue);outline-offset:2px}
@media (prefers-reduced-motion:reduce){*{scroll-behavior:auto!important}}
.navinfo{border-bottom:1px solid rgba(0,0,0,.12);padding:10px 0}
.navinfo .flinks{margin:0}
</style>
</head>
<body>

<header class="masthead">
<div class="wrap">
<div class="logoline"><a href="/"><img src="<?= e($logoSrc) ?>" width="260" height="52" alt="<?= e($host) ?>"></a></div>
<div class="seekbar"><span>Cari info <?= e($namaSitus) ?>&hellip;</span><i>&#9906;</i></div>
<div class="tabs"><b>Explore Categories</b><span>Popular Products</span></div>
<nav class="rail">
<?php foreach ($railKategori as $k): ?>
<a href="<?= e($daftarUrl) ?>" rel="nofollow"><img src="<?= e($k['img']) ?>" width="66" height="66" loading="lazy" decoding="async" alt="Ikon <?= e($k['t']) ?>"><b><?= e($k['t']) ?></b></a>
<?php endforeach; ?>
</nav>
</div>
</header>

<?php if (count($menuHalaman) > 0): ?>
<nav class="navinfo" aria-label="Halaman informasi">
<div class="wrap">
<div class="flinks">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
</div>
</nav>
<?php endif; ?>

<main>
<div class="wrap">

<?php if (!$isHome): ?>
<p class="crumb"><a href="/">Beranda</a> / <?= e($page['h1']) ?></p>
<?php endif; ?>

<div class="ctapair">
<a class="big big-login" href="<?= e($loginUrl) ?>" rel="nofollow">LOGIN</a>
<a class="big big-daftar" href="<?= e($daftarUrl) ?>" rel="nofollow">DAFTAR</a>
</div>

<h1><?= e($page['h1']) ?></h1>
<?php if ($isHome): ?>
<p class="pricetag">IDR 10.000</p>
<?php endif; ?>
<p class="stampline">Diperbarui <time datetime="<?= e($lastmod) ?>"><?= e($tglTampil) ?></time><?= $isHome ? ' &middot; Informasi umum, bukan penawaran produk' : '' ?></p>

<?php if (!empty($banner1)): ?>
<div class="slider"><a href="<?= e($daftarUrl) ?>" rel="nofollow"><img src="<?= e($banner1) ?>" width="728" height="300" alt="Banner promosi <?= e($host) ?>" loading="eager" fetchpriority="high" decoding="async"></a></div>
<?php endif; ?>

<?php if ($isHome): ?>
<div class="infocard">
<div class="infocard-top">INFORMASI LENGKAP <?= e(strtoupper($namaSitus)) ?></div>
<dl style="margin:0">
<?php foreach ($infoRows as $r): ?>
<div class="inforow"><dt><?= e($r['k']) ?></dt><dd><?= $r['v'] ?></dd></div>
<?php endforeach; ?>
</dl>
</div>

<div class="notice"><em>&#9889;</em><div>Akses <strong><?= e($namaSitus) ?></strong> tetap lancar lewat link alternatif resmi saat domain utama terganggu.</div></div>

<div class="market">
<h2>MARKET SLOT <?= e(strtoupper($namaSitus)) ?></h2>
<dl>
<?php foreach ($marketRows as $m): ?>
<dt><?= e($m['t']) ?></dt><dd><span class="gold">&#9733; &#9733; &#9733; &#9733; &#9733;</span><?= e($m['n']) ?> dari 5</dd>
<?php endforeach; ?>
</dl>
</div>
<?php endif; ?>

<div class="panel prose">
<?= $isiArtikel ?>
</div>

<?php if ($isHome): ?>
<div class="panel">
<h2>FAQ Pemain <?= e($namaSitus) ?></h2>
<div class="rule"></div>
<?php foreach ($faqList as $f): ?>
<div class="qa">
<div class="q"><span class="k">Q.</span><span><?= e($f['t']) ?></span></div>
<div class="a"><span class="k">A.</span><span><?= e($f['j']) ?></span></div>
</div>
<?php endforeach; ?>
</div>

<div class="panel">
<h2>Ulasan Pengguna <?= e($namaSitus) ?></h2>
<div class="rule"></div>
<?php foreach ($ulasan as $u): ?>
<div class="review"><b>&#128081; <?= e($u['n']) ?></b><p><?= e($u['p']) ?></p></div>
<?php endforeach; ?>
</div>
<?php endif; ?>

<?php if (count($bacaanLain) > 0): ?>
<div class="panel">
<h2><?= $isHome ? 'Bacaan lainnya' : 'Artikel terkait' ?></h2>
<div class="rule"></div>
<div class="flinks">
<?php foreach ($bacaanLain as $slug => $item): ?>
<?php if (!$isHome && isset($page['canonical_url']) && rtrim($page['canonical_url'], '/') === rtrim($origin . '/' . $slug, '/')) continue; ?>
<a href="/<?= e($slug) ?>"><?= e($item['title']) ?></a>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>

</div>
</main>

<footer>
<div class="wrap">
<div class="flinks">
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank">WhatsApp</a>
<a href="<?= e($tgUrl) ?>" rel="nofollow noopener" target="_blank">Telegram</a>
</div>
<?php if (count($menuHalaman) > 0): ?>
<div class="flinks" style="margin-bottom:16px">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
<?php endif; ?>
<p class="warn"><strong>Khusus 18+.</strong> Halaman ini berisi informasi umum mengenai akses dan mekanisme layanan, bukan ajakan maupun jaminan kemenangan. Pahami risiko finansial dan tentukan batas bermain sendiri sebelum berpartisipasi.</p>
<p style="margin-top:14px">&copy; <?= date('Y') ?> <?= e($host) ?></p>
</div>
</footer>

<div class="dock">
<div class="wrap">
<a class="pri" href="<?= e($daftarUrl) ?>" rel="nofollow">DAFTAR</a>
<a href="<?= e($loginUrl) ?>" rel="nofollow">LOGIN</a>
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank">LIVE CHAT</a>
</div>
</div>

</body>
</html>
