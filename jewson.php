<?php
/**
 * AGEN138 - Template T1 (adapted)
 * Engine dinamis baca /data/data.json - skema sama dengan Lemon-Grey T1
 * + field tambahan: testimonials, faqs, footer_links, floating_buttons, recommendations
 */

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

function h($str) { return htmlspecialchars($str ?? '', ENT_QUOTES, 'UTF-8'); }

$homepage    = $data['homepage'] ?? [];
$isHomepage  = ($page['category'] === 'homepage');
$domainName  = $_SERVER['HTTP_HOST'];
$origin      = 'https://' . $domainName;

$logoSrc      = $homepage['logo_src']      ?? '/img/logo.png';
$faviconSrc   = $homepage['favicon_src']   ?? '/img/favicon.png';
$bannerSrc    = $homepage['banner_src']    ?? ($homepage['image_src'] ?? '');
$whatsappCta  = $homepage['whatsapp_cta']  ?? '#';
$telegramCta  = $homepage['telegram_cta']  ?? '#';
$ctaDaftarUrl = $homepage['cta_daftar_url'] ?? '#';
$ctaLoginUrl  = $homepage['cta_login_url']  ?? '#';
$keyword      = $homepage['keyword']       ?? $domainName;
$gscToken     = $homepage['gsc_token']     ?? '';

$lang    = $page['lang'] ?? 'id';
$noindex = !empty($page['noindex']);
$heroImg = $isHomepage ? ($bannerSrc ?: ($page['image_src'] ?? '')) : ($page['image_src'] ?? '');

$allPosts = array_filter($data, fn($item) => isset($item['category']) && $item['category'] === 'post');

// og:image & schema WAJIB URL mutlak
$ogRel = $page['image_src'] ?? $bannerSrc ?? '';
$ogAbs = $ogRel ? ((strpos($ogRel, 'http') === 0) ? $ogRel : $origin . $ogRel) : '';

$dateMod = ($page['lastmod'] ?? date('Y-m-d')) . 'T00:00:00+07:00';

// Menu halaman (sama seperti template asal)
$polaMenu = [
    'slot'=>'Slot','sportsbook'=>'Sportsbook','casino'=>'Casino','togel'=>'Togel',
    'about-us'=>'Tentang Kami','tentang-kami'=>'Tentang Kami',
    'contact-us'=>'Kontak','kontak'=>'Kontak',
    'link-alternatif'=>'Link Alternatif','cara-daftar'=>'Cara Daftar','daftar'=>'Cara Daftar',
    'cara-masuk-akun'=>'Cara Masuk','cara-masuk'=>'Cara Masuk','login'=>'Cara Masuk',
    'disclaimer'=>'Disclaimer',
];
$menuHalaman = [];
$labelDipakai = [];
foreach ($polaMenu as $pola => $label) {
    if (isset($labelDipakai[$label])) continue;
    foreach ($allPosts as $slug => $item) {
        if (isset($menuHalaman[$slug])) continue;
        $s = strtolower(trim($slug));
        if ($s === $pola || substr($s, -(strlen($pola) + 1)) === '-' . $pola) {
            $menuHalaman[$slug] = $label;
            $labelDipakai[$label] = true;
            break;
        }
    }
}
$labelHanyaFooter = ['Tentang Kami','Kontak','Disclaimer'];
$menuHeader = [];
foreach ($menuHalaman as $slugMenu => $labelMenu) {
    if (!in_array($labelMenu, $labelHanyaFooter, true)) $menuHeader[$slugMenu] = $labelMenu;
}
$bacaanLain = array_diff_key($allPosts, $menuHalaman);

// Autolink nama situs pertama kali di content_html
$isiArtikel = $page['content_html'] ?? '';
$namaSitus  = !empty($homepage['keyword']) ? $homepage['keyword'] : explode('.', $domainName)[0];
if ($namaSitus !== '' && $isiArtikel !== '') {
    $bagian = preg_split('/(<[^>]*>)/', $isiArtikel, -1, PREG_SPLIT_DELIM_CAPTURE);
    $sudah = false;
    foreach ($bagian as $i => $b) {
        if ($sudah || $b === '' || $b[0] === '<') continue;
        $pos = stripos($b, $namaSitus);
        if ($pos !== false) {
            $asli = substr($b, $pos, strlen($namaSitus));
            $bagian[$i] = substr($b, 0, $pos) . '<a href="/">' . $asli . '</a>' . substr($b, $pos + strlen($namaSitus));
            $sudah = true;
        }
    }
    if ($sudah) $isiArtikel = implode('', $bagian);
}

// Data homepage fields (dengan default)
$trendingTags      = $homepage['trending_tags'] ?? [];
$testimonials      = $homepage['testimonials'] ?? [];
$faqs              = $homepage['faqs'] ?? [];
$footerLinks       = $homepage['footer_links'] ?? [];
$floatingButtons   = $homepage['floating_buttons'] ?? [];
$recommendations   = $homepage['recommendations'] ?? [];
$org               = $homepage['organization'] ?? [];
$sku               = $homepage['sku'] ?? $keyword;
$price             = $homepage['price'] ?? '10000';
$priceCurrency     = $homepage['price_currency'] ?? 'IDR';
?>
<!DOCTYPE html>
<html lang="<?= h($lang) ?>">
<head>
    <title><?= h($page['title']) ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="<?= h($page['meta_description']) ?>" />
    <meta name="robots" content="<?= $noindex ? 'noindex,nofollow' : 'index,follow' ?>" />
    <?php if (!empty($gscToken)): ?><meta name="google-site-verification" content="<?= h($gscToken) ?>" /><?php endif; ?>
    <link rel="shortcut icon" type="image/x-icon" media="all" href="<?= h($faviconSrc) ?>" />
    <link rel="canonical" href="<?= h($page['canonical_url']) ?>" />
    <?php if (!empty($page['amp_url']) && $page['amp_url'] !== '#'): ?>
    <link rel="amphtml" href="<?= h($page['amp_url']) ?>" />
    <link rel="alternate" hreflang="id" href="<?= h($page['amp_url']) ?>" />
    <link rel="alternate" hreflang="id-id" href="<?= h($page['amp_url']) ?>" />
    <link rel="alternate" hreflang="x-default" href="<?= h($page['amp_url']) ?>" />
    <link rel="alternate" hreflang="en" href="<?= h($page['amp_url']) ?>" />
    <?php endif; ?>

    <meta property="og:type" content="<?= $isHomepage ? 'website' : 'article' ?>" />
    <meta property="og:url" content="<?= h($page['canonical_url']) ?>" />
    <meta property="og:title" content="<?= h($page['title']) ?>" />
    <meta property="og:description" content="<?= h($page['meta_description']) ?>" />
    <meta property="og:image" content="<?= h($ogAbs) ?>" />
    <meta property="twitter:card" content="summary_large_image" />

    <script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@graph":[
        {
          "@type":"Article",
          "headline":<?= json_encode($page['h1'], JSON_UNESCAPED_UNICODE) ?>,
          "description":<?= json_encode($page['meta_description'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
          "image":<?= json_encode($ogAbs, JSON_UNESCAPED_UNICODE) ?>,
          "datePublished":<?= json_encode($dateMod, JSON_UNESCAPED_UNICODE) ?>,
          "dateModified":<?= json_encode($dateMod, JSON_UNESCAPED_UNICODE) ?>,
          "inLanguage":"id-ID",
          "author":{"@type":"Organization","name":<?= json_encode($domainName, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>},
          "publisher":{"@type":"Organization","name":<?= json_encode($domainName, JSON_UNESCAPED_UNICODE) ?>,"url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>,"logo":{"@type":"ImageObject","url":<?= json_encode($origin . $logoSrc, JSON_UNESCAPED_UNICODE) ?>}},
          "mainEntityOfPage":{"@type":"WebPage","@id":<?= json_encode($page['canonical_url'], JSON_UNESCAPED_UNICODE) ?>}
        },
        {
          "@type":"BreadcrumbList",
          "itemListElement":[
            {"@type":"ListItem","position":1,"name":"Beranda","item":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>}
            <?php if (!$isHomepage): ?>,
            {"@type":"ListItem","position":2,"name":<?= json_encode($page['h1'], JSON_UNESCAPED_UNICODE) ?>,"item":<?= json_encode($page['canonical_url'], JSON_UNESCAPED_UNICODE) ?>}
            <?php endif; ?>
          ]
        }
        <?php if ($isHomepage): ?>,
        {
          "@type":"Organization",
          "name":<?= json_encode($keyword, JSON_UNESCAPED_UNICODE) ?>,
          "url":<?= json_encode($origin . '/', JSON_UNESCAPED_UNICODE) ?>,
          "logo":<?= json_encode($logoSrc, JSON_UNESCAPED_UNICODE) ?>,
          "address":<?= json_encode($org['address'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
          "telephone":<?= json_encode($org['telephone'] ?? '', JSON_UNESCAPED_UNICODE) ?>,
          "email":<?= json_encode($org['email'] ?? '', JSON_UNESCAPED_UNICODE) ?>
        },
        {
          "@type":"FAQPage",
          "mainEntity":[
            <?php foreach ($faqs as $idx => $f): ?>
            {"@type":"Question","name":<?= json_encode($f['q'], JSON_UNESCAPED_UNICODE) ?>,"acceptedAnswer":{"@type":"Answer","text":<?= json_encode($f['a'], JSON_UNESCAPED_UNICODE) ?>}}<?= ($idx < count($faqs) - 1) ? ',' : '' ?>
            <?php endforeach; ?>
          ]
        }
        <?php endif; ?>
      ]
    }
    </script>

    <!-- Fonts & core CSS (dari aset Jewson, dibiarkan agar visual sama) -->
    <link rel="preconnect" href="https://use.typekit.net" crossorigin />
    <link rel="preload" as="style" href="https://use.typekit.net/gdr0xyc.css" />
    <link rel="stylesheet" href="https://use.typekit.net/gdr0xyc.css" media="print" onload="this.media='all'" />
    <noscript><link rel="stylesheet" href="https://use.typekit.net/gdr0xyc.css" /></noscript>

    <link rel="stylesheet" type="text/css" media="all"
        href="https://www.jewson.co.uk/_ui/responsive/theme-jewson/css/core.css?version=1f4233737e50f6d7a25fd1c1a0884a0f" />
    <link rel="preload" type="text/css" media="all"
        href="https://www.jewson.co.uk/_ui/responsive/theme-jewson/css/site.css?version=1f4233737e50f6d7a25fd1c1a0884a0f"
        as="style" onload="this.onload=null;this.rel='stylesheet'" />
    <noscript>
        <link rel="stylesheet" type="text/css" media="all"
            href="https://www.jewson.co.uk/_ui/responsive/theme-jewson/css/site.css?version=1f4233737e50f6d7a25fd1c1a0884a0f" />
    </noscript>

    <script>document.createElement("picture");</script>

    <style>
        /* ===== Blok CSS custom AGEN138 (diringkas dari file asal) ===== */
        .CTAAGEN138468516465{display:flex;width:100%;max-width:2000px;border:2px solid #fff;border-radius:8px;overflow:hidden;box-shadow:0 0 20px rgba(106,13,173,.6);animation:glowing 2s infinite alternate}
        .m-btn{flex:1;padding:15px 0;text-align:center;text-decoration:none;color:#fff;font:900 18px Arial,sans-serif;letter-spacing:1px;background:linear-gradient(180deg,#0047cc 0,#000 100%);position:relative;overflow:hidden;transition:.3s;display:block;border-right:1px solid rgba(255,255,255,.3)}
        .m-btn:last-child{border-right:none}
        .m-btn:hover{color:#ff0;text-shadow:0 0 10px #fff}
        @keyframes glowing{0%{box-shadow:0 0 5px #0047cc,0 0 10px #000}50%{box-shadow:0 0 20px #3294cc,0 0 10px #fff}100%{box-shadow:0 0 5px #0047cc,0 0 20px #000}}
        .cok-faq-title{text-align:center;color:#0047cc;font-size:32px;margin:25px 0;font-weight:800;text-shadow:0 0 12px #796705,0 0 20px #50504e}
        .faq-container{display:flex;flex-direction:column;gap:25px;max-width:1200px;margin:0 auto}
        .faq-item{background:linear-gradient(145deg,#0a0a0a,#1a1a1a);border:2px solid #0047cc;border-radius:20px;overflow:hidden;transition:.4s ease;box-shadow:0 5px 20px rgba(0,0,0,.5)}
        .faq-item:hover{border-color:#0047cc;transform:translateX(10px);box-shadow:0 12px 35px #0047cc}
        .faq-question{width:100%;padding:28px 35px;background:transparent;color:#fff;font-size:18px;font-weight:600;text-align:left;border:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center}
        .faq-question::after{content:'+';font-size:32px;font-weight:300;transition:.4s;color:#0047cc;width:40px;height:40px;display:flex;align-items:center;justify-content:center;border:2px solid #0047cc;border-radius:50%}
        .faq-item.active .faq-question::after{transform:rotate(135deg);color:#fff;border-color:transparent}
        .faq-answer{max-height:0;overflow:hidden;transition:max-height .5s ease,padding .5s ease;padding:0 35px;color:#e0e0e0}
        .faq-item.active .faq-answer{max-height:800px;padding:30px 35px;border-top:1px solid rgba(253,4,4,.3)}
        .testimoni-section{padding:60px 20px;background:linear-gradient(135deg,#000,#000);text-align:center;margin:40px 0}
        .testimoni-section h2{color:#0047cc;font-size:36px;margin-bottom:20px;font-weight:800;text-shadow:0 0 15px #0047cc}
        .testimoni-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:30px;max-width:1200px;margin:0 auto}
        .testimoni-card{background:#111;border:2px solid #0047cc;border-radius:16px;padding:25px;box-shadow:0 0 20px rgba(249,253,0,.4);transition:.3s}
        .testimoni-card:hover{transform:translateY(-10px);box-shadow:0 0 30px rgba(255,251,0,.4)}
        .rating-stars{color:#0047cc;font-size:28px;margin-bottom:15px;letter-spacing:5px}
        .testimoni-card blockquote{color:#fff;font-size:16px;line-height:1.6;margin:0 0 20px;font-style:italic}
        .testimoni-author{display:flex;justify-content:space-between;color:#0047cc;font-size:15px;font-weight:bold}
        .testimoni-author small{color:#aaa;font-weight:normal;font-size:14px}
        .wrapstarlinkalternatif{position:relative;width:100%;max-width:1500px;margin:5px auto;padding:30px;background:linear-gradient(#000,#000) padding-box,linear-gradient(180deg,#0047cc 0,#000 100%) border-box;border:4px solid transparent;border-radius:20px;text-align:center;box-shadow:0 0 25px rgba(138,43,226,.4),inset 0 0 20px #000}
        .wrapstarlink{color:#fff;font-size:16px;line-height:1.5;font-weight:700}
        .footerslotstar{position:fixed;bottom:0;left:0;width:100%;height:65px;background:linear-gradient(180deg,#0047cc 0%,#000 100%);display:flex;justify-content:space-around;align-items:center;z-index:99999;border-top:2px solid #0300bb;box-shadow:0 -5px 20px rgba(0,0,0,.7);animation:activeBorder 2s infinite alternate}
        @keyframes activeBorder{0%{border-color:#fff;box-shadow:0 -2px 10px #fff}50%{border-color:#0047cc;box-shadow:0 -4px 20px #3294cc}100%{border-color:#000;box-shadow:0 -2px 15px #fff}}
        .ft-btn{flex:1;display:flex;flex-direction:column;align-items:center;justify-content:center;text-decoration:none;color:#fff;font-family:sans-serif;transition:.3s;position:relative}
        .ft-btn svg{width:22px;height:22px;fill:#fff;margin-bottom:3px}
        .ft-btn span{font-size:10px;font-weight:900;text-transform:uppercase}
        .ft-main{background:linear-gradient(145deg,#0047cc,#f8c007);height:75px;margin-top:-30px;border-radius:50% 50% 0 0;border-top:3px solid #fff;box-shadow:0 -5px 15px rgba(255,255,255,.4)}
        .ft-main svg{width:28px;height:28px}
        .footer-floating-star{position:fixed;bottom:18px;left:50%;transform:translateX(-50%);width:100%;max-width:1500px;display:flex;gap:14px;padding:16px 22px;background:#0047cc54;backdrop-filter:blur(10px);border-radius:20px;border:2px solid rgb(0 0 0 / 50%);box-shadow:0 0 30px #0047cca6;z-index:999}
        .footer-btn-star{flex:1;min-width:0;display:flex;align-items:center;justify-content:center;gap:8px;padding:12px 10px;font-size:14px;font-weight:bold;color:#e3e3e3;background:#000;border-radius:32px;border:2px solid #d7d7d7;cursor:pointer;transition:.3s;box-shadow:0 0 14px rgba(247,231,6,.6);animation:floatUpDown 3s ease-in-out infinite;text-decoration:none;white-space:nowrap}
        .footer-btn-star img{width:18px;height:18px;flex-shrink:0}
        .footer-btn-star.login{animation-delay:.3s}.footer-btn-star.daftar{animation-delay:.6s}
        .footer-btn-star.link{animation-delay:.9s}.footer-btn-star.chat{animation-delay:1.2s}
        .footer-btn-star:hover{background:#fff;box-shadow:0 0 15px #c9c1c1,0 0 30px #c9c1c1,0 0 50px #ff7e4d;transform:translateY(-6px) scale(1.05)}
        @keyframes floatUpDown{0%{transform:translateY(0)}50%{transform:translateY(-8px)}100%{transform:translateY(0)}}
        body{padding-bottom:70px}
        @media (max-width:1024px){.footer-floating-star{flex-wrap:wrap}.footer-btn-star{flex:1 1 calc(50% - 10px)}}
        @media (max-width:600px){.footer-btn-star{flex:1 1 100%;font-size:13px;padding:10px 12px}}
    </style>
</head>

<body class="page-productDetails language-<?= h($lang) ?>">

<!-- ============ HEADER ============ -->
<header class="header-alt js-header header-alt--sticky js-sticky-header">
    <section class="header-alt__middle">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="header-alt__components">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="header-alt__logo order-1">
                                <a href="/" class="d-block mr-lg-1">
                                    <img class="header-alt__logo-img" src="<?= h($logoSrc) ?>" alt="<?= h($keyword) ?> Logo" title="<?= h($keyword) ?> Logo" />
                                </a>
                            </div>
                            <div class="header-alt__quick-bar d-flex">
                                <a href="<?= h($ctaLoginUrl) ?>" rel="nofollow" class="header-alt__quick-bar-link">
                                    <span class="d-none d-xxl-block">Login / Daftar</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <nav class="menu-alt js-main-menu-alt menu-alt--overlay">
        <div class="container">
            <div class="row menu-alt__wrap">
                <div class="col-12 menu-alt__inner">
                    <div class="menu-alt__tray">
                        <div class="yCmsComponent d-lg-flex justify-content-between w-100">
                            <div class="menu-alt__tray-item">
                                <a href="/" class="menu-alt__link menu-alt__link--main"><?= h($keyword) ?></a>
                            </div>
                            <?php foreach ($menuHeader as $slug => $label): ?>
                            <div class="menu-alt__tray-item">
                                <a href="/<?= h($slug) ?>" class="menu-alt__link menu-alt__link--main"><?= h($label) ?></a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>

<!-- ============ CTA DAFTAR / LOGIN ============ -->
<div class="CTAAGEN138468516465" id="ctaMeme">
    <a href="<?= h($ctaDaftarUrl) ?>" class="m-btn" rel="noopener">DAFTAR</a>
    <a href="<?= h($ctaLoginUrl) ?>" class="m-btn" rel="noopener">LOGIN</a>
</div>

<!-- ============ MAIN ============ -->
<main id="main" class="main">
    <div class="main-container container">

        <?php if (!$isHomepage): ?>
        <ol class="breadcrumb js-breadcrumbs">
            <li class="breadcrumb__item"><a class="breadcrumb__link" href="/"><span class="breadcrumb__inner breadcrumb__inner--text">Beranda</span></a></li>
            <li class="breadcrumb__item"><span class="breadcrumb__inner breadcrumb__inner--text"><?= h($page['h1']) ?></span></li>
        </ol>
        <?php endif; ?>

        <div class="product product--main row mb-3">
            <div class="col-12 col-lg-8 float-left">
                <div class="row">
                    <div class="col-12 col-lg-6 order-2 order-lg-1">
                        <?php if (!empty($heroImg)): ?>
                        <div class="product-details-carousel">
                            <div class="glider-slider__slide">
                                <div class="zoom product-details-carousel__zoom">
                                    <a href="<?= h($heroImg) ?>" data-component="zoom">
                                        <img src="<?= h($heroImg) ?>" width="100%"
                                             alt="<?= h($page['h1']) ?>" title="<?= h($page['h1']) ?>" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 col-lg-6 order-1 order-lg-2">
                        <h1 class="product-title mb-1"><?= h($page['h1']) ?></h1>
                        <div class="product-sku mb-2"><?= h($sku) ?> <?= date('Y') ?></div>

                        <div class="product__description mb-4">
                            <div class="product__description-long mb-3">
                                <div class="content"><?= $isiArtikel ?></div>
                            </div>

                            <?php if (!empty($trendingTags)): ?>
                            <div class="strong attrib">Trending Tags :</div>
                            <ul>
                                <?php foreach ($trendingTags as $tag): ?>
                                <li><?= h($tag) ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4 float-right product__panel">
                <div class="simple-container__generic simple-container__product-panel">
                    <div class="p-2 bg-light-grey">
                        <div class="d-flex mt-3 align-items-center">
                            <p class="strong text-blue mb-0">Akses Cepat &amp; Stabil</p>
                        </div>
                        <hr class="hr--default" />
                        <div class="form-group d-flex mb-0">
                            <div class="flex-grow-1">
                                <a href="<?= h($ctaLoginUrl) ?>" class="btn btn-primary w-100 mb-2">Login / Daftar Akun</a>
                                <p>Silakan <a href="<?= h($ctaLoginUrl) ?>">login atau daftar akun</a> untuk mengakses fitur eksklusif dan menyimpan aktivitas permainan Anda.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blok deskripsi tambahan -->
        <?php if (!empty($isiArtikel) && $isHomepage): ?>
        <div class="wrapstarlinkalternatif">
            <div class="wrapstarlink"><?= $isiArtikel ?></div>
        </div>
        <?php endif; ?>

        <!-- ============ FAQ ============ -->
        <?php if (!empty($faqs)): ?>
        <h2 class="cok-faq-title">FAQ TENTANG <?= h($keyword) ?></h2>
        <div class="faq-container">
            <?php foreach ($faqs as $f): ?>
            <div class="faq-item">
                <h3 class="faq-question"><?= h($f['q']) ?></h3>
                <div class="faq-answer"><?= h($f['a']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.faq-item').forEach(function(item){
                item.querySelector('.faq-question').addEventListener('click', function(){
                    var active = item.classList.contains('active');
                    document.querySelectorAll('.faq-item').forEach(function(o){o.classList.remove('active');});
                    if (!active) item.classList.add('active');
                });
            });
        });
        </script>
        <?php endif; ?>

        <!-- ============ TESTIMONI ============ -->
        <?php if (!empty($testimonials)): ?>
        <section class="testimoni-section">
            <h2>TESTIMONI MEMBER <?= h($keyword) ?></h2>
            <div class="testimoni-grid">
                <?php foreach ($testimonials as $t): ?>
                <div class="testimoni-card">
                    <div class="rating-stars"><?= str_repeat('&#9733;', (int)($t['rating'] ?? 5)) ?></div>
                    <blockquote><?= h($t['text']) ?></blockquote>
                    <div class="testimoni-author">
                        <span><?= h($t['name']) ?></span>
                        <small><?= h($t['date']) ?></small>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>
        <?php endif; ?>

        <!-- ============ REKOMENDASI ============ -->
        <?php if (!empty($recommendations)): ?>
        <div class="product-recommendations-carousel">
            <h2 class="mb-1">Pelanggan juga membeli</h2>
            <div class="glider-track" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:20px;">
                <?php foreach ($recommendations as $r): ?>
                <div class="product product--carousel">
                    <a href="<?= h($r['url'] ?? '/') ?>" class="link-header link-header--primary">
                        <div class="product__thumb">
                            <picture class="product__image">
                                <img alt="<?= h($r['name']) ?>" title="<?= h($r['name']) ?>" src="<?= h($r['image'] ?? $heroImg) ?>" />
                            </picture>
                        </div>
                        <div class="product__name"><?= h($r['name']) ?></div>
                    </a>
                    <div class="d-flex flex-column flex-grow-1">
                        <p class="flex-grow-1 small">SKU: <?= h($r['sku'] ?? '') ?></p>
                        <div class="price price--medium">
                            <div class="price__value"><?= h($r['tagline'] ?? '') ?></div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($isHomepage && count($bacaanLain) > 0): ?>
        <div class="product-recommendations-carousel">
            <h2 class="mb-1">Artikel Terbaru</h2>
            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:20px;">
                <?php foreach ($bacaanLain as $slug => $item): ?>
                <a href="/<?= h($slug) ?>" class="product product--carousel" style="text-decoration:none;">
                    <?php if (!empty($item['image_src'])): ?>
                    <div class="product__thumb">
                        <img src="<?= h($item['image_src']) ?>" alt="<?= h($item['title']) ?>" style="width:100%;height:auto;" />
                    </div>
                    <?php endif; ?>
                    <div class="product__name"><?= h($item['title']) ?></div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
</main>

<!-- ============ FOOTER ============ -->
<footer class="footer">
    <div class="footer__inner">
        <div class="container">
            <div class="row">
                <div class="accordion accordion--xs accordion--all js-accordion col-12">
                    <div class="row m-0">
                        <?php
                        $footerCols = [
                            'helpful' => 'Helpful links',
                            'company' => 'Our company',
                            'legal'   => 'Legal',
                        ];
                        foreach ($footerCols as $key => $heading):
                            if (empty($footerLinks[$key])) continue;
                        ?>
                        <div class="footer__section col-12 col-lg-3">
                            <div class="accordion-toggle__content mb-0">
                                <span class="h3 footer__heading"><?= h($heading) ?></span>
                                <div class="accordion-toggle__inner">
                                    <ul class="footer__list">
                                        <?php foreach ($footerLinks[$key] as $link): ?>
                                        <li><a href="<?= h($link['url']) ?>" title="<?= h($link['label']) ?>"><?= h($link['label']) ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>

                        <?php if (!empty($footerLinks['company_info'])): ?>
                        <div class="footer__section col-12 col-lg-3">
                            <div class="accordion-toggle__content mb-0">
                                <span class="h3 footer__heading">Company Information</span>
                                <div class="accordion-toggle__inner">
                                    <ul class="footer__list">
                                        <li>
                                            <div class="content">
                                                <?php foreach ($footerLinks['company_info'] as $line): ?>
                                                <p><?= h($line) ?></p>
                                                <?php endforeach; ?>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer__bottom">
        <div class="container">
            <div class="row">
                <div class="col-12"><hr class="footer__hr" /></div>
                <div class="col-12">
                    <div class="footer__copyright">
                        <span class="footer__small">
                            <div class="content"><?= date('Y') ?> <?= h($keyword) ?></div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- ============ FLOATING BUTTONS (footer-floating-star) ============ -->
<?php if (!empty($floatingButtons)): ?>
<div class="footer-floating-star">
    <?php foreach ($floatingButtons as $btn): ?>
    <a href="<?= h($btn['url']) ?>" class="footer-btn-star <?= h($btn['class'] ?? '') ?>"
       target="_blank" rel="nofollow noopener">
        <img src="<?= h($faviconSrc) ?>" alt="<?= h($btn['label']) ?>" /> <?= h($btn['label']) ?>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

</body>
</html>