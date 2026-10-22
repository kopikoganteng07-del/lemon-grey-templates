<?php
$id=(isset($_GET['id'])&&$_GET['id']!=='')?trim((string)$_GET['id'],'/'):'homepage';if($id==='')$id='homepage';$file=__DIR__.'/data/data.json';if(!is_file($file)){http_response_code(500);exit('data.json tidak ditemukan.');}$data=json_decode((string)file_get_contents($file),true);if(!is_array($data)){http_response_code(500);exit('data.json tidak valid.');}$page=$data[$id]??null;if(!is_array($page)){http_response_code(404);exit('<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="robots" content="noindex,nofollow"><title>404</title></head><body><h1>404</h1></body></html>');}$home=(isset($data['homepage'])&&is_array($data['homepage']))?$data['homepage']:[];$host=preg_replace('/:\\d+$/','',$_SERVER['HTTP_HOST']??'localhost');$origin='https://'.$host;$h=static fn($v)=>htmlspecialchars((string)($v??''),ENT_QUOTES,'UTF-8');$abs=static function($u)use($origin){$u=(string)$u;return $u===''?'':(preg_match('~^https?://~i',$u)?$u:$origin.'/'.ltrim($u,'/'));};$title=$page['title']??'';$desc=$page['meta_description']??'';$h1=$page['h1']??$title;$content=$page['content_html']??'';$site=$home['keyword']??explode('.',$host)[0];$canonical=$page['canonical_url']??($origin.'/');$amp=(!empty($page['amp_url'])&&$page['amp_url']!=='#')?$page['amp_url']:'';$robots=!empty($page['noindex'])?'noindex, nofollow':'index, follow';$logo=$abs($home['logo_src']??'');$favicon=$abs($home['favicon_src']??'');$image=$abs($page['image_src']??($page['banner_src']??($home['banner_src']??'')));$gsc=$home['gsc_token']??'';$login=$home['cta_login_url']??'#';$daftar=$home['cta_daftar_url']??'#';$template=<<<'HTMLPAGE'



<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="id-ID" prefix="fb: http://www.facebook.com/2008/fbml">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=Edge">
    <title>%%TITLE%%</title>
    <meta name="description" content="%%DESCRIPTION%%">
    <meta name="keywords" content="%%SITE%%, pembangunan fasilitas slot, fasilitas slot terkemuka, pusat hiburan daring, Indonesia 2026, sistem keamanan modern, lisensi terverifikasi">
    <link rel="apple-touch-icon" sizes="180x180" href="%%FAVICON%%">
    <link rel="icon" type="image/png" sizes="32x32" href="%%FAVICON%%">
    <link rel="icon" type="image/png" sizes="16x16" href="%%FAVICON%%">
    <link rel="manifest" href="https://assets.bonanza.com/site.webmanifest">
    <link rel="mask-icon" href="%%FAVICON%%" color="#29b7ae">
    <link rel="canonical" href="%%CANONICAL%%">
    %%AMPHTML%%
%%ALTERNATES%%
    <meta name="msapplication-TileColor" content="#173c37">
    <meta name="theme-color" content="#101312">
    <meta itemprop="url" content="%%ORIGIN_SLASH%%">
    <meta itemprop="quantity" content="68">
    <meta itemprop="availability" content="in_stock">
    <meta property="og:type" content="product">
    <meta property="og:site_name" content="%%SITE%%">
    <meta property="og:title" content="%%TITLE%%">
    <meta property="og:url" content="%%CANONICAL%%">
    <meta property="og:price:currency" content="IDR">
    <meta property="og:availability" content="instock">
    <meta property="og:image" content="%%IMAGE%%">
    <meta property="og:image:width" content="1000">
    <meta property="og:image:height" content="1000">
    <meta property="og:description" content="%%DESCRIPTION%%">
    <meta property="product:price:amount" content="10000">
    <meta property="product:retailer_item_id" content="20260228861303">
    <meta property="product:condition" content="%%SITE%%">
    <meta property="product:brand" content="%%SITE%%">
    <meta property="wanelo:store:url" content="%%ORIGIN_SLASH%%">
    <meta property="wanelo:store:name" content="%%SITE%%">
    <meta name="robots" content="%%ROBOTS%%">
%%GSC_META%%
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@%%SITE%%">
    <meta name="twitter:title" content="%%TITLE%%">
    <meta name="twitter:description"
        content="%%DESCRIPTION%%">
    <meta name="twitter:image:src" content="%%LOGO%%">
    <meta name="twitter:data1" content="10000 IDR">
    <meta name="twitter:label1" content="PRICE">
    <meta name="twitter:data2" content="%%SITE%%">
    <meta name="twitter:label2" content="%%SITE%%">
    <meta name="twitter:domain" content="%%SITE%%">
    <link rel="stylesheet" media="screen, print"
        href="https://assets.bonanza.com/assets/global_css-9af8c792c4b0065d1f1c9f59df4bd543.gz.css">
    <link rel="stylesheet" media="screen, print"
        href="https://assets.bonanza.com/assets/items_css-d5a50cdd4e0d004e14d94a293c60dd04.gz.css">
    <link rel="stylesheet" media="screen, print"
        href="https://assets.bonanza.com/assets/items_buy_css-47ccbb99d1ca186442571b94e8631899.gz.css">
    <link rel="stylesheet" media="screen, print"
        href="https://assets.bonanza.com/assets/validation_css-8d8a2c6e80caadb971b3d5c9da6877a7.gz.css">
    <link rel="stylesheet" media="screen, print"
        href="https://assets.bonanza.com/assets/sessions_css-6679cd03f087e2147af60db785446134.gz.css">
    <link rel="stylesheet" media="screen"
        href="https://fonts.googleapis.com/css?family=Lato:400,400italic,700,700italic">

    
  <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Product",
  "name": "%%SITE%%: Pembangunan Fasilitas Slot Terkemuka di Indonesia 2026",
  "image": "%%IMAGE%%",
  "description": "Sebagai representasi pembangunan fasilitas slot terkemuka di Indonesia pada 2026, %%SITE%% menghadirkan pusat hiburan daring terlengkap. Sistem keamanan modern dan lisensi terverifikasi memastikan lingkungan bermain yang kredibel.",
  "brand": {
    "@type": "Brand",
    "name": "%%SITE%%"
  },
  "sku": "tplbrand-2026-001",
  "mpn": "tplbrand-FASILITAS-001",
  "url": "%%ORIGIN_SLASH%%",
  "offers": {
    "@type": "Offer",
    "url": "%%ORIGIN_SLASH%%",
    "priceCurrency": "IDR",
    "price": "10000",
    "priceValidUntil": "2027-09-27",
    "itemCondition": "https://schema.org/NewCondition",
    "availability": "https://schema.org/InStock",
    "seller": {
      "@type": "Organization",
      "name": "%%SITE%%"
    }
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5.0",
    "reviewCount": 6
  },
  "review": [
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-05-12",
      "reviewBody": "%%SITE%% memiliki tampilan yang sangat ringan dan mudah dijelajahi untuk mengenal berbagai pilihan fasilitas permainan digital melalui perangkat komputer maupun seluler.",
      "author": {
        "@type": "Person",
        "name": "Reza Mahendra"
      }
    },
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-05-08",
      "reviewBody": "%%SITE%% menghadirkan antarmuka yang sangat praktis untuk pengguna seluler dengan navigasi yang mudah dipahami saat menjelajahi ekosistem permainan digital terkemuka ini.",
      "author": {
        "@type": "Person",
        "name": "Aditya Prakoso"
      }
    },
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-04-26",
      "reviewBody": "Sebagai platform permainan digital terkemuka %%SITE%% memiliki alur navigasi yang cukup jelas dari awal akses halaman hingga penjelajahan berbagai kategori permainan.",
      "author": {
        "@type": "Person",
        "name": "Fahmi Nugroho"
      }
    },
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-04-14",
      "reviewBody": "%%SITE%% menghadirkan pengalaman digital yang sangat rapi dengan struktur halaman yang mudah dikenali dan pilihan permainan yang tersusun jauh lebih terorganisir.",
      "author": {
        "@type": "Person",
        "name": "Rangga Saputra"
      }
    },
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-03-29",
      "reviewBody": "Hal yang paling menonjol dari fasilitas %%SITE%% adalah akses halaman yang ringan navigasi yang tidak membingungkan serta tampilan yang super responsif di berbagai perangkat.",
      "author": {
        "@type": "Person",
        "name": "Bayu Firmansyah"
      }
    },
    {
      "@type": "Review",
      "reviewRating": {
        "@type": "Rating",
        "ratingValue": 5,
        "bestRating": 5
      },
      "datePublished": "2026-03-17",
      "reviewBody": "Fasilitas %%SITE%% dapat dijelajahi melalui tampilan seluler yang sangat responsif sehingga pengguna dapat mengenal pilihan permainan digital dengan jauh lebih praktis.",
      "author": {
        "@type": "Person",
        "name": "Ilham Ramadhan"
      }
    }
  ]
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "name": "%%SITE%%",
      "item": "%%ORIGIN_SLASH%%"
    },
    {
      "@type": "ListItem",
      "position": 2,
      "name": "Fasilitas Slot Terkemuka",
      "item": "%%ORIGIN_SLASH%%"
    },
    {
      "@type": "ListItem",
      "position": 3,
      "name": "%%SITE%%: Pembangunan Fasilitas Slot Terkemuka di Indonesia 2026",
      "item": "%%ORIGIN_SLASH%%"
    }
  ]
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Organization",
  "name": "%%SITE%%",
  "url": "%%ORIGIN_SLASH%%",
  "logo": "%%LOGO%%",
  "sameAs": [
    "%%ORIGIN_SLASH%%",
    "%%ORIGIN_SLASH%%"
  ],
  "contactPoint": {
    "@type": "ContactPoint",
    "telephone": "",
    "contactType": "customer support",
    "areaServed": "ID",
    "availableLanguage": [
      "Indonesian",
      "English"
    ]
  }
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "WebSite",
  "name": "%%SITE%%",
  "url": "%%ORIGIN_SLASH%%",
  "potentialAction": {
    "@type": "SearchAction",
    "target": "%%ORIGIN_SLASH%%",
    "query-input": "required name=search_term_string"
  }
}
</script>

   <script type="application/ld+json" id="schema-data">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    {
      "@type": "Question",
      "name": "Apa itu representasi fasilitas terkemuka dalam ekosistem %%SITE%%?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "%%SITE%% adalah pusat hiburan daring yang menghadirkan lingkungan bermain kredibel dengan lisensi terverifikasi dan sistem keamanan paling modern di Indonesia."
      }
    },
    {
      "@type": "Question",
      "name": "Bagaimana %%SITE%% mengikuti perkembangan permainan digital saat ini?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Kami terus berinovasi mengikuti teknologi terbaru untuk memastikan setiap fasilitas permainan digital kami selalu mutakhir dan sangat praktis dimainkan."
      }
    },
    {
      "@type": "Question",
      "name": "Apa hubungan fasilitas terkemuka dengan perkembangan ekosistem %%SITE%%?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Fasilitas terkemuka ini merupakan fondasi utama yang membangun ekosistem %%SITE%% menjadi arena taruhan paling aman dan terorganisir di tahun 2026."
      }
    },
    {
      "@type": "Question",
      "name": "Apakah fasilitas %%SITE%% dapat dijelajahi melalui perangkat seluler?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Sangat bisa karena seluruh sistem kami telah dioptimalkan agar responsif dan mudah dijelajahi melalui berbagai perangkat pintar Anda setiap saat."
      }
    },
    {
      "@type": "Question",
      "name": "Apa yang menjadi fokus utama perkembangan platform %%SITE%%?",
      "acceptedAnswer": {
        "@type": "Answer",
        "text": "Fokus utama kami adalah memberikan pengalaman bermain paling aman nyaman dan terorganisir melalui sistem keamanan modern serta lisensi yang terverifikasi resmi."
      }
    }
  ]
}
</script>

    <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "%%ORIGIN_SLASH%%"
  },
  "headline": "%%SITE%%: Pembangunan Fasilitas Slot Terkemuka di Indonesia 2026",
  "alternativeHeadline": "%%SITE%%: Pembangunan Fasilitas Slot Terkemuka di Indonesia 2026",
  "image": [
    "%%IMAGE%%"
  ],
  "datePublished": "2026-01-06T09:00:00+07:00",
  "dateModified": "2026-01-07T09:00:00+07:00",
  "author": {
    "@type": "Person",
    "@id": "%%ORIGIN_SLASH%%",
    "name": "%%SITE%%",
    "url": "%%ORIGIN_SLASH%%"
  },
  "publisher": {
    "@type": "Organization",
    "@id": "%%ORIGIN_SLASH%%",
    "name": "%%SITE%%",
    "logo": {
      "@type": "ImageObject",
      "url": "%%LOGO%%"
    }
  },
  "description": "Sebagai representasi pembangunan fasilitas slot terkemuka di Indonesia pada 2026, %%SITE%% menghadirkan pusat hiburan daring terlengkap. Sistem keamanan modern dan lisensi terverifikasi memastikan lingkungan bermain yang kredibel.",
  "articleSection": "%%SITE%%, FASILITAS SLOT, PUSAT HIBURAN DARING",
  "keywords": [
    "%%SITE%%",
    "pembangunan fasilitas slot",
    "fasilitas slot terkemuka",
    "pusat hiburan daring",
    "Indonesia 2026",
    "sistem keamanan modern",
    "lisensi terverifikasi"
  ],
  "inLanguage": "id-ID",
  "isAccessibleForFree": true,
  "hasPart": [
    {
      "@type": "WebPageElement",
      "name": "Bagian Artikel",
      "cssSelector": "main"
    }
  ]
}
</script>
    <script>
        !function () { if (!window.klaviyo) { window._klOnsite = window._klOnsite || []; try { window.klaviyo = new Proxy({}, { get: function (n, i) { return "push" === i ? function () { var n; (n = window._klOnsite).push.apply(n, arguments) } : function () { for (var n = arguments.length, o = new Array(n), w = 0; w < n; w++)o[w] = arguments[w]; var t = "function" == typeof o[o.length - 1] ? o.pop() : void 0, e = new Promise((function (n) { window._klOnsite.push([i].concat(o, [function (i) { t && t(i), n(i) }])) })); return e } } }) } catch (n) { window.klaviyo = window.klaviyo || [], window.klaviyo.push = function () { var n; (n = window._klOnsite).push.apply(n, arguments) } } } }();


        var item = {
            "ProductName": "%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern",
            "ProductID": "20260211367303",
            "SKU": null,
            "Categories": ["tplbrand-20260211367303"],
            "ImageURL": "%%LOGO%%",
            "URL": "%%ORIGIN_SLASH%%",
            "Brand": "Unbranded",

            "Price": 0.777
        };
        klaviyo.push(["track", "Viewed Product", item]);

        klaviyo.push(["trackViewedItem", {
            "Title": "%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern",
            "ItemId": "20260211367303",
            "Categories": ["tplbrand-20260211367303"],
            "ImageUrl": "%%LOGO%%",
            "Url": "%%ORIGIN_SLASH%%",
            "Metadata": {
                "Brand": "Unbranded",

                "Price": 0.777
            }
        }]);

    </script>

    <script>
        (function () {
            var t;
            try {
                t = Intl.DateTimeFormat().resolvedOptions().timeZone
            } catch (e) { }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "/track", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            var params = "h=" + encodeURIComponent(window.location.href) +
                "&r=" + encodeURIComponent("%%ORIGIN_SLASH%%") +
                "&u=" + encodeURIComponent("") +
                "&m=" + encodeURIComponent("GET") +
                "&p=" + encodeURIComponent("%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern") +
                "&pt=" + encodeURIComponent("productDetail") +
                "&t=" + encodeURIComponent(t);

            xhr.send(params);

            XMLHttpRequest
        })();
    </script>



<style id="tplbrand-blue-red-luxury">
:root{--r138-blue:#29b7ae;--r138-blue2:#257f79;--r138-blue3:#173c37;--r138-red:#82c72b;--r138-red2:#527a22;--r138-ink:#f5f7f1;--r138-line:rgba(79, 213, 201,.22)}
html,body{background:radial-gradient(circle at 15% 0,rgba(41, 183, 174,.16),transparent 28%),radial-gradient(circle at 85% 0,rgba(130, 199, 43,.13),transparent 26%),linear-gradient(180deg,#101312 0%,#18201d 48%,#0d1110 100%)!important;color:var(--r138-ink)}
#header,.responsive_header_top_bar,.header_utilities,.header_search,.header_shopping{background:linear-gradient(135deg,#173c37 0%,#173c37 62%,#101b19 100%)!important;border-color:rgba(255,255,255,.08)!important;box-shadow:0 12px 30px rgba(0,0,0,.32),0 0 22px rgba(41, 183, 174,.16)}
.bonanza_logo img,.logo-img{filter:drop-shadow(0 8px 18px rgba(0,0,0,.46)) drop-shadow(0 0 15px rgba(41, 183, 174,.32))}
.item_description_inner,.tplbrand-desc,.tplbrand-table,.tplbrand-FAQ-section,.content,.item_listing_main_image,.item_listing_item_description{background:linear-gradient(180deg,rgba(20, 32, 29,.96),rgba(13, 17, 16,.98))!important;border-color:var(--r138-line)!important;box-shadow:0 18px 42px rgba(0,0,0,.28),0 0 20px rgba(41, 183, 174,.10)}
.tplbrand-header,.tplbrand-table th{background:linear-gradient(90deg,#257f79,#29b7ae 55%,#82c72b)!important;color:#fff!important;text-shadow:0 1px 8px rgba(0,0,0,.32)}
.tplbrand-table td,.tplbrand-FAQ-section details{border-color:rgba(79, 213, 201,.28)!important;background:linear-gradient(145deg,#14201d,#173c37)!important}
.tplbrand-table tr:hover{background:rgba(130, 199, 43,.12)!important}
.search-btn,.btn-cta,.cta-button,.responsive_header_link.log_in,.link_to_sell_on_bonanza{background:linear-gradient(135deg,#257f79,#29b7ae 60%,#55d2c5)!important;border-color:rgba(255,255,255,.14)!important;box-shadow:0 10px 24px rgba(0,0,0,.25),inset 0 1px 0 rgba(255,255,255,.12)}
.responsive_header_link.log_in,.btn-cta:last-child{background:linear-gradient(135deg,#527a22,#82c72b 62%,#9cce55)!important}
a,button,.search-btn,.btn-cta,.tplbrand-table tr{transition:all .25s ease}
a:hover,button:hover,.search-btn:hover,.btn-cta:hover{filter:brightness(1.08)}
.logo-link{position:relative;overflow:hidden;border-radius:18px}
.logo-link:after{content:"";position:absolute;top:0;left:-55%;width:35%;height:100%;background:linear-gradient(90deg,transparent,rgba(255,255,255,.16),transparent);transform:skewX(-22deg);animation:r138shine 6s ease-in-out infinite;pointer-events:none}
@keyframes r138shine{0%,75%{left:-55%}100%{left:135%}}
@media(max-width:768px){.bonanza_logo img,.logo-img{max-width:150px!important;height:auto!important}.item_description_inner,.tplbrand-desc,.tplbrand-table,.tplbrand-FAQ-section{border-radius:14px!important}}
</style>

<style id="tplbrand-clean-mobile-structure-final">
/* Clean hero structure: no legacy boxes/lines */
.r138-clean-banner{position:relative;margin:0 auto 18px;max-width:520px}
.r138-clean-banner a{display:block;position:relative;overflow:hidden;border-radius:20px;background:#101b19}
.r138-clean-banner img{display:block;width:100%;height:auto;aspect-ratio:1/1;object-fit:cover;object-position:center;border-radius:20px}

@media (max-width:768px){
  html,body{overflow-x:hidden!important}

  #main_wrapper,#content,
  .item_listing_content_wrapper,.item_listing_body,.item_listing_main,
  .item_listing_images,.r138-clean-hero-media,
  .item_listing_basic_info,.item_listing_title_and_price{
    width:100%!important;max-width:100%!important;min-width:0!important;
    background:transparent!important;background-image:none!important;
    border:0!important;outline:0!important;box-shadow:none!important;
    box-sizing:border-box!important;
  }

  #main_wrapper::before,#main_wrapper::after,#content::before,#content::after,
  .item_listing_content_wrapper::before,.item_listing_content_wrapper::after,
  .item_listing_body::before,.item_listing_body::after,
  .item_listing_main::before,.item_listing_main::after,
  .item_listing_images::before,.item_listing_images::after,
  .r138-clean-hero-media::before,.r138-clean-hero-media::after{
    content:none!important;display:none!important;border:0!important;box-shadow:none!important;
  }

  .item_listing_content_wrapper{padding:12px 12px 0!important;margin:0!important}
  .item_listing_body,.item_listing_main{display:block!important;margin:0!important;padding:0!important;overflow:visible!important}
  .r138-clean-hero-media{display:block!important;float:none!important;clear:both!important;margin:0!important;padding:0!important;height:auto!important;min-height:0!important}

  .r138-clean-banner{
    width:min(100%,430px)!important;max-width:430px!important;
    margin:0 auto 16px!important;padding:0!important;
    border:0!important;outline:0!important;border-radius:20px!important;
    background:transparent!important;
    box-shadow:0 18px 38px rgba(0,0,0,.32),0 0 18px rgba(41, 183, 174,.16)!important;
  }
  .r138-clean-banner a{
    display:block!important;width:100%!important;height:auto!important;aspect-ratio:1/1!important;
    border:0!important;outline:0!important;box-shadow:none!important;background:transparent!important;
    border-radius:20px!important;overflow:hidden!important;
  }
  .r138-clean-banner img{
    display:block!important;width:100%!important;height:100%!important;aspect-ratio:1/1!important;
    object-fit:cover!important;object-position:center!important;
    border:0!important;outline:0!important;box-shadow:none!important;border-radius:20px!important;
  }

  .item_listing_basic_info{display:block!important;float:none!important;clear:both!important;margin:0!important;padding:0!important}
  .item_listing_flags{display:flex!important;flex-wrap:wrap!important;gap:6px!important;margin:2px 0 10px!important;padding:0!important}
  .item_listing_flag{float:none!important;width:auto!important;margin:0!important}
  .flag_text_container{max-width:100%!important;white-space:normal!important;overflow-wrap:anywhere!important;font-size:11px!important;line-height:1.2!important;padding:4px 8px!important}

  .item_listing_title_and_price h1,
  .item_listing_title,
  h1[itemprop="name"]{width:100%!important;max-width:100%!important;margin:8px 0 10px!important;padding:0!important;font-size:21px!important;line-height:1.42!important;overflow-wrap:anywhere!important}

  .cta-buttons{display:grid!important;grid-template-columns:1fr 1fr!important;gap:10px!important;width:100%!important}
  .btn-cta{width:100%!important;min-width:0!important;margin:0!important}

  /* Testimonials */
  .tplbrand-FAQ-section{padding:22px 14px!important;border-radius:18px!important}
  .tplbrand-FAQ-section h2{text-align:center!important;font-size:20px!important;line-height:1.2!important;margin:0 0 16px!important;letter-spacing:.5px!important}
  .testimoni-wrapper{display:grid!important;grid-template-columns:1fr!important;gap:14px!important;margin-top:18px!important;width:100%!important}
  .tplbrand-FAQ-section blockquote{width:100%!important;min-height:0!important;margin:0!important;padding:20px 16px 16px!important;border-radius:16px!important;font-size:14px!important;line-height:1.75!important;overflow:hidden!important;word-break:break-word!important}
  .tplbrand-FAQ-section blockquote::before{top:4px!important;left:12px!important;font-size:44px!important;opacity:.28!important}
  .tplbrand-FAQ-section cite{margin-top:14px!important;font-size:13px!important;text-align:right!important}
  .seller-name__detail{margin-top:18px!important;grid-column:auto!important}
  .seller-name__detail a{display:inline-block!important;font-size:14px!important;padding:10px 18px!important}
}

@media (max-width:420px){
  .item_listing_content_wrapper{padding:10px 10px 0!important}
  .r138-clean-banner{width:100%!important;max-width:390px!important;border-radius:16px!important}
  .r138-clean-banner a,.r138-clean-banner img{border-radius:16px!important}
  .item_listing_title_and_price h1,.item_listing_title,h1[itemprop="name"]{font-size:19px!important;line-height:1.4!important}
  .flag_text_container{font-size:10px!important}
  .tplbrand-FAQ-section{padding:18px 12px!important}
  .tplbrand-FAQ-section h2{font-size:18px!important}
  .tplbrand-FAQ-section blockquote{padding:18px 14px 14px!important;font-size:13.5px!important}
}
</style>


<style id="tplbrand-disable-userguiding-artifacts">
#__userGuiding__preview_Root,#__UG_basement,#userguiding,#ug-modal-frame,#ug-tooltip-frame,#ug-troubleshooter-iframe,.ug-frame-wrapper{display:none!important;width:0!important;height:0!important;min-width:0!important;min-height:0!important;border:0!important;outline:0!important;box-shadow:none!important;visibility:hidden!important;pointer-events:none!important;position:absolute!important;left:-99999px!important;top:-99999px!important;}
</style>
</head>

<body id="items_show_body" class="show_body"><b tabindex="-1" aria-hidden="true"
        style="position: absolute; left: -1000px;"><iframe style="display: none;"></iframe></b>

    <iframe height="0" width="0" style="display: none; visibility: hidden;"></iframe>
<div class="responsive_header_menu_overlay is_hidden desktop_version"></div>


    <iframe height="0" width="0" style="display: none; visibility: hidden;"></iframe>
    <div id="header" class="">

        <div class="header_utilities">
            <div class="wrapper">
                <ul class="my_bonanza header_top_level_menu">
                    <li class="sell_on_bonanza header_top_level_button_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px;">
                        <a class="link_to_sell_on_bonanza" href="%%CTA_DAFTAR%%" rel="nofollow"
                            data-asw-org-font-size="13" style="font-size: 13px;">DAFTAR</a>

                        <div class="header_subnav_menu">
                            <ul class="header_secondary_level_menu section">
                                <li class="header_secondary_level_menu_item sell_in_one_click"
                                    data-asw-org-font-size="14" style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                        style="font-size: 13px;">Start selling in one click</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Add or edit items</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Import from Amazon</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Import from eBay</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Import from Etsy</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Import from Shopify</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Import from inventory
                                        file</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Open a Webstore</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="buyer header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px;">
                        <a class="link_to_my_bonanza" href="%%CTA_LOGIN%%" rel="nofollow"
                            data-asw-org-font-size="13" style="font-size: 13px;">
                            LOGIN

                            <i class="fa fa-angle-down inline_icon"></i>
                        </a>
                        <div class="header_subnav_menu">
                            <div class="section">
                                <a class="link_to_my_bonanza header_subnav_menu_button" href="%%CTA_LOGIN%%" rel="nofollow"
                                    data-asw-org-font-size="13" style="font-size: 13px;">Account Dashboard</a>
                            </div>

                            <ul class="header_secondary_level_menu section">
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Profile</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Messages</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Account settings</a></li>
                            </ul>

                            <ul class="header_secondary_level_menu section">
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Recent purchases</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Wish list</a></li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Hand-picked lists</a></li>
                            </ul>
                        </div>
                    </li>

                    <li class="help header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px;">
                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                            style="font-size: 13px;">LINK
                            ALTERNATIF<i class="fa fa-angle-down inline_icon"></i></a>

                        <div class="header_subnav_menu">
                            <div class="header_secondary_level_menu section">
                                <form class="header_subnav_menu_search_form" action="%%DISABLED_ENDPOINT%%"
                                    accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓">
                                    <input class="search_field" placeholder="Search help topics"
                                        aria-label="Search help topics" type="text" name="search_form[q]"
                                        id="search_form_q">
                                    <button name="button" type="submit" title="Submit search"
                                        aria-label="Submit search"><i
                                            class="fa fa-search inline_icon fa-flip-horizontal"></i></button>
                                </form>
                            </div>

                            <ul class="header_secondary_level_menu section">
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a target="_blank" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Visit the help center</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Contact support</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Seller success tips</a>
                                </li>
                            </ul>

                            <ul class="header_secondary_level_menu section">
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Read
                                        the %%SITE%% Selling blog</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Read
                                        the %%SITE%% Shopping blog</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%"rel="nofollow"  data-asw-org-font-size="14"
                                        style="font-size: 14px;">How %%SITE%% works</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Ask the
                                        community</a>
                                </li>
                                <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a target="_blank"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Submit an idea</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>

                <ul class="account header_top_level_menu">



                    <li class="user header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px;">

                        <a class="link_to_profile" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;"><img class="user_profile_pic"
                                alt="%%SITE%% RESMI's profile picture"
                                src="%%FAVICON%%">%%SITE%%<i
                                class="fa fa-angle-down inline_icon"></i></a>
                        <div class="header_subnav_menu">
                            <div class="section dashboard_links">
                                <a class="link_to_my_bonanza header_subnav_menu_button" href="%%CTA_LOGIN%%" rel="nofollow"
                                    data-asw-org-font-size="13" style="font-size: 13px;">Account Dashboard</a>
                            </div>

                            <div class="section">

                                <div class="not_user_maybe">Not %%SITE%% RESMI?</div>
                                <a class="link_to_log_out" href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="13"
                                    style="font-size: 13px;">Log out</a>
                            </div>
                        </div>
                    </li>


                    <li class="cart header_top_level_menu_item" data-asw-org-font-size="13" style="font-size: 13px;">

                        <a class="link_to_cart" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                            style="font-size: 13px;">Cart</a>

                    </li>
                </ul>
            </div>
        </div>
        <style>
            .item_listing_flag.free_shipping .flag_text_container {
                background-color: #257f79;
            }

            .header_search_container .search-btn {
                display: inline-block;
                border-radius: 0 5px 5px 0;
                box-shadow: 0 1px #4fd5c9 inset;
                margin-left: -4px;
                padding: 8px 12px;
                border: 1px solid #82c72b;
                background-color: #173c37;
                color: #fff;
                font-size: 20px;
                text-decoration: none;
                cursor: pointer;
                transition: all 0.3s ease;
            }

            .header_search_container .search-btn:hover {
                background-color: #82c72b;
                border-color: #9cce55;
                box-shadow:
                    0 0 10px rgba(41, 183, 174, 0.6),
                    0 2px 5px rgba(0, 0, 0, 0.3),
                    inset 0 1px #fff;
                transform: translateY(-1px);
            }

            .header_search_container .search-btn:active {
                transform: translateY(1px);
                box-shadow:
                    inset 0 2px 5px rgba(0, 0, 0, 0.4),
                    0 0 5px rgba(41, 183, 174, 0.5);
            }

            .bonanza_logo img {
                max-width: 100%;
                width: 140px;
                height: auto;
            }

            .logo-link {
                display: inline-block;
                text-decoration: none;
            }

            .logo-img {
                width: auto;
                height: 40px;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                filter: drop-shadow(0 0 8px rgba(130, 199, 43, 0.7));
            }

            .logo-link:hover .logo-img {
                animation: shake 0.6s ease-in-out infinite;
                transform: scale(1.1);
                box-shadow: 0 0 12px 4px rgba(107, 74, 53, 0.8);
            }

            @keyframes shake {
                0% {
                    transform: translateX(0);
                }

                20% {
                    transform: translateX(-12px);
                }

                40% {
                    transform: translateX(12px);
                }

                60% {
                    transform: translateX(-12px);
                }

                80% {
                    transform: translateX(12px);
                }

                100% {
                    transform: translateX(0);
                }

            }
        </style>
        <style>
            /* ===============================
   ✨ LOGO PREMIUM FLOAT EFFECT
================================= */
            .logo-link {
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 24px 0 36px;
                position: relative;
                animation: logoFloat 6s ease-in-out infinite;
            }

            .logo-link::before {
                content: "";
                position: absolute;
                width: 220px;
                height: 220px;
                background: radial-gradient(circle, rgba(130, 199, 43, .35), transparent 70%);
                filter: blur(35px);
                opacity: .75;
                z-index: 0;
                animation: glowPulse 5s ease-in-out infinite;
            }

            .logo-link img {
                position: relative;
                z-index: 2;
                height: 135px;
                filter:
                    drop-shadow(0 8px 18px rgba(0, 0, 0, .6)) drop-shadow(0 0 18px #9cce55);
                transition: all .45s ease;
            }

            .logo-link img:hover {
                transform: scale(1.07);
                filter:
                    drop-shadow(0 10px 25px rgba(0, 0, 0, .8)) drop-shadow(0 0 30px #4fd5c9);
            }

            /* Floating smooth */
            @keyframes logoFloat {

                0%,
                100% {
                    transform: translateY(0);
                }

                50% {
                    transform: translateY(-8px);
                }
            }

            @keyframes glowPulse {

                0%,
                100% {
                    opacity: .6;
                    transform: scale(1);
                }

                50% {
                    opacity: 1;
                    transform: scale(1.15);
                }
            }


            /* ===============================
   🎨 PALET ROYAL PREMIUM
================================= */
            :root {
                --warna-teks-utama: #f8f8f8;
                --warna-heading: #82c72b;
                --warna-harga: #82c72b;
                --warna-h2: #82c72b;
                --shadow-h2: #173c37;
                --gold-glow: #82c72b;
                --font-premium: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            }

            /* ===============================
   🖋️ TEXT STYLING ELEGANT
================================= */
            .t-body,
            .purchase-form__us-dollars-notice,
            .license-selector__description p,
            .flyout__link p,
            .t-icon-list__item {
                color: var(--warna-teks-utama) !important;
                text-shadow: 0 1px 4px rgba(0, 0, 0, .4);
            }

            /* ===============================
   💰 PRICE GOLD SHIMMER
================================= */
            .js-purchase-price,
            .purchase-form__price,
            .t-currency {
                color: var(--warna-harga) !important;
                font-weight: 700;
                letter-spacing: .6px;
                position: relative;
                animation: goldShine 3.5s linear infinite;
            }

            @keyframes goldShine {
                0% {
                    text-shadow: 0 0 6px rgba(130, 199, 43, .4);
                }

                50% {
                    text-shadow: 0 0 18px rgba(130, 199, 43, .9);
                }

                100% {
                    text-shadow: 0 0 6px rgba(130, 199, 43, .4);
                }
            }

            /* ===============================
   🔥 HEADING 3D ROYAL STYLE
================================= */
            h1 {
                font-size: 30px;
                font-weight: 1000;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                font-family: var(--font-premium);
                margin: 28px 0 16px;
                position: relative;

                background: linear-gradient(180deg, #82c72b, #82c72b);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;

                text-shadow:
                    0 3px 8px #4fd5c9,
                    0 0 12px #173c37;
            }

            @keyframes headingGlow {

                0%,
                100% {
                    text-shadow:
                        0 3px 8px rgba(0, 0, 0, .6),
                        0 0 12px #9cce55;
                }

                50% {
                    text-shadow:
                        0 5px 14px rgba(0, 0, 0, .8),
                        0 0 22px #4fd5c9;
                }
            }

            h2 {
                font-size: 30px;
                font-weight: 900;
                text-transform: uppercase;
                letter-spacing: 1.5px;
                font-family: var(--font-premium);
                margin: 28px 0 16px;
                position: relative;

                background: linear-gradient(180deg, #FFF, #FFF);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;

                text-shadow:
                    0 3px 8px #173c37,
                    0 0 12px #173c37;

                animation: headingGlow 4s ease-in-out infinite;
            }

            @keyframes headingGlow {

                0%,
                100% {
                    text-shadow:
                        0 3px 8px #173c37,
                        0 0 12px #9cce55;
                }

                50% {
                    text-shadow:
                        0 5px 14px #173c37,
                        0 0 22px #4fd5c9;
                }
            }

            /* Animated gold underline */
            h2::after {
                content: "";
                position: absolute;
                bottom: -8px;
                left: 50%;
                width: 70px;
                height: 4px;
                border-radius: 4px;
                background: linear-gradient(90deg, transparent, #82c72b, transparent);
                transform: translateX(-50%);
                animation: underlineGlow 3s ease-in-out infinite;
            }

            @keyframes underlineGlow {

                0%,
                100% {
                    opacity: .6;
                    width: 70px;
                }

                50% {
                    opacity: 1;
                    width: 120px;
                }
            }

            /* Hover cinematic */
            h2:hover {
                transform: scale(1.06);
                transition: all .4s ease;
            }
        </style>

        <style>
            :root {

                /* === ROYAL GOLD PALETTE (LEBIH ELEGAN) === */
                --gold-1: #eef7df;
                --gold-2: #9cce55;
                --gold-3: #82c72b;
                --gold-4: #6b4a35;
                --gold-5: #6b4a35;

                --royal-black: #0c0a06;
                --royal-dark: #14120d;

                --glass-bg: rgba(255, 255, 255, .05);
                --border-gold: rgba(130, 199, 43, .35);
                --glow-soft: rgba(130, 199, 43, .25);

                --radius: 22px;
                --pad: 22px;
                --cta-h: 56px;
                --shine-speed: 8s;
            }

            /* ===== CONTAINER PREMIUM ===== */
            .royal-actions.v2 .cta-royal {
                position: relative;
                isolation: isolate;
                overflow: hidden;
                padding: var(--pad);
                border-radius: var(--radius);

                background:
                    radial-gradient(circle at 50% -20%, rgba(255, 255, 255, .12), transparent 60%),
                    linear-gradient(180deg, #173c37, #82c72b);

                border: 1px solid var(--border-gold);

                box-shadow:
                    0 0 0 1px rgba(255, 255, 255, .05) inset,
                    0 25px 60px rgba(0, 0, 0, .6),
                    0 0 40px #173c37;

                backdrop-filter: blur(12px) saturate(1.2);
            }

            /* ===== GOLD ROTATING EDGE (LEBIH HALUS) ===== */
            .gilded-frame {
                position: absolute;
                inset: 0;
                border-radius: inherit;
                pointer-events: none;
            }

            .gilded-frame::before {
                content: "";
                position: absolute;
                inset: -1px;
                border-radius: inherit;
                background: conic-gradient(from 0deg,
                        #82c72b,
                        #82c72b,
                        #173c37,
                        #173c37,
                        #173c37,
                        #82c72b,
                        #82c72b);
                animation: spin var(--shine-speed) linear infinite;
                -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
                mask: radial-gradient(farthest-side, transparent calc(100% - 2px), #000 calc(100% - 1px));
                opacity: .75;
            }

            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            /* ===== BUTTONS PREMIUM ===== */
            .cta-buttons {
                position: relative;
                display: flex;
                gap: 20px;
                justify-content: center;
                z-index: 2;
            }

            .btn-cta {
                position: relative;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                height: var(--cta-h);
                min-width: 190px;
                padding: 0 28px;
                border-radius: 14px;
                font-weight: 800;
                letter-spacing: .8px;
                text-transform: uppercase;
                text-decoration: none;
                overflow: hidden;

                border: 1px solid rgba(255, 255, 255, .15);
                transition: all .25s ease;

                box-shadow:
                    0 10px 25px rgba(0, 0, 0, .5),
                    0 0 20px rgba(130, 199, 43, .15);
            }

            /* Shine halus */
            .btn-cta::after {
                content: "";
                position: absolute;
                inset: -2px;
                background: linear-gradient(75deg, transparent 40%, rgba(255, 255, 255, .25) 50%, transparent 60%);
                transform: translateX(-140%) skewX(-15deg);
                transition: transform .6s ease;
            }

            .btn-cta:hover::after {
                transform: translateX(140%) skewX(-15deg);
            }

            /* ===== COIN ANIMATION LEBIH SOFT ===== */
            .petals span {
                width: 36px;
                height: 36px;
                opacity: .8;
                filter: drop-shadow(0 4px 8px rgba(0, 0, 0, .6));
                animation:
                    coinFall linear infinite,
                    coinRotate 8s linear infinite;
            }

            @keyframes coinFall {
                0% {
                    transform: translateY(-60px);
                    opacity: 0;
                }

                10% {
                    opacity: .9;
                }

                85% {
                    opacity: .9;
                }

                100% {
                    transform: translateY(380px);
                    opacity: 0;
                }
            }

            @keyframes coinRotate {
                from {
                    transform: rotateY(0deg);
                }

                to {
                    transform: rotateY(360deg);
                }
            }

            /* ===== RESPONSIVE ===== */
            @media(max-width:600px) {
                .btn-cta {
                    min-width: 48%;
                    height: 48px;
                    font-size: .9rem;
                }

                .royal-actions.v2 .cta-royal {
                    padding: 16px;
                    border-radius: 16px;
                }
            }
        </style>




        <div class="header_search">
            <div class="wrapper">
                <a class="bonanza_logo" title="%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern"
                    href="%%ORIGIN_SLASH%%" data-asw-org-font-size="14" style="font-size: 14px;">
                    <img alt="%%SITE%%" data-retina="true" src="%%LOGO%%">
                </a>

                <div id="header_search_box" class="header_search_container">
                    <form action="%%DISABLED_ENDPOINT%%" accept-charset="UTF-8" method="get"><input
                            name="utf8" type="hidden" value="✓"> <input type="hidden" name="q[filter_category_id]">
                        <input type="hidden" name="q[catalog_id]">
                        <input type="hidden" name="q[in_booth_id]">
                        <input value="true" type="hidden" name="q[translate_term]">
                        <input value="0" type="hidden" name="q[shipping_in_price]">
                        <input value="relevancy" type="hidden" name="q[sort_by]">

                        <input class="search_term ui-autocomplete-input" aria-label="Search for items"
                            placeholder="CARI %%SITE%% DI GOOGLE" type="text" name="q[search_term]" autocomplete="off"
                            role="textbox" aria-autocomplete="list" aria-haspopup="true">
                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" class="search-btn" title="DAFTAR %%SITE%%"
                            aria-label="Submit search">
                            <i class="fa fa-search inline_icon fa-flip-horizontal"></i>
                        </a>
                    </form>
                </div>
            </div>
        </div>



        <div class="header_shopping">
            <div class="wrapper">

                <ul class="header_top_level_menu">

                    <li class="womens_fashion header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a data-short-name="%%SITE%%" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">%%SITE%%</a>
                    </li>

                    <li class="mens_fashion header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a data-short-name="FASILITAS SLOT" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">FASILITAS SLOT</a>
                    </li>

                    <li class="home_and_garden header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a data-short-name="PERMAINAN SLOT" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">PERMAINAN SLOT</a>

                    </li>

                    <li class="health_and_beauty header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a data-short-name="GAME DIGITAL" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">GAME DIGITAL</a>
                    </li>

                    <li class="collectibles header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a data-short-name="PLATFORM GAME" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">PLATFORM GAME</a>
                    </li>

                    <li class="handbags header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a class="link_to_search" href="%%ORIGIN_SLASH%%"
                            data-asw-org-font-size="13" style="font-size: 13px;">PUSAT HIBURAN DARING</a>
                    </li>

                    <li class="jewelry header_top_level_menu_item has_children" data-asw-org-font-size="13"
                        style="font-size: 13px; display: list-item;">
                        <a href="%%ORIGIN_SLASH%%" data-asw-org-font-size="13"
                            style="font-size: 13px;">AKSES %%SITE%%</a>
                    </li>



                    <div class="header_subnav_menu single_column">
                        <div class="col">
                            <div class="section">
                                <ul class="header_secondary_level_menu">
                                    <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                        style="font-size: 14px;">
                                        <a href="%%ORIGIN_SLASH%%" data-asw-org-font-size="14" rel="nofollow"
                                            style="font-size: 14px;">Hand-Picked Lists</a>
                                    </li>
                                    <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                        style="font-size: 14px;">
                                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                            style="font-size: 14px;">Curated Guides</a>
                                    </li>
                                    <li class="header_secondary_level_menu_item" data-asw-org-font-size="14" 
                                        style="font-size: 14px;">
                                        <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                            data-asw-org-font-size="14" style="font-size: 14px;">New Items</a>
                                    </li>
                                    <li class="header_secondary_level_menu_item" data-asw-org-font-size="14"
                                        style="font-size: 14px;">
                                        <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                            data-asw-org-font-size="14" style="font-size: 14px;">Freebies</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    </li>
                </ul>
            </div>
        </div>


    </div>

    <div id="site_wrapper" class="with_responsive_header">
        <div id="responsive_header" class="desktop_version">
            <div class="responsive_header_top_bar" style="">
                <div class="responsive_header_main_content">
                    <div class="responsive_header_menu_and_logo_container">
                        <span class="responsive_header_menu_button" data-asw-org-font-size="18"
                            style="font-size: 18px;"></span>
                        <span class="responsive_header_menu_button close_button is_hidden" data-asw-org-font-size="18"
                            style="font-size: 18px;"></span>

                        <a title="%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern"
                         data-asw-org-font-size="14" style="font-size: 14px;"><img
                                class="link_to_home" data-retina="true"
                                src="%%LOGO%%"></a>
                    </div>

                    <div class="responsive_header_links_container">
                        <a class="responsive_header_link search" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="20"
                            style="font-size: 20px;"><img alt="Search" width="1" height="1"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>

                        <a class="responsive_header_link log_in" href="%%CTA_LOGIN%%" rel="nofollow"
                            data-asw-org-font-size="14" style="font-size: 14px;">Log in</a>
                    </div>
                </div>

                <div class="responsive_header_search_form_container is_hidden">

                    <form class="responsive_header_search_form" action="%%DISABLED_ENDPOINT%%"
                        accept-charset="UTF-8" method="get"><input name="utf8" type="hidden" value="✓"> <input
                            type="hidden" name="q[filter_category_id]">
                        <input value="true" type="hidden" name="q[translate_term]">
                        <input value="0" type="hidden" name="q[shipping_in_price]">
                        <input type="hidden" name="q[catalog_id]">
                        <input type="hidden" name="q[in_booth_id]">
                        <input value="relevancy" type="hidden" name="q[sort_by]">

                        <img class="search_form_icon"
                            src="https://assets.bonanza.com/images/mobile/search_icon_blue.png" alt="Search icon blue">
                        <input class="search_term ui-autocomplete-input" autocomplete="off"
                            aria-label="Search the site for items" type="text" name="q[search_term]" role="textbox"
                            aria-autocomplete="list" aria-haspopup="true">
                        <a class="search_form_clear_button" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                            style="font-size: 14px;"><img alt="Close search form" width="1" height="1"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="><i
                                class="fa fa-close inline_icon"></i></a>
                        <button name="button" type="submit">Go</button>
                        <a class="search_form_close_button" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                            style="font-size: 14px;">Close</a>
                    </form>
                </div>


            </div>

        </div>

        <div class="responsive_header_top_menu desktop_version">
            <div class="responsive_header_top_menu_section featured_categories">
                <div class="menu_section_header">
                    <h5 data-asw-org-font-size="14" style="font-size: 14px;">Shop by Category</h5>
                </div>

                <div class="menu_section_content">

                    <div class="menu_section_expandable_link" data-category-name="womens_fashion">
                        <a href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Women's Fashion</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Clothing</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Shoes</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Accessories</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Vintage</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Formal &amp; Wedding</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">DEALS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Under $100</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Under $50</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">TOP BRANDS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Anthropologie</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Ann Taylor</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Banana Republic</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Calvin Klein</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Gap</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">J. Crew</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Lululemon</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Michael Kors</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Nike</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Ralph Lauren</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="mens_fashion">
                        <a href="%%ORIGIN_SLASH%%"rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Men's Fashion</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Clothing</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Shoes</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Accessories</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Vintage</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Formal &amp; Wedding</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">DEALS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Under $100</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Under $50</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">TOP BRANDS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">American Eagle</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Banana Republic</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Brooks Brothers</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Calvin Klein</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Gap</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">J. Crew</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Levi's</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Nike</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Ralph Lauren</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="home_and_garden">
                        <a href="%%ORIGIN_SLASH%%"rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Home &amp;
                            Garden</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Bath</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Bedding</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Furniture</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Home Decor</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Home Improvement</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Kitchen &amp; Dining</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Lamps &amp; Ceiling
                                        Fans</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Yard, Garden &amp;
                                        Outdoor</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">TOP BRANDS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Craftsman</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Cuisinart</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">DeWalt</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Dyson</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Keurig</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">KitchenAid</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow" 
                                        data-asw-org-font-size="14" style="font-size: 14px;">Kohler</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Lenox</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="health_and_beauty">
                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Health &amp;
                            Beauty</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Bath &amp; Body</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Dietary Supplements</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Fragrances</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Hair Care</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Health Care</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Makeup</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Nail Care</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Skin Care</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Vision Care</a>
                                </li>
                            </ul>
                        </div>
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">TOP BRANDS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Avon</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Clinique</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Dove</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Estee Lauder</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Lancôme</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">L’Oreal</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Maybelline</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Neutrogena</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Olay</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="collectibles">
                        <a href="%%ORIGIN_SLASH%%"  rel="nofollow"data-asw-org-font-size="14" style="font-size: 14px;">Collectibles &amp;
                            Art</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Art</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow"data-asw-org-font-size="14"
                                        style="font-size: 14px;">Collectibles</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Antiques</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Crafts</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%"  rel="nofollow"data-asw-org-font-size="14"
                                        style="font-size: 14px;">Coins &amp; Paper Money</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Entertainment Memorabilia</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Pottery &amp; Glass</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Sports Memorabilia</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Stamps</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="handbags">
                        <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                            data-asw-org-font-size="14" style="font-size: 14px;">Handbags</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">TOP BRANDS</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Ann Taylor</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Coach</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Fossil</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Kate Spade</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Louis Vuitton</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Michael Kors</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Vera Bradley</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="jewelry">
                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Jewelry</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Fashion Jewelry</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Fine Jewelry</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Handcrafted Jewelry</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Vintage Jewelry</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Wedding Jewelry</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Watches</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="menu_section_expandable_link" data-category-name="coupons">
                        <a class="link_to_search" href="%%ORIGIN_SLASH%%"  rel="nofollow"data-asw-org-font-size="14"
                            style="font-size: 14px;">Coupons</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">

                    </div>
                    <div class="menu_section_expandable_link" data-category-name="more_categories">
                        <a class="link_to_search" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                            style="font-size: 14px;">More Categories</a>

                        <div class="expansion_toggle_container">
                            <div class="expansion_toggle closed"><i class="fa fa-angle-right inline_icon"></i></div>
                            <div class="expansion_toggle open"><i class="fa fa-angle-down inline_icon"></i></div>
                        </div>
                    </div>

                    <div class="menu_section_expandable_submenu">
                        <div class="expandable_submenu_section">
                            <h5 data-asw-org-font-size="14" style="font-size: 14px;">CATEGORIES</h5>
                            <ul class="expandable_submenu_list">
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Baby</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Books</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Business &amp;
                                        Industrial</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;"><span
                                            class="translation_missing"
                                            title="translation missing: en.header.shopping.more_categories.cameras_and_photos"
                                            data-asw-org-font-size="14" style="font-size: 14px;">Cameras And
                                            Photos</span></a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Cell Phones &amp;
                                        Accessories</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Computers &amp; Tablets</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Consumer Electronics</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Digital Goods</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Dolls &amp; Bears</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Movies
                                        &amp; TV</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Everything Else</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Music</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Musical Instruments &amp;
                                        Gear</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Parts &amp; Accessories</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Pet Supplies</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Specialty Services</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                                        style="font-size: 14px;">Sporting Goods</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Tickets &amp;
                                        Experiences</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14" style="font-size: 14px;">Toys
                                        &amp; Hobbies</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%" rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Travel</a>
                                </li>
                                <li class="expandable_submenu_list_item" data-asw-org-font-size="14"
                                    style="font-size: 14px;">
                                    <a class="link_to_search"
                                        href="%%ORIGIN_SLASH%%"rel="nofollow"
                                        data-asw-org-font-size="14" style="font-size: 14px;">Video Games &amp;
                                        Consoles</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="responsive_header_top_menu_section featured_ways_to_shop">
                <div class="menu_section_header">
                    <h5 data-asw-org-font-size="14" style="font-size: 14px;">More Ways to Shop</h5>
                </div>

                <div class="menu_section_content">
                    <ul>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Hand-Picked Lists</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Curated Guides</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a class="link_to_search"
                                href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">New Items</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a class="link_to_search"
                                href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Freebies</a></li>
                    </ul>
                </div>
            </div>

            <div class="responsive_header_top_menu_section account_actions">
                <div class="menu_section_header">
                    <h5 data-asw-org-font-size="14" style="font-size: 14px;">Your Account</h5>
                </div>

                <div class="menu_section_content">
                    <ul>

                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Cart (0)</a></li>

                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Log In/Sign Up</a></li>
                    </ul>
                </div>
            </div>


            <div class="responsive_header_top_menu_section more_actions">
                <div class="menu_section_header">
                    <h5 data-asw-org-font-size="14" style="font-size: 14px;">More</h5>
                </div>

                <div class="menu_section_content">
                    <ul>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Start Selling Online</a></li>

                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a
                                href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="14"
                                style="font-size: 14px;">Help Center</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a
                                href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="14"
                                style="font-size: 14px;">Contact Support</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow" 
                                data-asw-org-font-size="14" style="font-size: 14px;">About %%SITE%%</a></li>
                        <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                                data-asw-org-font-size="14" style="font-size: 14px;">Blog</a></li>
                    </ul>
                </div>
            </div>
        </div>




        <div id="main_wrapper" class="">

            <div id="content" class="clearfix">







                <div class="item_listing_content_wrapper lang_id locale_id_us">
<div class="item_listing_body" itemscope="" itemtype="http://schema.org/Product">
                        <div class="item_listing_main">
                            <div class="item_listing_images r138-clean-hero-media">
                                <div class="r138-clean-banner">
                                    <a href="%%ORIGIN_SLASH%%" aria-label="%%SITE%%">
                                        <img itemprop="image"
                                            src="%%IMAGE%%"
                                            alt="%%SITE%% FASILITAS SLOT"
                                            loading="eager"
                                            decoding="async">
                                    </a>
                                </div>
                            </div>

                            <div class="item_listing_basic_info">

                                <div class="item_listing_title_and_price">
                                    <div class="item_listing_flags">
                                        <div class="item_listing_flag free_shipping">
                                            <div class="flag_text_container">%%SITE%%</div>
                                        </div>

                                        <div class="item_listing_flag recent_views">
                                            <div class="flag_text_container">%%SITE%% PLATFORM GAME</div>
                                        </div>
                                        <div class="item_listing_flag recent_views">
                                            <div class="flag_text_container">%%SITE%% PUSAT HIBURAN DARING</div>
                                        </div>

                                    </div>

                                    <h1 lang="en" data-asw-org-font-size="24" style="font-size: 24px;">
                                        <span itemprop="name" data-asw-org-font-size="24"
                                            style="font-size: 24px;">%%H1%%</span>

                                        <meta itemprop="category" content="Apparel &amp; Accessories &gt;&gt; Clothing">
                                    </h1>





                                    <div class="item_status_and_price_container">
                                        <div class="item_status_and_price_content" itemprop="offers"
                                            itemtype="https://schema.org/Offer" itemscope="">


                                            <div class="item_price">
                                                IDR 10.000
                                            </div>

                                            <div style="font-size: 14px; color: #777">
                                           Sebagai representasi pembangunan fasilitas slot terkemuka di Indonesia pada 2026, %%SITE%% menghadirkan pusat hiburan daring terlengkap. Sistem keamanan modern dan lisensi terverifikasi memastikan lingkungan bermain yang kredibel.
                                            </div>


                                            <link itemprop="url" href="%%ORIGIN_SLASH%%">
                                            <meta itemprop="itemCondition" content="http://schema.org/NewCondition">
                                            <meta itemprop="availability" content="https://schema.org/InStock">
                                            <meta itemprop="price" content="10000">
                                            <meta itemprop="priceCurrency" content="IDR">
                                            <div itemprop="shippingDetails"
                                                itemtype="https://schema.org/OfferShippingDetails" itemscope="">
                                                <div itemprop="shippingRate"
                                                    itemtype="https://schema.org/MonetaryAmount" itemscope="">
                                                    <meta itemprop="value" content="0.0">
                                                    <meta itemprop="currency" content="USD">
                                                </div>
                                                <div itemprop="shippingDestination"
                                                    itemtype="https://schema.org/DefinedRegion" itemscope="">
                                                    <meta itemprop="addressCountry" content="US">
                                                </div>
                                                <div itemprop="deliveryTime"
                                                    itemtype="https://schema.org/ShippingDeliveryTime" itemscope="">
                                                    <div itemprop="handlingTime"
                                                        itemtype="https://schema.org/QuantitativeValue" itemscope="">
                                                        <meta itemprop="maxValue" content="3">
                                                    </div>
                                                </div>
                                            </div>


                                            <br>

                                            <div class="item-preview__actions royal-actions v2">
                                                <div class="cta-royal">
                                                    <!-- Border emas berkilau -->
                                                    <div class="gilded-frame" aria-hidden="true"></div>

                                                    <!-- lapisan animasi kelopak mawar -->
                                                    <div class="petals" aria-hidden="true">
                                                        <!-- tambah/kurangi span untuk intensitas -->
                                                        <span data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14" style="font-size: 14px;"></span>
                                                        <span data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14" style="font-size: 14px;"></span>
                                                        <span data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14"
                                                            style="font-size: 14px;"></span><span
                                                            data-asw-org-font-size="14" style="font-size: 14px;"></span>
                                                    </div>

                                                    <!-- CTA buttons -->
                                                    <div class="cta-buttons">
                                                        <a href="%%ORIGIN_SLASH%%" 
                                                            rel="nofollow noreferrer" class="btn-cta btn-login"
                                                            title="Masuk akun" data-asw-org-font-size="14"
                                                            style="font-size: 14px;">LOGIN</a>
                                                        <a href="%%ORIGIN_SLASH%%"
                                                            rel="nofollow noreferrer" class="btn-cta btn-daftar"
                                                            title="Daftar sekarang" data-asw-org-font-size="14"
                                                            style="font-size: 14px;">DAFTAR</a>
                                                    </div>

                                                </div>

                                            </div>
                                            <div class="meta-attributes js-meta-attributes"
                                                data-view="CondenseItemInfoPanel">

                                                <style>
                                                    .tplbrand-header {
                                                        text-align: center;
                                                        font-size: 22px;
                                                        font-weight: 1000;
                                                        margin-bottom: 15px;
                                                        padding: 18px 20px;
                                                        border-radius: 14px;
                                                        background: linear-gradient(145deg, #173c37, #101312);
                                                        box-shadow: 0 0 25px rgba(130, 199, 43, 0.12);
                                                        letter-spacing: .5px;
                                                        -webkit-background-clip: text;
                                                        -webkit-text-fill-color: transparent;
                                                    }

                                                    .tplbrand-desc {
                                                        text-align: center;
                                                        max-width: 800px;
                                                        margin: 0 auto 25px;
                                                        padding: 20px 25px;
                                                        border-radius: 14px;
                                                        border: 2px solid #82c72b;
                                                        background: linear-gradient(145deg, #173c37, #173c37);
                                                        box-shadow: 0 0 20px rgba(130, 199, 43, 0.08);
                                                        color: #e8e8e8;
                                                        line-height: 1.7;
                                                        font-size: 15px;
                                                    }

                                                    .gold-text {
                                                        color: #55d2c5;
                                                        font-weight: 600;
                                                    }

                                                    .glow-text {
                                                        color: #82c72b;
                                                        font-weight: 600;
                                                        text-shadow: 0 0 6px rgba(130, 199, 43, 0.6);
                                                    }

                                                    .tplbrand-table {
                                                        width: 100%;
                                                        border-collapse: collapse;
                                                        font-family: "Poppins", sans-serif;
                                                        font-size: 15px;
                                                        color: #f5f5f5;
                                                        background: linear-gradient(145deg, #14201d, #101312);
                                                        border: 1px solid rgba(130, 199, 43, 0.25);
                                                        box-shadow: 0 0 25px rgba(130, 199, 43, 0.08);
                                                        border-radius: 12px;
                                                        overflow: hidden;
                                                    }

                                                    .tplbrand-table th {
                                                        background: linear-gradient(90deg, #173c37, #527a22, #82c72b);
                                                        color: #FFF;
                                                        text-transform: uppercase;
                                                        font-weight: 700;
                                                        padding: 14px;
                                                        letter-spacing: .5px;
                                                    }

                                                    .tplbrand-table td {
                                                        padding: 12px 14px;
                                                        border-bottom: 1px solid rgba(130, 199, 43, 0.15);
                                                        vertical-align: top;
                                                        border: 2px solid #82c72b;
                                                    }

                                                    .tplbrand-table tr:nth-child(even) {
                                                        background: rgba(255, 255, 255, 0.03);
                                                    }

                                                    .tplbrand-table tr:hover {
                                                        background-color: #4fd5c9;
                                                        opacity: 25%;
                                                        transition: .3s ease;
                                                    }

                                                    .tplbrand-header {
                                                        text-align: center;
                                                        font-size: 22px;
                                                        font-weight: 1000;
                                                        margin-bottom: 12px;
                                                        background: linear-gradient(90deg, #173c37, #173c37);
                                                        -webkit-background-clip: text;
                                                        -webkit-text-fill-color: transparent;
                                                    }

                                                    .tplbrand-desc {
                                                        text-align: center;
                                                        max-width: 800px;
                                                        margin: 0 auto 20px;
                                                        color: rgb(209, 209, 209);
                                                        line-height: 1.6;
                                                    }
                                                </style>

                                                <div class="tplbrand-header">
                                                    Informasi Fasilitas %%SITE%%
                                                </div>

                                                <div class="tplbrand-desc"><div class="dynamic-content">%%CONTENT%%</div>
                                                </div>

                                                <table class="tplbrand-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Informasi</th>
                                                            <th>Detail Fasilitas %%SITE%%</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Fasilitas Unggulan</td>
                                                            <td>Pusat Hiburan Daring Terlengkap</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Fokus Platform</td>
                                                            <td>Pembangunan Fasilitas Slot</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Sistem Keamanan</td>
                                                            <td>Sistem Keamanan Modern</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Status Lisensi</td>
                                                            <td>Lisensi Terverifikasi</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Akses Perangkat</td>
                                                            <td>Komputer dan Perangkat Seluler</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Keunggulan Utama</td>
                                                            <td>Lingkungan Kredibel dan Terorganisir</td>
                                                        </tr>
                                                    </tbody>
                                                </table>

                                            </div>

                                        </div>


                                    </div>

                                </div>

                            </div>



                            <style>
                                .item_listing_item_description,
                                .item_description_inner,
                                .plain_text_description_container,
                                .plain_text_description {
                                    display: block !important;
                                    visibility: visible !important;
                                    opacity: 1 !important;
                                    height: auto !important;
                                    max-height: none !important;
                                    overflow: visible !important;
                                }

                                .item_listing_item_description {
                                    position: relative;
                                    padding: 20px;
                                }

                                .item_description_inner {
                                    position: relative;
                                    background: #173c37;
                                    padding: 25px;
                                    border-radius: 12px;
                                    overflow: hidden;
                                    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
                                }

                                /* Overlay gradient */
                                .item_description_inner::before {
                                    content: "";
                                    position: absolute;
                                    inset: 0;
                                    background: linear-gradient(135deg,
                                            rgba(41, 183, 174, 0.15),
                                            rgba(79, 213, 201, 0.15));
                                    pointer-events: none;
                                    border-radius: 12px;
                                }

                                /* Text styling */
                                .plain_text_description {
                                    position: relative;
                                    color: #f5f5f5;
                                    font-size: 16px;
                                    line-height: 1.7;
                                    z-index: 2;
                                }

                                /* Toggle link styling */
                                .description_toggle_link {
                                    display: inline-block;
                                    margin-top: 15px;
                                    color: #82c72b;
                                    font-weight: 600;
                                    text-decoration: none;
                                    transition: 0.3s ease;
                                }

                                .description_toggle_link:hover {
                                    color: #82c72b;
                                }

                                .plain_text_description {
                                    position: relative;
                                    color: #f5f5f5;
                                    font-size: 16px;
                                    line-height: 1.7;
                                    z-index: 2;
                                    text-align: justify;
                                }
                            </style>

                            <div class="item_listing_item_description">

                                <div class="item_description_inner" style="min-height: 0px;">
                                    <div class="loading_overlay" style="display: none;"><i
                                            class="fa fa-spinner inline_icon fa-pulse fa-4x"></i></div>


                                    <div class="plain_text_description_container">
                                        <div class="plain_text_description"><p>%%SITE%% menjadi representasi nyata dari <strong>pembangunan fasilitas slot terkemuka</strong> di Indonesia pada tahun 2026 yang terus berubah mengikuti perkembangan teknologi dan kebiasaan pengguna masa kini. Kehadiran pusat hiburan daring terlengkap ini tidak hanya berkaitan dengan semakin beragamnya permainan yang tersedia tetapi juga menunjukkan bagaimana permainan berbasis online berkembang menjadi lebih praktis untuk dijelajahi melalui berbagai perangkat. Dalam ekosistem <a href="%%ORIGIN_SLASH%%">%%SITE%%</a> perkembangan tersebut mempertemukan identitas fasilitas kelas atas dengan ragam permainan dan pengalaman digital dalam satu lingkungan yang semakin terorganisir. Perubahan teknologi dari waktu ke waktu turut membuat cara pengguna mengenal dan menjelajahi permainan ikut berkembang pesat sehingga %%SITE%% dapat dipahami sebagai bagian utama dari pertumbuhan ekosistem permainan digital tanpa mengubah identitas utama merek.</p>
                                        </div>
                                        <div class="description_toggle_links_container">
                                            <a class="description_toggle_link" data-alt-text="Collapse" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                                data-asw-org-font-size="16" style="font-size: 16px;">See full
                                                description</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <style>
                    /* ===== RESET ===== */
                    * {
                        box-sizing: border-box;
                    }

                    /* ===== WRAPPER ===== */
                    .tplbrand-FAQ-section {
                        max-width: 1200px;
                        margin: 60px auto;
                        padding: 60px 55px;
                        border-radius: 22px;
                        background: linear-gradient(180deg, #173c37, #82c72b);
                        border: 4px solid #82c72b;
                        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.85);
                        font-family: "Poppins", sans-serif;
                        color: #eaeaea;
                        position: relative;
                        overflow: hidden;
                    }

                    /* ===== TITLE ===== */
                    .tplbrand-FAQ-section h2 {
                        text-align: center;
                        font-size: 34px;
                        font-weight: 700;
                        margin-bottom: 35px;
                        letter-spacing: 1px;
                        color: #82c72b;
                        text-shadow: 0 0 12px rgba(130, 199, 43, 0.35);
                    }

                    /* ===== FAQ ===== */
                    .tplbrand-FAQ-faq {
                        max-width: 980px;
                        margin: 0 auto 60px;
                    }

                    .tplbrand-FAQ-section details {
                        background: linear-gradient(145deg, #111, #0a0a0a);
                        border-radius: 14px;
                        margin-bottom: 18px;
                        padding: 20px 26px;
                        border: 1px solid #82c72b;
                        transition: all 0.35s ease;
                    }

                    .tplbrand-FAQ-section details[open] {
                        transform: translateY(-3px);
                        box-shadow: 0 18px 40px rgba(130, 199, 43, 0.15);
                    }


                    .tplbrand-FAQ-section summary {
                        cursor: pointer;
                        font-size: 18px;
                        font-weight: 600;
                        color: #b9b9b9;
                    }

                    .tplbrand-FAQ-section summary::-webkit-details-marker {
                        display: none;
                    }

                    .tplbrand-FAQ-section details p {
                        margin-top: 14px;
                        font-size: 15.8px;
                        line-height: 1.75;
                        color: #d6d6d6;
                    }

                    /* ===== TESTIMONI GRID ===== */
                    .testimoni-wrapper {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 28px;
                        margin-top: 45px;
                    }

                    /* ===== TESTIMONI CARD ===== */
                    .tplbrand-FAQ-section blockquote {
                        background: linear-gradient(160deg, #111, #0a0a0a);
                        border-radius: 18px;
                        padding: 28px 30px 26px;
                        min-height: 170px;
                        position: relative;
                        border: 1px solid #82c72b;
                        box-shadow: 0 15px 45px rgba(0, 0, 0, 0.7);
                        transition: all 0.35s ease;
                    }


                    .tplbrand-FAQ-section blockquote:hover {
                        transform: translateY(-5px);
                        box-shadow: 0 28px 65px #82c72b;
                    }


                    /* QUOTE ICON */
                    .tplbrand-FAQ-section blockquote::before {
                        content: "❝";
                        font-size: 64px;
                        color: #82c72b;
                        position: absolute;
                        top: 8px;
                        left: 18px;
                        font-family: serif;
                        opacity: 40%;
                    }


                    /* TEXT */
                    .tplbrand-FAQ-section blockquote {
                        color: #e1e1e1;
                        font-size: 15.8px;
                        line-height: 1.7;
                    }

                    /* AUTHOR */
                    .tplbrand-FAQ-section cite {
                        display: block;
                        margin-top: 20px;
                        font-weight: 600;
                        font-size: 14px;
                        background: linear-gradient(90deg, #a77a58, #82c72b);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        text-align: right;
                    }

                    /* ===== BRAND FOOTER ===== */
                    .seller-name__detail {
                        margin-top: 55px;
                        text-align: center;
                        grid-column: span 2;
                    }


                    .seller-name__detail a {
                        color: #82c72b;
                        font-weight: 700;
                        font-size: 1.15em;
                        text-decoration: none;
                        letter-spacing: 1px;
                        padding: 12px 28px;
                        border-radius: 30px;
                        border: 2px solid #82c72b;
                        background: linear-gradient(145deg, #4fd5c9, #9cce55);
                        box-shadow: 0 0 25px rgba(130, 199, 43, 0.25);
                        transition: all 0.35s ease;
                    }

                    .seller-name__detail a:hover {
                        background: linear-gradient(145deg, #82c72b, #82c72b);
                        color: #FFF;
                        box-shadow: 0 0 40px #82c72b;
                    }

                    /* ===== AMBIENT GLOW ===== */
                    .tplbrand-FAQ-section::after {
                        content: "";
                        position: absolute;
                        inset: -2px;
                        border-radius: 26px;
                        background: linear-gradient(120deg, transparent, rgba(0, 0, 0, 0.274), transparent);
                        opacity: 0.8;
                        pointer-events: none;
                    }
                </style>




                <div class="tplbrand-FAQ-section">

                    <h2 data-asw-org-font-size="36" style="font-size: 36px;">PERTANYAAN SEPUTAR %%SITE%%</h2>
                    <div class="tplbrand-FAQ-faq" id="faq-container"></div>

                    <h2>ULASAN MEMBER %%SITE%%</h2>
                    <div class="testimoni-wrapper" id="review-container"></div>

                    <div class="seller-name__detail" data-spm="seller">
                        <a href="%%ORIGIN_SLASH%%" target="_self" data-asw-org-font-size="16"
                            style="font-size: 16px;">%%SITE%%</a>
                    </div>

                </div>
            </div>

            <div id="email_form" class="new_email_form_container popup_container ask_seller_a_question_popup jqm-init">
                <a class="popup_close_control" href="%%ORIGIN_SLASH%%" rel="nofollow" onclick="BONZ.Application.hideAllPopups();; return false;"
                    onkeypress="BONZ.Application.hideAllPopups();; return false;" data-asw-org-font-size="14"
                    style="font-size: 14px;"><img alt="Close popup" width="1" height="1"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>




                <div class="new_email_form ask_seller_a_question_form">
                    <div class="email_explanation explanation_message small_message" style="display: none;"></div>
                    <div class="loading"><i class="fa fa-spinner inline_icon fa-pulse fa-3x"></i></div>

                    <form class="new_email" action="%%DISABLED_ENDPOINT%%" accept-charset="UTF-8" method="post"><input name="utf8"
                            type="hidden" value="✓"><input type="hidden" name="authenticity_token"
                            value="PQ1ZtDhzXNMBK799ADp60PxTmv4VLfv7w73I4pFc0Ubwa3k1H/dZ17RQebpwwWV0XbCYoKQq2wpjzGQyvaxpFg==">
                        <fieldset class="email_form_fieldset">
                            <legend class="email_title">Contact the seller about this item</legend>
                            <input
                                value="Somebody emailed you about your &quot;%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern&quot;!"
                                type="hidden" name="email[subject]">
                            <input value="60278281" type="hidden" name="email[receiver_id]">
                            <input value="20260228861303" type="hidden" name="email[item_id]">

                            <textarea rows="10" placeholder="Write your message here"
                                aria-label="Write your message here" name="email[body]"></textarea>

                            <div class="togglable">
                                <ul class="emoji_picker">
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😃
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😀
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😆
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😍
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😉
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😛
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😞
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😮
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😎
                                    </li>
                                    <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😇
                                    </li>
                                    <li class="emoji_button bonus" data-asw-org-font-size="24" style="font-size: 24px;">
                                        😺</li>
                                </ul>
                            </div>


                            <div class="submit_container">
                                <input type="hidden" name="email_source" value="7">
                                <input type="submit" name="commit" value="Send Your Message" class="email_send_button"
                                    data-disable-with="Send Your Message">

                                <a class="email_cancel_button" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                    data-asw-org-font-size="13" style="font-size: 13px;">Cancel</a>
                            </div>
                        </fieldset>
                    </form>
                </div>

            </div>


            <div id="add_to_wishlist_popup" class="popup_container new_email_form_container jqm-init">
                <a class="popup_close_control" href="%%ORIGIN_SLASH%%"  rel="nofollow"onclick="$('#add_to_wishlist_popup').jqmHide();; return false;"
                    onkeypress="$('#add_to_wishlist_popup').jqmHide();; return false;" data-asw-org-font-size="14"
                    style="font-size: 14px;"><img alt="Close popup" width="1" height="1"
                        src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>
                <h2 class="add_to_wishlist_popup_header" data-asw-org-font-size="24" style="font-size: 24px;"><i
                        class="fa fa-star inline_icon"></i><span class="inline_icon_text" data-asw-org-font-size="24"
                        style="font-size: 24px;">Added to your <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="24"
                            style="font-size: 24px;">wish
                            list</a>!</span></h2>

                <div class="email_container">

                    <div class="item">
                        <div class="item_image_container">
                            <img title="" class="item_image"
                                onerror="BONZ.handleBrokenImage(this, 20260228861303, '%%LOGO%%')"
                                alt="GAME DIGITAL"
                                src="%%LOGO%%">
                        </div>

                        <ul class="item_info_list">
                            <li class="title" data-asw-org-font-size="14" style="font-size: 14px;"><a
                                    href="%%ORIGIN_SLASH%%" data-asw-org-font-size="14"
                                    style="font-size: 14px;">%%SITE%%: Penyedia Game Online Terlengkap Dan Paling
                                    Diminati Para Pecinta Game Online</a></li>

                            <li data-asw-org-font-size="14" style="font-size: 14px;">68 in stock</li>

                            <li data-asw-org-font-size="14" style="font-size: 14px;">Available in multiple sizes
                            </li>



                            <li data-asw-org-font-size="14" style="font-size: 14px;">
                                Handling time 3 days.
                            </li>

                            <li data-asw-org-font-size="14" style="font-size: 14px;">Returns/refunds accepted</li>

                            <li class="item_action_buttons" data-asw-org-font-size="14" style="font-size: 14px;">
                                <a class="button_medium" href="%%ORIGIN_SLASH%%" rel="nofollow"
                                    data-asw-org-font-size="13" style="font-size: 13px;">Add to cart</a>
                            </li>
                        </ul>
                    </div>


                    <div class="new_email_form ask_seller_a_question_form">
                        <div class="email_explanation explanation_message small_message" style="display: none;">
                        </div>
                        <div class="loading"><i class="fa fa-spinner inline_icon fa-pulse fa-3x"></i></div>

                        <form class="new_email" action="%%DISABLED_ENDPOINT%%" accept-charset="UTF-8" method="post"><input name="utf8"
                                type="hidden" value="✓"><input type="hidden" name="authenticity_token"
                                value="PQ1ZtDhzXNMBK799ADp60PxTmv4VLfv7w73I4pFc0Ubwa3k1H/dZ17RQebpwwWV0XbCYoKQq2wpjzGQyvaxpFg==">
                            <fieldset class="email_form_fieldset">
                                <legend class="email_title">Contact the seller</legend>
                                <input
                                    value="Somebody emailed you about your &quot;%%SITE%%: Perkembangan Permainan FASILITAS SLOT dalam Ekosistem Digital Modern&quot;!"
                                    type="hidden" name="email[subject]">
                                <input value="60278281" type="hidden" name="email[receiver_id]">
                                <input value="20260228861303" type="hidden" name="email[item_id]">

                                <textarea rows="10" placeholder="Write your message here"
                                    aria-label="Write your message here" name="email[body]"></textarea>

                                <div class="togglable">
                                    <ul class="emoji_picker">
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😃
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😀
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😆
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😍
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😉
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😛
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😞
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😮
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😎
                                        </li>
                                        <li class="emoji_button" data-asw-org-font-size="24" style="font-size: 24px;">😇
                                        </li>
                                        <li class="emoji_button bonus" data-asw-org-font-size="24"
                                            style="font-size: 24px;">😺</li>
                                    </ul>
                                </div>


                                <div class="submit_container">
                                    <input type="hidden" name="email_source" value="7">
                                    <input type="submit" name="commit" value="Send Your Message"
                                        class="email_send_button" data-disable-with="Send Your Message">

                                </div>
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>




            <div class="remind_me_later_form responsive_popup_container jqm-init">
                <div class="popup_inner">
                    <a class="popup_close_control"  data-asw-org-font-size="14"
                        style="font-size: 14px;"><img alt="Close popup" width="1" height="1"
                            src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>
                    <h2 data-asw-org-font-size="24" style="font-size: 24px;">Get an item reminder</h2>
                    <p class="reminder_explanation" data-asw-org-font-size="14" style="font-size: 14px;">
                        We'll email you a link to your item now and follow up with a single reminder (if you'd like
                        one).
                        That's it! No spam, no hassle.
                    </p>

                    <form action="%%DISABLED_ENDPOINT%%" accept-charset="UTF-8" method="post">
                        <input name="utf8" type="hidden" value="✓"><input type="hidden" name="authenticity_token"
                            value="PQ1ZtDhzXNMBK799ADp60PxTmv4VLfv7w73I4pFc0Ubwa3k1H/dZ17RQebpwwWV0XbCYoKQq2wpjzGQyvaxpFg==">
                        <label for="remind_me_later_email_address">Your email address:</label>
                        <input class="validate[required,custom[email]] email_input" type="email"
                            name="remind_me_later[email_address]" id="remind_me_later_email_address">

                        <div class="reminder_delay_options">
                            <fieldset>
                                <legend>When would you like a reminder?</legend>

                                <input type="radio" value="1" name="remind_me_later[delay_interval]"
                                    id="remind_me_later_delay_interval_1">
                                <label for="remind_me_later_delay_interval_1">1 day</label>

                                <input type="radio" value="3" checked="checked" name="remind_me_later[delay_interval]"
                                    id="remind_me_later_delay_interval_3">
                                <label for="remind_me_later_delay_interval_3">3 days</label>

                                <input type="radio" value="7" name="remind_me_later[delay_interval]"
                                    id="remind_me_later_delay_interval_7">
                                <label for="remind_me_later_delay_interval_7">7 days</label>

                                <input type="radio" value="0" name="remind_me_later[delay_interval]"
                                    id="remind_me_later_delay_interval_0">
                                <label for="remind_me_later_delay_interval_0">never</label>
                            </fieldset>
                        </div>

                        <div class="reminder_email_confirm hidden">
                            <em id="reminder_email_confirm_label">Please make sure your email address is correct so
                                we can get in touch with you.</em>
                            <input type="text" disabled="disabled" class="email_confirm_display"
                                aria-labelledby="reminder_email_confirm_label">
                        </div>
                        <button name="button" type="submit" class="reminder_submit">Create your item
                            reminder</button>
                    </form>
                    <div class="reminder_sign_in">
                        Already have an account?
                        <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                            style="font-size: 14px;">Log in and add this item to your wish list.</a>
                    </div>
                </div>
            </div>






        </div> <!-- B0 K4NG TH4O -->
        <!-- centerJustifiedDiv -->
    </div> <!-- main_wrapper -->
    </div> <!-- site_wrapper -->

    <!-- footer -->
    <div id="footer">

        <div class="footer_links">
            <div class="wrapper">
                <div class="footer_links_container">
                    <ul class="footer_links_menu">
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">About</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                target="_blank" href="%%ORIGIN_SLASH%%"rel="nofollow"
                                data-asw-org-font-size="13" style="font-size: 13px;">Affiliates</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">API</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Selling
                                Blog</a> / <a href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Shopping Blog</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Contact</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%"  rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Help</a></li>
                        <!--        <li class="footer_links_menu_item"></li>-->
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Legal</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Partners</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Press</a></li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">Webstores</a>
                        </li>
                        <li class="footer_links_menu_item" data-asw-org-font-size="13" style="font-size: 13px;"><a
                                target="_blank" href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="13"
                                style="font-size: 13px;">bCapital</a></li>
                    </ul>
                </div>

                <ul class="footer_links_social_media">
                    <li class="footer_links_social_media_item" data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_social_media_icon" target="_blank"
                            onclick="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Facebook'});"
                            onkeypress="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Facebook'});"
                            href="%%ORIGIN_SLASH%%" rel="nofollow" data-asw-org-font-size="14"
                            style="font-size: 14px;"><img alt="Facebook" data-retina="true"
                                src="https://assets.bonanza.com/images/global_icons/social_media/facebook.png"></a>
                    </li>
                    <li class="footer_links_social_media_item" data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_social_media_icon" target="_blank"
                            onclick="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Twitter'});"
                            onkeypress="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Twitter'});"
                            href="%%ORIGIN_SLASH%%" rel="nofollow"data-asw-org-font-size="14"
                            style="font-size: 14px;"><img alt="Twitter" data-retina="true"
                                src="https://assets.bonanza.com/images/global_icons/social_media/twitter.png"></a>
                    </li>
                    <li class="footer_links_social_media_item" data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_social_media_icon" target="_blank"
                            onclick="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Pinterest'});"
                            onkeypress="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Pinterest'});"
                            href="%%ORIGIN_SLASH%%" rel="nofollow"data-asw-org-font-size="14"
                            style="font-size: 14px;"><img alt="Pinterest" data-retina="true"
                                src="https://assets.bonanza.com/images/global_icons/social_media/pinterest.png"></a>
                    </li>
                    <li class="footer_links_social_media_item" data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_social_media_icon" target="_blank"
                            onclick="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Instagram'});"
                            onkeypress="gtag('event', 'social_share', {action: 'Click-footer', medium: 'Instagram'});"
                            href="%%ORIGIN_SLASH%%" rel="nofollow"  data-asw-org-font-size="14"
                            style="font-size: 14px;"><img alt="Instagram" data-retina="true"
                                src="https://assets.bonanza.com/images/global_icons/social_media/instagram.png"></a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer_bottom">
            <div class="wrapper">
                <div class="utilities">

                    <a id="select_locale_link" class="locale flags-us" href="%%ORIGIN_SLASH%%" rel="nofollow"
                        data-asw-org-font-size="13" style="font-size: 13px;">
                        United States
                        / United States Dollar $
                    </a>
                    <input type="hidden" name="click_track_page" id="click_track_page" value="false">

                    <span class="accessibility_trigger" onclick="$('.asw-menu-btn').get(0).click()"
                        data-asw-org-font-size="13" style="font-size: 13px;">
                        <span class="sr-only" data-asw-org-font-size="13" style="font-size: 13px;">Click to activate
                            accessibility preferences</span><i class="fa fa-universal-access inline_icon"></i>
                        <span data-asw-org-font-size="13" style="font-size: 13px;">Accessibility preferences</span>
                    </span>

                </div>

                <ul class="trust">
                    <li data-asw-org-font-size="14" style="font-size: 14px;">
                        <div class="footer_ssl_credential"><span class="sr-only" data-asw-org-font-size="14"
                                style="font-size: 14px;">SSL Secure Connection</span></div>
                    </li>
                    <li data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_bbb_credential" title="%%SITE%%.com, Internet Shopping, Seattle, WA"
                            target="_blank"
                            href="%%ORIGIN_SLASH%%" rel="nofollow"
                            data-asw-org-font-size="14" style="font-size: 14px;"><img
                                alt="Better Business Bureau Accredited Business" width="1" height="1"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>
                    </li>
                    <li data-asw-org-font-size="14" style="font-size: 14px;">
                        <a class="footer_paypal_credential" target="_blank"
                            href="%%ORIGIN_SLASH%%" rel="nofollow"
                            data-asw-org-font-size="14" style="font-size: 14px;"><img alt="PayPal Buyer Protection"
                                width="1" height="1"
                                src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="></a>
                    </li>
                </ul>
            </div>
        </div>

        <ul class="footer_legal">
            <li data-asw-org-font-size="14" style="font-size: 14px;">© 2026 %%SITE%%. All Rights Reserved</li>
            <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                    data-asw-org-font-size="14" style="font-size: 14px;">Cookies and Tracking</a></li>
            <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                    data-asw-org-font-size="14" style="font-size: 14px;">Accessibility</a></li>
            <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                    data-asw-org-font-size="14" style="font-size: 14px;">Privacy Policy</a></li>
            <li data-asw-org-font-size="14" style="font-size: 14px;"><a href="%%ORIGIN_SLASH%%" rel="nofollow"
                    data-asw-org-font-size="14" style="font-size: 14px;">Terms of Use</a></li>
        </ul>

    </div>

    <script>
        //<![CDATA[
        jQuery(BONZ.wrap(function () {
            $("a.tooltip").tooltip({ appendElement: "body", width: 400 });

            BONZ.Application.whenDefined('ItemShow', 'BuyerReminders', function () { BONZ.ItemShow.BuyerReminders.initialize(); });
            BONZ.Application.setupPopup('#email_form', { modal: true });
            BONZ.ItemShow.initialize();
            BONZ.ItemShow.Images.initialize();
            BONZ.Application.whenDefined("Sessions", function () { BONZ.Sessions.initializeLoginSlideup(0.0); });
            BONZ.Header.initialize();
            BONZ.Application.whenDefined('Ads', 'WhatsHot', function () { BONZ.Ads.WhatsHot.initialize(); });
            BONZ.AnalyticEvents.initialize();

        }));

        //]]>
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {

            const jsonLdScripts = document.querySelectorAll('script[type="application/ld+json"]');

            let faqData = [];
            let reviewData = [];

            jsonLdScripts.forEach(script => {
                try {
                    const data = JSON.parse(script.textContent);

                    // Jika FAQPage
                    if (data["@type"] === "FAQPage" && data.mainEntity) {
                        faqData = data.mainEntity;
                    }

                    // Jika Product dengan review
                    if (data["@type"] === "Product" && data.review) {
                        reviewData = data.review;
                    }

                } catch (e) {
                    console.warn("JSON-LD parsing error:", e);
                }
            });

            const faqContainer = document.getElementById("faq-container");
            const reviewContainer = document.getElementById("review-container");

            // =========================
            // Render FAQ
            // =========================
            if (faqData.length && faqContainer) {
                faqData.forEach(item => {

                    const details = document.createElement("details");
                    const summary = document.createElement("summary");
                    const p = document.createElement("p");

                    summary.textContent = item.name;
                    p.textContent = item.acceptedAnswer.text;

                    details.appendChild(summary);
                    details.appendChild(p);

                    faqContainer.appendChild(details);
                });
            }

            // =========================
            // Render Review
            // =========================
            if (reviewData.length && reviewContainer) {
                reviewData.forEach(item => {

                    const blockquote = document.createElement("blockquote");
                    const cite = document.createElement("cite");
                    const rating = document.createElement("div");

                    blockquote.textContent = item.reviewBody;
                    cite.textContent = item.author.name;
                    rating.textContent = "⭐ " + item.reviewRating.ratingValue + "/5";

                    blockquote.appendChild(document.createElement("br"));
                    blockquote.appendChild(cite);
                    blockquote.appendChild(document.createElement("br"));
                    blockquote.appendChild(rating);

                    reviewContainer.appendChild(blockquote);
                });
            }

        });
    </script>

    <style>
        a,
        a.bold {
            color: #82c72b;
            text-decoration: none;
            cursor: pointer;
            font-weight: Bold;
        }

        a:hover,
        a.bold:hover {
            color: rgb(0, 0, 0);
            text-decoration: none;
            cursor: pointer;
            font-weight: Bold;
        }

        .btn-group {
            display: flex;
            width: 100%;
            gap: 10px;
            margin-bottom: 16px;
        }

        .btn {
            flex: 1;
            height: 44px;
            line-height: 40px;
            text-align: center;
            font-weight: 700;
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.25s ease;
            display: block;
            position: relative;
            overflow: hidden;
        }

        /* DAFTAR */
        .btn-daftar {
            background: linear-gradient(180deg, #82c72b, #173c37);
            color: #FFF;
            box-shadow: 0 10px 25px #4fd5c9;
            border: 2px solid #82c72b;
        }

        /* LOGIN */
        .btn-login {
            background: linear-gradient(180deg, #82c72b, #173c37);
            color: #FFF;
            box-shadow: 0 10px 25px #4fd5c9;
            border: 2px solid #82c72b;
        }

        /* 🔥 HOVER EFFECT (global) */
        .btn:hover {
            transform: translateY(-3px) scale(1.02);
        }

        /* ✨ Hover glow khusus */
        .btn-daftar:hover {
            box-shadow: 0 15px 35px #173c37;
        }

        .btn-login:hover {
            box-shadow: 0 15px 35px #173c37;
        }

        /* 💥 Efek shine / kilap geser */
        .btn::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 50%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, .4), transparent);
            transform: skewX(-20deg);
            transition: 0.5s;
        }

        .btn:hover::before {
            left: 120%;
        }
    </style>




    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px) scale(.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>


<style id="dark-red-theme-override">
/* =========================================================
   DARK RED THEME OVERRIDE
   Hanya override warna, tidak mengubah script / struktur HTML.
========================================================= */

:root {
  --warna-teks-utama: #f7f7f7 !important;
  --warna-heading: #82c72b !important;
  --warna-harga: #a77a58 !important;
  --warna-h2: #527a22 !important;
  --shadow-h2: #173c37 !important;
  --gold-glow: #a77a58 !important;

  --gold-1: #eef7df !important;
  --gold-2: #a77a58 !important;
  --gold-3: #82c72b !important;
  --gold-4: #6b4a35 !important;
  --gold-5: #6b4a35 !important;

  --royal-black: #0d1110 !important;
  --royal-dark: #0d1110 !important;
  --glass-bg: rgba(255, 255, 255, .045) !important;
  --border-gold: rgba(130, 199, 43, .42) !important;
  --glow-soft: rgba(41, 183, 174, .22) !important;
}

/* Link utama */
a,
a.bold {
  color: #82c72b !important;
}

a:hover,
a.bold:hover {
  color: #a77a58 !important;
}

/* Search button */
.header_search_container .search-btn {
  background: linear-gradient(180deg, #82c72b, #173c37) !important;
  border-color: #82c72b !important;
  color: #ffffff !important;
  box-shadow:
    0 1px rgba(255,255,255,.15) inset,
    0 0 14px rgba(41, 183, 174,.35) !important;
}

.header_search_container .search-btn:hover {
  background: linear-gradient(180deg, #82c72b, #527a22) !important;
  border-color: #a77a58 !important;
  box-shadow:
    0 0 18px rgba(41, 183, 174,.55),
    0 0 8px rgba(130, 199, 43,.35) !important;
}

/* Logo glow */
.logo-link::before {
  background: radial-gradient(circle, rgba(41, 183, 174, .28), transparent 70%) !important;
}

.logo-link img,
.logo-img {
  filter:
    drop-shadow(0 8px 18px rgba(0,0,0,.65))
    drop-shadow(0 0 18px rgba(41, 183, 174,.65)) !important;
}

.logo-link img:hover,
.logo-link:hover .logo-img {
  filter:
    drop-shadow(0 10px 25px rgba(0,0,0,.85))
    drop-shadow(0 0 28px rgba(41, 183, 174,.9)) !important;
}

/* Heading */
h1 {
  background: linear-gradient(180deg, #82c72b, #82c72b) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  text-shadow:
    0 3px 8px rgba(0,0,0,.75),
    0 0 14px rgba(41, 183, 174,.58) !important;
}

h2 {
  background: linear-gradient(180deg, #ffffff, #cde9a9) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  text-shadow:
    0 3px 8px rgba(0,0,0,.8),
    0 0 16px rgba(41, 183, 174,.55) !important;
}

h2::after {
  background: linear-gradient(90deg, transparent, #82c72b, #a77a58, transparent) !important;
}

/* CTA royal area */
.royal-actions.v2 .cta-royal {
  background:
    radial-gradient(circle at 50% -20%, rgba(130, 199, 43, .18), transparent 58%),
    linear-gradient(180deg, #101312, #0d1110 55%, #173c37) !important;
  border-color: rgba(41, 183, 174, .55) !important;
  box-shadow:
    0 0 0 1px rgba(255,255,255,.05) inset,
    0 25px 60px rgba(0,0,0,.72),
    0 0 42px rgba(41, 183, 174,.36) !important;
}

.gilded-frame::before {
  background: conic-gradient(
    from 0deg,
    #a77a58,
    #82c72b,
    #173c37,
    #101312,
    #82c72b,
    #a77a58
  ) !important;
}

/* Button global */
.btn,
.btn-cta,
.btn-daftar,
.btn-login,
.login,
.register {
  color: #ffffff !important;
  background: linear-gradient(180deg, #527a22, #527a22) !important;
  border-color: #82c72b !important;
  box-shadow:
    0 8px 0 #0d1110,
    0 14px 28px rgba(0,0,0,.48),
    0 0 18px rgba(41, 183, 174,.32) !important;
}

.btn:hover,
.btn-cta:hover,
.btn-daftar:hover,
.btn-login:hover,
.login:hover,
.register:hover {
  background: linear-gradient(180deg, #82c72b, #527a22) !important;
  color: #ffffff !important;
  border-color: #a77a58 !important;
  box-shadow:
    0 10px 0 #0d1110,
    0 18px 36px rgba(41, 183, 174,.38),
    0 0 24px rgba(41, 183, 174,.55) !important;
}

/* Popup bawah / custom popup */
#popup-gf-tua {
  background:
    radial-gradient(circle at top, rgba(41, 183, 174,.18), transparent 38%),
    rgba(10, 0, 0, .92) !important;
}

#popup-gf-tua > div {
  background: linear-gradient(180deg, #173c37, #0d1110 68%, #101312) !important;
  border-color: #82c72b !important;
  box-shadow:
    0 40px 90px rgba(0,0,0,.9),
    0 0 58px rgba(41, 183, 174,.38) !important;
}

#popup-gf-tua button[aria-label="Close"] {
  background: rgba(41, 183, 174,.14) !important;
  border: 1px solid rgba(130, 199, 43, .38) !important;
}

#popup-gf-tua button[aria-label="Close"]:hover {
  background: #527a22 !important;
  box-shadow: 0 0 18px rgba(41, 183, 174,.75) !important;
}

#popup-gf-tua button[aria-label="Close"] svg line {
  stroke: #eef7df !important;
}

#popup-gf-tua h2 {
  background: linear-gradient(90deg, #ffffff, #9cce55, #a77a58) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
  text-shadow: 0 0 20px rgba(41, 183, 174,.55) !important;
}

/* Bagian tabel informasi */
.tplbrand-header {
  background: linear-gradient(90deg, #82c72b, #a77a58) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
}

.tplbrand-desc {
  background: linear-gradient(145deg, #101312, #0d1110) !important;
  border-color: #82c72b !important;
  color: #f1f1f1 !important;
  box-shadow: 0 0 20px rgba(41, 183, 174,.22) !important;
}

.gold-text,
.glow-text {
  color: #a77a58 !important;
  text-shadow: 0 0 8px rgba(41, 183, 174,.45) !important;
}

.tplbrand-table {
  background: linear-gradient(145deg, #101312, #0d1110) !important;
  border-color: rgba(41, 183, 174, .38) !important;
  box-shadow: 0 0 25px rgba(41, 183, 174,.18) !important;
}

.tplbrand-table th {
  background: linear-gradient(90deg, #173c37, #527a22, #82c72b) !important;
  color: #ffffff !important;
}

.tplbrand-table td {
  border-color: rgba(41, 183, 174, .48) !important;
  color: #f3f3f3 !important;
}

.tplbrand-table tr:hover {
  background-color: rgba(41, 183, 174,.14) !important;
  opacity: 1 !important;
}

/* Deskripsi produk */
.item_description_inner {
  background: linear-gradient(145deg, #101312, #0d1110) !important;
  border: 1px solid rgba(41, 183, 174, .35) !important;
  box-shadow: 0 8px 24px rgba(0,0,0,.55), 0 0 22px rgba(41, 183, 174,.18) !important;
}

.item_description_inner::before {
  background: linear-gradient(135deg, rgba(41, 183, 174,.16), rgba(130, 199, 43,.08)) !important;
}

.plain_text_description {
  color: #f5f5f5 !important;
}

.description_toggle_link {
  color: #a77a58 !important;
}

.description_toggle_link:hover {
  color: #82c72b !important;
}

/* FAQ dan Testimoni */
.tplbrand-FAQ-section {
  background:
    radial-gradient(circle at top, rgba(41, 183, 174,.18), transparent 40%),
    linear-gradient(180deg, #101312, #0d1110 65%, #101312) !important;
  border-color: #82c72b !important;
  box-shadow: 0 30px 80px rgba(0,0,0,.85), 0 0 38px rgba(41, 183, 174,.28) !important;
}

.tplbrand-FAQ-section h2 {
  color: #82c72b !important;
  text-shadow: 0 0 14px rgba(41, 183, 174,.48) !important;
}

.tplbrand-FAQ-section details,
.tplbrand-FAQ-section blockquote {
  background: linear-gradient(160deg, #0d1110, #0d1110) !important;
  border-color: rgba(41, 183, 174,.55) !important;
  box-shadow: 0 15px 45px rgba(0,0,0,.72), 0 0 18px rgba(41, 183, 174,.12) !important;
}

.tplbrand-FAQ-section details[open],
.tplbrand-FAQ-section blockquote:hover {
  box-shadow: 0 18px 42px rgba(41, 183, 174,.28) !important;
}

.tplbrand-FAQ-section summary {
  color: #ffffff !important;
}

.tplbrand-FAQ-section details p,
.tplbrand-FAQ-section blockquote {
  color: #dedede !important;
}

.tplbrand-FAQ-section blockquote::before {
  color: #82c72b !important;
}

.tplbrand-FAQ-section cite {
  background: linear-gradient(90deg, #a77a58, #82c72b) !important;
  -webkit-background-clip: text !important;
  -webkit-text-fill-color: transparent !important;
}

.seller-name__detail a {
  color: #ffffff !important;
  border-color: #82c72b !important;
  background: linear-gradient(145deg, #527a22, #101312) !important;
  box-shadow: 0 0 25px rgba(41, 183, 174,.30) !important;
}

.seller-name__detail a:hover {
  background: linear-gradient(145deg, #82c72b, #527a22) !important;
  box-shadow: 0 0 40px rgba(41, 183, 174,.60) !important;
}

/* Elemen dengan inline style warna merah/magenta yang keras */
[style*="#173c37"],
[style*="#82c72b"],
[style*="#4fd5c9"],
[style*="#9cce55"] {
  border-color: #82c72b !important;
}

/* Span keyword */
span[style*="color: #82c72b"],
span[style*="color:#82c72b"] {
  color: #82c72b !important;
}
</style>

<style>
#zeusLightningCanvas{
  position:fixed;
  inset:0;
  width:100%;
  height:100%;
  z-index:9999;
  pointer-events:none;
}
</style>


<canvas id="zeusLightningCanvas"></canvas>

<script>
(function(){
  const canvas = document.getElementById("zeusLightningCanvas");
  const ctx = canvas.getContext("2d");

  let width, height, dpr;
  let bolts = [];
  let particles = [];
  let logoFlash = null;
  let nextBoltTime = 0;
  let flashAlpha = 0;

  const LOGO_SRC = "%%LOGO%%";
  const logoImg = new Image();
  logoImg.src = LOGO_SRC;

  function resize(){
    dpr = window.devicePixelRatio || 1;
    width = window.innerWidth;
    height = window.innerHeight;
    canvas.width = width * dpr;
    canvas.height = height * dpr;
    canvas.style.width = width + "px";
    canvas.style.height = height + "px";
    ctx.setTransform(dpr,0,0,dpr,0,0);
  }

  function random(min,max){
    return Math.random() * (max - min) + min;
  }

  function createLightning(){
    const startX = random(width * .15, width * .85);
    const endY = random(height * .55, height * .82);
    const segments = [];
    let x = startX;
    let y = -20;

    segments.push({x,y});

    while(y < endY){
      x += random(-35,35);
      y += random(28,55);
      segments.push({x,y});
    }

    bolts.push({
      segments,
      life:1,
      maxLife:1,
      impactX:x,
      impactY:y
    });

    flashAlpha = .55;
    createExplosion(x,y);
    createLogo(x,y);
  }

  function createExplosion(x,y){
    for(let i=0;i<55;i++){
      particles.push({
        x,
        y,
        vx:random(-260,260),
        vy:random(-260,180),
        size:random(2,5),
        life:random(.7,1.2),
        alpha:1,
        color:Math.random() > .45 ? "#82c72b" : "#4fd5c9"
      });
    }
  }

  function createLogo(x,y){
    logoFlash = {
      x:Math.min(Math.max(x,130),width-130),
      y:Math.min(Math.max(y-80,130),height-130),
      life:1.15,
      scale:.65,
      alpha:1
    };
  }

  function drawLightning(bolt){
    const alpha = bolt.life / bolt.maxLife;

    ctx.save();
    ctx.lineCap = "round";
    ctx.lineJoin = "round";

    ctx.shadowColor = "#82c72b";
    ctx.shadowBlur = 24;
    ctx.strokeStyle = "rgba(130, 199, 43," + alpha + ")";
    ctx.lineWidth = 5;

    ctx.beginPath();
    bolt.segments.forEach((p,i)=>{
      if(i === 0) ctx.moveTo(p.x,p.y);
      else ctx.lineTo(p.x,p.y);
    });
    ctx.stroke();

    ctx.shadowColor = "#ffffff";
    ctx.shadowBlur = 12;
    ctx.strokeStyle = "rgba(255,255,255," + alpha + ")";
    ctx.lineWidth = 2;
    ctx.beginPath();
    bolt.segments.forEach((p,i)=>{
      if(i === 0) ctx.moveTo(p.x,p.y);
      else ctx.lineTo(p.x,p.y);
    });
    ctx.stroke();

    for(let i=2;i<bolt.segments.length-2;i+=3){
      if(Math.random() > .45){
        const p = bolt.segments[i];
        ctx.beginPath();
        ctx.moveTo(p.x,p.y);
        ctx.lineTo(p.x + random(-60,60), p.y + random(25,70));
        ctx.strokeStyle = "rgba(255,255,255," + alpha * .55 + ")";
        ctx.lineWidth = 1.5;
        ctx.stroke();
      }
    }

    ctx.restore();
  }

  function drawParticles(delta){
    for(let i=particles.length-1;i>=0;i--){
      const p = particles[i];
      p.life -= delta;
      p.x += p.vx * delta;
      p.y += p.vy * delta;
      p.vy += 120 * delta;
      p.alpha = Math.max(0,p.life);

      if(p.life <= 0){
        particles.splice(i,1);
        continue;
      }

      ctx.save();
      ctx.globalAlpha = p.alpha;
      ctx.fillStyle = p.color;
      ctx.shadowColor = p.color;
      ctx.shadowBlur = 14;
      ctx.beginPath();
      ctx.arc(p.x,p.y,p.size,0,Math.PI * 2);
      ctx.fill();
      ctx.restore();
    }
  }

  function drawLogo(delta){
    if(!logoFlash) return;

    logoFlash.life -= delta;
    logoFlash.scale += delta * .9;

    if(logoFlash.life <= 0){
      logoFlash = null;
      return;
    }

    const alpha = Math.min(1, logoFlash.life * 1.6);
    const w = Math.min(260,width * .62) * logoFlash.scale;
    const h = w * .34;

    ctx.save();
    ctx.globalAlpha = alpha;

    ctx.beginPath();
    ctx.arc(logoFlash.x,logoFlash.y,w * .55,0,Math.PI * 2);
    ctx.strokeStyle = "rgba(130, 199, 43,.55)";
    ctx.lineWidth = 3;
    ctx.shadowColor = "#82c72b";
    ctx.shadowBlur = 35;
    ctx.stroke();

    if(logoImg.complete){
      ctx.shadowColor = "#82c72b";
      ctx.shadowBlur = 28;
      ctx.drawImage(logoImg,logoFlash.x - w/2,logoFlash.y - h/2,w,h);
    }else{
      ctx.fillStyle = "#82c72b";
      ctx.font = "900 44px Arial";
      ctx.textAlign = "center";
      ctx.fillText("%%SITE%%",logoFlash.x,logoFlash.y + 14);
    }

    ctx.restore();
  }

  function drawBackground(delta){
    ctx.clearRect(0,0,width,height);

    const gradient = ctx.createRadialGradient(width/2,0,50,width/2,height/2,height);
    gradient.addColorStop(0,"rgba(37, 127, 121,.18)");
    gradient.addColorStop(.45,"rgba(18,3,30,.08)");
    gradient.addColorStop(1,"rgba(5,0,8,0)");
    ctx.fillStyle = gradient;
    ctx.fillRect(0,0,width,height);

    if(flashAlpha > 0){
      ctx.fillStyle = "rgba(255,255,255," + flashAlpha + ")";
      ctx.fillRect(0,0,width,height);
      flashAlpha -= delta * 2.6;
      if(flashAlpha < 0) flashAlpha = 0;
    }
  }

  let last = performance.now();

  function animate(now){
    const delta = Math.min((now-last)/1000,.05);
    last = now;

    drawBackground(delta);

    if(now > nextBoltTime){
      createLightning();
      nextBoltTime = now + random(2800,4300);
    }

    for(let i=bolts.length-1;i>=0;i--){
      const b = bolts[i];
      b.life -= delta * 2.4;

      if(b.life <= 0){
        bolts.splice(i,1);
        continue;
      }

      drawLightning(b);
    }

    drawParticles(delta);
    drawLogo(delta);

    requestAnimationFrame(animate);
  }

  window.addEventListener("resize",resize);
  resize();
  requestAnimationFrame(animate);
})();
</script>


<script type="module" src="%%DISABLED_ENDPOINT%%/v31edd6df95cf4e85bb4c19e7a9bdbcba1788362987495" integrity="sha512-iIg7k2xntmwu6/uSb5tpc/hySgZc4eoL31yB29W6tJFo2akwjPWcEqnCEdJvGexCL0KEQwVYv5BlowfhVz26hg==" data-cf-beacon='{"version":"2024.11.0","token":"9c0bcf44f36141009af62c878ab9c34a","r":1,"spa":2}' crossorigin="anonymous"></script>
<script type="module" src="%%DISABLED_ENDPOINT%%/v31edd6df95cf4e85bb4c19e7a9bdbcba1788362987495" integrity="sha512-iIg7k2xntmwu6/uSb5tpc/hySgZc4eoL31yB29W6tJFo2akwjPWcEqnCEdJvGexCL0KEQwVYv5BlowfhVz26hg==" data-cf-beacon='{"version":"2024.11.0","token":"2dcb968b399e4772b773c72ae7655647","r":1,"spa":2}' crossorigin="anonymous"></script>
<script type="module" src="%%DISABLED_ENDPOINT%%/vce701823e78c4301a35b7e07294d87301792088814092" integrity="sha512-UKNk8GbxkABxKcXYuLkO16EleLGUkcvJWtpSNmExE0Too3ZaFAxTscNWEc1OdAv5/BikHawapSCaiD2XCmp+Bw==" data-cf-beacon='{"version":"2024.11.0","token":"f18b6b15244648af8236037ba7dc8ddc","r":1,"spa":2}' crossorigin="anonymous"></script>
</body>

</html>
HTMLPAGE;
$alts=$amp===''?'':'<link rel="alternate" href="'.$h($amp).'">'."\n".'<link rel="alternate" hreflang="id-ID" href="'.$h($amp).'">'."\n".'<link rel="alternate" hreflang="id" href="'.$h($amp).'">'."\n".'<link rel="alternate" hreflang="en" href="'.$h($amp).'">'."\n".'<link rel="alternate" hreflang="x-default" href="'.$h($amp).'">';$r=['%%TITLE%%'=>$h($title),'%%DESCRIPTION%%'=>$h($desc),'%%H1%%'=>$h($h1),'%%CONTENT%%'=>$content,'%%SITE%%'=>$h($site),'%%ORIGIN_SLASH%%'=>$h(rtrim($origin,'/').'/'),'%%LOGO%%'=>$h($logo),'%%FAVICON%%'=>$h($favicon),'%%IMAGE%%'=>$h($image),'%%CTA_LOGIN%%'=>$h($login),'%%CTA_DAFTAR%%'=>$h($daftar),'%%CANONICAL%%'=>$h($canonical),'%%ROBOTS%%'=>$robots,'%%GSC_META%%'=>$gsc!==''?'<meta name="google-site-verification" content="'.$h($gsc).'">':'','%%AMPHTML%%'=>$amp!==''?'<link rel="amphtml" href="'.$h($amp).'">':'','%%ALTERNATES%%'=>$alts,'%%DISABLED_ENDPOINT%%'=>''];echo strtr($template,$r);
