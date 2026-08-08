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
$papanRtp = [
['nama' => 'Gerbang Olympia',   'prov' => 'Pragmatic Play', 'rtp' => '96.5%',  'st' => 'TINGGI', 'kelas' => 'hi'],
['nama' => 'Mahjong Jalur 2',   'prov' => 'PG Soft',        'rtp' => '96.9%',  'st' => 'TINGGI', 'kelas' => 'hi'],
['nama' => 'Manis Bonanza',     'prov' => 'Pragmatic Play', 'rtp' => '96.5%',  'st' => 'SEDANG', 'kelas' => 'mid'],
['nama' => 'Putri Bintang',     'prov' => 'Pragmatic Play', 'rtp' => '96.5%',  'st' => 'SEDANG', 'kelas' => 'mid'],
['nama' => 'Koin Naga',         'prov' => 'PG Soft',        'rtp' => '96.2%',  'st' => 'RENDAH', 'kelas' => 'lo'],
];

$providerList = ['Pragmatic Play','PG Soft','Habanero','Microgaming','Playtech','Evolution','JILI','CQ9'];

$faqList = [
['t' => 'Apa arti angka RTP di papan ' . $host . '?',
'j' => 'RTP adalah persentase teoritis dari total taruhan yang kembali ke pemain dalam jangka sangat panjang. Angka ini berasal dari provider dan dihitung lintas jutaan putaran, bukan jaminan hasil satu sesi.'],
['t' => 'Berapa kali papan RTP diperbarui?',
'j' => 'Sekali sehari. Waktu pembaruan terakhir selalu tercantum di bagian atas halaman ini.'],
['t' => 'Apakah status TINGGI berarti pasti menang?',
'j' => 'Tidak. Status itu merangkum laporan komunitas dalam 24 jam terakhir. Setiap putaran ditentukan RNG dan independen dari putaran sebelumnya.'],
['t' => 'Dari mana angka RTP diambil?',
'j' => 'Dari informasi resmi yang dipublikasikan tiap provider di halaman info game. Angka dicocokkan ulang setiap kali provider merilis pembaruan.'],
['t' => 'Apa bedanya RTP dengan volatilitas?',
'j' => 'RTP mengukur berapa persen taruhan yang kembali dalam jangka panjang, sedangkan volatilitas menggambarkan pola kemenangannya. Volatilitas tinggi berarti menang jarang tapi besar; rendah berarti menang kecil tapi lebih sering.'],
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

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@600;800&family=IBM+Plex+Mono:wght@400;600&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
:root{--ink:#0d1117;--ink2:#151b26;--line:#232c3b;--paper:#e8eaf0;--muted:#8b97ab;--amber:#f5b93b;--signal:#3ddc97;--warn:#ff7a5c}
*{box-sizing:border-box}
html{scroll-behavior:smooth}
body{margin:0;background:var(--ink);color:var(--paper);font-family:'IBM Plex Sans',system-ui,sans-serif;font-size:16px;line-height:1.65;padding-bottom:76px}
.shell{max-width:980px;margin:0 auto;padding:0 18px}
a{color:inherit}
img{max-width:100%}

.topdock{position:sticky;top:0;z-index:40;background:rgba(13,17,23,.92);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
.topdock .shell{display:flex;align-items:center;gap:12px;min-height:60px}
.mark{margin-right:auto;display:flex;align-items:center}
.mark img{height:34px;width:auto}
.pill{display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:0 16px;border-radius:8px;font-weight:600;font-size:14px;text-decoration:none;border:1px solid var(--line);color:var(--paper)}
.pill-fill{background:var(--amber);color:#1a1200;border-color:var(--amber)}

.masthead{padding:34px 0 26px;border-bottom:1px solid var(--line)}
.kicker{font-family:'IBM Plex Mono',monospace;font-size:12px;letter-spacing:.14em;text-transform:uppercase;color:var(--amber);margin:0 0 12px}
h1{font-family:'Sora',sans-serif;font-weight:800;font-size:clamp(28px,7vw,40px);line-height:1.15;letter-spacing:-.03em;margin:0 0 14px}
.standfirst{font-size:17px;color:#c6ccd9;margin:0 0 18px}
.stampline{font-family:'IBM Plex Mono',monospace;font-size:12.5px;color:var(--muted);display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin:0}
.blip{width:7px;height:7px;border-radius:50%;background:var(--signal);box-shadow:0 0 0 3px rgba(61,220,151,.16)}
.crumb{font-family:'IBM Plex Mono',monospace;font-size:12px;color:var(--muted);padding:14px 0 0}
.crumb a{color:var(--amber);text-decoration:none}

.rtpboard{margin:26px 0;border:1px solid var(--line);border-radius:12px;background:var(--ink2);overflow:hidden}
.rtpboard-top{display:flex;justify-content:space-between;align-items:baseline;padding:13px 16px;border-bottom:1px solid var(--line);font-family:'IBM Plex Mono',monospace;font-size:12px;letter-spacing:.1em;text-transform:uppercase;color:var(--muted)}
.rtprow{display:grid;grid-template-columns:1fr auto auto;gap:10px;align-items:center;padding:13px 16px;border-bottom:1px solid var(--line)}
.rtprow:last-of-type{border-bottom:0}
.rtpname{font-weight:600;font-size:15px;line-height:1.3}
.rtpprov{display:block;font-size:12.5px;color:var(--muted);font-weight:400}
.rtpnum{font-family:'IBM Plex Mono',monospace;font-weight:600;font-size:15px}
.flag{font-family:'IBM Plex Mono',monospace;font-size:11px;font-weight:600;padding:4px 8px;border-radius:5px;letter-spacing:.06em;white-space:nowrap}
.flag-hi{background:rgba(61,220,151,.14);color:var(--signal)}
.flag-mid{background:rgba(245,185,59,.14);color:var(--amber)}
.flag-lo{background:rgba(255,122,92,.14);color:var(--warn)}
.rtpnote{padding:12px 16px;font-size:13px;color:var(--muted);border-top:1px solid var(--line);margin:0}

.promo{display:block;margin:26px 0}
.promo img{display:block;width:100%;height:auto;border-radius:12px;border:1px solid var(--line);background:#1d2430}

.block{padding:30px 0;border-bottom:1px solid var(--line)}
h2{font-family:'Sora',sans-serif;font-weight:600;font-size:clamp(21px,4.6vw,26px);letter-spacing:-.02em;margin:0 0 14px}
h3{font-family:'Sora',sans-serif;font-weight:600;font-size:18px;margin:22px 0 8px}
p{margin:0 0 14px}

.tiles{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
@media(min-width:620px){.tiles{grid-template-columns:repeat(3,1fr)}}
@media(min-width:900px){.tiles{grid-template-columns:repeat(5,1fr)}}
.tile{border:1px solid var(--line);border-radius:10px;overflow:hidden;background:var(--ink2);text-decoration:none;display:block}
.tile img{display:block;width:100%;height:auto;aspect-ratio:4/3;object-fit:cover;background:#1d2430}
.tile b{display:block;padding:10px 12px;font-size:13.5px;font-weight:600}

.tagrow{display:flex;flex-wrap:wrap;gap:8px}
.tagrow span,.tagrow a{border:1px solid var(--line);border-radius:999px;padding:8px 14px;font-size:13.5px;color:#c6ccd9;background:var(--ink2);text-decoration:none;display:inline-flex;align-items:center;min-height:40px}

.callout{border:1px solid var(--amber);border-radius:12px;padding:22px 18px;background:linear-gradient(180deg,rgba(245,185,59,.08),rgba(245,185,59,0));text-align:center}
.callout h2{margin-bottom:8px}
.callout p{color:#c6ccd9;font-size:15px}
.pill-big{min-height:52px;font-size:16px;padding:0 30px;margin-top:6px}

.readable p,.readable ul,.readable ol{color:#c9cfdb}
.readable p,.readable li{text-align:justify;hyphens:auto;-webkit-hyphens:auto}
.readable ul,.readable ol{padding-left:20px;margin:0 0 14px}
.readable li{margin-bottom:6px}
.readable h2{color:var(--paper)}
.readable a{color:var(--amber);text-decoration:underline;text-underline-offset:3px}

details{border-bottom:1px solid var(--line)}
summary{cursor:pointer;list-style:none;padding:15px 30px 15px 0;position:relative;font-weight:600;font-size:15.5px;min-height:44px}
summary::-webkit-details-marker{display:none}
summary::after{content:"+";position:absolute;right:4px;top:13px;font-family:'IBM Plex Mono',monospace;font-size:20px;color:var(--amber)}
details[open] summary::after{content:"\2013"}
details p{padding:0 0 15px;color:#c9cfdb;font-size:15px;margin:0;max-width:68ch}

.baseboard{padding:28px 0 34px;color:var(--muted);font-size:14px}
.baseboard img{height:38px;width:auto;margin-bottom:14px}
.warnbox{border-left:2px solid var(--warn);padding-left:14px;font-size:13px;line-height:1.6;max-width:68ch}

.botdock{position:fixed;left:0;right:0;bottom:0;z-index:50;background:rgba(13,17,23,.96);backdrop-filter:blur(10px);border-top:1px solid var(--line);padding:12px 0 14px}
.botdock .shell{display:flex;gap:10px}
.botdock .pill{flex:1}

a:focus-visible,summary:focus-visible{outline:2px solid var(--amber);outline-offset:2px}
@media (prefers-reduced-motion:reduce){*{transition:none!important;scroll-behavior:auto!important}}
.navinfo{border-bottom:1px solid rgba(255,255,255,.10);padding:10px 0}
.navinfo .tagrow{margin:0}
</style>
</head>
<body>

<header class="topdock">
<div class="shell">
<a class="mark" href="/"><img src="<?= e($logoSrc) ?>" width="180" height="58" alt="<?= e($host) ?>"></a>
<a href="<?= e($loginUrl) ?>" class="pill" rel="nofollow">Masuk</a>
<a href="<?= e($daftarUrl) ?>" class="pill pill-fill" rel="nofollow">Daftar</a>
</div>
</header>

<?php if (count($menuHalaman) > 0): ?>
<nav class="navinfo" aria-label="Halaman informasi">
<div class="shell">
<div class="tagrow">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
</div>
</nav>
<?php endif; ?>

<main>
<div class="shell">

<?php if (!$isHome): ?>
<p class="crumb"><a href="/">Beranda</a> / <?= e($page['h1']) ?></p>
<?php endif; ?>

<div class="masthead">
<p class="kicker"><?= $isHome ? 'Papan RTP &middot; Diperbarui harian' : 'Artikel' ?></p>
<h1><?= e($page['h1']) ?></h1>
<?php if (!empty($page['meta_description'])): ?>
<p class="standfirst"><?= e($page['meta_description']) ?></p>
<?php endif; ?>
<p class="stampline"><span class="blip"></span> Pembaruan terakhir: <time datetime="<?= e($lastmod) ?>"><?= e($tglTampil) ?></time></p>
</div>

<?php if ($isHome): ?>
<div class="rtpboard">
<div class="rtpboard-top"><span>Papan RTP Hari Ini</span><span><?= e($tglTampil) ?></span></div>
<?php foreach ($papanRtp as $g): ?>
<div class="rtprow">
<div class="rtpname"><?= e($g['nama']) ?><span class="rtpprov"><?= e($g['prov']) ?></span></div>
<div class="rtpnum"><?= e($g['rtp']) ?></div>
<span class="flag flag-<?= e($g['kelas']) ?>"><?= e($g['st']) ?></span>
</div>
<?php endforeach; ?>
<p class="rtpnote">Angka RTP adalah persentase teoritis jangka panjang yang dipublikasikan provider. Kolom status merangkum laporan komunitas, bukan prediksi hasil putaran berikutnya.</p>
</div>
<?php endif; ?>

<?php if (!empty($banner1)): ?>
<a class="promo" href="<?= e($daftarUrl) ?>" rel="nofollow"><img src="<?= e($banner1) ?>" width="728" height="240" alt="Promosi <?= e($host) ?>" loading="eager" fetchpriority="high" decoding="async"></a>
<?php endif; ?>

<?php if ($isHome): ?>
<section class="block">
<h2>Game yang paling sering dicari</h2>
<div class="tiles">
<?php foreach ($papanRtp as $i => $g): ?>
<a class="tile" href="<?= e($daftarUrl) ?>" rel="nofollow" target="_blank">
<img src="/img/asset-game-<?= $i + 1 ?>.jpg" width="320" height="240" loading="lazy" decoding="async" alt="Ikon game <?= e($g['nama']) ?>">
<b><?= e($g['nama']) ?></b>
</a>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<section class="block">
<div class="callout">
<h2>Buat akun dalam 2 menit</h2>
<p>Isi data, verifikasi, lalu papan RTP bisa diakses penuh.</p>
<a href="<?= e($daftarUrl) ?>" class="pill pill-fill pill-big" rel="nofollow" target="_blank">Daftar Sekarang</a>
</div>
</section>

<?php if ($isHome): ?>
<section class="block">
<h2>Provider yang tersedia</h2>
<div class="tagrow">
<?php foreach ($providerList as $p): ?><span><?= e($p) ?></span><?php endforeach; ?>
</div>
</section>
<?php endif; ?>

<section class="block readable">
<?= $isiArtikel ?>
</section>

<?php if ($isHome): ?>
<section class="block">
<h2>Pertanyaan yang sering masuk</h2>
<?php foreach ($faqList as $i => $f): ?>
<details<?= $i === 0 ? ' open' : '' ?>>
<summary><?= e($f['t']) ?></summary>
<p><?= e($f['j']) ?></p>
</details>
<?php endforeach; ?>
</section>
<?php endif; ?>

<?php if (count($bacaanLain) > 0): ?>
<section class="block">
<h2><?= $isHome ? 'Bacaan lainnya' : 'Artikel terkait' ?></h2>
<div class="tagrow">
<?php foreach ($bacaanLain as $slug => $item): ?>
<?php if (!$isHome && isset($page['canonical_url']) && rtrim($page['canonical_url'], '/') === rtrim($origin . '/' . $slug, '/')) continue; ?>
<a href="/<?= e($slug) ?>"><?= e($item['title']) ?></a>
<?php endforeach; ?>
</div>
</section>
<?php endif; ?>

</div>
</main>

<footer class="baseboard">
<div class="shell">
<img src="<?= e($logoSrc) ?>" width="180" height="58" alt="<?= e($host) ?>" loading="lazy">
<div class="tagrow" style="margin-bottom:18px">
<a href="<?= e($waUrl) ?>" rel="nofollow noopener" target="_blank">WhatsApp</a>
<a href="<?= e($tgUrl) ?>" rel="nofollow noopener" target="_blank">Telegram</a>
</div>
<?php if (count($menuHalaman) > 0): ?>
<div class="tagrow" style="margin-bottom:16px">
<a href="/">Beranda</a>
<?php foreach ($menuHalaman as $slug => $label): ?><a href="/<?= e($slug) ?>"><?= e($label) ?></a><?php endforeach; ?>
</div>
<?php endif; ?>
<p class="warnbox"><strong>Khusus 18+.</strong> Halaman ini berisi informasi mengenai angka RTP dan mekanisme permainan, bukan ajakan maupun jaminan kemenangan. Pahami risiko finansial dan tentukan batas bermain sendiri sebelum berpartisipasi.</p>
<p style="margin-top:16px">&copy; <?= date('Y') ?> <?= e($host) ?></p>
</div>
</footer>

<div class="botdock">
<div class="shell">
<a href="<?= e($loginUrl) ?>" class="pill" rel="nofollow">Masuk</a>
<a href="<?= e($daftarUrl) ?>" class="pill pill-fill" rel="nofollow">Daftar Sekarang</a>
</div>
</div>

</body>
</html>
